{{-- resources/views/agent-registration.blade.php --}}

@extends('layouts.app')

@section('title', 'Register Your CSC Center - Punjab Saathi')
@section('meta_description', 'List your Common Service Center on Punjab Saathi so citizens searching by pincode or location can find you. Free listing, verified badge, takes under two minutes.')

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
<style>
.psk-reg-hero {
    position: relative; background: #040e26; padding: 130px 0 60px; overflow: hidden; color: #fff;
}
.psk-reg-hero__bg {
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle at 12% 20%, rgba(252,94,40,0.20) 0, transparent 40%),
        radial-gradient(circle at 88% 15%, rgba(252,94,40,0.12) 0, transparent 35%),
        radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1.5px);
    background-size: auto, auto, 26px 26px;
}
.psk-reg-hero .container { position: relative; z-index: 1; }
.psk-reg-hero__breadcrumbs { color: rgba(255,255,255,0.55); font-size: 0.82rem; margin-bottom: 22px; }
.psk-reg-hero__breadcrumbs a { color: rgba(255,255,255,0.75); text-decoration: none; }
.psk-reg-hero__title { font-size: 2.3rem; font-weight: 800; color: #fff; margin-bottom: 16px; line-height: 1.25; max-width: 720px; }
.psk-reg-hero__sub { color: rgba(255,255,255,0.75); font-size: 1.02rem; line-height: 1.75; max-width: 640px; margin-bottom: 26px; }
.psk-reg-hero__sub a { color: #fc5e28; font-weight: 600; text-decoration: underline; }
.psk-reg-hero__stat {
    margin-top: 34px; padding-top: 24px; border-top: 1px solid rgba(255,255,255,0.12);
    font-size: 0.95rem; color: rgba(255,255,255,0.85);
}
.psk-reg-hero__stat .fa { color: #fc5e28; margin-right: 8px; }
.psk-reg-hero__stat strong { color: #fc5e28; font-size: 1.1rem; }

.psk-reg-benefit {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 28px 24px; height: 100%; box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.psk-reg-benefit:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); border-color: #fc5e28; }
.psk-reg-benefit__icon {
    width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center;
    justify-content: center; font-size: 1.3rem; margin-bottom: 16px;
}
.psk-reg-benefit h3 { font-size: 1rem; font-weight: 700; color: #1e2a3a; margin-bottom: 8px; }
.psk-reg-benefit p { font-size: 0.85rem; color: #6b7280; line-height: 1.6; margin: 0; }

/* ── Sidebar cards next to the form ── */
.psk-reg-checklist {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 24px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.psk-reg-checklist h4 { font-size: 0.95rem; font-weight: 700; color: #1e2a3a; margin-bottom: 14px; }
.psk-reg-checklist h4 .fa { color: #fc5e28; }
.psk-reg-checklist ul { list-style: none; margin: 0 0 14px; padding: 0; }
.psk-reg-checklist li {
    display: flex; align-items: flex-start; gap: 10px; font-size: 0.85rem;
    color: #4b5563; padding: 7px 0; line-height: 1.5;
}
.psk-reg-checklist li .fa { color: #25D366; margin-top: 3px; flex-shrink: 0; }
.psk-reg-checklist p { font-size: 0.78rem; color: #9ca3af; margin: 0; font-style: italic; }

.psk-reg-wa {
    background: linear-gradient(160deg, #25D366 0%, #1aab50 100%);
    border-radius: 16px; padding: 24px; text-align: center; color: #fff;
}
.psk-reg-wa .fa-whatsapp { font-size: 2rem; margin-bottom: 10px; display: block; }
.psk-reg-wa h4 { font-size: 1rem; font-weight: 700; margin-bottom: 6px; color: #fff; }
.psk-reg-wa p { font-size: 0.82rem; color: rgba(255,255,255,0.85); margin-bottom: 16px; line-height: 1.5; }
.psk-reg-wa a {
    display: inline-flex; align-items: center; background: #fff; color: #1aab50 !important;
    font-weight: 700; font-size: 0.85rem; padding: 10px 20px; border-radius: 10px; text-decoration: none;
}
.psk-reg-wa a:hover { background: #f0fdf4; }

@media (max-width: 767.98px) {
    .psk-reg-hero { padding: 100px 0 40px; }
    .psk-reg-hero__title { font-size: 1.6rem; }
    .psk-reg-form-card { padding: 22px 16px 20px !important; }
}

/* ── Registration form: breathing room between fields ── */
#agent-register-form .form-group { margin-bottom: 24px; }
#agent-register-form label { margin-bottom: 8px; }
#agent-register-form .input-group-text {
    width: 44px; justify-content: center; padding: 0.375rem 0;
}
#agent-register-form small { display: block; margin-top: 6px; line-height: 1.5; }
</style>
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
<style>
/* ── Modal backdrop ──────────────────────────────────── */
#loc-modal-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(4,14,38,0.60); backdrop-filter: blur(5px);
    z-index: 9999; align-items: center; justify-content: center;
}
#loc-modal-backdrop.show { display: flex; animation: fadeInBd 0.2s ease; }
@keyframes fadeInBd { from{opacity:0} to{opacity:1} }

#loc-modal {
    background: #fff; border-radius: 20px; padding: 36px 32px 28px;
    max-width: 440px; width: 92%; text-align: center;
    box-shadow: 0 24px 64px rgba(0,0,0,0.20);
    animation: slideUp 0.3s cubic-bezier(0.34,1.56,0.64,1);
    position: relative; max-height: 90vh; overflow-y: auto;
}
@keyframes slideUp {
    from{transform:translateY(40px) scale(0.95);opacity:0}
    to{transform:translateY(0) scale(1);opacity:1}
}

/* icon ring */
.loc-icon-ring {
    width:76px; height:76px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    margin: 0 auto 18px; transition: background 0.3s, border-color 0.3s;
}
.loc-icon-ring.state-ask  { background:linear-gradient(135deg,#fff3ee,#ffe0d4); border:3px solid rgba(252,94,40,0.18); animation: pulseRing 2s infinite; }
.loc-icon-ring.state-denied { background:linear-gradient(135deg,#fff0f0,#ffd6d6); border:3px solid rgba(220,53,69,0.20); }
.loc-icon-ring.state-ok   { background:linear-gradient(135deg,#e8fff2,#c8f7dc); border:3px solid rgba(37,211,102,0.25); }
@keyframes pulseRing {
    0%,100%{box-shadow:0 0 0 0 rgba(252,94,40,0.25)}
    50%    {box-shadow:0 0 0 12px rgba(252,94,40,0)}
}

#loc-modal h4 { font-size:19px; font-weight:700; color:#040e26; margin-bottom:8px; }
#loc-modal .sub { font-size:13.5px; color:#6b7280; line-height:1.65; margin-bottom:20px; }

/* steps list */
.loc-steps { background:#f9fafb; border-radius:12px; padding:14px 16px; margin-bottom:20px; text-align:left; }
.loc-steps li { font-size:13px; color:#374151; padding:5px 0; list-style:none; display:flex; align-items:flex-start; gap:10px; line-height:1.5; }
.step-dot { width:20px; height:20px; min-width:20px; border-radius:50%; color:#fff; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; margin-top:1px; }
.step-dot.orange { background:#fc5e28; }
.step-dot.red    { background:#dc3545; }

/* browser tabs */
.browser-tabs { display:flex; gap:6px; justify-content:center; margin-bottom:14px; flex-wrap:wrap; }
.browser-tab {
    padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600;
    border:1.5px solid #e5e7eb; background:#f9fafb; cursor:pointer;
    color:#374151; transition:all 0.15s;
}
.browser-tab.active { background:#fc5e28; border-color:#fc5e28; color:#fff; }

/* unblock box */
.unblock-box { background:#fff8e1; border:1px solid #ffe082; border-radius:10px; padding:14px 16px; margin-bottom:18px; text-align:left; }
.unblock-box .ub-title { font-size:13px; font-weight:700; color:#7c5e00; margin-bottom:8px; display:flex; align-items:center; gap:6px; }
.unblock-box ol { margin:0; padding-left:18px; }
.unblock-box ol li { font-size:12.5px; color:#374151; line-height:1.6; padding:2px 0; }
.unblock-box code { background:#fff3cd; padding:1px 5px; border-radius:4px; font-size:11.5px; }

/* main btn */
#btn-modal-allow {
    width:100%; padding:14px; border:none; border-radius:10px;
    font-size:15px; font-weight:700; cursor:pointer; letter-spacing:0.3px;
    display:flex; align-items:center; justify-content:center; gap:8px;
    transition:transform 0.15s, box-shadow 0.15s, background 0.2s;
    margin-bottom:4px;
}
#btn-modal-allow.btn-orange {
    background:linear-gradient(135deg,#fc5e28,#e04d1c); color:#fff;
    box-shadow:0 4px 16px rgba(252,94,40,0.35);
}
#btn-modal-allow.btn-orange:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(252,94,40,0.45); }
#btn-modal-allow.btn-green {
    background:linear-gradient(135deg,#25D366,#1aab50); color:#fff;
    box-shadow:0 4px 16px rgba(37,211,102,0.30);
}
#btn-modal-allow:disabled { opacity:0.5; cursor:not-allowed; transform:none !important; }

#btn-modal-dismiss { margin-top:10px; background:none; border:none; font-size:12.5px; color:#9ca3af; cursor:pointer; text-decoration:underline; }
#btn-modal-dismiss:hover { color:#dc3545; }

/* inline status bar */
#location-status { display:none; border-radius:8px; padding:13px 18px; margin-bottom:16px; text-align:center; border:1px solid; }
</style>

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
<style>
/* ── Modal backdrop ──────────────────────────────────── */
#loc-modal-backdrop {
    display: none; position: fixed; inset: 0;
    background: rgba(4,14,38,0.60); backdrop-filter: blur(5px);
    z-index: 9999; align-items: center; justify-content: center;
}
#loc-modal-backdrop.show { display: flex; animation: fadeInBd 0.2s ease; }
@keyframes fadeInBd { from{opacity:0} to{opacity:1} }

#loc-modal {
    background: #fff; border-radius: 20px; padding: 36px 32px 28px;
    max-width: 440px; width: 92%; text-align: center;
    box-shadow: 0 24px 64px rgba(0,0,0,0.20);
    animation: slideUp 0.3s cubic-bezier(0.34,1.56,0.64,1);
    position: relative; max-height: 90vh; overflow-y: auto;
}
@keyframes slideUp {
    from{transform:translateY(40px) scale(0.95);opacity:0}
    to{transform:translateY(0) scale(1);opacity:1}
}

.loc-icon-ring {
    width:76px; height:76px; border-radius:50%;
    display:flex; align-items:center; justify-content:center;
    margin: 0 auto 18px; transition: background 0.3s, border-color 0.3s;
}
.loc-icon-ring.state-ask    { background:linear-gradient(135deg,#fff3ee,#ffe0d4); border:3px solid rgba(252,94,40,0.18); animation: pulseRing 2s infinite; }
.loc-icon-ring.state-denied { background:linear-gradient(135deg,#fff0f0,#ffd6d6); border:3px solid rgba(220,53,69,0.20); }
.loc-icon-ring.state-ok     { background:linear-gradient(135deg,#e8fff2,#c8f7dc); border:3px solid rgba(37,211,102,0.25); }
@keyframes pulseRing {
    0%,100%{box-shadow:0 0 0 0 rgba(252,94,40,0.25)}
    50%    {box-shadow:0 0 0 12px rgba(252,94,40,0)}
}

#loc-modal h4 { font-size:19px; font-weight:700; color:#040e26; margin-bottom:8px; }
#loc-modal .sub { font-size:13.5px; color:#6b7280; line-height:1.65; margin-bottom:20px; }

.loc-steps { background:#f9fafb; border-radius:12px; padding:14px 16px; margin-bottom:20px; text-align:left; }
.loc-steps li { font-size:13px; color:#374151; padding:5px 0; list-style:none; display:flex; align-items:flex-start; gap:10px; line-height:1.5; }
.step-dot { width:20px; height:20px; min-width:20px; border-radius:50%; color:#fff; font-size:11px; font-weight:700; display:flex; align-items:center; justify-content:center; margin-top:1px; }
.step-dot.orange { background:#fc5e28; }
.step-dot.red    { background:#dc3545; }

.browser-tabs { display:flex; gap:6px; justify-content:center; margin-bottom:14px; flex-wrap:wrap; }
.browser-tab {
    padding:5px 12px; border-radius:20px; font-size:12px; font-weight:600;
    border:1.5px solid #e5e7eb; background:#f9fafb; cursor:pointer;
    color:#374151; transition:all 0.15s;
}
.browser-tab.active { background:#fc5e28; border-color:#fc5e28; color:#fff; }

.unblock-box { background:#fff8e1; border:1px solid #ffe082; border-radius:10px; padding:14px 16px; margin-bottom:18px; text-align:left; }
.unblock-box .ub-title { font-size:13px; font-weight:700; color:#7c5e00; margin-bottom:8px; display:flex; align-items:center; gap:6px; }
.unblock-box ol { margin:0; padding-left:18px; }
.unblock-box ol li { font-size:12.5px; color:#374151; line-height:1.6; padding:2px 0; }
.unblock-box code { background:#fff3cd; padding:1px 5px; border-radius:4px; font-size:11.5px; }

#btn-modal-allow {
    width:100%; padding:14px; border:none; border-radius:10px;
    font-size:15px; font-weight:700; cursor:pointer; letter-spacing:0.3px;
    display:flex; align-items:center; justify-content:center; gap:8px;
    transition:transform 0.15s, box-shadow 0.15s, background 0.2s;
    margin-bottom:4px;
}
#btn-modal-allow.btn-orange {
    background:linear-gradient(135deg,#fc5e28,#e04d1c); color:#fff;
    box-shadow:0 4px 16px rgba(252,94,40,0.35);
}
#btn-modal-allow.btn-orange:hover { transform:translateY(-1px); box-shadow:0 6px 20px rgba(252,94,40,0.45); }
#btn-modal-allow.btn-green {
    background:linear-gradient(135deg,#25D366,#1aab50); color:#fff;
    box-shadow:0 4px 16px rgba(37,211,102,0.30);
}
#btn-modal-allow:disabled { opacity:0.5; cursor:not-allowed; transform:none !important; }

#btn-modal-dismiss { margin-top:10px; background:none; border:none; font-size:12.5px; color:#9ca3af; cursor:pointer; text-decoration:underline; }
#btn-modal-dismiss:hover { color:#dc3545; }

#location-status { display:none; border-radius:8px; padding:13px 18px; margin-bottom:16px; text-align:center; border:1px solid; }
</style>

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