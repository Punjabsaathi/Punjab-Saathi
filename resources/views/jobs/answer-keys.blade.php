{{-- Save as: resources/views/jobs/answer-keys.blade.php --}}
@extends('layouts.app')
@section('title', 'Answer Keys | Official Answer Keys | Punjab Seva Kendra')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--or:#fc5e28;--nv:#040e26;--gr:#f8f9fb;--bd:#e4e7ec;--txt:#4b5563;--amb:#d97706;--amb-bg:#fef3c7;--red:#dc2626;--red-bg:#fee2e2;}
.jobs-hero{background:linear-gradient(135deg,#040e26 0%,#0d275c 60%,#112278 100%);padding:32px 0 20px;}
.jobs-hero .breadcrumb{background:transparent;padding:0;margin-bottom:8px;}
.jobs-hero .breadcrumb-item a{color:var(--or);}
.jobs-hero .breadcrumb-item.active,.jobs-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.5);}
.jobs-hero h1{font-family:'Poppins',sans-serif;font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:4px;}
.jobs-hero p{color:rgba(255,255,255,.72);font-size:13px;margin:0;}
.ak-card{background:#fff;border-radius:8px;box-shadow:0 2px 10px rgba(4,14,38,.08);border-left:4px solid var(--amb);margin-bottom:12px;padding:16px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;}
.ak-card:hover{box-shadow:0 6px 20px rgba(4,14,38,.12);}
.ak-info h5{font-family:'Poppins',sans-serif;font-weight:800;font-size:14px;color:var(--nv);margin:0 0 4px;}
.ak-info h5 a{color:var(--nv);text-decoration:none;}
.ak-info h5 a:hover{color:var(--or);}
.ak-job-link{font-size:11px;color:var(--or);font-weight:700;text-decoration:none;}
.ak-meta{display:flex;flex-wrap:wrap;gap:12px;margin-top:8px;}
.ak-m{font-size:11px;color:var(--txt);display:flex;align-items:center;gap:4px;}
.ak-m i{color:var(--amb);font-size:10px;}
.btn-ak{display:inline-flex;align-items:center;gap:5px;background:var(--amb);color:#fff!important;font-size:11px;font-weight:700;padding:8px 16px;border-radius:4px;text-decoration:none;transition:background .15s;}
.btn-ak:hover{background:#b45309;text-decoration:none;}
</style>
@endpush

@section('content')
<section class="jobs-hero">
    <div class="container" style="position:relative;z-index:1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Sarkari Naukri</a></li>
                <li class="breadcrumb-item active">Answer Keys</li>
            </ol>
        </nav>
        <h1><i class="fas fa-key mr-2" style="color:var(--or);"></i>Official Answer Keys</h1>
        <p>Download official answer keys and raise objections before the deadline</p>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                @forelse($answerKeys as $ak)
                <div class="ak-card">
                    <div class="ak-info">
                        <h5><a href="{{ route('jobs.show', $ak->job->slug) }}#answerkey">{{ $ak->title }}</a></h5>
                        <a href="{{ route('jobs.show', $ak->job->slug) }}" class="ak-job-link">
                            <i class="fas fa-briefcase mr-1"></i>{{ $ak->job->title ?? '' }}
                        </a>
                        <div class="ak-meta">
                            @if($ak->release_date)<div class="ak-m"><i class="fas fa-calendar-plus"></i> Released: <strong>{{ $ak->release_date->format('d M Y') }}</strong></div>@endif
                            @if($ak->objection_end_date)<div class="ak-m"><i class="fas fa-exclamation-circle" style="color:var(--red);"></i> Objection Deadline: <strong style="color:var(--red);">{{ $ak->objection_end_date->format('d M Y') }}</strong></div>@endif
                        </div>
                        @if($ak->objection_details)<p style="font-size:11px;color:var(--txt);margin:6px 0 0;">{{ $ak->objection_details }}</p>@endif
                    </div>
                    <a href="{{ $ak->download_link }}" target="_blank" class="btn-ak">
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
                @empty
                <div class="text-center py-5 bg-white rounded shadow-sm">
                    <i class="fas fa-key fa-3x mb-3" style="color:#e5e7eb;"></i>
                    <h5 style="font-family:'Poppins',sans-serif;color:var(--nv);">No Answer Keys Released Yet</h5>
                    <p style="color:#9ca3af;font-size:13px;">Answer keys will appear here once officially released.</p>
                </div>
                @endforelse
                @if($answerKeys->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $answerKeys->links() }}</div>
                @endif
            </div>
            <div class="col-lg-4 col-xl-3">@include('jobs._sidebar')</div>
        </div>
    </div>
</section>
@endsection
