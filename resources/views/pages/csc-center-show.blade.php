@extends('layouts.app')

@php
    $displayName = $center->display_name;
    $locationLine = $center->location_line;
    $waText = "Hello, I found this CSC center on Punjab Saathi and need help:\n"
        . "Center: {$displayName}\n"
        . "Location: " . ($locationLine ?: 'Punjab') . ($center->pincode ? " — {$center->pincode}" : '');
    $waUrl = 'https://wa.me/917710556330?text=' . urlencode($waText);
@endphp

@section('title', $center->seo_title)
@section('meta_description', $center->seo_description)

<link rel="canonical" href="{{ route('csc.show', $center) }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="{{ $center->seo_title }}">
<meta property="og:description" content="{{ $center->seo_description }}">
<meta property="og:url"         content="{{ route('csc.show', $center) }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $center->seo_title }}">
<meta name="twitter:description" content="{{ $center->seo_description }}">
<meta name="twitter:image"       content="{{ asset('images/og-default.jpg') }}">

<script type="application/ld+json">{!! json_encode($center->toLocalBusinessSchema(), JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($center->toBreadcrumbSchema(), JSON_UNESCAPED_SLASHES) !!}</script>
@if($faqSchema = $center->toFaqSchema())
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_SLASHES) !!}</script>
@endif

@section('content')

<section class="psk-csc-profile-hero">
    <div class="overlay"></div>
    <div class="container">
        <p class="breadcrumbs">
            <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
            <span class="mr-2"><a href="{{ route('csc.directory') }}">Find a CSC Center <i class="fa fa-chevron-right"></i></a></span>
            <span>{{ $displayName }}</span>
        </p>

        @if($center->is_verified)
        <span class="psk-verified-pill">
            <span class="fa fa-check-circle mr-1"></span> Verified CSC Center
        </span>
        @endif

        <h1 class="psk-csc-profile-hero__name">{{ $displayName }} <span class="psk-csc-profile-hero__name-sub">— CSC Center in {{ $locationLine ?: 'Punjab' }}</span></h1>

        @if($displayName !== $center->vle_name)
        <p class="psk-csc-profile-hero__operator"><span class="fa fa-user mr-1"></span> Operated by {{ $center->vle_name }}</p>
        @endif

        <p class="psk-csc-profile-hero__location">
            <span class="fa fa-map-marker mr-1"></span> {{ $locationLine }}
            @if($center->pincode) — {{ $center->pincode }} @endif
        </p>

        <div class="psk-csc-profile-hero__actions">
            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="btn btn-primary">
                <span class="fa fa-whatsapp mr-1"></span> Connect via Punjab Saathi
            </a>
            @if($center->mobile)
            <a href="tel:{{ preg_replace('/\D/', '', $center->mobile) }}" class="btn btn-white btn-outline-primary">
                <span class="fa fa-phone mr-1"></span> Call Center
            </a>
            @endif
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="psk-csc-info-card">
                    <h2 class="psk-csc-info-card__title">Center Information</h2>
                    <div class="psk-csc-info-grid">
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-map-marker mr-1"></span>Address</span>
                            <span class="psk-csc-info-item__value">{{ $center->address ?: $locationLine }}</span>
                        </div>
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-building mr-1"></span>District</span>
                            <span class="psk-csc-info-item__value">{{ $center->district ?: '—' }}</span>
                        </div>
                        @if($center->sub_district)
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-map mr-1"></span>Sub-District</span>
                            <span class="psk-csc-info-item__value">{{ $center->sub_district }}</span>
                        </div>
                        @endif
                        @if($center->pincode)
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-envelope-o mr-1"></span>Pincode</span>
                            <span class="psk-csc-info-item__value">{{ $center->pincode }}</span>
                        </div>
                        @endif
                        @if($center->csc_id)
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-id-badge mr-1"></span>CSC ID</span>
                            <span class="psk-csc-info-item__value">{{ $center->csc_id }}</span>
                        </div>
                        @endif
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-clock-o mr-1"></span>Opening Hours</span>
                            <span class="psk-csc-info-item__value psk-csc-info-item__value--muted">Not on file — please contact the center directly</span>
                        </div>
                    </div>
                </div>

                <div class="psk-csc-info-card">
                    <h2 class="psk-csc-info-card__title">Services Available</h2>
                    <p class="text-muted mb-3" style="font-size:0.9rem;">
                        CSC centers across Punjab help with a wide range of government services. Specific services offered
                        can vary by center — for the full list of services Punjab Saathi can help you apply for, browse:
                    </p>
                    <a href="{{ url('/services') }}" class="btn btn-outline-primary">
                        <span class="fa fa-list mr-1"></span> Browse All Services
                    </a>
                </div>

                @if($center->faqs->isNotEmpty())
                <div class="psk-csc-info-card">
                    <h2 class="psk-csc-info-card__title">Frequently Asked Questions</h2>
                    <div class="psk-csc-faq-list">
                        @foreach($center->faqs as $faq)
                        <div class="psk-csc-faq-item">
                            <h3 class="psk-csc-faq-item__q">{{ $faq->question }}</h3>
                            <p class="psk-csc-faq-item__a">{{ $faq->answer }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>

            <div class="col-lg-4">
                <div class="psk-csc-side-card">
                    <h3 class="psk-csc-side-card__title">Looking for a different center?</h3>
                    <p class="text-muted" style="font-size:0.88rem;">Search by pincode or find the CSC center nearest to you.</p>
                    <a href="{{ route('csc.directory') }}" class="btn btn-primary w-100">
                        <span class="fa fa-search mr-1"></span> Search CSC Centers
                    </a>
                </div>

                <div class="psk-csc-side-card psk-csc-side-card--cta">
                    <h3 class="psk-csc-side-card__title">Own this center?</h3>
                    <p style="font-size:0.88rem;color:rgba(255,255,255,0.8);">
                        If this is your CSC center and the details need updating, register with your CSC ID to update it.
                    </p>
                    <a href="{{ route('agent.registration') }}" class="btn btn-white btn-outline-primary w-100">
                        <span class="fa fa-edit mr-1"></span> Update / Register
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-csc-center-show.css') }}">
@endpush
