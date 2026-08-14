@extends('layouts.app')

<!-- @section('title', 'Contact Punjab Saathi | Government Service Assistance in Amritsar')

@section('meta_description', 'Contact Punjab Saathi for government application assistance, online service help, and CSC support in Punjab. Call, WhatsApp, or visit our office in Amritsar.')
 -->
<meta name="keywords" content="Punjab Saathi contact, Contact Punjab Saathi, Punjab Saathi support, government service help in Punjab, online government application assistance, CSC Amritsar">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url('/contact') }}">

<meta property="og:type"        content="website">
<meta property="og:title"       content="Contact Punjab Saathi | Government Service Assistance">
<meta property="og:description" content="Get in touch with Punjab Saathi for government service assistance.">
<meta property="og:url"         content="{{ url('/contact') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-contact.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="Contact Punjab Saathi | Government Service Assistance">
<meta name="twitter:description" content="Contact Punjab Saathi for government application assistance and CSC support in Punjab, Amritsar.">
<meta name="twitter:image"       content="{{ asset('images/og-contact.jpg') }}">


<style>
.psk-contact-hero {
    position: relative; min-height: 320px;
    display: flex; align-items: center;
    background-image: url('{{ asset("images/contact-us.jpg") }}');
    background-size: cover; background-position: center; overflow: hidden;
}
.psk-contact-hero .overlay {
    position: absolute; inset: 0;
    background: linear-gradient(135deg, rgba(4,14,38,0.88) 0%, rgba(4,14,38,0.65) 100%);
}
.psk-contact-hero .container { position: relative; z-index: 2; }
.psk-contact-hero .psk-breadcrumb {
    display: flex; align-items: center; gap: 8px;
    color: rgba(255,255,255,0.75); font-size: 13px; margin-bottom: 14px;
}
.psk-contact-hero .psk-breadcrumb a { color: rgba(255,255,255,0.75); text-decoration: none; }
.psk-contact-hero .psk-breadcrumb a:hover { color: #fff; }
.psk-contact-hero h1 {
    color: #fff; font-size: clamp(1.9rem, 4vw, 2.8rem);
    font-weight: 700; margin-bottom: 10px;
}
.psk-contact-hero p { color: rgba(255,255,255,0.82); font-size: 1rem; max-width: 560px; }
.psk-contact-hero .psk-hero-badges { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 20px; }
.psk-hero-badge {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.13); border: 1px solid rgba(255,255,255,0.22);
    color: #fff; padding: 6px 14px; border-radius: 20px; font-size: 12px;
}
.psk-disclaimer-bar {
    background: #fff8ed; border-bottom: 1px solid #fde68a;
    padding: 10px 0; font-size: 13px; color: #92400e;
}
.psk-stats-strip { background: #040e26; padding: 22px 0; }
.psk-stats-strip .psk-stat {
    text-align: center; color: #fff;
    border-right: 1px solid rgba(255,255,255,0.15);
}
.psk-stats-strip .psk-stat:last-child { border-right: none; }
.psk-stats-strip .psk-stat__num {
    font-size: 1.8rem; font-weight: 800;
    color: #fc5e28; display: block; line-height: 1.1;
}
.psk-stats-strip .psk-stat__label { font-size: 12px; opacity: 0.8; margin-top: 3px; display: block; }
.psk-contact-section { padding: 60px 0; }
.psk-section-head { margin-bottom: 40px; }
.psk-section-head .subheading {
    display: inline-block; color: #fc5e28; font-size: 13px;
    font-weight: 600; letter-spacing: 1.5px; text-transform: uppercase; margin-bottom: 8px;
}
.psk-section-head h2 { font-size: clamp(1.5rem, 3vw, 2rem); font-weight: 700; color: #040e26; margin-bottom: 10px; }
.psk-section-head p { color: #6b7280; font-size: 0.95rem; }
.psk-contact-form-card {
    background: #fff; border-radius: 16px;
    box-shadow: 0 4px 30px rgba(4,14,38,0.10);
    padding: 36px 32px; height: 100%;
}
.psk-contact-form-card h3 { font-size: 1.2rem; font-weight: 700; color: #040e26; margin-bottom: 6px; }
.psk-contact-form-card > p { color: #6b7280; font-size: 0.88rem; margin-bottom: 24px; }
.psk-form-group { margin-bottom: 18px; }
.psk-form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.psk-required { color: #ef4444; }
.psk-optional { color: #9ca3af; font-weight: 400; font-size: 11px; }
.psk-input-wrap { position: relative; }
.psk-input-icon {
    position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
    color: #9ca3af; font-size: 13px; pointer-events: none;
}
.psk-input {
    width: 100%; padding: 10px 12px 10px 36px;
    border: 1.5px solid #d1d5db; border-radius: 10px;
    font-size: 13.5px; color: #1f2937; background: #f9fafb;
    outline: none; transition: border-color 0.15s, background 0.15s; font-family: inherit;
}
.psk-input:focus { border-color: #040e26; background: #fff; }
.psk-textarea { min-height: 110px; resize: vertical; }
.psk-form-group--error .psk-input { border-color: #ef4444; background: #fff5f5; }
.psk-field-error { font-size: 11.5px; color: #ef4444; margin-top: 4px; display: block; }
.psk-hp { display: none !important; }
.psk-btn-submit {
    background: linear-gradient(135deg, #040e26, #0f2050);
    color: #fff; border: none; padding: 12px 28px; border-radius: 10px;
    font-size: 14px; font-weight: 600; cursor: pointer; width: 100%;
    transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px;
}
.psk-btn-submit:hover { background: linear-gradient(135deg, #0f2050, #040e26); transform: translateY(-1px); }
.psk-btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
.psk-recaptcha-note { font-size: 11px; color: #9ca3af; margin-top: 10px; text-align: center; }
.psk-alert-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px;
    padding: 14px 18px; display: flex; align-items: center; gap: 10px;
    color: #166534; font-size: 13.5px; font-weight: 600; margin-bottom: 20px;
}
.psk-alert-error {
    background: #fff5f5; border: 1px solid #fecaca; border-radius: 10px;
    padding: 14px 18px; display: flex; align-items: center; gap: 10px;
    color: #991b1b; font-size: 13.5px; margin-bottom: 20px;
}
.psk-info-cards { display: flex; flex-direction: column; gap: 16px; }
.psk-info-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 16px rgba(4,14,38,0.08);
    padding: 20px 22px; display: flex; align-items: flex-start; gap: 16px;
    transition: box-shadow 0.2s, transform 0.2s; text-decoration: none;
}
.psk-info-card:hover { box-shadow: 0 6px 28px rgba(4,14,38,0.14); transform: translateY(-2px); }
.psk-info-card__icon-wrap {
    width: 48px; height: 48px; border-radius: 12px; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1.2rem;
}
.psk-info-card__icon-wrap.orange { background: #fff3e8; color: #fc5e28; }
.psk-info-card__icon-wrap.blue   { background: #eef2f9; color: #040e26; }
.psk-info-card__icon-wrap.green  { background: #f0fdf4; color: #22c55e; }
.psk-info-card__icon-wrap.red    { background: #fff5f5; color: #ef4444; }
.psk-info-card__label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.8px; }
.psk-info-card__value { font-size: 14px; font-weight: 700; color: #040e26; margin: 2px 0; }
.psk-info-card__sub   { font-size: 12px; color: #6b7280; }
.psk-hours-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 16px rgba(4,14,38,0.08);
    padding: 22px; overflow: hidden;
}
.psk-hours-card h4 {
    font-size: 14px; font-weight: 700; color: #040e26;
    margin-bottom: 14px; display: flex; align-items: center; gap: 8px;
}
.psk-hours-table { width: 100%; font-size: 13px; }
.psk-hours-table tr { border-bottom: 1px solid #f3f4f6; }
.psk-hours-table tr:last-child { border-bottom: none; }
.psk-hours-table td { padding: 8px 4px; color: #374151; }
.psk-hours-table td:last-child { text-align: right; font-weight: 600; color: #040e26; }
.psk-open-badge {
    display: inline-block; background: #f0fdf4; color: #22c55e;
    border: 1px solid #bbf7d0; border-radius: 20px; padding: 2px 10px;
    font-size: 11px; font-weight: 700;
}
.psk-closed-badge {
    display: inline-block; background: #fff5f5; color: #ef4444;
    border: 1px solid #fecaca; border-radius: 20px; padding: 2px 10px;
    font-size: 11px; font-weight: 700;
}
.psk-wa-cta {
    background: linear-gradient(135deg, #25D366, #128C7E);
    border-radius: 14px; padding: 22px; color: #fff; text-align: center; margin-top: 16px;
}
.psk-wa-cta .fa { font-size: 2rem; margin-bottom: 8px; display: block; }
.psk-wa-cta h4 { font-weight: 700; margin-bottom: 6px; }
.psk-wa-cta p  { font-size: 12px; opacity: 0.88; margin-bottom: 14px; }
.psk-btn-wa {
    display: inline-flex; align-items: center; gap: 6px;
    background: #fff; color: #128C7E; font-weight: 700; font-size: 13px;
    padding: 10px 22px; border-radius: 8px; text-decoration: none; transition: all 0.15s;
}
.psk-btn-wa:hover { background: #f0fdf4; color: #128C7E; }
.psk-map-section { padding: 0 0 60px; }
.psk-map-wrapper {
    border-radius: 16px; overflow: hidden;
    box-shadow: 0 4px 30px rgba(4,14,38,0.13); position: relative;
}
.psk-map-wrapper iframe { display: block; width: 100%; height: 420px; border: 0; }
.psk-map-label {
    position: absolute; top: 16px; left: 16px; z-index: 10;
    background: #040e26; color: #fff; border-radius: 10px;
    padding: 10px 16px; font-size: 13px; font-weight: 600;
    display: flex; align-items: center; gap: 8px;
    box-shadow: 0 4px 16px rgba(4,14,38,0.3);
}
.psk-faq-section { padding: 60px 0; background: #f0f4fb; }
.psk-faq-new { max-width: 860px; margin: 0 auto; }
.psk-faq-new__item {
    background: #fff; border-radius: 12px; margin-bottom: 10px;
    box-shadow: 0 1px 8px rgba(4,14,38,0.07); overflow: hidden;
}
.psk-faq-new__q {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 20px; cursor: pointer; transition: background 0.15s;
}
.psk-faq-new__q:hover { background: #f8faff; }
.psk-faq-new__num {
    width: 28px; height: 28px; border-radius: 8px;
    background: #eef2f9; color: #040e26;
    font-size: 12px; font-weight: 700;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.psk-faq-new__q-text { flex: 1; font-size: 14px; font-weight: 600; color: #1f2937; }
.psk-faq-new__chevron { color: #9ca3af; transition: transform 0.25s; font-size: 12px; }
.psk-faq-new__item--open .psk-faq-new__chevron { transform: rotate(180deg); }
.psk-faq-new__item--open .psk-faq-new__num { background: #040e26; color: #fff; }
.psk-faq-new__a {
    padding: 0 20px 0 60px; max-height: 0; overflow: hidden;
    font-size: 13.5px; color: #6b7280; line-height: 1.65;
    transition: max-height 0.3s ease, padding 0.3s ease;
}
.psk-faq-new__item--open .psk-faq-new__a { max-height: 300px; padding: 0 20px 16px 60px; }
.psk-cta-banner {
    background: linear-gradient(135deg, #040e26 0%, #0f2050 100%);
    padding: 60px 0;
}
.psk-cta-banner h2 { color: #fff; font-size: clamp(1.4rem, 3vw, 1.9rem); font-weight: 700; }
.psk-cta-banner p  { color: rgba(255,255,255,0.8); font-size: 0.95rem; }
.psk-btn-primary {
    display: inline-flex; align-items: center; gap: 8px;
    background: #fc5e28; color: #fff; border: none;
    padding: 13px 28px; border-radius: 10px; font-size: 14px;
    font-weight: 700; text-decoration: none; transition: all 0.2s;
}
.psk-btn-primary:hover { background: #e06910; color: #fff; transform: translateY(-1px); }
.psk-btn-outline-white {
    display: inline-flex; align-items: center; gap: 8px;
    background: transparent; color: #fff;
    border: 2px solid rgba(255,255,255,0.5);
    padding: 12px 26px; border-radius: 10px; font-size: 14px;
    font-weight: 600; text-decoration: none; transition: all 0.2s;
}
.psk-btn-outline-white:hover { background: rgba(255,255,255,0.1); color: #fff; }
.psk-wa-bubble {
    position: fixed; bottom: 24px; right: 24px; z-index: 9999;
    width: 58px; height: 58px; border-radius: 50%;
    background: #25D366; color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.7rem; box-shadow: 0 4px 18px rgba(37,211,102,0.45);
    text-decoration: none; transition: transform 0.2s;
}
.psk-wa-bubble:hover { transform: scale(1.08); color: #fff; }
@media (max-width: 768px) {
    .psk-contact-form-card { padding: 24px 18px; }
    .psk-info-cards { gap: 12px; }
    .psk-map-wrapper iframe { height: 280px; }
    .psk-stats-strip .psk-stat { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.1); padding: 12px 0; }
    .psk-stats-strip .psk-stat:last-child { border-bottom: none; }

    /* This page uses its own local section/heading classes rather than
       .ftco-section / .heading-section, so the sitewide mobile spacing
       fix (96px -> 56px section padding, 48px -> 32px heading margin)
       never reached it — these sections were still full desktop padding
       on a phone screen. Matches the same target values used elsewhere. */
    .psk-contact-section,
    .psk-faq-section { padding: 32px 0; }
    .psk-map-section { padding: 0 0 32px; }
    .psk-section-head { margin-bottom: 24px; }
}
</style>

@section('content')

{{-- HERO --}}
<section class="psk-contact-hero" aria-label="Contact page header">
    <div class="overlay"></div>
    <div class="container">
        <nav class="psk-breadcrumb" aria-label="breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="fa fa-chevron-right"></span>
            <span aria-current="page">Contact Us</span>
        </nav>
        <h1>Get in Touch with Us</h1>
        <p>We're here to help you with government services, scheme applications, and documentation assistance — in Punjabi, Hindi, or English.</p>
        <div class="psk-hero-badges">
            <span class="psk-hero-badge"><span class="fa fa-clock-o"></span> Mon–Sat, 9 AM–6 PM</span>
            <span class="psk-hero-badge"><span class="fa fa-whatsapp"></span> WhatsApp Support</span>
            <span class="psk-hero-badge"><span class="fa fa-shield"></span> Authorised CSC Operator</span>
        </div>
    </div>
</section>

{{-- DISCLAIMER --}}
<div class="psk-disclaimer-bar" role="note">
    <div class="container">
        <span class="fa fa-info-circle mr-2"></span>
        <strong>Disclaimer:</strong> Punjab Saathi is a <strong>private assistance platform</strong>
        and is <strong>not an official government website</strong>. We help citizens apply through
        authorised government portals as a Common Service Centre (CSC).
    </div>
</div>

{{-- STATS --}}
<div class="psk-stats-strip" aria-label="Key statistics">
    <div class="container">
        <div class="row">
            <div class="col-6 col-md-3 psk-stat">
                <span class="psk-stat__num">75,000+</span>
                <span class="psk-stat__label">Services Completed</span>
            </div>
            <div class="col-6 col-md-3 psk-stat">
                <span class="psk-stat__num">24 hrs</span>
                <span class="psk-stat__label">Response Time</span>
            </div>
            <div class="col-6 col-md-3 psk-stat">
                <span class="psk-stat__num">100%</span>
                <span class="psk-stat__label">Accuracy Guarantee</span>
            </div>
            <div class="col-6 col-md-3 psk-stat">
                <span class="psk-stat__num">3</span>
                <span class="psk-stat__label">Languages Supported</span>
            </div>
        </div>
    </div>
</div>

{{-- CONTACT FORM + INFO --}}
<section class="psk-contact-section" id="contact-form" aria-labelledby="contact-heading">
    <div class="container">

        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center psk-section-head">
                <span class="subheading">Contact Us</span>
                <h2 id="contact-heading">Send Us a Message</h2>
                <p>Fill in the form below and our team will get back to you within 24 hours with the help you need.</p>
            </div>
        </div>

        <div class="row">

            {{-- Contact Form --}}
            <div class="col-lg-7 mb-4 mb-lg-0 ftco-animate">
                <div class="psk-contact-form-card">
                    <h3><span class="fa fa-paper-plane mr-2" style="color:#fc5e28;"></span>Send Your Query</h3>
                    <p>We respond to all messages within 24 hours on working days.</p>

                    @if(session('success'))
                    <div class="psk-alert-success" role="alert">
                        <span class="fa fa-check-circle" style="font-size:1.2rem;color:#22c55e;"></span>
                        {{ session('success') }}
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="psk-alert-error" role="alert">
                        <span class="fa fa-exclamation-circle" style="font-size:1.1rem;"></span>
                        Please fix the errors below before submitting.
                    </div>
                    @endif

                    <form action="{{ route('contact.submit') }}"
                          method="POST"
                          id="psk-contact-form"
                          novalidate
                          aria-label="Contact form">
                        @csrf

                        {{-- Honeypot --}}
                        <div class="psk-hp" aria-hidden="true">
                            <label for="website">Website</label>
                            <input type="text" name="website" id="website" tabindex="-1" autocomplete="off">
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="psk-form-group {{ $errors->has('name') ? 'psk-form-group--error' : '' }}">
                                    <label for="c_name">Full Name <span class="psk-required">*</span></label>
                                    <div class="psk-input-wrap">
                                        <span class="fa fa-user psk-input-icon"></span>
                                        <input type="text" id="c_name" name="name"
                                               value="{{ old('name') }}"
                                               placeholder="Your full name"
                                               class="psk-input"
                                               required autocomplete="name">
                                    </div>
                                    @error('name')
                                        <span class="psk-field-error" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="psk-form-group {{ $errors->has('phone') ? 'psk-form-group--error' : '' }}">
                                    <label for="c_phone">Mobile Number <span class="psk-required">*</span></label>
                                    <div class="psk-input-wrap">
                                        <span class="fa fa-phone psk-input-icon"></span>
                                        <input type="tel" id="c_phone" name="phone"
                                               value="{{ old('phone') }}"
                                               placeholder="10-digit mobile number"
                                               class="psk-input"
                                               maxlength="10" required autocomplete="tel"
                                               pattern="[6-9][0-9]{9}">
                                    </div>
                                    @error('phone')
                                        <span class="psk-field-error" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="psk-form-group {{ $errors->has('email') ? 'psk-form-group--error' : '' }}">
                                    <label for="c_email">Email Address <span class="psk-optional">(optional)</span></label>
                                    <div class="psk-input-wrap">
                                        <span class="fa fa-envelope psk-input-icon"></span>
                                        <input type="email" id="c_email" name="email"
                                               value="{{ old('email') }}"
                                               placeholder="your@email.com"
                                               class="psk-input"
                                               autocomplete="email">
                                    </div>
                                    @error('email')
                                        <span class="psk-field-error" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="psk-form-group {{ $errors->has('subject') ? 'psk-form-group--error' : '' }}">
                                    <label for="c_subject">Subject <span class="psk-required">*</span></label>
                                    <div class="psk-input-wrap">
                                        <span class="fa fa-tag psk-input-icon"></span>
                                        <select id="c_subject" name="subject" class="psk-input" required>
                                            <option value="">Select a topic…</option>
                                            <option value="application_status" {{ old('subject') === 'application_status' ? 'selected' : '' }}>Application Status</option>
                                            <option value="document_help"      {{ old('subject') === 'document_help'      ? 'selected' : '' }}>Document Assistance</option>
                                            <option value="service_info"       {{ old('subject') === 'service_info'       ? 'selected' : '' }}>Service Information</option>
                                            <option value="fees_payment"       {{ old('subject') === 'fees_payment'       ? 'selected' : '' }}>Fees &amp; Payment</option>
                                            <option value="complaint"          {{ old('subject') === 'complaint'          ? 'selected' : '' }}>Complaint / Feedback</option>
                                            <option value="other"              {{ old('subject') === 'other'              ? 'selected' : '' }}>Other</option>
                                        </select>
                                    </div>
                                    @error('subject')
                                        <span class="psk-field-error" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="psk-form-group {{ $errors->has('message') ? 'psk-form-group--error' : '' }}">
                                    <label for="c_message">Message <span class="psk-required">*</span></label>
                                    <div class="psk-input-wrap">
                                        <span class="fa fa-comment psk-input-icon" style="top:14px;transform:none;"></span>
                                        <textarea id="c_message" name="message" rows="5"
                                                  placeholder="Describe your query or issue in detail…"
                                                  class="psk-input psk-textarea"
                                                  required>{{ old('message') }}</textarea>
                                    </div>
                                    @error('message')
                                        <span class="psk-field-error" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="psk-form-group">
                                    <label for="c_language">Preferred Reply Language</label>
                                    <div class="psk-input-wrap">
                                        <span class="fa fa-language psk-input-icon"></span>
                                        <select id="c_language" name="language" class="psk-input">
                                            <option value="en" {{ old('language', 'en') === 'en' ? 'selected' : '' }}>English</option>
                                            <option value="hi" {{ old('language') === 'hi' ? 'selected' : '' }}>हिंदी (Hindi)</option>
                                            <option value="pa" {{ old('language') === 'pa' ? 'selected' : '' }}>ਪੰਜਾਬੀ (Punjabi)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <p style="font-size:11.5px;color:#9ca3af;margin-bottom:14px;">
                            <span class="fa fa-lock mr-1"></span>
                            Your information is kept private and used only to respond to your query.
                        </p>

                        <button type="submit" class="psk-btn-submit" id="psk-submit-btn">
                            <span class="fa fa-paper-plane"></span>
                            Send Message
                        </button>

                        <p class="psk-recaptcha-note">
                            This site is protected against spam. We never share your data with third parties.
                        </p>

                    </form>
                </div>
            </div>

            {{-- Contact Info --}}
            <div class="col-lg-5 ftco-animate">
                <div class="psk-info-cards">

                    <a href="tel:+9198765XXXXX" class="psk-info-card">
                        <div class="psk-info-card__icon-wrap orange">
                            <span class="fa fa-phone"></span>
                        </div>
                        <div>
                            <span class="psk-info-card__label">Phone / Helpline</span>
                            <p class="psk-info-card__value">+91 7710556330</p>
                            <span class="psk-info-card__sub">Mon–Sat · 9 AM–6 PM</span>
                        </div>
                    </a>

                    <a href="mailto:support@punjabsaathi.in" class="psk-info-card">
                        <div class="psk-info-card__icon-wrap blue">
                            <span class="fa fa-envelope"></span>
                        </div>
                        <div>
                            <span class="psk-info-card__label">Email</span>
                            <p class="psk-info-card__value">support@punjabsaathi.in</p>
                            <span class="psk-info-card__sub">We reply within 24 hours</span>
                        </div>
                    </a>

                    <div class="psk-info-card" style="cursor:default;">
                        <div class="psk-info-card__icon-wrap red">
                            <span class="fa fa-map-marker"></span>
                        </div>
                        <div>
                            <span class="psk-info-card__label">Office Address</span>
                            <p class="psk-info-card__value">Shop No : 1, </p>
                            <span class="psk-info-card__sub">
                                Lal Market, Near OHM Omjee Cinema,<br>
                                Grand Trunk Rd, 143001, Amritsar.
                            </span>
                        </div>
                    </div>

                    <div class="psk-hours-card">
                        <h4>
                            <span class="fa fa-clock-o" style="color:#fc5e28;"></span>
                            Working Hours
                        </h4>
                        <table class="psk-hours-table">
                            <tbody>
                                <tr>
                                    <td>Monday – Friday</td>
                                    <td>9:00 AM – 5:00 PM <span class="psk-open-badge">Open</span></td>
                                </tr>
                                <tr>
                                    <td>Saturday</td>
                                    <td>9:00 AM – 4:00 PM <span class="psk-open-badge">Open</span></td>
                                </tr>
                                <tr>
                                    <td>Sunday</td>
                                    <td><span class="psk-closed-badge">Closed</span></td>
                                </tr>
                                <tr>
                                    <td>Public Holidays</td>
                                    <td><span class="psk-closed-badge">Closed</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="psk-wa-cta">
                        <span class="fa fa-whatsapp"></span>
                        <h4>Prefer WhatsApp?</h4>
                        <p>Send your documents and queries directly. No app download needed.</p>
                        <a href="https://wa.me/917710556330"
                           target="_blank" rel="noopener noreferrer"
                           class="psk-btn-wa">
                            <span class="fa fa-whatsapp"></span>
                            Chat on WhatsApp
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>

{{-- MAP --}}
<section class="psk-map-section" aria-labelledby="map-heading">
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center psk-section-head">
                <span class="subheading">Find Us</span>
                <h2 id="map-heading">Our Location in Amritsar</h2>
                <p>Lane No. 12, Shri Hargobind Avenue, Sher Shah Suri Road, Chherrata, Amritsar – 143001</p>
            </div>
        </div>

        <div class="psk-map-wrapper ftco-animate">
            <div class="psk-map-label">
                <span class="fa fa-map-marker"></span>
                Punjab Saathi, Amritsar
            </div>
            <iframe
                title="Punjab Saathi location on Google Maps"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3396.3!2d74.8723!3d31.6340!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMzHCsDM4JzAyLjQiTiA3NMKwNTInMjAuMyJF!5e0!3m2!1sen!2sin!4v1680000000000!5m2!1sen!2sin"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div class="text-center mt-4">
            <a href="https://maps.google.com/?q=Shri+Hargobind+Avenue+Sher+Shah+Suri+Road+Chherrata+Amritsar+143001"
               target="_blank" rel="noopener noreferrer"
               class="psk-btn-primary">
                <span class="fa fa-location-arrow"></span>
                Get Directions on Google Maps
            </a>
        </div>
    </div>
</section>

{{-- FAQ --}}
<section class="psk-faq-section" aria-labelledby="faq-heading" id="faq">
    <div class="container">

        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center psk-section-head">
                <span class="subheading">FAQ</span>
                <h2 id="faq-heading">Frequently Asked Questions</h2>
                <p>Quick answers to the most common questions we receive.</p>
            </div>
        </div>

        <div class="psk-faq-new">
            <div class="psk-faq-new__list">

                <div class="psk-faq-new__item psk-faq-new__item--open">
                    <div class="psk-faq-new__q" role="button" tabindex="0" aria-expanded="true">
                        <div class="psk-faq-new__num">1</div>
                        <span class="psk-faq-new__q-text">How quickly will I get a response after submitting the contact form?</span>
                        <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                    </div>
                    <div class="psk-faq-new__a">
                        We respond to all contact form submissions within 24 working hours. For urgent matters, we recommend reaching out via WhatsApp for a faster reply — usually within a few hours during working hours.
                    </div>
                </div>

                <div class="psk-faq-new__item">
                    <div class="psk-faq-new__q" role="button" tabindex="0" aria-expanded="false">
                        <div class="psk-faq-new__num">2</div>
                        <span class="psk-faq-new__q-text">Can I visit your Amritsar office without an appointment?</span>
                        <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                    </div>
                    <div class="psk-faq-new__a">
                        Yes, walk-ins are welcome at our office at Lane No. 12, Shri Hargobind Avenue, Sher Shah Suri Road, Chherrata, Amritsar during working hours (Mon–Sat, 9 AM–5 PM). However, for complex service requests, we recommend calling ahead.
                    </div>
                </div>

                <div class="psk-faq-new__item">
                    <div class="psk-faq-new__q" role="button" tabindex="0" aria-expanded="false">
                        <div class="psk-faq-new__num">3</div>
                        <span class="psk-faq-new__q-text">What languages can I communicate in?</span>
                        <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                    </div>
                    <div class="psk-faq-new__a">
                        Our team supports Punjabi (ਪੰਜਾਬੀ), Hindi (हिंदी), and English. You can choose your preferred language when submitting this form and we will reply accordingly.
                    </div>
                </div>

                <div class="psk-faq-new__item">
                    <div class="psk-faq-new__q" role="button" tabindex="0" aria-expanded="false">
                        <div class="psk-faq-new__num">4</div>
                        <span class="psk-faq-new__q-text">Is Punjab Saathi an official government office?</span>
                        <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                    </div>
                    <div class="psk-faq-new__a">
                        Punjab Saathi is an authorised Common Service Centre (CSC) — a private assistance platform that helps citizens apply through official government portals. We are not a government office, but we work with government systems to assist you.
                    </div>
                </div>

                <div class="psk-faq-new__item">
                    <div class="psk-faq-new__q" role="button" tabindex="0" aria-expanded="false">
                        <div class="psk-faq-new__num">5</div>
                        <span class="psk-faq-new__q-text">What documents do I need to bring or send for service applications?</span>
                        <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                    </div>
                    <div class="psk-faq-new__a">
                        Required documents vary by service. You can browse the specific service page on our website to see a detailed checklist. For general enquiries, our team will guide you after reviewing your query.
                    </div>
                </div>

                <div class="psk-faq-new__item">
                    <div class="psk-faq-new__q" role="button" tabindex="0" aria-expanded="false">
                        <div class="psk-faq-new__num">6</div>
                        <span class="psk-faq-new__q-text">How can I check my application status?</span>
                        <span class="fa fa-chevron-down psk-faq-new__chevron"></span>
                    </div>
                    <div class="psk-faq-new__a">
                        You can check your application status by using our AI chatbot — just enter your reference number (e.g. PSK-2026-XXXXXX). Alternatively, mention your reference number in the contact form above and we will respond with a status update.
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- Fixed WhatsApp bubble --}}
<a href="https://wa.me/9198765XXXXX?text=Hello%20Punjab%20Seva%20Kendra%2C%20I%20need%20help."
   target="_blank" rel="noopener noreferrer"
   class="psk-wa-bubble"
   title="Chat on WhatsApp"
   aria-label="Contact us on WhatsApp">
    <span class="fa fa-whatsapp"></span>
</a>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    var form = document.getElementById('psk-contact-form');
    var btn  = document.getElementById('psk-submit-btn');
    if (form && btn) {
        form.addEventListener('submit', function () {
            btn.disabled = true;
            btn.innerHTML = '<span class="fa fa-spinner fa-spin"></span> Sending…';
        });
    }

    var phoneInput = document.getElementById('c_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/[^0-9]/g, '');
        });
    }

    var firstError = document.querySelector('.psk-field-error');
    if (firstError) {
        firstError.closest('.psk-form-group').scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

});
</script>
@endpush

@endsection
