{{-- resources/views/agent-registration.blade.php --}}

@extends('layouts.app')

@section('title', 'Register Your CSC Center - Punjab Saathi')
@section('meta_description', 'List your Common Service Center on Punjab Saathi so citizens searching by pincode or location can find you. Free listing, verified badge, takes under two minutes.')

@push('head')
<link rel="canonical" href="{{ route('agent.registration') }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="Register Your CSC Center - Punjab Saathi">
<meta property="og:description" content="List your Common Service Center on Punjab Saathi so citizens searching by pincode or location can find you. Free listing, verified badge, takes under two minutes.">
<meta property="og:url"         content="{{ route('agent.registration') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="Register Your CSC Center - Punjab Saathi">
<meta name="twitter:description" content="List your Common Service Center on Punjab Saathi so citizens searching by pincode or location can find you.">

<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Register Your CSC Center', 'url' => route('agent.registration')],
])) !!}</script>
@endpush

@section('content')

{{-- ══════════════════════════════════════════════════ --}}
{{-- HERO — explains WHY, not just what                 --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="psk-reg-hero">
    <div class="psk-reg-hero__bg"></div>
    <div class="container">
        <p class="psk-reg-hero__breadcrumbs">
            <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
            <span>Register Your CSC Center</span>
        </p>

        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="psk-reg-hero__title">Get Your CSC Center Found by Citizens Across Punjab</h1>
                <p class="psk-reg-hero__sub">
                    Punjab Saathi's <a href="{{ route('csc.directory') }}">CSC Center Locator</a> lets citizens search
                    for centers by PIN code or their current location. Register your center here so people looking
                    for help nearby can actually find you — it's free, and takes under two minutes.
                </p>
                <a href="#register-form" class="btn btn-primary btn-lg">
                    <span class="fa fa-arrow-down mr-2"></span>Register My Center
                </a>
            </div>
        </div>

        @if($totalCenters)
        <div class="psk-reg-hero__stat">
            <span class="fa fa-building-o"></span>
            Join <strong>{{ number_format($totalCenters) }}+</strong> CSC centers already listed on Punjab Saathi
        </div>
        @endif
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{-- WHY REGISTER — the actual value proposition        --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">Why Register</span>
                <h2 class="mb-3">What You Get on Punjab Saathi</h2>
            </div>
        </div>

        <div class="row">
            @foreach([
                ['fa-search', '#fc5e28', 'Get Found by Citizens', 'Your center appears when people search by PIN code or "nearest CSC center" — real citizens actively looking for help near them.'],
                ['fa-inr', '#059669', '100% Free Listing', 'No cost, no subscription, no hidden fees. Registering and staying listed on Punjab Saathi is completely free.'],
                ['fa-check-circle', '#0ea5e9', 'Verified Badge', 'Once our team verifies your details, your center gets a "Verified CSC" badge — building trust with citizens before they even visit.'],
                ['fa-refresh', '#8b5cf6', 'Always Up To Date', 'Already listed from government records? Registering with your CSC ID updates your existing listing — your info stays accurate.'],
            ] as $item)
            <div class="col-md-6 col-lg-3 mb-4">
                <div class="psk-reg-benefit ftco-animate">
                    <div class="psk-reg-benefit__icon" style="background:{{ $item[1] }}18;">
                        <span class="fa {{ $item[0] }}" style="color:{{ $item[1] }};"></span>
                    </div>
                    <h3>{{ $item[2] }}</h3>
                    <p>{{ $item[3] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-agent-registration.css') }}">
@endpush

{{-- FORM SECTION                                      --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="ftco-section ftco-no-pt" id="register-form">
    <div class="container">

        {{-- Section heading --}}
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">CSC Network</span>
                <h2 class="mb-3">Register Your CSC Center</h2>
                <p class="text-muted">
                    Already registered? Enter your mobile number — if it exists in our database
                    we will update your record automatically. No duplicate entries.
                </p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- ── Success alert ──────────────────────────────── --}}
                @if(session('success'))
                <div class="alert d-flex align-items-center mb-4 ftco-animate"
                    style="background:{{ session('reg_action') === 'created' ? 'rgba(37,211,102,0.10)' : 'rgba(252,94,40,0.10)' }};
                           border-left: 4px solid {{ session('reg_action') === 'created' ? '#25D366' : '#fc5e28' }};
                           border-radius:8px; padding:18px 20px;">
                    <span class="fa {{ session('reg_action') === 'created' ? 'fa-check-circle' : 'fa-refresh' }} mr-3"
                        style="font-size:22px;color:{{ session('reg_action') === 'created' ? '#25D366' : '#fc5e28' }};"></span>
                    <span style="font-size:15px;font-weight:600;color:#040e26;">
                        {{ session('success') }}
                    </span>
                </div>
                @endif

                {{-- ── Validation errors ──────────────────────────── --}}
                @if($errors->any())
                <div class="alert d-flex align-items-start mb-4"
                    style="background:rgba(220,53,69,0.08);border-left:4px solid #dc3545;border-radius:8px;padding:16px 20px;">
                    <span class="fa fa-exclamation-circle mr-3 mt-1" style="color:#dc3545;font-size:18px;"></span>
                    <ul class="mb-0 pl-0" style="list-style:none;">
                        @foreach($errors->all() as $error)
                            <li style="color:#dc3545;font-size:14px;">• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- ── Form card ──────────────────────────────────── --}}
                <div class="ftco-animate psk-reg-form-card"
                    style="background:#fff;border-radius:16px;padding:40px 40px 36px;
                           box-shadow:0 4px 32px rgba(0,0,0,0.08);border:1px solid #f0f0f0;">

                    <form method="POST" action="{{ route('agent.register') }}" id="agent-register-form" data-psk-loading="Submitting your registration…">
                        @csrf
                        {{-- Hidden location fields — filled by JS --}}
                        <input type="hidden" name="latitude"  id="lat_field">
                        <input type="hidden" name="longitude" id="lng_field">
                        {{-- ── Row 1: Mobile + Name ──────────────── --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">
                                    Mobile Number <span style="color:#fc5e28;">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-mobile" style="color:#fc5e28;font-size:18px;"></i>
                                        </span>
                                    </div>
                                    <input type="tel" name="mobile" id="mobile_field"
                                        value="{{ old('mobile') }}"
                                        maxlength="10"
                                        placeholder="10-digit mobile number"
                                        class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}"
                                        style="border-color:#dee2e6;font-size:15px;"
                                        required>
                                </div>
                                <small style="color:#6b7280;font-size:12px;" id="mobile-check-default">
                                    <i class="fa fa-info-circle mr-1" style="color:#fc5e28;"></i>
                                    If already registered, your record will be updated.
                                </small>
                                <small id="mobile-check-result" style="display:none;font-size:12px;font-weight:600;"></small>
                            </div>

                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">
                                    Your Name (VLE / Operator) <span style="color:#fc5e28;">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-user" style="color:#fc5e28;"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="vle_name"
                                        value="{{ old('vle_name') }}"
                                        placeholder="Full name"
                                        class="form-control {{ $errors->has('vle_name') ? 'is-invalid' : '' }}"
                                        style="border-color:#dee2e6;font-size:15px;"
                                        required>
                                </div>
                            </div>
                        </div>

                        {{-- ── Row 2: Kiosk name + Email ─────────── --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">
                                    Kiosk / Center Name
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-building" style="color:#fc5e28;"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="kiosk_name"
                                        value="{{ old('kiosk_name') }}"
                                        placeholder="e.g. Guru Nanak CSC Center"
                                        class="form-control"
                                        style="border-color:#dee2e6;font-size:15px;">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-envelope" style="color:#fc5e28;"></i>
                                        </span>
                                    </div>
                                    <input type="email" name="email"
                                        value="{{ old('email') }}"
                                        placeholder="email@example.com"
                                        class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                        style="border-color:#dee2e6;font-size:15px;">
                                </div>
                            </div>
                        </div>

                        {{-- ── Row 3: CSC ID + Pincode ───────────── --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">
                                    CSC ID
                                    <span style="font-weight:400;color:#9ca3af;font-size:12px;">(optional)</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-id-badge" style="color:#fc5e28;"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="csc_id"
                                        value="{{ old('csc_id') }}"
                                        placeholder="e.g. 110136780019"
                                        class="form-control"
                                        style="border-color:#dee2e6;font-size:15px;">
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">Pincode</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-map-pin" style="color:#fc5e28;"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="pincode"
                                        value="{{ old('pincode') }}"
                                        maxlength="6"
                                        placeholder="6-digit pincode"
                                        class="form-control"
                                        style="border-color:#dee2e6;font-size:15px;">
                                </div>
                            </div>
                        </div>

                        {{-- ── Row 4: District + Sub-district ───── --}}
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">
                                    District <span style="color:#fc5e28;">*</span>
                                </label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-map-marker" style="color:#fc5e28;"></i>
                                        </span>
                                    </div>
                                    <select name="district"
                                        class="form-control {{ $errors->has('district') ? 'is-invalid' : '' }}"
                                        style="border-color:#dee2e6;font-size:15px;"
                                        required>
                                        <option value="">-- Select District --</option>
                                        @foreach([
                                            'Amritsar','Barnala','Bathinda','Faridkot',
                                            'Fatehgarh Sahib','Fazilka','Ferozepur','Gurdaspur',
                                            'Hoshiarpur','Jalandhar','Kapurthala','Ludhiana',
                                            'Malerkotla','Mansa','Moga','Pathankot','Patiala',
                                            'Rupnagar','S.A.S. Nagar (Mohali)','Sangrur',
                                            'Shahid Bhagat Singh Nagar','Sri Muktsar Sahib','Tarn Taran'
                                        ] as $dist)
                                            <option value="{{ $dist }}"
                                                {{ old('district') === $dist ? 'selected' : '' }}>
                                                {{ $dist }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label style="font-weight:600;color:#040e26;font-size:14px;">Sub-District / Block</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                            <i class="fa fa-map" style="color:#fc5e28;"></i>
                                        </span>
                                    </div>
                                    <input type="text" name="sub_district"
                                        value="{{ old('sub_district') }}"
                                        placeholder="Sub-district / block name"
                                        class="form-control"
                                        style="border-color:#dee2e6;font-size:15px;">
                                </div>
                            </div>
                        </div>

                        {{-- ── Full address ──────────────────────── --}}
                        <div class="form-group">
                            <label style="font-weight:600;color:#040e26;font-size:14px;">Full Address</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="background:#f8f9fa;border-color:#dee2e6;">
                                        <i class="fa fa-home" style="color:#fc5e28;"></i>
                                    </span>
                                </div>
                                <textarea name="address" rows="2"
                                    placeholder="Village / Street / Colony, full address"
                                    class="form-control"
                                    style="border-color:#dee2e6;font-size:15px;">{{ old('address') }}</textarea>
                            </div>
                        </div>

                        {{-- Location status bar --}}
<div id="location-status" class="mb-3 p-3 text-center"
    style="border-radius:8px; background:#fff8e1; border:1px solid #ffe082; display:none;">
    <i class="fa fa-map-marker mr-2" style="color:#fc5e28;"></i>
    <span id="location-msg" style="font-size:14px; font-weight:600; color:#040e26;">
        Location required. Please allow location access.
    </span>
    <br>
    <button type="button" id="btn-get-location" class="btn btn-sm mt-2"
        style="background:#fc5e28; color:#fff; border:none; border-radius:6px; padding:6px 18px;">
        <i class="fa fa-location-arrow mr-1"></i> Allow My Location
    </button>
</div>
                        {{-- ── Submit button ─────────────────────── --}}
                        <div class="row mt-3" id="btn-register-submit">
                            <div class="col-12">
                                <button type="submit"
                                    style="background:#fc5e28;color:#fff;font-weight:700;font-size:15px;
                                           letter-spacing:0.5px;border:none;border-radius:8px;
                                           padding:14px 40px;width:100%;transition:background 0.3s;"
                                    onmouseover="this.style.background='#e04d1c'"
                                    onmouseout="this.style.background='#fc5e28'">
                                    <i class="fa fa-paper-plane mr-2"></i>
                                    Register / Update My Center
                                </button>
                            </div>
                        </div>

                        {{-- ── Privacy note ──────────────────────── --}}
                        <p class="text-center mt-3 mb-0"
                            style="font-size:12px;color:#9ca3af;">
                            <i class="fa fa-lock mr-1" style="color:#fc5e28;"></i>
                            Your information is stored securely and never shared with third parties.
                        </p>

                    </form>
                </div>{{-- end card --}}

            </div>

            {{-- ── Sidebar — fills the wide side gutter, gives useful
                 supporting content instead of leaving it blank ── --}}
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="psk-reg-checklist">
                    <h4><span class="fa fa-clipboard mr-2"></span>What You'll Need</h4>
                    <ul>
                        <li><span class="fa fa-check"></span>Your 10-digit mobile number</li>
                        <li><span class="fa fa-check"></span>Your name as the VLE / Operator</li>
                        <li><span class="fa fa-check"></span>Your district (required)</li>
                        <li><span class="fa fa-check"></span>Your CSC ID — if you have one, from government records</li>
                    </ul>
                    <p>That's it — everything else is optional and can be added later.</p>
                </div>

                <div class="psk-reg-wa">
                    <span class="fa fa-whatsapp"></span>
                    <h4>Need Help Registering?</h4>
                    <p>Message us directly and our team will help you get listed.</p>
                    <a href="https://wa.me/917710556330?text=Hello%2C%20I%20need%20help%20registering%20my%20CSC%20center" target="_blank" rel="noopener">
                        <span class="fa fa-whatsapp mr-1"></span> WhatsApp Us
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- ══════════════════════════════════════════════════ --}}
{{-- INFO STRIP (matches your site's trust badges)     --}}
{{-- ══════════════════════════════════════════════════ --}}
<section class="ftco-section ftco-no-pt" style="padding-bottom:60px;">
    <div class="container">
        <div class="row">
            @foreach([
                ['fa-shield',        '#fc5e28', 'Secure Registration',    'Your data is stored in our verified CSC database and protected.'],
                ['fa-refresh',       '#3b82f6', 'No Duplicates',          'Mobile number check prevents duplicate entries automatically.'],
                ['fa-check-circle',  '#25D366', 'Instant Confirmation',   'You see a confirmation message immediately after submitting.'],
            ] as $item)
            <div class="col-md-4 ftco-animate mb-4 mb-md-0">
                <div class="media block-6 services d-flex"
                    style="background:#fff;border-radius:12px;padding:28px 24px;
                           box-shadow:0 2px 16px rgba(0,0,0,0.06);border:1px solid #f0f0f0;height:100%;">
                    <div class="icon justify-content-center align-items-center d-flex"
                        style="background:rgba(252,94,40,0.08);border-radius:50%;
                               width:56px;height:56px;min-width:56px;">
                        <span class="fa {{ $item[0] }}" style="color:{{ $item[1] }};font-size:22px;"></span>
                    </div>
                    <div class="media-body pl-4">
                        <h3 class="heading mb-2" style="font-size:1rem;">{{ $item[2] }}</h3>
                        <p style="font-size:14px;color:#6b7280;margin:0;line-height:1.6;">{{ $item[3] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
@push('scripts')
<link rel="stylesheet" href="{{ asset('css/psk-agent-registration.css') }}">

{{-- ══ Modal markup ══════════════════════════════════════════ --}}
<div id="loc-modal-backdrop">
    <div id="loc-modal">

        {{-- Icon --}}
        <div class="loc-icon-ring state-ask" id="loc-icon-ring">
            <i class="fa fa-map-marker" id="loc-icon" style="font-size:30px;color:#fc5e28;"></i>
        </div>

        <h4 id="loc-title">Location Access Required</h4>
        <p class="sub" id="loc-sub">
            We need your location to pin your CSC Center on the Punjab network map.
            Please allow access to continue.
        </p>

        {{-- ASK state: normal steps --}}
        <ul class="loc-steps" id="loc-steps-ask">
            <li><span class="step-dot orange">1</span> Click <strong>"Allow My Location"</strong> below</li>
            <li><span class="step-dot orange">2</span> Browser popup appears — click <strong>"Allow"</strong></li>
            <li><span class="step-dot orange">3</span> Submit button unlocks automatically ✓</li>
        </ul>

        {{-- DENIED state: browser-specific unblock guide --}}
        <div id="loc-denied-section" style="display:none;">
            <div class="browser-tabs" id="browser-tabs">
                <button class="browser-tab active" data-browser="chrome">Chrome</button>
                <button class="browser-tab" data-browser="firefox">Firefox</button>
                <button class="browser-tab" data-browser="edge">Edge</button>
                <button class="browser-tab" data-browser="safari">Safari</button>
            </div>
            <div class="unblock-box">
                <div class="ub-title"><i class="fa fa-unlock-alt"></i> How to unblock location:</div>
                <ol id="unblock-steps">
                    <li>Click the <code>🔒</code> or <code>ⓘ</code> icon in your address bar</li>
                    <li>Find <strong>"Location"</strong> and change it to <strong>"Allow"</strong></li>
                    <li>Reload this page, then click <strong>"Allow My Location"</strong> again</li>
                </ol>
            </div>
        </div>

        <button id="btn-modal-allow" class="btn-orange" type="button">
            <i class="fa fa-location-arrow" id="btn-icon"></i>
            <span id="btn-label">Allow My Location</span>
        </button>
        <br>
        <button id="btn-modal-dismiss" type="button">I'll do this later (form stays locked)</button>
    </div>
</div>
@push('scripts')
<link rel="stylesheet" href="{{ asset('css/psk-agent-registration.css') }}">

{{-- ══ Modal markup ══════════════════════════════════════════ --}}
<div id="loc-modal-backdrop">
    <div id="loc-modal">

        <div class="loc-icon-ring state-ask" id="loc-icon-ring">
            <i class="fa fa-map-marker" id="loc-icon" style="font-size:30px;color:#fc5e28;"></i>
        </div>

        <h4 id="loc-title">Location Access Required</h4>
        <p class="sub" id="loc-sub">
            We need your location to pin your CSC Center on the Punjab network map.
            Please allow access to continue.
        </p>

        <ul class="loc-steps" id="loc-steps-ask">
            <li><span class="step-dot orange">1</span> Click <strong>"Allow My Location"</strong> below</li>
            <li><span class="step-dot orange">2</span> Browser popup appears — click <strong>"Allow"</strong></li>
            <li><span class="step-dot orange">3</span> Submit button unlocks automatically ✓</li>
        </ul>

        <div id="loc-denied-section" style="display:none;">
            <div class="browser-tabs" id="browser-tabs">
                <button class="browser-tab active" data-browser="chrome">Chrome</button>
                <button class="browser-tab" data-browser="firefox">Firefox</button>
                <button class="browser-tab" data-browser="edge">Edge</button>
                <button class="browser-tab" data-browser="safari">Safari</button>
            </div>
            <div class="unblock-box">
                <div class="ub-title"><i class="fa fa-unlock-alt"></i> How to unblock location:</div>
                <ol id="unblock-steps">
                    <li>Click the <code>🔒</code> or <code>ⓘ</code> icon in your address bar</li>
                    <li>Find <strong>"Location"</strong> and change it to <strong>"Allow"</strong></li>
                    <li>Reload this page, then click <strong>"Allow My Location"</strong> again</li>
                </ol>
            </div>
        </div>

        <button id="btn-modal-allow" class="btn-orange" type="button">
            <i class="fa fa-location-arrow" id="btn-icon"></i>
            <span id="btn-label">Allow My Location</span>
        </button>
        <br>
        <button id="btn-modal-dismiss" type="button">I'll do this later (form stays locked)</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    (function () {

        /* ── DOM refs ──────────────────────────────────────────── */
        var latField     = document.getElementById('lat_field');
        var lngField     = document.getElementById('lng_field');
        var statusBox    = document.getElementById('location-status');
        var statusMsg    = document.getElementById('location-msg');
        var btnGet       = document.getElementById('btn-get-location');
        var submitBtn    = document.getElementById('btn-register-submit');
        var form         = document.getElementById('agent-register-form');
        var backdrop     = document.getElementById('loc-modal-backdrop');
        var btnAllow     = document.getElementById('btn-modal-allow');
        var btnDismiss   = document.getElementById('btn-modal-dismiss');
        var iconRing     = document.getElementById('loc-icon-ring');
        var locIcon      = document.getElementById('loc-icon');
        var locTitle     = document.getElementById('loc-title');
        var locSub       = document.getElementById('loc-sub');
        var stepsAsk     = document.getElementById('loc-steps-ask');
        var deniedSec    = document.getElementById('loc-denied-section');
        var btnIcon      = document.getElementById('btn-icon');
        var btnLabel     = document.getElementById('btn-label');
        var unblockSteps = document.getElementById('unblock-steps');

        /* ── Safety check — bail if critical elements missing ── */
        if (!submitBtn || !form || !latField || !lngField) {
            console.warn('Location script: required elements not found. Skipping init.');
            return;
        }

        /* ── Browser detection ─────────────────────────────────── */
        var ua = navigator.userAgent;
        var activeBrowser = 'chrome';
        if (ua.indexOf('Edg') > -1)          activeBrowser = 'edge';
        else if (ua.indexOf('Firefox') > -1) activeBrowser = 'firefox';
        else if (ua.indexOf('Safari') > -1 && ua.indexOf('Chrome') === -1) activeBrowser = 'safari';

        var unblockGuides = {
            chrome: [
                'Click the <code>🔒</code> or <code>ⓘ</code> icon in the address bar (left of the URL)',
                'Click <strong>Site settings</strong>',
                'Find <strong>Location</strong> → change to <strong>Allow</strong>',
                'Reload this page, then click <strong>"Allow My Location"</strong>'
            ],
            edge: [
                'Click the <code>🔒</code> icon in the address bar',
                'Click <strong>Permissions for this site</strong>',
                'Find <strong>Location</strong> → set to <strong>Allow</strong>',
                'Reload the page and try again'
            ],
            firefox: [
                'Click the <code>🔒</code> icon in the address bar',
                'Click the <strong>×</strong> next to "Blocked Temporarily" under Location',
                'Reload the page — browser will ask again',
                'Click <strong>Allow</strong> on the popup'
            ],
            safari: [
                'Go to <strong>Safari → Settings → Websites → Location</strong>',
                'Find this website and set it to <strong>Allow</strong>',
                'Reload this page and try again'
            ]
        };

        /* ── Lock / unlock submit ──────────────────────────────── */
        function lockSubmit() {
            submitBtn.disabled          = true;
            submitBtn.style.opacity     = '0.45';
            submitBtn.style.cursor      = 'not-allowed';
            submitBtn.title             = 'Allow location access to enable this button';
        }
        function unlockSubmit() {
            submitBtn.disabled          = false;
            submitBtn.style.opacity     = '1';
            submitBtn.style.cursor      = 'pointer';
            submitBtn.title             = '';
        }
        lockSubmit();

        /* ── Modal show / hide ─────────────────────────────────── */
        function showModal() { backdrop.classList.add('show'); }
        function hideModal() { backdrop.classList.remove('show'); }

        /* ── ASK state ─────────────────────────────────────────── */
        function showAskState() {
            iconRing.className   = 'loc-icon-ring state-ask';
            locIcon.style.color  = '#fc5e28';
            locTitle.textContent = 'Location Access Required';
            locSub.textContent   = 'We need your location to pin your CSC Center on the Punjab network map.';
            stepsAsk.style.display  = 'block';
            deniedSec.style.display = 'none';
            btnAllow.className   = 'btn-orange';
            btnIcon.className    = 'fa fa-location-arrow';
            btnLabel.textContent = 'Allow My Location';
            btnAllow.disabled    = false;
            showModal();
        }

        /* ── DENIED state ──────────────────────────────────────── */
        function showDeniedState() {
            iconRing.className   = 'loc-icon-ring state-denied';
            locIcon.style.color  = '#dc3545';
            locTitle.textContent = 'Location Access Blocked';
            locSub.textContent   = 'You previously denied location access. Follow the steps below to unblock it in your browser, then try again.';
            stepsAsk.style.display  = 'none';
            deniedSec.style.display = 'block';
            btnAllow.className   = 'btn-orange';
            btnIcon.className    = 'fa fa-refresh';
            btnLabel.textContent = "I've unblocked — Try Again";
            btnAllow.disabled    = false;

            document.querySelectorAll('.browser-tab').forEach(function (t) {
                t.classList.toggle('active', t.dataset.browser === activeBrowser);
            });
            renderUnblockSteps(activeBrowser);
            showModal();
        }

        /* ── Render unblock steps ──────────────────────────────── */
        function renderUnblockSteps(browser) {
            var steps = unblockGuides[browser] || unblockGuides.chrome;
            unblockSteps.innerHTML = steps.map(function (s) {
                return '<li>' + s + '</li>';
            }).join('');
        }

        /* ── Success ───────────────────────────────────────────── */
        function setLocation(lat, lng) {
            latField.value = lat;
            lngField.value = lng;
            hideModal();

            statusBox.style.cssText = 'display:block;background:rgba(37,211,102,0.10);border-color:#25D366;border-radius:8px;padding:13px 18px;margin-bottom:16px;text-align:center;border:1px solid #25D366;';
            statusMsg.style.color   = '#1a7a3e';
            statusMsg.innerHTML     = '<i class="fa fa-check-circle mr-1" style="color:#25D366;"></i> Location captured (' + lat.toFixed(5) + ', ' + lng.toFixed(5) + ')';
            if (btnGet) btnGet.style.display = 'none';
            unlockSubmit();
        }

        /* ── GPS error ─────────────────────────────────────────── */
        function locationError(err) {
            latField.value = '';
            lngField.value = '';
            lockSubmit();

            if (err.code === 1) {
                // Permission denied
                if (navigator.permissions) {
                    navigator.permissions.query({ name: 'geolocation' })
                        .then(function () { showDeniedState(); })
                        .catch(function () { showDeniedState(); });
                } else {
                    showDeniedState();
                }
            } else {
                // Timeout / unavailable
                btnAllow.disabled    = false;
                btnIcon.className    = 'fa fa-refresh';
                btnLabel.textContent = 'Try Again';
                showModal();
            }
        }

        /* ── Core GPS call ─────────────────────────────────────── */
        function doGetPosition() {
            btnAllow.disabled    = true;
            btnIcon.className    = 'fa fa-spinner fa-spin';
            btnLabel.textContent = 'Getting location…';

            if (!navigator.geolocation) {
                locationError({ code: 0 });
                return;
            }
            navigator.geolocation.getCurrentPosition(
                function (pos) { setLocation(pos.coords.latitude, pos.coords.longitude); },
                locationError,
                { timeout: 10000, maximumAge: 0 }
            );
        }

        /* ── Allow / Try-Again button ──────────────────────────── */
        /* Re-checks live permission before attempting GPS so "Try Again"
           after denial doesn't silently fail                          */
        function requestLocation() {
            // if (navigator.permissions) {
            //     navigator.permissions.query({ name: 'geolocation' }).then(function (result) {
            //         if (result.state === 'denied') {
            //             showDeniedState();   // still blocked — keep showing guide
            //         } else {
            //             doGetPosition();    // 'granted' or 'prompt' — go for it
            //         }
            //     }).catch(function () {
            //         doGetPosition();        // permissions API unavailable — just try
            //     });
            // } else {
            // }
         doGetPosition();
        }

        /* ── Silent fetch (permission already granted on load) ─── */
        function requestLocationSilent() {
            navigator.geolocation.getCurrentPosition(
                function (pos) { setLocation(pos.coords.latitude, pos.coords.longitude); },
                function ()    { setTimeout(showAskState, 400); },
                { timeout: 8000, maximumAge: 30000 }
            );
        }

        /* ── Init: check permission state on page load ─────────── */
        function checkAndInit() {
            if (navigator.permissions) {
                navigator.permissions.query({ name: 'geolocation' }).then(function (result) {
                    if (result.state === 'denied') {
                        showDeniedState();
                    } else if (result.state === 'granted') {
                        requestLocationSilent();
                    } else {
                        setTimeout(showAskState, 400);  // 'prompt'
                    }

                    // React if user changes permission mid-session
                    result.onchange = function () {
                        if (result.state === 'granted') {
                            requestLocationSilent();
                        } else if (result.state === 'denied') {
                            showDeniedState();
                        }
                    };
                }).catch(function () {
                    setTimeout(showAskState, 400);
                });
            } else {
                setTimeout(showAskState, 400);
            }
        }

        /* ── Browser tab switcher ──────────────────────────────── */
        document.querySelectorAll('.browser-tab').forEach(function (tab) {
            tab.addEventListener('click', function () {
                document.querySelectorAll('.browser-tab').forEach(function (t) {
                    t.classList.remove('active');
                });
                tab.classList.add('active');
                renderUnblockSteps(tab.dataset.browser);
            });
        });

        /* ── Button: Allow / Try Again ─────────────────────────── */
        btnAllow.addEventListener('click', requestLocation);

        /* ── Button: Dismiss ───────────────────────────────────── */
        btnDismiss.addEventListener('click', function () {
            hideModal();
            statusBox.style.cssText = 'display:block;background:#fff8e1;border-color:#ffe082;border-radius:8px;padding:13px 18px;margin-bottom:16px;text-align:center;border:1px solid #ffe082;';
            statusMsg.style.color   = '#7c5e00';
            statusMsg.innerHTML     = '<i class="fa fa-exclamation-triangle mr-1" style="color:#fc5e28;"></i> Location not allowed. Submit is locked. <a href="#" id="reopen-modal" style="color:#fc5e28;font-weight:600;">Allow location →</a>';
            if (btnGet) btnGet.style.display = 'none';

            setTimeout(function () {
                var reopenLink = document.getElementById('reopen-modal');
                if (reopenLink) {
                    reopenLink.addEventListener('click', function (e) {
                        e.preventDefault();
                        if (navigator.permissions) {
                            navigator.permissions.query({ name: 'geolocation' }).then(function (r) {
                                r.state === 'denied' ? showDeniedState() : showAskState();
                            }).catch(showAskState);
                        } else {
                            showAskState();
                        }
                    });
                }
            }, 50);
        });

        /* ── Button: inline status bar "Allow" button ──────────── */
        if (btnGet) {
            btnGet.addEventListener('click', function () {
                if (navigator.permissions) {
                    navigator.permissions.query({ name: 'geolocation' }).then(function (r) {
                        r.state === 'denied' ? showDeniedState() : showAskState();
                    }).catch(showAskState);
                } else {
                    showAskState();
                }
            });
        }

        /* ── Hard-block form submit without coords ─────────────── */
        form.addEventListener('submit', function (e) {
            if (!latField.value || !lngField.value) {
                e.preventDefault();
                if (navigator.permissions) {
                    navigator.permissions.query({ name: 'geolocation' }).then(function (r) {
                        r.state === 'denied' ? showDeniedState() : showAskState();
                    }).catch(showAskState);
                } else {
                    showAskState();
                }
            }
        });

        /* ── Go ─────────────────────────────────────────────────── */
        checkAndInit();

    })();

    /* ── Live mobile duplicate check ───────────────────────────── */
    (function () {
        var mobileField  = document.getElementById('mobile_field');
        var defaultHint  = document.getElementById('mobile-check-default');
        var resultHint   = document.getElementById('mobile-check-result');
        if (!mobileField || !resultHint) return;

        var debounceTimer = null;

        mobileField.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            var mobile = mobileField.value.replace(/\D/g, '');

            if (mobile.length !== 10) {
                resultHint.style.display = 'none';
                defaultHint.style.display = 'block';
                return;
            }

            debounceTimer = setTimeout(function () {
                fetch('{{ route("agent.check-mobile") }}?mobile=' + mobile)
                    .then(function (res) { return res.json(); })
                    .then(function (data) {
                        if (data.exists) {
                            resultHint.style.color = '#fc5e28';
                            resultHint.innerHTML = '<i class="fa fa-refresh mr-1"></i> Already registered'
                                + (data.vle_name ? ' as ' + data.vle_name : '')
                                + (data.district ? ' (' + data.district + ')' : '')
                                + ' — submitting will update this record.';
                        } else {
                            resultHint.style.color = '#25D366';
                            resultHint.innerHTML = '<i class="fa fa-check-circle mr-1"></i> New number — this will be a fresh registration.';
                        }
                        defaultHint.style.display = 'none';
                        resultHint.style.display = 'block';
                    })
                    .catch(function () { /* silent — non-critical UX enhancement */ });
            }, 400);
        });
    })();
});
</script>
@endpush
