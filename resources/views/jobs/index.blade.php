{{-- ─────────────────────────────────────────────────────────
     Save as: resources/views/jobs/index.blade.php
     ───────────────────────────────────────────────────────── --}}
@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDesc)

@push('head')
<link rel="preload" as="image" href="{{ asset('images/sarkari-naukri-job-application-form.webp') }}">
<link rel="canonical" href="{{ $canonical }}">
<meta name="robots" content="{{ $robotsMeta }}">

<meta property="og:type"        content="website">
<meta property="og:title"       content="{{ $metaTitle }}">
<meta property="og:description" content="{{ $metaDesc }}">
<meta property="og:url"         content="{{ $canonical }}">
<meta property="og:site_name"   content="Punjab Saathi">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $metaTitle }}">
<meta name="twitter:description" content="{{ $metaDesc }}">

@if($breadcrumbSchema)
<script type="application/ld+json">{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endif
@if($itemListSchema)
<script type="application/ld+json">{!! json_encode($itemListSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endif
@if($faqSchema)
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endif
@endpush

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/psk-jobs.css') }}">
@endpush

@section('content')

{{-- ── Hero — reuses the site's standard detail-page banner
     (.psk-detail-hero, already used by /services/{slug}) instead of
     a page-specific one, and the same background photo, so utility
     pages share one consistent banner style. ── --}}
<section class="psk-detail-hero" style="background-image: url('{{ asset('images/sarkari-naukri-job-application-form.webp') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            @if(isset($category))
                <a href="{{ route('jobs.index') }}">Job Saathi</a>
                <span class="fa fa-chevron-right"></span>
                <span>{{ $category->name }}</span>
            @else
                <span>Job Saathi</span>
            @endif
        </nav>
        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:#fc5e2822;">
                <span class="fas fa-briefcase" style="color:#fc5e28;"></span>
            </div>
            <div>
                <h1 class="psk-detail-hero__title">{{ isset($category) ? (str_contains($category->name, 'Punjab') ? $category->name : $category->name . ' in Punjab') : $pageSettings->h1 }}</h1>
                <p class="psk-detail-hero__desc">{{ isset($category) ? ($category->description ?: 'Latest ' . $category->name . ' recruitment updates in Punjab.') : $pageSettings->hero_subtitle }}</p>
                <div class="psk-detail-hero__meta">
                    <span><strong>{{ $stats['total'] }}</strong> Total Jobs</span>
                    <span><strong>{{ $stats['active'] }}</strong> Active</span>
                    <span><strong>{{ $stats['upcoming'] }}</strong> Upcoming</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Intro (hub only, short by design — the listing below is the
     actual content searchers came for; this just orients them and
     gives crawlers a keyword-relevant lead paragraph) ──────────── --}}
@if(!isset($category) && $pageSettings->intro_content)
<div class="container">
    <div class="psk-jobs-intro">{!! $pageSettings->intro_content !!}</div>
</div>
@endif

{{-- ── Live Ticker ──────────────────────────────────────── --}}
@php
    $tickerJobs = \App\Models\GovJob::published()->where('status','active')->punjabFirst()->latest()->limit(8)->get();
@endphp
@if($tickerJobs->count())
<div class="psk-ticker">
    <div class="psk-ticker__label">
        <div class="psk-ticker__dot"></div>
        <i class="fas fa-bell" style="font-size:10px;"></i> LIVE
    </div>
    <div class="psk-ticker__track">
        <div class="psk-ticker__inner">
            @foreach([$tickerJobs, $tickerJobs] as $group)
                @foreach($group as $tj)
                    <span class="psk-ticker__item">
                        <span class="psk-badge psk-badge--new" style="animation:none;">JOBS</span>
                        <a href="{{ route('jobs.show', $tj->slug) }}">{{ $tj->title }}</a>
                        @if($tj->apply_end)
                            — Last Date: <strong style="color:#e11d48;">{{ $tj->apply_end->format('d M Y') }}</strong>
                        @endif
                    </span>
                    <span class="psk-ticker__sep">|</span>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ── Main Content ─────────────────────────────────────── --}}
<section class="psk-jobs-section">
    <div class="container">
        <div class="row">

            {{-- ── Jobs Column ────────────────────────────── --}}
            <div class="col-lg-8 col-xl-9">

                {{-- Category Pills --}}
                <div class="psk-job-pills">
                    <a href="{{ route('jobs.index') }}" class="psk-job-pill {{ !isset($category) ? 'active' : '' }}">
                        <i class="fas fa-th"></i> All <span class="psk-job-pill__count">{{ $stats['total'] }}</span>
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('jobs.category', $cat->slug) }}"
                       class="psk-job-pill {{ (isset($category) && $category->slug === $cat->slug) ? 'active' : '' }}">
                        <i class="fas {{ $cat->icon ?? 'fa-circle' }}"></i>
                        {{ $cat->name }} <span class="psk-job-pill__count">{{ $cat->jobs_count }}</span>
                    </a>
                    @endforeach
                </div>

                {{-- Filter Bar --}}
                <form method="GET" class="psk-job-filter">
                    <div class="psk-job-filter__search">
                        <i class="fas fa-search"></i>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search jobs by title or department...">
                    </div>
                    <select name="status" class="psk-job-filter__select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active"   {{ request('status')=='active'   ? 'selected':'' }}>Active</option>
                        <option value="upcoming" {{ request('status')=='upcoming' ? 'selected':'' }}>Upcoming</option>
                        <option value="expired"  {{ request('status')=='expired'  ? 'selected':'' }}>Expired</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search mr-1"></i> Search</button>
                    @if(request()->hasAny(['search','status']))
                        <a href="{{ isset($category) ? route('jobs.category',$category->slug) : route('jobs.index') }}" class="btn btn-primary btn-outline-primary btn-sm">
                            <i class="fas fa-times mr-1"></i> Clear
                        </a>
                    @endif
                    <span class="psk-job-filter__count">{{ $jobs->total() }} job{{ $jobs->total()!==1?'s':'' }} found</span>
                </form>

                {{-- Jobs List --}}
                @forelse($jobs as $job)
                <a href="{{ route('jobs.show', $job->slug) }}" class="psk-job-card {{ $job->is_featured ? 'psk-job-card--featured' : '' }}">
                    <div class="psk-job-card__body">
                        <div class="psk-job-card__top">
                            <div>
                                <div class="psk-job-card__title">
                                    <span class="psk-job-card__title-text">{{ $job->title }}</span>
                                    @if($job->is_new) <span class="psk-badge psk-badge--new">NEW</span> @endif
                                    <span class="psk-badge psk-badge--category">{{ $job->category->name }}</span>
                                    @if($job->is_featured) <span class="psk-badge psk-badge--featured"><i class="fas fa-star mr-1"></i>Featured</span> @endif
                                    @php $sb = $job->status_badge; @endphp
                                    <span class="psk-badge psk-badge--{{ str_replace('badge-', '', $sb['class']) }}">{{ $sb['label'] }}</span>
                                </div>
                                <div class="psk-job-card__dept">
                                    <i class="fas fa-building"></i> {{ $job->department }}
                                    @if($job->location) · <i class="fas fa-map-marker-alt"></i> {{ $job->location }} @endif
                                </div>
                            </div>
                        </div>

                        <div class="psk-job-card__meta">
                            <div class="psk-job-card__meta-item">
                                <i class="fas fa-users"></i>
                                <span>Vacancies: <strong>{{ number_format($job->total_posts) }}</strong></span>
                            </div>
                            @if($job->apply_start)
                            <div class="psk-job-card__meta-item">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Apply Start: <strong>{{ $job->apply_start->format('d M Y') }}</strong></span>
                            </div>
                            @endif
                            @if($job->apply_end)
                            <div class="psk-job-card__meta-item {{ $job->is_urgent ? 'psk-urgent' : '' }}">
                                <i class="fas fa-calendar-times"></i>
                                <span>Last Date: <strong>
                                    {{ $job->apply_end->format('d M Y') }}
                                    @if($job->is_urgent) <i class="fas fa-fire" title="Closing soon!"></i> @endif
                                </strong></span>
                            </div>
                            @endif
                            @if($job->apply_end && $job->is_urgent)
                            <div class="psk-job-card__meta-item psk-urgent psk-job-countdown-inline"
                                 data-deadline="{{ $job->apply_end->copy()->endOfDay()->toIso8601String() }}">
                                <i class="fas fa-bolt"></i>
                                <span class="psk-job-countdown-inline__text">Closes in: <strong>
                                    <span class="psk-cd-d">--</span>d
                                    <span class="psk-cd-h">--</span>h
                                    <span class="psk-cd-m">--</span>m
                                    <span class="psk-cd-s">--</span>s
                                </strong></span>
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
                @empty
                <div class="psk-no-results">
                    <i class="fas fa-search"></i>
                    <h5>No Jobs Found</h5>
                    <p>No jobs match your current filters. Try clearing them or check back later.</p>
                    <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm" style="margin-top:10px;">View All Jobs</a>
                </div>
                @endforelse

                {{-- Pagination --}}
                @if($jobs->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $jobs->links() }}
                </div>
                @endif

            </div>{{-- /col-jobs --}}

            {{-- ── Sidebar ─────────────────────────────────── --}}
            <div class="col-lg-4 col-xl-3">
                @include('jobs._sidebar')
            </div>

        </div>
    </div>
</section>

{{-- ── Below-the-listing content — the hub's how-to-apply, eligibility
     and FAQ blocks only render here, never on category pages, so the
     ~15 department pages don't all carry the same paragraphs as
     duplicate/near-duplicate content. ──────────────────────────── --}}
@if(!isset($category))

    @if($pageSettings->how_to_apply_content)
    <section class="ftco-section ftco-no-pt psk-jobs-content-block">
        <div class="container">
            <h2 class="psk-jobs-content-block__h2">How to Apply for a Punjab Government Job</h2>
            <div class="psk-jobs-content-block__body">{!! $pageSettings->how_to_apply_content !!}</div>
        </div>
    </section>
    @endif

    @if($pageSettings->eligibility_content)
    <section class="ftco-section ftco-no-pt psk-jobs-content-block">
        <div class="container">
            <h2 class="psk-jobs-content-block__h2">Eligibility for Punjab Government Jobs</h2>
            <div class="psk-jobs-content-block__body">{!! $pageSettings->eligibility_content !!}</div>
        </div>
    </section>
    @endif

    @if(!empty($pageSettings->faqs))
    <section class="ftco-section ftco-no-pt psk-jobs-content-block" id="faq">
        <div class="container">
            <h2 class="psk-jobs-content-block__h2">Frequently Asked Questions</h2>
            <div class="psk-faq-new">
                <div class="psk-faq-new__list">
                    @foreach($pageSettings->faqs as $i => $faq)
                    @continue(empty($faq['question']) || empty($faq['answer']))
                    <div class="psk-faq-new__item {{ $i === 0 ? 'psk-faq-new__item--open' : '' }}">
                        <div class="psk-faq-new__q">
                            <div class="psk-faq-new__num">{{ $i + 1 }}</div>
                            <span class="psk-faq-new__q-text">{{ $faq['question'] }}</span>
                            <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                        </div>
                        <div class="psk-faq-new__a">{{ $faq['answer'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

@endif

{{-- Disclaimer — same component used on /services, must appear on jobs
     pages too since this is exactly the content most likely to read as
     "official" to a first-time visitor. --}}
<div class="psk-disclaimer-bar">
    <div class="container">
        <span class="fa fa-info-circle mr-2"></span>
        <strong>Disclaimer:</strong> Punjab Saathi is a <strong>private information & assistance platform</strong>
        and is <strong>not an official government website or recruitment board</strong>. Always verify
        vacancy details, dates, and apply through the official notification/website linked on each posting.
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/psk-job-countdown.js') }}"></script>
@endpush
