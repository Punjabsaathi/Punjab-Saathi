{{-- Save as: resources/views/jobs/results.blade.php --}}
@extends('layouts.app')
@section('title', 'Exam Results | Merit List | Punjab Seva Kendra')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--or:#fc5e28;--nv:#040e26;--gr:#f8f9fb;--bd:#e4e7ec;--txt:#4b5563;--grn:#16a34a;--grn-bg:#dcfce7;}
.jobs-hero{background:linear-gradient(135deg,#040e26 0%,#0d275c 60%,#112278 100%);padding:32px 0 20px;}
.jobs-hero .breadcrumb{background:transparent;padding:0;margin-bottom:8px;}
.jobs-hero .breadcrumb-item a{color:var(--or);}
.jobs-hero .breadcrumb-item.active,.jobs-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.5);}
.jobs-hero h1{font-family:'Poppins',sans-serif;font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:4px;}
.jobs-hero p{color:rgba(255,255,255,.72);font-size:13px;margin:0;}
.res-card{background:#fff;border-radius:8px;box-shadow:0 2px 10px rgba(4,14,38,.08);border-left:4px solid var(--grn);margin-bottom:12px;padding:16px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;}
.res-card:hover{box-shadow:0 6px 20px rgba(4,14,38,.12);}
.res-info h5{font-family:'Poppins',sans-serif;font-weight:800;font-size:14px;color:var(--nv);margin:0 0 4px;}
.res-info h5 a{color:var(--nv);text-decoration:none;}
.res-info h5 a:hover{color:var(--or);}
.res-job-link{font-size:11px;color:var(--or);font-weight:700;text-decoration:none;}
.res-meta{display:flex;flex-wrap:wrap;gap:12px;margin-top:8px;}
.res-m{font-size:11px;color:var(--txt);display:flex;align-items:center;gap:4px;}
.res-m i{color:var(--grn);font-size:10px;}
.res-actions{display:flex;flex-direction:column;gap:6px;}
.btn-res{display:inline-flex;align-items:center;gap:5px;font-size:11px;font-weight:700;padding:7px 14px;border-radius:4px;text-decoration:none;transition:all .15s;}
.btn-res-main{background:var(--grn);color:#fff!important;}.btn-res-main:hover{background:#15803d;text-decoration:none;}
.btn-res-out{background:transparent;color:var(--grn)!important;border:1.5px solid var(--grn);}.btn-res-out:hover{background:var(--grn);color:#fff!important;text-decoration:none;}
</style>
@endpush

@section('content')
<section class="jobs-hero">
    <div class="container" style="position:relative;z-index:1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Sarkari Naukri</a></li>
                <li class="breadcrumb-item active">Results</li>
            </ol>
        </nav>
        <h1><i class="fas fa-trophy mr-2" style="color:var(--or);"></i>Exam Results</h1>
        <p>Official results, merit lists, cut off marks, and scorecard downloads — all in one place</p>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                @forelse($results as $result)
                <div class="res-card">
                    <div class="res-info">
                        <h5><a href="{{ route('jobs.show', $result->job->slug) }}#result">{{ $result->title }}</a></h5>
                        <a href="{{ route('jobs.show', $result->job->slug) }}" class="res-job-link">
                            <i class="fas fa-briefcase mr-1"></i>{{ $result->job->title ?? '' }}
                        </a>
                        <div class="res-meta">
                            @if($result->result_date)<div class="res-m"><i class="fas fa-calendar-check"></i> Declared: <strong>{{ $result->result_date->format('d M Y') }}</strong></div>@endif
                            @if($result->cutoff_marks)<div class="res-m"><i class="fas fa-chart-bar"></i> Cut Off: <strong style="color:var(--or);">{{ $result->cutoff_marks }}</strong></div>@endif
                        </div>
                        @if($result->notes)<p style="font-size:11px;color:var(--txt);margin:6px 0 0;">{{ $result->notes }}</p>@endif
                    </div>
                    <div class="res-actions">
                        <a href="{{ $result->download_link }}" target="_blank" class="btn-res btn-res-main"><i class="fas fa-download"></i> Result PDF</a>
                        @if($result->merit_list_link)<a href="{{ $result->merit_list_link }}" target="_blank" class="btn-res btn-res-out"><i class="fas fa-list-ol"></i> Merit List</a>@endif
                        @if($result->scorecard_link)<a href="{{ $result->scorecard_link }}" target="_blank" class="btn-res btn-res-out"><i class="fas fa-file-alt"></i> Scorecard</a>@endif
                    </div>
                </div>
                @empty
                <div class="text-center py-5 bg-white rounded shadow-sm">
                    <i class="fas fa-trophy fa-3x mb-3" style="color:#e5e7eb;"></i>
                    <h5 style="font-family:'Poppins',sans-serif;color:var(--nv);">No Results Declared Yet</h5>
                    <p style="color:#9ca3af;font-size:13px;">Results will appear here once declared officially.</p>
                </div>
                @endforelse
                @if($results->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $results->links() }}</div>
                @endif
            </div>
            <div class="col-lg-4 col-xl-3">@include('jobs._sidebar')</div>
        </div>
    </div>
</section>
@endsection
