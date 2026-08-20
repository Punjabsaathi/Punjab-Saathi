{{-- Save as: resources/views/jobs/admit-cards.blade.php --}}
@extends('layouts.app')
@section('title', 'Admit Cards | Hall Tickets | Punjab Saathi')
@section('meta_description', 'Download the latest Punjab government exam admit cards and hall tickets — PSSSB, Punjab Police, SSC, RRB, Banking and more, updated as soon as they are released.')

@push('head')
<link rel="canonical" href="{{ route('jobs.admit-cards') }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="Admit Cards | Hall Tickets | Punjab Saathi">
<meta property="og:description" content="Download the latest Punjab government exam admit cards and hall tickets — PSSSB, Punjab Police, SSC, RRB, Banking and more, updated as soon as they are released.">
<meta property="og:url"         content="{{ route('jobs.admit-cards') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="Admit Cards | Hall Tickets | Punjab Saathi">
<meta name="twitter:description" content="Download the latest Punjab government exam admit cards and hall tickets, updated as soon as they are released.">

<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Job Saathi', 'url' => route('jobs.index')],
    ['name' => 'Admit Cards', 'url' => route('jobs.admit-cards')],
])) !!}</script>

@if($cards->count())
<script type="application/ld+json">{!! \App\Support\Seo::json([
    '@context' => 'https://schema.org',
    '@type'    => 'ItemList',
    'itemListElement' => collect($cards->items())->values()->map(fn ($card, $i) => [
        '@type'    => 'ListItem',
        'position' => (($cards->currentPage() - 1) * $cards->perPage()) + $i + 1,
        'url'      => route('jobs.show', $card->job->slug),
        'name'     => $card->title,
    ])->all(),
]) !!}</script>
@endif
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/psk-jobs.css') }}">
@endpush

@section('content')
<section class="psk-detail-hero" style="background-image: url('{{ asset('images/exam-admit-card-omr-sheet.webp') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            <a href="{{ route('jobs.index') }}">Sarkari Naukri</a>
            <span class="fa fa-chevron-right"></span>
            <span>Admit Cards</span>
        </nav>
        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:#3b82f622;">
                <span class="fas fa-id-card" style="color:#3b82f6;"></span>
            </div>
            <div>
                <h1 class="psk-detail-hero__title">Admit Cards / Hall Tickets</h1>
                <p class="psk-detail-hero__desc">Download your hall ticket for government exams — Punjab, SSC, Railway, Banking &amp; more</p>
            </div>
        </div>
    </div>
</section>

<section class="psk-jobs-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                @forelse($cards as $card)
                <div class="psk-job-card">
                    <div class="psk-job-card__body">
                        <div class="psk-job-card__top">
                            <div style="display:flex;gap:14px;align-items:flex-start;">
                                <div class="psk-job-card__icon psk-job-card__icon--blue"><i class="fas fa-id-card"></i></div>
                                <div>
                                    <div class="psk-job-card__title"><a href="{{ route('jobs.show', $card->job->slug) }}#admit">{{ $card->title }}</a></div>
                                    <a href="{{ route('jobs.show', $card->job->slug) }}" class="psk-job-card__dept">
                                        <i class="fas fa-briefcase"></i>{{ $card->job->title ?? 'View Job' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="psk-job-card__meta">
                            @if($card->release_date)<div class="psk-job-card__meta-item"><i class="fas fa-calendar-plus"></i> Released: <strong>{{ $card->release_date->format('d M Y') }}</strong></div>@endif
                            @if($card->exam_date)<div class="psk-job-card__meta-item"><i class="fas fa-calendar-check"></i> Exam: <strong>{{ $card->exam_date->format('d M Y') }}</strong></div>@endif
                            <div class="psk-job-card__meta-item"><i class="fas fa-tag"></i> {{ $card->job->category->name ?? '' }}</div>
                        </div>
                    </div>
                    <div class="psk-job-card__footer" style="justify-content:flex-end;">
                        <div class="psk-job-card__actions">
                            <a href="{{ $card->download_link }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="psk-no-results">
                    <i class="fas fa-id-card"></i>
                    <h5>No Admit Cards Yet</h5>
                    <p>Admit cards will appear here once released. Check back soon.</p>
                </div>
                @endforelse
                @if($cards->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $cards->links() }}</div>
                @endif
            </div>
            <div class="col-lg-4 col-xl-3">@include('jobs._sidebar')</div>
        </div>
    </div>
</section>
@endsection
