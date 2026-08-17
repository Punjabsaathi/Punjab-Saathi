{{-- ─────────────────────────────────────────────────────────
     Save as: resources/views/jobs/index.blade.php
     ───────────────────────────────────────────────────────── --}}
@extends('layouts.app')

@section('title', 'Sarkari Naukri | Government Jobs | Punjab Saathi')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/psk-jobs.css') }}">
@endpush

@section('content')

{{-- ── Hero — reuses the site's standard detail-page banner
     (.psk-detail-hero, already used by /services/{slug}) instead of
     a page-specific one, and the same background photo, so utility
     pages share one consistent banner style. ── --}}
<section class="psk-detail-hero" style="background-image: url('{{ asset('images/bg_1.jpg') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            @if(isset($category))
                <a href="{{ route('jobs.index') }}">Sarkari Naukri</a>
                <span class="fa fa-chevron-right"></span>
                <span>{{ $category->name }}</span>
            @else
                <span>Sarkari Naukri</span>
            @endif
        </nav>
        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:#fc5e2822;">
                <span class="fas fa-briefcase" style="color:#fc5e28;"></span>
            </div>
            <div>
                <h1 class="psk-detail-hero__title">{{ isset($category) ? $category->name : 'Latest Sarkari Naukri Alerts' }}</h1>
                <p class="psk-detail-hero__desc">PSSSB · Punjab Police · SSC · RRB · Banking · NHM — All Punjab Government Jobs at One Place</p>
                <div class="psk-detail-hero__meta">
                    <span><strong>{{ $stats['total'] }}</strong> Total Jobs</span>
                    <span><strong>{{ $stats['active'] }}</strong> Active</span>
                    <span><strong>{{ $stats['upcoming'] }}</strong> Upcoming</span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ── Live Ticker ──────────────────────────────────────── --}}
@php
    $tickerJobs = \App\Models\GovJob::published()->where('status','active')->latest()->limit(8)->get();
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
                <div class="psk-job-card {{ $job->is_featured ? 'psk-job-card--featured' : '' }}">
                    <div class="psk-job-card__body">
                        <div class="psk-job-card__top">
                            <div>
                                <div class="psk-job-card__title">
                                    <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    @if($job->is_new) <span class="psk-badge psk-badge--new">NEW</span> @endif
                                </div>
                                <div class="psk-job-card__dept">
                                    <i class="fas fa-building"></i> {{ $job->department }}
                                    @if($job->location) · <i class="fas fa-map-marker-alt"></i> {{ $job->location }} @endif
                                </div>
                                <div class="psk-job-card__badges">
                                    <span class="psk-badge psk-badge--category">{{ $job->category->name }}</span>
                                    @if($job->is_featured) <span class="psk-badge psk-badge--featured"><i class="fas fa-star mr-1"></i>Featured</span> @endif
                                    @php $sb = $job->status_badge; @endphp
                                    <span class="psk-badge psk-badge--{{ str_replace('badge-', '', $sb['class']) }}">{{ $sb['label'] }}</span>
                                </div>
                            </div>
                            <div class="psk-job-card__stats">
                                <div class="psk-job-card__count">
                                    <div class="psk-job-card__count-num">{{ number_format($job->total_posts) }}</div>
                                    <div class="psk-job-card__count-label">Vacancies</div>
                                </div>
                                @if($job->apply_end && $job->apply_end->copy()->endOfDay()->isFuture())
                                <div class="psk-job-countdown-banner {{ $job->is_urgent ? 'psk-job-countdown-banner--urgent' : '' }}"
                                     data-deadline="{{ $job->apply_end->copy()->endOfDay()->toIso8601String() }}">
                                    <div class="psk-job-countdown-banner__label">
                                        <i class="fas fa-bolt"></i> Closes In
                                    </div>
                                    <div class="psk-job-countdown-banner__timer">
                                        <div class="psk-job-countdown-banner__unit">
                                            <span class="psk-job-countdown-banner__num psk-cd-d">--</span>
                                            <span class="psk-job-countdown-banner__lbl">Days</span>
                                        </div>
                                        <span class="psk-job-countdown-banner__colon">:</span>
                                        <div class="psk-job-countdown-banner__unit">
                                            <span class="psk-job-countdown-banner__num psk-cd-h">--</span>
                                            <span class="psk-job-countdown-banner__lbl">Hrs</span>
                                        </div>
                                        <span class="psk-job-countdown-banner__colon">:</span>
                                        <div class="psk-job-countdown-banner__unit">
                                            <span class="psk-job-countdown-banner__num psk-cd-m">--</span>
                                            <span class="psk-job-countdown-banner__lbl">Min</span>
                                        </div>
                                        <span class="psk-job-countdown-banner__colon">:</span>
                                        <div class="psk-job-countdown-banner__unit">
                                            <span class="psk-job-countdown-banner__num psk-cd-s">--</span>
                                            <span class="psk-job-countdown-banner__lbl">Sec</span>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="psk-job-card__meta">
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
                            @if($job->qualification)
                            <div class="psk-job-card__meta-item">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ Str::limit($job->qualification, 50) }}</span>
                            </div>
                            @endif
                            @if($job->salary_pay_scale)
                            <div class="psk-job-card__meta-item">
                                <i class="fas fa-rupee-sign"></i>
                                <span><strong>{{ $job->salary_pay_scale }}</strong></span>
                            </div>
                            @endif
                        </div>

                        @if($job->short_description)
                        <p class="psk-job-card__desc">{{ Str::limit($job->short_description, 160) }}</p>
                        @endif
                    </div>
                    <div class="psk-job-card__footer">
                        <span class="psk-job-card__posted">
                            <i class="fas fa-clock mr-1"></i> Posted {{ $job->created_at->diffForHumans() }}
                        </span>
                        <div class="psk-job-card__actions">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="btn btn-primary btn-outline-primary btn-sm">
                                <i class="fas fa-eye mr-1"></i> Full Details
                            </a>
                            @if($job->apply_link)
                            <a href="{{ $job->apply_link }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-external-link-alt mr-1"></i> Apply Online
                            </a>
                            @endif
                            @if($job->notification_link)
                            <a href="{{ $job->notification_link }}" target="_blank" class="btn btn-primary btn-outline-primary btn-sm">
                                <i class="fas fa-file-pdf mr-1"></i> Notification
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
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

@endsection

@push('scripts')
<script src="{{ asset('js/psk-job-countdown.js') }}"></script>
@endpush
