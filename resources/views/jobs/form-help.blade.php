{{-- Save as: resources/views/jobs/form-help.blade.php --}}
@extends('layouts.app')
@section('title', 'Form Filling Help | Government Job Applications | Punjab Seva Kendra')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--or:#fc5e28;--or-dark:#e04d1c;--or-bg:rgba(252,94,40,.10);--nv:#040e26;--gr:#f8f9fb;--bd:#e4e7ec;--txt:#4b5563;--grn:#16a34a;--grn-bg:#dcfce7;}
.jobs-hero{background:linear-gradient(135deg,#040e26 0%,#0d275c 60%,#112278 100%);padding:32px 0 20px;}
.jobs-hero .breadcrumb{background:transparent;padding:0;margin-bottom:8px;}
.jobs-hero .breadcrumb-item a{color:var(--or);}
.jobs-hero .breadcrumb-item.active,.jobs-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.5);}
.jobs-hero h1{font-family:'Poppins',sans-serif;font-size:1.8rem;font-weight:800;color:#fff;margin-bottom:4px;}
.jobs-hero p{color:rgba(255,255,255,.72);font-size:13px;margin:0;}
.fh-card{background:#fff;border-radius:8px;box-shadow:0 2px 10px rgba(4,14,38,.08);overflow:hidden;margin-bottom:20px;}
.fh-head{background:var(--nv);padding:16px 20px;}
.fh-head h4{font-family:'Poppins',sans-serif;font-weight:800;color:#fff;margin:0 0 4px;font-size:16px;}
.fh-head p{color:rgba(255,255,255,.65);font-size:12px;margin:0;}
.fh-body{padding:24px;}
.fh-body .form-group label{font-weight:700;font-size:12px;color:var(--nv);text-transform:uppercase;letter-spacing:.3px;margin-bottom:5px;}
.fh-body .req{color:var(--or);}
.fh-body .form-control{border:1px solid var(--bd);border-radius:6px;font-size:13px;padding:10px 13px;}
.fh-body .form-control:focus{border-color:var(--or);box-shadow:0 0 0 3px rgba(252,94,40,.12);}
.btn-fh{width:100%;background:var(--or);color:#fff;font-family:'Poppins',sans-serif;font-weight:800;font-size:14px;padding:13px;border:none;border-radius:6px;cursor:pointer;text-transform:uppercase;letter-spacing:1px;transition:background .2s;}
.btn-fh:hover{background:var(--or-dark);}
.why-list{list-style:none;padding:0;margin:0;}
.why-list li{display:flex;gap:10px;padding:10px 0;border-bottom:1px solid #f5f6f8;font-size:13px;color:var(--txt);}
.why-list li:last-child{border-bottom:none;}
.why-list li i{color:var(--grn);font-size:15px;flex-shrink:0;margin-top:1px;}
.proc-step{display:flex;gap:14px;padding:12px 0;border-bottom:1px solid #f5f6f8;}
.proc-step:last-child{border-bottom:none;}
.proc-num{width:32px;height:32px;background:var(--or);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:800;font-size:13px;flex-shrink:0;}
.proc-txt h6{font-family:'Poppins',sans-serif;font-weight:700;font-size:13px;color:var(--nv);margin:0 0 2px;}
.proc-txt p{font-size:11px;color:var(--txt);margin:0;}
.wa-block{background:linear-gradient(135deg,#25D366,#1da851);border-radius:8px;padding:20px;text-align:center;}
.wa-block i{font-size:36px;color:#fff;display:block;margin-bottom:8px;}
.wa-block h5{font-family:'Poppins',sans-serif;font-weight:800;color:#fff;margin-bottom:4px;}
.wa-block p{font-size:12px;color:rgba(255,255,255,.85);margin-bottom:12px;}
.wa-block a{display:inline-flex;align-items:center;gap:6px;background:#fff;color:#25D366!important;font-weight:800;font-size:13px;padding:10px 22px;border-radius:20px;text-decoration:none;}
</style>
@endpush

@section('content')
<section class="jobs-hero">
    <div class="container" style="position:relative;z-index:1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Sarkari Naukri</a></li>
                <li class="breadcrumb-item active">Form Filling Help</li>
            </ol>
        </nav>
        <h1><i class="fas fa-file-signature mr-2" style="color:var(--or);"></i>Government Job Form Filling Help</h1>
        <p>Let our experts fill your government job application — zero errors, zero rejections, guaranteed</p>
    </div>
</section>

<section class="py-4">
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
        @endif

        <div class="row">
            <div class="col-lg-7 mb-4">
                <div class="fh-card">
                    <div class="fh-head">
                        <h4><i class="fas fa-file-alt mr-2"></i>Request Form Filling Assistance</h4>
                        <p>Fill the form below — our team will contact you within a few hours</p>
                    </div>
                    <div class="fh-body">
                        <form action="{{ route('jobs.form-help.submit') }}" method="POST" novalidate>
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
                            <button type="submit" class="btn-fh">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Request
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="fh-card mb-4">
                    <div class="fh-head"><h4><i class="fas fa-star mr-2"></i>Why Choose Punjab Seva Kendra?</h4></div>
                    <div class="fh-body p-3">
                        <ul class="why-list">
                            <li><i class="fas fa-check-circle"></i> 100% accurate form filling — zero rejections guaranteed</li>
                            <li><i class="fas fa-check-circle"></i> Eligibility verified before applying</li>
                            <li><i class="fas fa-check-circle"></i> Complete document review included</li>
                            <li><i class="fas fa-check-circle"></i> WhatsApp support throughout the process</li>
                            <li><i class="fas fa-check-circle"></i> Affordable & fully transparent pricing</li>
                            <li><i class="fas fa-check-circle"></i> 5,000+ successful applications filed</li>
                            <li><i class="fas fa-check-circle"></i> All Punjab government portals covered</li>
                        </ul>
                    </div>
                </div>

                <div class="fh-card mb-4">
                    <div class="fh-head"><h4><i class="fas fa-list-ol mr-2"></i>Our Process</h4></div>
                    <div class="fh-body p-3" style="padding:16px!important;">
                        <div class="proc-step">
                            <div class="proc-num">1</div>
                            <div class="proc-txt"><h6>Submit Your Request</h6><p>Fill the form or WhatsApp us with your details</p></div>
                        </div>
                        <div class="proc-step">
                            <div class="proc-num">2</div>
                            <div class="proc-txt"><h6>Eligibility Check</h6><p>We verify you're eligible before proceeding</p></div>
                        </div>
                        <div class="proc-step">
                            <div class="proc-num">3</div>
                            <div class="proc-txt"><h6>Document Collection</h6><p>Send us your documents via WhatsApp securely</p></div>
                        </div>
                        <div class="proc-step">
                            <div class="proc-num">4</div>
                            <div class="proc-txt"><h6>Form Filled & Submitted</h6><p>We fill and submit — you get confirmation</p></div>
                        </div>
                    </div>
                </div>

                <div class="wa-block">
                    <i class="fab fa-whatsapp"></i>
                    <h5>Prefer to Talk Directly?</h5>
                    <p>Call or WhatsApp us — we respond within minutes during business hours</p>
                    <a href="https://wa.me/91XXXXXXXXXX" target="_blank"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
