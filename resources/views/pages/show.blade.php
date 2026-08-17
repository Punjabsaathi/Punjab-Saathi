@extends('layouts.app')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- SEO META TAGS                                           --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@section('title', $service->meta_title)

@section('meta_description', $service->meta_description)

@push('head')
@if($service->meta_keywords)
<meta name="keywords" content="{{ $service->meta_keywords }}">
@endif

<link rel="canonical" href="{{ $service->canonical_url }}">

<meta property="og:type"        content="website">
<meta property="og:title"       content="{{ $service->meta_title }}">
<meta property="og:description" content="{{ $service->meta_description }}">
<meta property="og:url"         content="{{ $service->canonical_url }}">
<meta property="og:site_name"   content="Punjab Saathi">
@if($service->og_image)
<meta property="og:image" content="{{ asset('storage/' . $service->og_image) }}">
@endif

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $service->meta_title }}">
<meta name="twitter:description" content="{{ $service->meta_description }}">

<meta name="robots" content="index, follow">

<script type="application/ld+json">{!! $breadcrumbSchema !!}</script>

@if($faqSchema)
<script type="application/ld+json">{!! $faqSchema !!}</script>
@endif

@php
$serviceSchema = json_encode([
    '@context'    => 'https://schema.org',
    '@type'       => 'Service',
    'name'        => $service->title,
    'description' => $service->meta_description,
    'provider'    => [
        '@type'      => 'LocalBusiness',
        'name'       => 'Punjab Saathi',
        'url'        => url('/'),
        'areaServed' => 'Punjab, India',
        'telephone'  => '+917710556330',
    ],
    'serviceType' => $service->tag,
    'url'         => $service->canonical_url,
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
@endphp
<script type="application/ld+json">{!! $serviceSchema !!}</script>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- HERO BANNER                                             --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="psk-detail-hero"
         style="background-image: url('{{ $service->image_url ?: asset('images/forms.jpg') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">

        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            <a href="{{ url('/services') }}">Services</a>
            <span class="fa fa-chevron-right"></span>
            <span>{{ $service->title }}</span>
        </nav>

        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:{{ $service->color }}22;">
                <span class="fa {{ $service->icon }}" style="color:{{ $service->color }};"></span>
            </div>
            <div>
                <span class="psk-detail-hero__tag">{{ $service->tag }}</span>
                <h1 class="psk-detail-hero__title">{{ $service->title }}</h1>
                <p class="psk-detail-hero__desc">{{ $service->short_desc }}</p>
                <div class="psk-detail-hero__meta">
                    <span><span class="fa fa-clock-o"></span> {{ $service->processing_time }}</span>
                    @if($service->fee_range)
                        <span><span class="fa fa-inr"></span> {{ $service->fee_range }}</span>
                    @endif
                    @if($service->is_popular)
                        <span class="psk-detail-hero__popular"><span class="fa fa-star"></span> Most Requested</span>
                    @endif
                </div>
                <div class="psk-detail-hero__actions">
                    <a href="#apply-form" class="btn psk-btn-primary">
                        <span class="fa fa-paper-plane mr-2"></span> Apply Now
                    </a>
                    <!-- <a href="{{ $service->whatsapp_url }}" target="_blank" rel="noopener"
                       class="btn psk-btn-whatsapp">
                        <span class="fa fa-whatsapp mr-2"></span> WhatsApp Us
                    </a> -->
                    <a href="https://wa.me/917710556330" target="_blank" rel="noopener"
                        class="btn psk-btn-whatsapp">
                            <span class="fa fa-whatsapp mr-2"></span> WhatsApp Us
                        </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- DISCLAIMER BANNER                                       --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<div class="psk-disclaimer-bar">
    <div class="container">
        <span class="fa fa-info-circle mr-2"></span>
        <strong>Disclaimer:</strong> Punjab Saathi is a <strong>private assistance platform</strong>
        and is <strong>not an official government website</strong>. We help citizens apply through
        authorised government portals as a Common Service Centre (CSC).
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- MAIN CONTENT + SIDEBAR                                  --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="psk-detail-body ftco-section ftco-no-pt">
    <div class="container">
        <div class="row">

            {{-- ── LEFT: Main content ───────────────────── --}}
            <div class="col-lg-8">

                @if(session('success'))
                <div class="psk-alert-success ftco-animate">
                    <span class="fa fa-check-circle mr-2"></span>
                    {{ session('success') }}
                </div>
                @endif

                {{-- OVERVIEW --}}
                <div class="psk-detail-card ftco-animate" id="overview">
                    <div class="psk-detail-card__header">
                        <span class="fa fa-align-left psk-detail-card__icon" style="color:#fc5e28;"></span>
                        <h2>Service Overview</h2>
                    </div>
                    <div class="psk-detail-card__body psk-overview-content">
                        {!! $service->overview !!}
                    </div>
                </div>

                {{-- REQUIRED DOCUMENTS --}}
                @if($service->documents->isNotEmpty())
                <div class="psk-detail-card ftco-animate" id="documents">
                    <div class="psk-detail-card__header">
                        <span class="fa fa-paperclip psk-detail-card__icon" style="color:#3b82f6;"></span>
                        <h2>Required Documents</h2>
                    </div>
                    <div class="psk-detail-card__body">
                        <div class="psk-doc-grid">
                            @foreach($service->documents as $doc)
                            <div class="psk-doc-item {{ $doc->is_mandatory ? 'psk-doc-item--mandatory' : 'psk-doc-item--optional' }}">
                                <span class="psk-doc-item__icon fa {{ $doc->is_mandatory ? 'fa-check-circle' : 'fa-circle-o' }}"></span>
                                <div>
                                    <strong>{{ $doc->label }}</strong>
                                    @if($doc->note)
                                        <span class="psk-doc-item__note">{{ $doc->note }}</span>
                                    @endif
                                </div>
                                @if(!$doc->is_mandatory)
                                    <span class="psk-doc-badge">Optional</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <p class="psk-doc-note mt-3">
                            <span class="fa fa-info-circle mr-1" style="color:#fc5e28;"></span>
                            Send clear, readable photos or scanned copies of all documents via WhatsApp or upload below.
                        </p>
                    </div>
                </div>
                @endif

                {{-- ELIGIBILITY --}}
                @if($service->eligibility)
                <div class="psk-detail-card ftco-animate" id="eligibility">
                    <div class="psk-detail-card__header">
                        <span class="fa fa-user psk-detail-card__icon" style="color:#059669;"></span>
                        <h2>Who Can Apply</h2>
                    </div>
                    <div class="psk-detail-card__body psk-overview-content">
                        {!! $service->eligibility !!}
                    </div>
                </div>
                @endif

                {{-- FEES & PROCESSING TIME --}}
                <div class="psk-detail-card ftco-animate" id="fees">
                    <div class="psk-detail-card__header">
                        <span class="fa fa-rupee psk-detail-card__icon" style="color:#d97706;"></span>
                        <h2>Fees &amp; Processing Time</h2>
                    </div>
                    <div class="psk-detail-card__body">
                        <div class="psk-info-grid">
                            <div class="psk-info-box psk-info-box--orange">
                                <span class="fa fa-clock-o psk-info-box__icon"></span>
                                <div>
                                    <p class="psk-info-box__label">Processing Time</p>
                                    <p class="psk-info-box__value">{{ $service->processing_time }}</p>
                                </div>
                            </div>
                            @if($service->fee_range)
                            <div class="psk-info-box psk-info-box--blue">
                                <span class="fa fa-inr psk-info-box__icon"></span>
                                <div>
                                    <p class="psk-info-box__label">Service Fee</p>
                                    <p class="psk-info-box__value">{{ $service->fee_range }}</p>
                                </div>
                            </div>
                            @endif
                            <div class="psk-info-box psk-info-box--green">
                                <span class="fa fa-whatsapp psk-info-box__icon"></span>
                                <div>
                                    <p class="psk-info-box__label">How to Pay</p>
                                    <p class="psk-info-box__value">UPI / Bank Transfer / Cash</p>
                                </div>
                            </div>
                        </div>
                        @if($service->fee_note)
                        <div class="psk-fee-note mt-3">
                            <span class="fa fa-info-circle mr-1"></span>
                            {!! $service->fee_note !!}
                        </div>
                        @endif
                    </div>
                </div>

                {{-- APPLICATION FORM --}}
                <div class="psk-detail-card psk-apply-card ftco-animate" id="apply-form">
                    <div class="psk-detail-card__header">
                        <span class="fa fa-paper-plane psk-detail-card__icon" style="color:#fc5e28;"></span>
                        <h2>Apply for {{ $service->title }}</h2>
                    </div>
                    <div class="psk-detail-card__body">
                        <p class="text-muted mb-4" style="font-size:0.9rem;">
                            Fill in your details below. Our team will review your application and call you within 24 hours.
                        </p>

                        @if($errors->any())
                        <div class="psk-alert-error mb-4">
                            <span class="fa fa-exclamation-circle mr-2"></span>
                            Please fix the errors below before submitting.
                        </div>
                        @endif
                            {{-- Success message --}}
@if(session('success'))
<div class="psk-alert-success ftco-animate" style="
    background:#f0fdf4;
    border:1px solid #bbf7d0;
    border-radius:10px;
    padding:16px 20px;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    gap:10px;
    color:#166534;
    font-size:0.9rem;
    font-weight:600;">
    <span class="fa fa-check-circle" style="font-size:1.2rem;color:#22c55e;"></span>
    {{ session('success') }}
</div>
@endif
                        <form action="{{ route('services.apply', $service->slug) }}"
                              method="POST"
                              id="apply-form"
                              enctype="multipart/form-data"
                              class="psk-apply-form"
                              data-psk-loading="Submitting your application…"
                              novalidate>
                            @csrf

                            <div class="row">
                                {{-- Name --}}
                                <div class="col-md-6">
                                    <div class="psk-form-group {{ $errors->has('name') ? 'psk-form-group--error' : '' }}">
                                        <label for="app_name">Full Name <span class="psk-required">*</span></label>
                                        <div class="psk-input-wrap">
                                            <span class="fa fa-user psk-input-icon"></span>
                                            <input type="text" id="app_name" name="name"
                                                   value="{{ old('name') }}"
                                                   placeholder="Enter your full name"
                                                   class="psk-input" required>
                                        </div>
                                        @error('name')
                                            <span class="psk-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <div class="psk-form-group {{ $errors->has('phone') ? 'psk-form-group--error' : '' }}">
                                        <label for="app_phone">Mobile Number <span class="psk-required">*</span></label>
                                        <div class="psk-input-wrap">
                                            <span class="fa fa-phone psk-input-icon"></span>
                                            <input type="tel" id="app_phone" name="phone"
                                                   value="{{ old('phone') }}"
                                                   placeholder="10-digit mobile number"
                                                   class="psk-input" maxlength="10" required>
                                        </div>
                                        @error('phone')
                                            <span class="psk-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6">
                                    <div class="psk-form-group {{ $errors->has('email') ? 'psk-form-group--error' : '' }}">
                                        <label for="app_email">Email Address <span class="psk-optional">(optional)</span></label>
                                        <div class="psk-input-wrap">
                                            <span class="fa fa-envelope psk-input-icon"></span>
                                            <input type="email" id="app_email" name="email"
                                                   value="{{ old('email') }}"
                                                   placeholder="your@email.com"
                                                   class="psk-input">
                                        </div>
                                        @error('email')
                                            <span class="psk-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Address --}}
                                <div class="col-md-6">
                                    <div class="psk-form-group {{ $errors->has('address') ? 'psk-form-group--error' : '' }}">
                                        <label for="app_address">Full Address <span class="psk-required">*</span></label>
                                        <div class="psk-input-wrap">
                                            <span class="fa fa-map-marker psk-input-icon"></span>
                                            <input type="text" id="app_address" name="address"
                                                   value="{{ old('address') }}"
                                                   placeholder="Village / City, District, Punjab"
                                                   class="psk-input" required>
                                        </div>
                                        @error('address')
                                            <span class="psk-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Message --}}
                                <div class="col-12">
                                    <div class="psk-form-group">
                                        <label for="app_message">Additional Information <span class="psk-optional">(optional)</span></label>
                                        <textarea id="app_message" name="message" rows="3"
                                                  placeholder="Any specific details or questions..."
                                                  class="psk-input psk-textarea">{{ old('message') }}</textarea>
                                    </div>
                                </div>

                                {{-- Document Upload --}}
                                <div class="col-12">
                                    <div class="psk-form-group {{ $errors->has('documents.*') ? 'psk-form-group--error' : '' }}">
                                        <label>Upload Documents <span class="psk-optional">(optional — max 10 files, 5MB each)</span></label>
                                        <div class="psk-upload-zone" id="uploadZone">
                                            <input type="file" name="documents[]" id="app_documents"
                                                   multiple accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                                   class="psk-upload-input">
                                            <div class="psk-upload-ui">
                                                <span class="fa fa-cloud-upload psk-upload-icon"></span>
                                                <p class="psk-upload-text">
                                                    <strong>Click to browse</strong> or drag &amp; drop files here
                                                </p>
                                                <p class="psk-upload-hint">JPG, PNG, PDF, DOC, DOCX — Max 5MB each</p>
                                            </div>
                                            <div class="psk-upload-preview" id="uploadPreview"></div>
                                        </div>
                                        @error('documents.*')
                                            <span class="psk-field-error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <p class="psk-privacy-note">
                                <span class="fa fa-lock mr-1"></span>
                                Your information is kept private and used only to process your application.
                                We do not share your data with third parties.
                            </p>

                            <button type="submit" class="btn psk-btn-submit">
                                <span class="fa fa-paper-plane mr-2"></span>
                                Submit Application
                            </button>
                        </form>
                    </div>
                </div>

            </div>{{-- /col-lg-8 --}}

            {{-- ── RIGHT: Sidebar ───────────────────────── --}}
            <div class="col-lg-4">
                <div class="psk-sidebar">

                    {{-- Quick info --}}
                    <div class="psk-sidebar-card psk-sidebar-card--highlight">
                        <h3 class="psk-sidebar-card__title">
                            <span class="fa fa-info-circle mr-2"></span> Quick Info
                        </h3>
                        <ul class="psk-sidebar-info-list">
                            <li>
                                <span class="psk-sidebar-info-list__label">Category</span>
                                <span class="psk-sidebar-info-list__value">{{ ucfirst($service->category) }}</span>
                            </li>
                            <li>
                                <span class="psk-sidebar-info-list__label">Department</span>
                                <span class="psk-sidebar-info-list__value">{{ $service->tag }}</span>
                            </li>
                            <li>
                                <span class="psk-sidebar-info-list__label">Processing</span>
                                <span class="psk-sidebar-info-list__value">{{ $service->processing_time }}</span>
                            </li>
                            @if($service->fee_range)
                            <li>
                                <span class="psk-sidebar-info-list__label">Fee</span>
                                <span class="psk-sidebar-info-list__value">{{ $service->fee_range }}</span>
                            </li>
                            @endif
                            <li>
                                <span class="psk-sidebar-info-list__label">Mode</span>
                                <span class="psk-sidebar-info-list__value">Online / WhatsApp</span>
                            </li>
                        </ul>
                    </div>

                    {{-- WhatsApp CTA --}}
                    <div class="psk-sidebar-card psk-sidebar-wa">
                        <span class="fa fa-whatsapp psk-sidebar-wa__icon"></span>
                        <h4>Get Instant Help</h4>
                        <p>Send your documents on WhatsApp. No visit required.</p>
                        <a href="https://wa.me/917710556330" target="_blank" rel="noopener"
                           class="btn psk-btn-whatsapp w-100">
                            <span class="fa fa-whatsapp mr-2"></span> Chat on WhatsApp
                        </a>
                    </div>

                    {{-- Page nav --}}
                    <div class="psk-sidebar-card psk-sidebar-nav">
                        <h3 class="psk-sidebar-card__title">On This Page</h3>
                        <ul class="psk-page-nav">
                            <li><a href="#overview"><span class="fa fa-align-left mr-2"></span>Overview</a></li>
                            @if($service->documents->isNotEmpty())
                                <li><a href="#documents"><span class="fa fa-paperclip mr-2"></span>Documents</a></li>
                            @endif
                            @if($service->eligibility)
                                <li><a href="#eligibility"><span class="fa fa-user mr-2"></span>Eligibility</a></li>
                            @endif
                            <li><a href="#fees"><span class="fa fa-rupee mr-2"></span>Fees &amp; Time</a></li>
                            @if($service->faqs->isNotEmpty())
                                <li><a href="#faq"><span class="fa fa-question-circle mr-2"></span>FAQ</a></li>
                            @endif
                            <li><a href="#apply-form"><span class="fa fa-paper-plane mr-2"></span>Apply Now</a></li>
                        </ul>
                    </div>

                    {{-- Trust signals --}}
                    <div class="psk-sidebar-card psk-sidebar-trust">
                        <h3 class="psk-sidebar-card__title">Why Choose Us</h3>
                        <ul class="psk-trust-list">
                            <li><span class="fa fa-check-circle" style="color:#059669;"></span> Authorised CSC Operator</li>
                            <li><span class="fa fa-check-circle" style="color:#059669;"></span> + Services Completed</li>
                            <li><span class="fa fa-check-circle" style="color:#059669;"></span> No Visit Required</li>
                            <li><span class="fa fa-check-circle" style="color:#059669;"></span> 100% Accurate — No Rejections</li>
                            <li><span class="fa fa-check-circle" style="color:#059669;"></span> Punjabi / Hindi Support</li>
                            <li><span class="fa fa-check-circle" style="color:#059669;"></span> Transparent Fixed Pricing</li>
                        </ul>
                    </div>

                </div>
            </div>{{-- /col-lg-4 --}}

        </div>{{-- /row --}}
    </div>{{-- /container --}}
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- RELATED SERVICES                                        --}}
{{-- ═══════════════════════════════════════════════════════ --}}{{-- ═══════════════════════════════════════════════════════ --}}
{{-- RELATED SERVICES                                        --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if($related->isNotEmpty())
<section class="ftco-section ftco-no-pt psk-related-section">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-12 col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">More Services</span>
                <h2>Related Services You May Need</h2>
            </div>
        </div>
        <div class="row psk-service-grid">
            @foreach($related as $svc)
            <div class="col-12 col-md-6 col-lg-4 ftco-animate">
                <div class="psk-service-card">
                    @if($svc->is_popular)
                        <div class="psk-service-card__popular">⭐ Most Requested</div>
                    @endif
                    <div class="psk-service-card__header">
                        <div class="psk-service-card__icon" style="background:{{ $svc->color }}15;">
                            <span class="fa {{ $svc->icon }}" style="color:{{ $svc->color }};"></span>
                        </div>
                        <div>
                            <span class="psk-service-card__tag">{{ $svc->tag }}</span>
                            <h4 class="psk-service-card__title">{{ $svc->title }}</h4>
                        </div>
                    </div>
                    <p class="psk-service-card__desc">{{ $svc->short_desc }}</p>

                    @if($svc->documents->isNotEmpty())
                    <div class="psk-service-card__docs">
                        <p class="psk-service-card__docs-title">
                            <span class="fa fa-paperclip mr-1"></span>
                            <strong>DOCUMENTS TYPICALLY NEEDED:</strong>
                        </p>
                        <ul class="psk-service-card__docs-list">
                            @foreach($svc->documents->take(3) as $doc)
                            <li>
                                <span class="fa fa-check text-primary mr-1"></span>
                                <strong>{{ $doc->label }}</strong>
                                @if($doc->note)
                                    <span class="psk-service-card__doc-note"> — {{ $doc->note }}</span>
                                @endif
                            </li>
                            @endforeach
                            @if($svc->documents->count() > 3)
                            <li class="psk-service-card__docs-more">
                                <span class="fa fa-ellipsis-h mr-1"></span>
                                +{{ $svc->documents->count() - 3 }} more documents
                            </li>
                            @endif
                        </ul>
                    </div>
                    @endif

                    <div class="psk-service-card__footer">
                        <span class="psk-service-card__time">
                            <span class="fa fa-clock-o mr-1"></span> {{ $svc->processing_time }}
                        </span>
                        <a href="{{ route('services.show', $svc->slug) }}"
                           class="btn btn-sm btn-primary">
                            <span class="fa fa-paper-plane mr-1"></span> Apply Now
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- FAQ SECTION                                             --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@if($service->faqs->isNotEmpty())
<section class="ftco-section ftco-no-pt psk-faq-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">

                <div class="psk-faq-new">
                    <div class="psk-faq-new__intro">
                        <div class="psk-faq-new__icon">
                            <span class="fa fa-question-circle"></span>
                        </div>
                        <div>
                            <h2 class="psk-faq-new__title">Frequently Asked Questions</h2>
                            <p class="psk-faq-new__sub">Everything you need to know before applying.</p>
                        </div>
                    </div>

                    <div class="psk-faq-new__list" id="faqNewAccordion">
                        @foreach($service->faqs as $i => $faq)
                        <div class="psk-faq-new__item {{ $i === 0 ? 'psk-faq-new__item--open' : '' }}">
                            <div class="psk-faq-new__q">
                                <div class="psk-faq-new__num">{{ $i + 1 }}</div>
                                <span class="psk-faq-new__q-text">{{ $faq->question }}</span>
                                <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                            </div>
                            <div class="psk-faq-new__a">{{ $faq->answer }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endif

{{-- Fixed WhatsApp bubble --}}
<a href="{{ $service->whatsapp_url }}"
   target="_blank" rel="noopener"
   title="WhatsApp Punjab Saathi"
   style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:#fff;
          width:58px;height:58px;border-radius:50%;display:flex;align-items:center;
          justify-content:center;font-size:1.7rem;box-shadow:0 4px 18px rgba(37,211,102,0.45);
          text-decoration:none;">
    <span class="fa fa-whatsapp"></span>
</a>

@endsection