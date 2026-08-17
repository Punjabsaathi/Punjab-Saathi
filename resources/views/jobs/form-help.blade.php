{{-- Save as: resources/views/jobs/form-help.blade.php --}}
@extends('layouts.app')
@section('title', 'Form Filling Help | Government Job Applications | Punjab Saathi')

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
            <span>Form Filling Help</span>
        </nav>
        <div class="psk-detail-hero__body">
            <div class="psk-detail-hero__icon-wrap" style="background:#fc5e2822;">
                <span class="fas fa-file-signature" style="color:#fc5e28;"></span>
            </div>
            <div>
                <h1 class="psk-detail-hero__title">Government Job Form Filling Help</h1>
                <p class="psk-detail-hero__desc">Let our experts fill your government job application — zero errors, zero rejections, guaranteed</p>
            </div>
        </div>
    </div>
</section>

<section class="psk-jobs-section">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="psk-fh-card">
                    <div class="psk-fh-card__head">
                        <h4><i class="fas fa-file-alt mr-2"></i>Request Form Filling Assistance</h4>
                        <p>Fill the form below — our team will contact you within a few hours</p>
                    </div>
                    <div class="psk-fh-card__body">
                        <form action="{{ route('jobs.form-help.submit') }}" method="POST" novalidate data-psk-loading="Submitting your request…">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Full Name <span class="req">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Your full name" required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mobile Number <span class="req">*</span></label>
                                        <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" placeholder="10-digit mobile number" required>
                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Email Address <small class="text-muted font-weight-normal">(optional)</small></label>
                                <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="your@email.com">
                            </div>
                            <div class="form-group">
                                <label>Service Required <span class="req">*</span></label>
                                <select name="service_type" class="form-control @error('service_type') is-invalid @enderror" required>
                                    <option value="">-- Select a service --</option>
                                    <option value="job_form"   {{ old('service_type')=='job_form'   ?'selected':'' }}>Government Job Form Filling</option>
                                    <option value="admit_card" {{ old('service_type')=='admit_card' ?'selected':'' }}>Admit Card Download Help</option>
                                    <option value="result"     {{ old('service_type')=='result'     ?'selected':'' }}>Result Check Help</option>
                                    <option value="answer_key" {{ old('service_type')=='answer_key' ?'selected':'' }}>Answer Key Assistance</option>
                                    <option value="other"      {{ old('service_type')=='other'      ?'selected':'' }}>Other / General Query</option>
                                </select>
                                @error('service_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="form-group">
                                <label>Job Name <small class="text-muted font-weight-normal">(optional)</small></label>
                                <input type="text" name="job_name" class="form-control" value="{{ old('job_name') }}" placeholder="e.g. PSSSB Clerk, Punjab Police Constable">
                            </div>
                            <div class="form-group">
                                <label>Message <small class="text-muted font-weight-normal">(optional)</small></label>
                                <textarea name="message" class="form-control" rows="3" placeholder="Any additional details...">{{ old('message') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary" style="width:100%;padding:13px;">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="psk-fh-card mb-4">
                    <div class="psk-fh-card__head"><h4><i class="fas fa-star mr-2"></i>Why Choose Punjab Saathi?</h4></div>
                    <div class="psk-fh-card__body" style="padding:16px 24px;">
                        <ul class="psk-why-list">
                            <li><i class="fas fa-check-circle"></i> 100% accurate form filling — zero rejections guaranteed</li>
                            <li><i class="fas fa-check-circle"></i> Eligibility verified before applying</li>
                            <li><i class="fas fa-check-circle"></i> Complete document review included</li>
                            <li><i class="fas fa-check-circle"></i> WhatsApp support throughout the process</li>
                            <li><i class="fas fa-check-circle"></i> Affordable &amp; fully transparent pricing</li>
                            <li><i class="fas fa-check-circle"></i> 5,000+ successful applications filed</li>
                            <li><i class="fas fa-check-circle"></i> All Punjab government portals covered</li>
                        </ul>
                    </div>
                </div>

                <div class="psk-fh-card mb-4">
                    <div class="psk-fh-card__head"><h4><i class="fas fa-list-ol mr-2"></i>Our Process</h4></div>
                    <div class="psk-fh-card__body" style="padding:16px 24px;">
                        <div class="psk-proc-step">
                            <div class="psk-proc-step__num">1</div>
                            <div><div class="psk-proc-step__title">Submit Your Request</div><p class="psk-proc-step__desc">Fill the form or WhatsApp us with your details</p></div>
                        </div>
                        <div class="psk-proc-step">
                            <div class="psk-proc-step__num">2</div>
                            <div><div class="psk-proc-step__title">Eligibility Check</div><p class="psk-proc-step__desc">We verify you're eligible before proceeding</p></div>
                        </div>
                        <div class="psk-proc-step">
                            <div class="psk-proc-step__num">3</div>
                            <div><div class="psk-proc-step__title">Document Collection</div><p class="psk-proc-step__desc">Send us your documents via WhatsApp securely</p></div>
                        </div>
                        <div class="psk-proc-step">
                            <div class="psk-proc-step__num">4</div>
                            <div><div class="psk-proc-step__title">Form Filled &amp; Submitted</div><p class="psk-proc-step__desc">We fill and submit — you get confirmation</p></div>
                        </div>
                    </div>
                </div>

                <div class="psk-wa-block">
                    <i class="fab fa-whatsapp"></i>
                    <h5>Prefer to Talk Directly?</h5>
                    <p>Call or WhatsApp us — we respond within minutes during business hours</p>
                    <a href="https://wa.me/917710556330" target="_blank"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
