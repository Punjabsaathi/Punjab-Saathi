{{-- ─────────────────────────────────────────────────────────
     Save as: resources/views/jobs/index.blade.php
     ─────────────────────────────────────────────────────────
     Change 'layouts.app' to match YOUR layout file name.
     e.g. layouts.master / layouts.main / layouts.ftco
     ───────────────────────────────────────────────────────── --}}
@extends('layouts.app')

@section('title', 'Sarkari Naukri | Government Jobs | Punjab Seva Kendra')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--or:#fc5e28;--or-dark:#e04d1c;--or-bg:rgba(252,94,40,.10);--nv:#040e26;--gr:#f8f9fb;--bd:#e4e7ec;--txt:#4b5563;--grn:#16a34a;--grn-bg:#dcfce7;--blu:#1d4ed8;--blu-bg:#dbeafe;--red:#dc2626;--red-bg:#fee2e2;--rad:6px;--sha:0 2px 10px rgba(4,14,38,.10);}
/* ── Hero ── */
.jobs-hero{background:linear-gradient(135deg,#040e26 0%,#0d275c 60%,#112278 100%);padding:36px 0 24px;position:relative;overflow:hidden;}
.jobs-hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");}
.jobs-hero .breadcrumb{background:transparent;padding:0;margin-bottom:8px;}
.jobs-hero .breadcrumb-item a{color:var(--or);}
.jobs-hero .breadcrumb-item.active{color:rgba(255,255,255,.6);}
.jobs-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.4);}
.jobs-hero h1{font-family:'Poppins',sans-serif;font-size:1.9rem;font-weight:800;color:#fff;margin-bottom:4px;}
.jobs-hero p{color:rgba(255,255,255,.72);font-size:13px;margin:0;}
.stat-pill{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.10);border:1px solid rgba(255,255,255,.18);border-radius:20px;padding:4px 13px;font-size:12px;font-weight:700;color:rgba(255,255,255,.85);}
.stat-pill .num{color:var(--or);font-size:14px;font-weight:800;}
/* ── Ticker ── */
.jobs-ticker{display:flex;align-items:center;overflow:hidden;height:38px;background:#fff;border-bottom:1px solid var(--bd);box-shadow:0 1px 4px rgba(0,0,0,.06);}
.ticker-lbl{background:var(--or);color:#fff;font-weight:800;font-size:10px;letter-spacing:1px;text-transform:uppercase;padding:0 14px;height:38px;display:flex;align-items:center;gap:6px;white-space:nowrap;flex-shrink:0;}
.ticker-dot{width:7px;height:7px;background:#fff;border-radius:50%;animation:bpulse 1s infinite;}
@keyframes bpulse{0%,100%{opacity:1}50%{opacity:.3}}
.ticker-wrap{flex:1;overflow:hidden;}
.ticker-inner{display:flex;align-items:center;white-space:nowrap;height:38px;animation:tscroll 50s linear infinite;}
.ticker-inner:hover{animation-play-state:paused;}
@keyframes tscroll{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
.t-item{display:inline-flex;align-items:center;gap:6px;padding:0 24px;font-size:12px;font-weight:600;color:var(--nv);}
.t-item a{color:var(--nv);text-decoration:none;}
.t-item a:hover{color:var(--or);}
.t-sep{color:var(--bd);font-size:16px;padding:0 4px;}
.tb{font-size:9px;font-weight:800;letter-spacing:.8px;padding:1px 6px;border-radius:3px;text-transform:uppercase;flex-shrink:0;}
.tb-job{background:var(--red-bg);color:var(--red);}
.tb-admit{background:var(--blu-bg);color:var(--blu);}
.tb-result{background:var(--grn-bg);color:var(--grn);}
/* ── Filter Bar ── */
.filter-bar{background:#fff;border-radius:8px;box-shadow:var(--sha);padding:14px 16px;margin-bottom:16px;display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
.f-search{flex:1;min-width:180px;display:flex;align-items:center;border:1px solid var(--bd);border-radius:var(--rad);overflow:hidden;}
.f-search i{padding:0 10px;color:#9ca3af;font-size:13px;flex-shrink:0;}
.f-search input{border:none;outline:none;flex:1;padding:8px 10px 8px 0;font-size:13px;color:var(--nv);background:transparent;}
.f-select{border:1px solid var(--bd);border-radius:var(--rad);padding:8px 12px;font-size:13px;background:#fff;outline:none;min-width:140px;color:var(--nv);}
.btn-filter-clear{background:var(--gr);border:1px solid var(--bd);color:var(--txt);font-size:12px;font-weight:700;padding:7px 12px;border-radius:var(--rad);text-decoration:none;white-space:nowrap;}
.f-count{margin-left:auto;color:#9ca3af;font-size:12px;font-weight:600;white-space:nowrap;}
/* ── Category Pills ── */
.cat-pills{display:flex;flex-wrap:wrap;gap:7px;margin-bottom:14px;}
.c-pill{display:inline-flex;align-items:center;gap:4px;padding:5px 13px;border-radius:20px;border:2px solid var(--bd);background:#fff;font-size:12px;font-weight:700;color:var(--txt);text-decoration:none;white-space:nowrap;transition:all .15s;}
.c-pill:hover,.c-pill.active{border-color:var(--or);background:var(--or);color:#fff;text-decoration:none;}
.c-pill .cnt{background:rgba(0,0,0,.12);padding:0 5px;border-radius:10px;font-size:10px;}
/* ── Job Card ── */
.job-card{background:#fff;border-radius:8px;box-shadow:var(--sha);border:1px solid #f0f2f5;margin-bottom:12px;overflow:hidden;transition:box-shadow .2s,transform .2s;}
.job-card:hover{box-shadow:0 6px 20px rgba(4,14,38,.13);transform:translateY(-2px);}
.job-card.featured{border-left:3px solid var(--or);}
.jc-body{padding:16px;}
.jc-top{display:flex;align-items:flex-start;justify-content:space-between;gap:12px;flex-wrap:wrap;}
.jc-title{font-family:'Poppins',sans-serif;font-size:14px;font-weight:800;color:var(--nv);margin-bottom:3px;line-height:1.3;}
.jc-title a{color:var(--nv);text-decoration:none;}
.jc-title a:hover{color:var(--or);}
.jc-dept{font-size:11px;color:#9ca3af;font-weight:600;}
.jc-dept i{font-size:9px;margin-right:3px;}
.jc-badges{display:flex;flex-wrap:wrap;gap:5px;margin-top:6px;}
.b-new{display:inline-block;background:var(--red-bg);color:var(--red);font-size:9px;font-weight:800;letter-spacing:1px;padding:2px 7px;border-radius:3px;text-transform:uppercase;animation:nblink 1.5s ease-in-out infinite;}
@keyframes nblink{0%,100%{opacity:1}50%{opacity:.4}}
.b-feat{background:#fef3c7;color:#d97706;font-size:9px;font-weight:800;letter-spacing:.8px;padding:2px 7px;border-radius:3px;text-transform:uppercase;}
.b-cat{background:var(--or-bg);color:var(--or);font-size:10px;font-weight:800;padding:2px 10px;border-radius:12px;}
.s-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:800;letter-spacing:.4px;text-transform:uppercase;padding:3px 10px;border-radius:12px;white-space:nowrap;}
.s-badge::before{content:'';width:5px;height:5px;border-radius:50%;display:inline-block;}
.sb-active{background:var(--grn-bg);color:var(--grn)}.sb-active::before{background:var(--grn);}
.sb-upcoming{background:var(--blu-bg);color:var(--blu)}.sb-upcoming::before{background:var(--blu);}
.sb-expired{background:#f3f4f6;color:#6b7280}.sb-expired::before{background:#9ca3af;}
.jc-meta{display:flex;flex-wrap:wrap;gap:14px;margin-top:10px;padding-top:10px;border-top:1px solid #f5f6f8;}
.jm{display:flex;align-items:center;gap:5px;font-size:11px;color:var(--txt);}
.jm i{color:var(--or);font-size:11px;width:14px;text-align:center;}
.jm strong{color:var(--nv);font-weight:700;}
.jc-foot{display:flex;align-items:center;justify-content:space-between;padding:10px 16px;background:var(--gr);border-top:1px solid #f0f2f5;flex-wrap:wrap;gap:8px;}
.jc-actions{display:flex;gap:7px;}
.btn-view-job,.btn-apply-job,.btn-notif-job{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;padding:6px 13px;border-radius:4px;text-decoration:none;transition:all .15s;}
.btn-view-job{background:var(--nv);color:#fff!important;}
.btn-view-job:hover{background:var(--or);text-decoration:none;}
.btn-apply-job{background:var(--or);color:#fff!important;}
.btn-apply-job:hover{background:var(--or-dark);text-decoration:none;}
.btn-notif-job{background:transparent;color:var(--or)!important;border:1.5px solid var(--or);}
.btn-notif-job:hover{background:var(--or);color:#fff!important;text-decoration:none;}
.date-urgent{color:var(--red);font-weight:800;}
.date-normal{color:var(--nv);font-weight:700;}
/* ── Empty ── */
.no-results{text-align:center;padding:60px 20px;background:#fff;border-radius:8px;box-shadow:var(--sha);}
.no-results i{font-size:48px;color:#e5e7eb;margin-bottom:14px;display:block;}
.no-results h5{color:var(--nv);font-family:'Poppins',sans-serif;font-weight:700;margin-bottom:6px;}
.no-results p{color:#9ca3af;font-size:13px;}
</style>
@endpush

@section('content')

{{-- ── Hero ──────────────────────────────────────────────── --}}
<section class="jobs-hero">
    <div class="container" style="position:relative;z-index:1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                @if(isset($category))
                    <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Sarkari Naukri</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                @else
                    <li class="breadcrumb-item active">Sarkari Naukri</li>
                @endif
            </ol>
        </nav>
        <h1>
            <i class="fas fa-briefcase mr-2" style="color:var(--or);"></i>
            {{ isset($category) ? $category->name : 'Latest Sarkari Naukri Alerts' }}
        </h1>
        <p>PSSSB · Punjab Police · SSC · RRB · Banking · NHM — All Punjab Government Jobs at One Place</p>
        <div class="d-flex flex-wrap mt-3" style="gap:8px;">
            <div class="stat-pill"><span class="num">{{ $stats['total'] }}</span>&nbsp;Total Jobs</div>
            <div class="stat-pill"><span class="num">{{ $stats['active'] }}</span>&nbsp;Active</div>
            <div class="stat-pill"><span class="num">{{ $stats['upcoming'] }}</span>&nbsp;Upcoming</div>
        </div>
    </div>
</section>

{{-- ── Live Ticker ──────────────────────────────────────── --}}
@php
    $tickerJobs = \App\Models\GovJob::published()->where('status','active')->latest()->limit(8)->get();
@endphp
@if($tickerJobs->count())
<div class="jobs-ticker">
    <div class="ticker-lbl">
        <div class="ticker-dot"></div>
        <i class="fas fa-bell" style="font-size:10px;"></i> LIVE
    </div>
    <div class="ticker-wrap">
        <div class="ticker-inner">
            @foreach([$tickerJobs, $tickerJobs] as $group)
                @foreach($group as $tj)
                    <span class="t-item">
                        <span class="tb tb-job">JOBS</span>
                        <a href="{{ route('jobs.show', $tj->slug) }}">{{ $tj->title }}</a>
                        @if($tj->apply_end)
                            — Last Date: <strong style="color:var(--red);">{{ $tj->apply_end->format('d M Y') }}</strong>
                        @endif
                    </span>
                    <span class="t-sep">|</span>
                @endforeach
            @endforeach
        </div>
    </div>
</div>
@endif

{{-- ── Main Content ─────────────────────────────────────── --}}
<section class="py-4">
    <div class="container">
        <div class="row">

            {{-- ── Jobs Column ────────────────────────────── --}}
            <div class="col-lg-8 col-xl-9">

                {{-- Category Pills --}}
                <div class="cat-pills">
                    <a href="{{ route('jobs.index') }}" class="c-pill {{ !isset($category) ? 'active' : '' }}">
                        All <span class="cnt">{{ $stats['total'] }}</span>
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('jobs.category', $cat->slug) }}"
                       class="c-pill {{ (isset($category) && $category->slug === $cat->slug) ? 'active' : '' }}">
                        <i class="fas {{ $cat->icon ?? 'fa-circle' }}" style="font-size:10px;"></i>
                        {{ $cat->name }} <span class="cnt">{{ $cat->jobs_count }}</span>
                    </a>
                    @endforeach
                </div>

                {{-- Filter Bar --}}
                <form method="GET" class="filter-bar">
                    <div class="f-search">
                        <i class="fas fa-search"></i>
                        <input type="search" name="search" value="{{ request('search') }}" placeholder="Search jobs by title or department...">
                    </div>
                    <select name="status" class="f-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="active"   {{ request('status')=='active'   ? 'selected':'' }}>Active</option>
                        <option value="upcoming" {{ request('status')=='upcoming' ? 'selected':'' }}>Upcoming</option>
                        <option value="expired"  {{ request('status')=='expired'  ? 'selected':'' }}>Expired</option>
                    </select>
                    <button type="submit" class="btn-view-job"><i class="fas fa-search"></i> Search</button>
                    @if(request()->hasAny(['search','status']))
                        <a href="{{ isset($category) ? route('jobs.category',$category->slug) : route('jobs.index') }}" class="btn-filter-clear">
                            <i class="fas fa-times mr-1"></i> Clear
                        </a>
                    @endif
                    <span class="f-count">{{ $jobs->total() }} job{{ $jobs->total()!==1?'s':'' }} found</span>
                </form>

                {{-- Jobs List --}}
                @forelse($jobs as $job)
                <div class="job-card {{ $job->is_featured ? 'featured' : '' }}">
                    <div class="jc-body">
                        <div class="jc-top">
                            <div>
                                <div class="jc-title">
                                    <a href="{{ route('jobs.show', $job->slug) }}">{{ $job->title }}</a>
                                    @if($job->is_new) <span class="b-new">NEW</span> @endif
                                </div>
                                <div class="jc-dept">
                                    <i class="fas fa-building"></i> {{ $job->department }}
                                    @if($job->location) · <i class="fas fa-map-marker-alt"></i> {{ $job->location }} @endif
                                </div>
                                <div class="jc-badges">
                                    <span class="b-cat">{{ $job->category->name }}</span>
                                    @if($job->is_featured) <span class="b-feat"><i class="fas fa-star mr-1"></i>Featured</span> @endif
                                    @php
                                        $sb = $job->status_badge;
                                    @endphp
                                    <span class="s-badge {{ $sb['class'] }}">{{ $sb['label'] }}</span>
                                </div>
                            </div>
                            <div class="text-right" style="flex-shrink:0;">
                                <div style="font-family:'Poppins',sans-serif;font-size:24px;font-weight:800;color:var(--or);line-height:1;">
                                    {{ number_format($job->total_posts) }}
                                </div>
                                <div style="font-size:10px;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.5px;">Vacancies</div>
                            </div>
                        </div>

                        <div class="jc-meta">
                            @if($job->apply_start)
                            <div class="jm">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Apply Start: <strong>{{ $job->apply_start->format('d M Y') }}</strong></span>
                            </div>
                            @endif
                            @if($job->apply_end)
                            <div class="jm">
                                <i class="fas fa-calendar-times"></i>
                                <span>Last Date: <strong class="{{ $job->is_urgent ? 'date-urgent' : 'date-normal' }}">
                                    {{ $job->apply_end->format('d M Y') }}
                                    @if($job->is_urgent) <i class="fas fa-fire" title="Closing soon!"></i> @endif
                                </strong></span>
                            </div>
                            @endif
                            @if($job->qualification)
                            <div class="jm">
                                <i class="fas fa-graduation-cap"></i>
                                <span>{{ Str::limit($job->qualification, 50) }}</span>
                            </div>
                            @endif
                            @if($job->salary_pay_scale)
                            <div class="jm">
                                <i class="fas fa-rupee-sign"></i>
                                <span><strong>{{ $job->salary_pay_scale }}</strong></span>
                            </div>
                            @endif
                        </div>

                        @if($job->short_description)
                        <p style="font-size:12px;color:var(--txt);margin:10px 0 0;padding-top:10px;border-top:1px solid #f5f6f8;">
                            {{ Str::limit($job->short_description, 160) }}
                        </p>
                        @endif
                    </div>
                    <div class="jc-foot">
                        <span style="font-size:11px;color:#9ca3af;">
                            <i class="fas fa-clock mr-1"></i> Posted {{ $job->created_at->diffForHumans() }}
                        </span>
                        <div class="jc-actions">
                            <a href="{{ route('jobs.show', $job->slug) }}" class="btn-view-job">
                                <i class="fas fa-eye"></i> Full Details
                            </a>
                            @if($job->apply_link)
                            <a href="{{ $job->apply_link }}" target="_blank" class="btn-apply-job">
                                <i class="fas fa-external-link-alt"></i> Apply Online
                            </a>
                            @endif
                            @if($job->notification_link)
                            <a href="{{ $job->notification_link }}" target="_blank" class="btn-notif-job">
                                <i class="fas fa-file-pdf"></i> Notification
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="no-results">
                    <i class="fas fa-search"></i>
                    <h5>No Jobs Found</h5>
                    <p>No jobs match your current filters. Try clearing them or check back later.</p>
                    <a href="{{ route('jobs.index') }}" class="btn-view-job" style="display:inline-flex;margin-top:10px;">View All Jobs</a>
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
