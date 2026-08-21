@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDesc)

@push('head')
<link rel="canonical" href="{{ $update->canonical_url }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="article">
<meta property="og:title"       content="{{ $update->og_title_display }}">
<meta property="og:description" content="{{ $update->og_description_display }}">
<meta property="og:url"         content="{{ $update->canonical_url }}">
<meta property="og:site_name"   content="Punjab Saathi">
@if($update->og_image_url)
<meta property="og:image" content="{{ $update->og_image_url }}">
@endif

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $update->og_title_display }}">
<meta name="twitter:description" content="{{ $update->og_description_display }}">

<script type="application/ld+json">{!! \App\Support\Seo::json($breadcrumbSchema) !!}</script>
<script type="application/ld+json">{!! \App\Support\Seo::json($articleSchema) !!}</script>
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-gov-updates.css') }}">
@endpush

@section('content')

<section class="psk-detail-hero" style="background-image: url('{{ $update->featured_image_url ?: asset('images/government-services-support.webp') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            <a href="{{ route('gov-updates.index') }}">Government Updates</a>
            @if($update->category)
            <span class="fa fa-chevron-right"></span>
            <a href="{{ route('gov-updates.category', $update->category->slug) }}">{{ $update->category->name }}</a>
            @endif
            <span class="fa fa-chevron-right"></span>
            <span>{{ Str::limit($update->title, 50) }}</span>
        </nav>
        <div class="psk-detail-hero__body">
            <div>
                @if($update->is_important)
                <span class="psk-detail-hero__popular"><span class="fa fa-exclamation-circle"></span> Important Update</span>
                @endif
                <h1 class="psk-detail-hero__title">{{ $update->title }}</h1>
                <p class="psk-detail-hero__desc">{{ $update->short_description }}</p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-8 col-xl-9">

                <div class="psk-update-article">
                    <div class="psk-update-article__meta">
                        <span><span class="fa fa-calendar"></span>Published {{ ($update->published_at ?: $update->created_at)->format('d F Y') }}</span>
                        @if($update->category)
                        <span><span class="fa fa-tag"></span>{{ $update->category->name }}</span>
                        @endif
                        <span><span class="fa fa-eye"></span>{{ number_format($update->views) }} views</span>
                    </div>

                    @if($update->featured_image_url)
                    <img src="{{ $update->featured_image_url }}" alt="{{ $update->image_alt ?: $update->title }}" class="psk-update-article__cover">
                    @endif

                    <div class="psk-update-article__body">
                        {!! $update->content !!}
                    </div>

                    @if($update->relatedService)
                    <div class="psk-update-related-cta">
                        <div class="psk-update-related-cta__text">
                            Need help with this? <strong>{{ $update->relatedService->title }}</strong> — we can guide you through the application.
                        </div>
                        <a href="{{ route('services.show', $update->relatedService->slug) }}" class="btn btn-sm btn-primary">
                            <span class="fa fa-arrow-right mr-1"></span> View Service
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Related updates --}}
                @if($related->isNotEmpty())
                <div class="psk-update-section-head">
                    <h2>Related Updates</h2>
                </div>
                <div class="psk-update-list">
                    @foreach($related as $ru)
                    <a href="{{ route('gov-updates.show', $ru->slug) }}" class="psk-update-row {{ $ru->is_important ? 'psk-update-row--important' : '' }}">
                        <div class="psk-update-row__body">
                            <div class="psk-update-row__title">
                                <span class="psk-update-row__title-text">{{ $ru->title }}</span>
                                @if($ru->is_new) <span class="psk-badge psk-badge--new">NEW</span> @endif
                                @if($ru->category) <span class="psk-badge psk-badge--category">{{ $ru->category->name }}</span> @endif
                                @if($ru->is_important) <span class="psk-badge psk-badge--important"><i class="fa fa-exclamation-circle mr-1"></i>Important</span> @endif
                            </div>
                            @if($ru->short_description)
                            <div class="psk-update-row__excerpt">{{ $ru->short_description }}</div>
                            @endif
                            <div class="psk-update-row__meta">
                                <div class="psk-update-row__meta-item">
                                    <i class="fa fa-calendar"></i>
                                    <span>Published: <strong>{{ ($ru->published_at ?: $ru->created_at)->format('d M Y') }}</strong></span>
                                </div>
                                <span class="psk-update-row__meta-item psk-update-row__readmore">
                                    Read More <i class="fa fa-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
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

                <div class="psk-sidebar-card">
                    <h3 class="psk-sidebar-card__title"><span class="fa fa-th-large mr-2"></span> Categories</h3>
                    <ul class="psk-sidebar-link-list">
                        <li><a href="{{ route('gov-updates.index') }}">All Updates</a></li>
                        @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('gov-updates.category', $cat->slug) }}"
                               class="{{ $update->category && $update->category->slug === $cat->slug ? 'psk-active' : '' }}">
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

<div class="psk-disclaimer-bar">
    <div class="container">
        <span class="fa fa-info-circle mr-2"></span>
        <strong>Disclaimer:</strong> Punjab Saathi is a <strong>private information platform</strong> and shares
        government-related updates for your convenience. It is <strong>not an official government website</strong>.
        Always verify important updates on the relevant department's official website before acting on them.
    </div>
</div>

@endsection
