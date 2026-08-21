@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDesc)

@push('head')
<link rel="preload" as="image" href="{{ asset('images/government-services-support.webp') }}">
<link rel="canonical" href="{{ $canonical }}">
<meta name="robots" content="{{ $robotsMeta }}">

<meta property="og:type"        content="website">
<meta property="og:title"       content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:url"         content="{{ $canonical }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">

@if($breadcrumbSchema)
<script type="application/ld+json">{!! \App\Support\Seo::json($breadcrumbSchema) !!}</script>
@endif
@if($itemListSchema)
<script type="application/ld+json">{!! \App\Support\Seo::json($itemListSchema) !!}</script>
@endif
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-gov-updates.css') }}">
@endpush

@section('content')

{{-- ── Hero ── --}}
<section class="psk-detail-hero" style="background-image: url('{{ asset('images/government-services-support.webp') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            @if(isset($category))
                <a href="{{ route('gov-updates.index') }}">Government Updates</a>
                <span class="fa fa-chevron-right"></span>
                <span>{{ $category->name }}</span>
            @else
                <span>Government Updates</span>
            @endif
        </nav>
        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:#fc5e2822;">
                <span class="fas fa-megaphone" style="color:#fc5e28;"></span>
            </div>
            <div>
                <h1 class="psk-detail-hero__title">{{ isset($category) ? $category->name . ' Updates' : 'Latest Government Updates' }}</h1>
                <p class="psk-detail-hero__desc">
                    {{ isset($category) ? ($category->description ?: 'Latest ' . $category->name . ' updates and announcements.') : 'Punjab Saathi brings together the latest government-related updates and announcements — Aadhaar, PAN, Passport, Voter ID, Driving Licence, certificates, fees, and procedures — explained clearly, in one place.' }}
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ── Main content ── --}}
<section class="ftco-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-xl-9">

                {{-- Category pills --}}
                <div class="psk-update-pills">
                    <a href="{{ route('gov-updates.index') }}" class="psk-update-pill {{ !isset($category) ? 'active' : '' }}">
                        <span class="fa fa-th"></span> All Updates
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('gov-updates.category', $cat->slug) }}"
                       class="psk-update-pill {{ (isset($category) && $category->slug === $cat->slug) ? 'active' : '' }}">
                        <span class="fa {{ $cat->icon ?: 'fa-circle' }}"></span>
                        {{ $cat->name }} <span class="psk-update-pill__count">{{ $cat->updates_count }}</span>
                    </a>
                    @endforeach
                </div>

                <div class="psk-update-section-head">
                    <h2>{{ isset($category) ? $category->name . ' Updates' : 'Latest Updates' }}</h2>
                    <span class="psk-update-count">{{ $updates->total() }} update{{ $updates->total() !== 1 ? 's' : '' }}</span>
                </div>

                @if($updates->isEmpty())
                <div class="psk-update-empty">
                    <span class="fa fa-megaphone"></span>
                    <h5>No updates published yet</h5>
                    <p class="mb-0">Check back soon for the latest government-related updates.</p>
                </div>
                @else
                <div class="psk-update-list">
                    @foreach($updates as $update)
                    <a href="{{ route('gov-updates.show', $update->slug) }}" class="psk-update-row {{ $update->is_important ? 'psk-update-row--important' : '' }}">
                        <div class="psk-update-row__body">
                            <div class="psk-update-row__title">
                                <span class="psk-update-row__title-text">{{ $update->title }}</span>
                                @if($update->is_new) <span class="psk-badge psk-badge--new">NEW</span> @endif
                                @if($update->category) <span class="psk-badge psk-badge--category">{{ $update->category->name }}</span> @endif
                                @if($update->is_important) <span class="psk-badge psk-badge--important"><i class="fa fa-exclamation-circle mr-1"></i>Important</span> @endif
                            </div>
                            @if($update->short_description)
                            <div class="psk-update-row__excerpt">{{ $update->short_description }}</div>
                            @endif

                            <div class="psk-update-row__meta">
                                <div class="psk-update-row__meta-item">
                                    <i class="fa fa-calendar"></i>
                                    <span>Published: <strong>{{ ($update->published_at ?: $update->created_at)->format('d M Y') }}</strong></span>
                                </div>
                                @if($update->relatedService)
                                <div class="psk-update-row__meta-item">
                                    <i class="fa fa-link"></i>
                                    <span>Related: <strong>{{ $update->relatedService->title }}</strong></span>
                                </div>
                                @endif
                                <span class="psk-update-row__meta-item psk-update-row__readmore">
                                    Read More <i class="fa fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
                @endif

                @if($updates->hasPages())
                <div class="mt-4 d-flex justify-content-center">{{ $updates->links() }}</div>
                @endif

            </div>

            {{-- ── Sidebar ── --}}
            <div class="col-lg-4 col-xl-3">

                <div class="psk-sidebar-wa mb-4">
                    <i class="fab fa-whatsapp"></i>
                    <h6>Need Help With a Government Process?</h6>
                    <p>Message us and we'll guide you through the application step by step.</p>
                    <a href="https://wa.me/917710556330" target="_blank">
                        <i class="fab fa-whatsapp"></i> WhatsApp Us
                    </a>
                </div>

                @if($important->isNotEmpty())
                <div class="psk-sidebar-card">
                    <h3 class="psk-sidebar-card__title"><span class="fa fa-exclamation-circle mr-2" style="color:#e11d48;"></span> Important Updates</h3>
                    <ul class="psk-sidebar-important-list">
                        @foreach($important as $imp)
                        <li>
                            <a href="{{ route('gov-updates.show', $imp->slug) }}">
                                <span class="fa fa-exclamation-circle"></span>
                                <span>{{ Str::limit($imp->title, 70) }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="psk-sidebar-card">
                    <h3 class="psk-sidebar-card__title"><span class="fa fa-th-large mr-2"></span> Categories</h3>
                    <ul class="psk-sidebar-link-list">
                        <li>
                            <a href="{{ route('gov-updates.index') }}" class="{{ !isset($category) ? 'psk-active' : '' }}">
                                All Updates
                            </a>
                        </li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('gov-updates.category', $cat->slug) }}"
                               class="{{ (isset($category) && $category->slug === $cat->slug) ? 'psk-active' : '' }}">
                                <span><i class="fas {{ $cat->icon ?: 'fa-circle' }} mr-1" style="font-size:10px;"></i> {{ $cat->name }}</span>
                                <span class="psk-sidebar-link-list__count">{{ $cat->updates_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

            </div>

        </div>
    </div>
</section>

{{-- Disclaimer — same as elsewhere on the site: this is an informational
     platform sharing government-related updates, not an official
     government source. --}}
<div class="psk-disclaimer-bar">
    <div class="container">
        <span class="fa fa-info-circle mr-2"></span>
        <strong>Disclaimer:</strong> Punjab Saathi is a <strong>private information platform</strong> and shares
        government-related updates for your convenience. It is <strong>not an official government website</strong>.
        Always verify important updates on the relevant department's official website before acting on them.
    </div>
</div>

@endsection
