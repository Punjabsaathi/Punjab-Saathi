{{-- Save as: resources/views/jobs/answer-keys.blade.php --}}
@extends('layouts.app')
@section('title', 'Answer Keys | Official Answer Keys | Punjab Saathi')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/psk-jobs.css') }}">
@endpush

@section('content')
<section class="psk-detail-hero" style="background-image: url('{{ asset('images/government-job-vacancy-listing.jpg') }}');">
    <div class="psk-detail-hero__overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            <a href="{{ route('jobs.index') }}">Sarkari Naukri</a>
            <span class="fa fa-chevron-right"></span>
            <span>Answer Keys</span>
        </nav>
        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:#d9770622;">
                <span class="fas fa-key" style="color:#d97706;"></span>
            </div>
            <div>
                <h1 class="psk-detail-hero__title">Official Answer Keys</h1>
                <p class="psk-detail-hero__desc">Download official answer keys and raise objections before the deadline</p>
            </div>
        </div>
    </div>
</section>

<section class="psk-jobs-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                @forelse($answerKeys as $ak)
                <div class="psk-job-card">
                    <div class="psk-job-card__body">
                        <div class="psk-job-card__top">
                            <div style="display:flex;gap:14px;align-items:flex-start;">
                                <div class="psk-job-card__icon psk-job-card__icon--amber"><i class="fas fa-key"></i></div>
                                <div>
                                    <div class="psk-job-card__title"><a href="{{ route('jobs.show', $ak->job->slug) }}#answerkey">{{ $ak->title }}</a></div>
                                    <a href="{{ route('jobs.show', $ak->job->slug) }}" class="psk-job-card__dept">
                                        <i class="fas fa-briefcase"></i>{{ $ak->job->title ?? '' }}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="psk-job-card__meta">
                            @if($ak->release_date)<div class="psk-job-card__meta-item"><i class="fas fa-calendar-plus"></i> Released: <strong>{{ $ak->release_date->format('d M Y') }}</strong></div>@endif
                            @if($ak->objection_end_date)<div class="psk-job-card__meta-item psk-urgent"><i class="fas fa-exclamation-circle"></i> Objection Deadline: <strong>{{ $ak->objection_end_date->format('d M Y') }}</strong></div>@endif
                        </div>
                        @if($ak->objection_details)<p class="psk-job-card__desc">{{ $ak->objection_details }}</p>@endif
                    </div>
                    <div class="psk-job-card__footer" style="justify-content:flex-end;">
                        <div class="psk-job-card__actions">
                            <a href="{{ $ak->download_link }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-download mr-1"></i> Download
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="psk-no-results">
                    <i class="fas fa-key"></i>
                    <h5>No Answer Keys Released Yet</h5>
                    <p>Answer keys will appear here once officially released.</p>
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
