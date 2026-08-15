{{-- Save as: resources/views/jobs/results.blade.php --}}
@extends('layouts.app')
@section('title', 'Exam Results | Merit List | Punjab Saathi')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/psk-jobs.css') }}">
@endpush

@section('content')
<section class="psk-detail-hero" style="background-image: url('{{ asset('images/bg_1.jpg') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            <a href="{{ route('jobs.index') }}">Sarkari Naukri</a>
            <span class="fa fa-chevron-right"></span>
            <span>Results</span>
        </nav>
        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:#05966922;">
                <span class="fas fa-trophy" style="color:#059669;"></span>
            </div>
            <div>
                <h1 class="psk-detail-hero__title">Exam Results</h1>
                <p class="psk-detail-hero__desc">Official results, merit lists, cut off marks, and scorecard downloads — all in one place</p>
            </div>
        </div>
    </div>
</section>

<section class="psk-jobs-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                @forelse($results as $result)
                <div class="psk-job-card">
                    <div class="psk-job-card__body">
                        <div class="psk-job-card__top">
                            <div style="display:flex;gap:14px;align-items:flex-start;">
                                <div class="psk-job-card__icon psk-job-card__icon--green"><i class="fas fa-trophy"></i></div>
                                <div>
                                    <div class="psk-job-card__title"><a href="{{ route('jobs.show', $result->job->slug) }}#result">{{ $result->title }}</a></div>
                                    <a href="{{ route('jobs.show', $result->job->slug) }}" class="psk-job-card__dept">
                                        <i class="fas fa-briefcase"></i>{{ $result->job->title ?? '' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="psk-job-card__meta">
                            @if($result->result_date)<div class="psk-job-card__meta-item"><i class="fas fa-calendar-check"></i> Declared: <strong>{{ $result->result_date->format('d M Y') }}</strong></div>@endif
                            @if($result->cutoff_marks)<div class="psk-job-card__meta-item"><i class="fas fa-chart-bar"></i> Cut Off: <strong>{{ $result->cutoff_marks }}</strong></div>@endif
                        </div>
                        @if($result->notes)<p class="psk-job-card__desc">{{ $result->notes }}</p>@endif
                    </div>
                    <div class="psk-job-card__footer" style="justify-content:flex-end;">
                        <div class="psk-job-card__actions">
                            <a href="{{ $result->download_link }}" target="_blank" class="btn btn-primary btn-sm"><i class="fas fa-download mr-1"></i> Result PDF</a>
                            @if($result->merit_list_link)<a href="{{ $result->merit_list_link }}" target="_blank" class="btn btn-primary btn-outline-primary btn-sm"><i class="fas fa-list-ol mr-1"></i> Merit List</a>@endif
                            @if($result->scorecard_link)<a href="{{ $result->scorecard_link }}" target="_blank" class="btn btn-primary btn-outline-primary btn-sm"><i class="fas fa-file-alt mr-1"></i> Scorecard</a>@endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="psk-no-results">
                    <i class="fas fa-trophy"></i>
                    <h5>No Results Declared Yet</h5>
                    <p>Results will appear here once declared officially.</p>
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
