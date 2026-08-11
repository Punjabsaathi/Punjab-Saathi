{{-- Save as: resources/views/jobs/admit-cards.blade.php --}}
@extends('layouts.app')
@section('title', 'Admit Cards | Hall Tickets | Punjab Seva Kendra')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--or:#fc5e28;--nv:#040e26;--gr:#f8f9fb;--bd:#e4e7ec;--txt:#4b5563;--blu:#1d4ed8;--blu-bg:#dbeafe;}
.jobs-hero{background:linear-gradient(135deg,#040e26 0%,#0d275c 60%,#112278 100%);padding:32px 0 20px;}
.jobs-hero .breadcrumb{background:transparent;padding:0;margin-bottom:8px;}
.jobs-hero .breadcrumb-item a{color:var(--or);}
.jobs-hero .breadcrumb-item.active{color:rgba(255,255,255,.6);}
.jobs-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.4);}
.jobs-hero h1{font-family:'Poppins',sans-serif;font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:4px;}
.jobs-hero p{color:rgba(255,255,255,.72);font-size:13px;margin:0;}
.ac-card{background:#fff;border-radius:8px;box-shadow:0 2px 10px rgba(4,14,38,.08);border-left:4px solid var(--blu);margin-bottom:12px;padding:16px;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;}
.ac-card:hover{box-shadow:0 6px 20px rgba(4,14,38,.12);}
.ac-info h5{font-family:'Poppins',sans-serif;font-weight:800;font-size:14px;color:var(--nv);margin:0 0 4px;}
.ac-info a{color:var(--nv);text-decoration:none;}
.ac-info a:hover{color:var(--or);}
.ac-job-link{font-size:11px;color:var(--or);font-weight:700;text-decoration:none;}
.ac-meta{display:flex;flex-wrap:wrap;gap:12px;margin-top:8px;}
.ac-m{font-size:11px;color:var(--txt);display:flex;align-items:center;gap:4px;}
.ac-m i{color:var(--or);font-size:10px;}
.btn-dl{display:inline-flex;align-items:center;gap:5px;background:var(--blu);color:#fff!important;font-size:11px;font-weight:700;padding:8px 16px;border-radius:4px;text-decoration:none;transition:background .15s;}
.btn-dl:hover{background:#1e3a8a;text-decoration:none;}
</style>
@endpush

@section('content')
<section class="jobs-hero">
    <div class="container" style="position:relative;z-index:1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Sarkari Naukri</a></li>
                <li class="breadcrumb-item active">Admit Cards</li>
            </ol>
        </nav>
        <h1><i class="fas fa-id-card mr-2" style="color:var(--or);"></i>Admit Cards / Hall Tickets</h1>
        <p>Download your hall ticket for government exams — Punjab, SSC, Railway, Banking & more</p>
    </div>
</section>

<section class="py-4">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                @forelse($cards as $card)
                <div class="ac-card">
                    <div class="ac-info">
                        <h5><a href="{{ route('jobs.show', $card->job->slug) }}#admit">{{ $card->title }}</a></h5>
                        <a href="{{ route('jobs.show', $card->job->slug) }}" class="ac-job-link">
                            <i class="fas fa-briefcase mr-1"></i>{{ $card->job->title ?? 'View Job' }}
                        </a>
                        <div class="ac-meta">
                            @if($card->release_date)<div class="ac-m"><i class="fas fa-calendar-plus"></i> Released: <strong>{{ $card->release_date->format('d M Y') }}</strong></div>@endif
                            @if($card->exam_date)<div class="ac-m"><i class="fas fa-calendar-check"></i> Exam: <strong style="color:var(--or);">{{ $card->exam_date->format('d M Y') }}</strong></div>@endif
                            <div class="ac-m"><i class="fas fa-tag"></i> {{ $card->job->category->name ?? '' }}</div>
                        </div>
                    </div>
                    <a href="{{ $card->download_link }}" target="_blank" class="btn-dl">
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
                @empty
                <div class="text-center py-5 bg-white rounded shadow-sm">
                    <i class="fas fa-id-card fa-3x mb-3" style="color:#e5e7eb;"></i>
                    <h5 style="font-family:'Poppins',sans-serif;color:var(--nv);">No Admit Cards Yet</h5>
                    <p style="color:#9ca3af;font-size:13px;">Admit cards will appear here once released. Check back soon.</p>
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
