@extends('layouts.app')

@section('title', 'About Us - Punjab Saathi | Trusted Public Services in Punjab')
@section('meta_description', 'Punjab Saathi is a private Common Service Centre (CSC) helping citizens across Punjab apply for government documents and certificates online — fast, reliable, and without the queues.')

@push('head')
<link rel="preload" as="image" href="{{ asset('images/punjab-farmers-field-banner.webp') }}">

<link rel="canonical" href="{{ url('/about') }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="About Us - Punjab Saathi | Trusted Public Services in Punjab">
<meta property="og:description" content="Punjab Saathi is a private Common Service Centre (CSC) helping citizens across Punjab apply for government documents and certificates online — fast, reliable, and without the queues.">
<meta property="og:url"         content="{{ url('/about') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="About Us - Punjab Saathi | Trusted Public Services in Punjab">
<meta name="twitter:description" content="Punjab Saathi is a private Common Service Centre (CSC) helping citizens across Punjab apply for government documents and certificates online — fast, reliable, and without the queues.">

<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'About Us', 'url' => url('/about')],
])) !!}</script>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════ --}}
{{-- HERO SECTION                                    --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/punjab-farmers-field-banner.webp') }}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>About Us <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">About Punjab Saathi</h1>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════ --}}
{{-- WHO WE ARE SECTION                             --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section" id="about-section">
    <div class="container">
        <div class="row">
            {{-- Left image --}}
            <div class="col-md-6 d-flex align-items-stretch">
                <div class="about-wrap img w-100" style="background-image: url({{ asset('images/punjab-saathi-csc-operator-helping-citizen.webp') }});">
                    <div class="icon d-flex align-items-center justify-content-center">
                        <span class="flaticon-crane"></span>
                    </div>
                </div>
            </div>

            {{-- Right content --}}
            <div class="col-md-6 py-5 pl-md-5">
                <div class="row justify-content-center mb-4 pt-md-4">
                    <div class="col-md-12 heading-section ftco-animate">
                        <span class="subheading">Who We Are</span>
                        <h2 class="mb-4">Punjab's Trusted Online Service Partner</h2>

                        <div class="d-flex about mb-3">
                            <div class="icon"><span class="flaticon-hammer"></span></div>
                            <h3>Helping You Access Government Services, Simply</h3>
                        </div>

                        <!-- <p>Punjab Saathi is a trusted digital service centre helping citizens across Punjab navigate complex government portals, certificates, and document processes — quickly, affordably, and without stress.</p> -->

                        <p>We believe everyone in Punjab deserves easy, fast, and honest access to government services — whether they live in Ludhiana, a small village in Sangrur, or anywhere across the state. You don't need to stand in long queues or make multiple trips to government offices. We handle everything for you, online, from the comfort of your home.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════ --}}
{{-- OUR MISSION & VISION                           --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section bg-half-light">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">Our Purpose</span>
                <h2 class="mb-4">Mission, Vision & Values</h2>
                <p class="text-muted">Everything we do is guided by one goal — making government services accessible to every person in Punjab.</p>
            </div>
        </div>

        <div class="row">
            {{-- Mission --}}
            <div class="col-md-4">
                <div class="media block-6 services d-flex ftco-animate">
                    <div class="icon justify-content-center align-items-center d-flex">
                        <span class="flaticon-engineer-1"></span>
                    </div>
                    <div class="media-body pl-4">
                        <h3 class="heading mb-3">Our Mission</h3>
                        <p>To bring every government service to every person in Punjab — online, fast, affordable, and in their own language — so nobody is left behind due to distance, language, or lack of knowledge.</p>
                    </div>
                </div>
            </div>

            {{-- Vision --}}
            <div class="col-md-4">
                <div class="media block-6 services services-2 d-flex ftco-animate">
                    <div class="icon justify-content-center align-items-center d-flex">
                        <span class="flaticon-worker-1"></span>
                    </div>
                    <div class="media-body pl-4">
                        <h3 class="heading mb-3">Our Vision</h3>
                        <p>To become Punjab's most trusted digital government service platform — where every family, farmer, student, and business can access 100+ government services from their phone or home.</p>
                    </div>
                </div>
            </div>

            {{-- Values --}}
            <div class="col-md-4">
                <div class="media block-6 services d-flex ftco-animate">
                    <div class="icon justify-content-center align-items-center d-flex">
                        <span class="flaticon-engineer"></span>
                    </div>
                    <div class="media-body pl-4">
                        <h3 class="heading mb-3">Our Values</h3>
                        <p>Honesty, speed, and accuracy. We never take shortcuts with your documents. Every application is reviewed carefully before submission — your trust is our biggest asset.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
{{-- ═══════════════════════════════════════════════ --}}
{{-- STATS COUNTER SECTION — Enhanced               --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section ftco-no-pt ftco-no-pb psk-counter-section" style="position:relative;overflow:hidden;">

    {{-- Full-bleed background image with overlay --}}
    <div style="position:absolute;inset:0;background-image:url({{ asset('images/document-submission-service.webp') }});background-size:cover;background-position:center;z-index:0;"></div>
    <div style="position:absolute;inset:0;background:linear-gradient(100deg,#040e26 0%,rgba(4,14,38,0.92) 48%,rgba(4,14,38,0.55) 100%);z-index:1;"></div>

    <div class="container" style="position:relative;z-index:2;">
        <div class="row no-gutters align-items-stretch" style="min-height:520px;">

            {{-- LEFT — Text content --}}
            {{-- align-items-end (not -center): the stat-cards column on
                 the right is taller than this text block, so centering
                 split the leftover space evenly above and below —
                 leaving the button floating with a dead gap beneath it
                 instead of sitting near the bottom. Anchoring to the
                 bottom matches how the site's own hero banners already
                 anchor text over a background image (align-items-end).
                 Also swapped py-5 for pt-5 + a smaller bottom padding —
                 that bottom padding sits outside the flex alignment
                 entirely (it's on the column, not the content), so it
                 stayed as a literal gap below the button no matter how
                 the content above it was aligned. --}}
            <div class="col-md-6 d-flex align-items-end pt-5 pb-4 pr-md-5">
                <div>
                    <span style="display:inline-block;background:#fc5e28;color:#fff;font-size:11px;font-weight:700;letter-spacing:3px;text-transform:uppercase;padding:5px 14px;border-radius:30px;margin-bottom:20px;">
                        Punjab Saathi
                    </span>

                    <h2 style="font-size:38px;font-weight:800;color:#fff;line-height:1.25;margin-bottom:20px;">
                        Serving People Across<br>
                        <span style="color:#fc5e28;">Every District of Punjab</span>
                    </h2>

                    <p style="color:rgba(255,255,255,0.78);font-size:16px;line-height:1.8;margin-bottom:28px;">
                        From Amritsar to Pathankot, from Ludhiana to Ferozepur — families, students, farmers, and businesses across Punjab trust us for fast, correct, and affordable government services. We are a certified CSC with operators trained on all state and central government portals.
                    </p>

                    {{-- Trust badges --}}
                    <div style="display:flex;flex-wrap:wrap;gap:12px;margin-bottom:32px;">
                        <div style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:8px;padding:8px 14px;">
                            <span class="fa fa-shield" style="color:#fc5e28;"></span>
                            <span style="color:#fff;font-size:13px;font-weight:500;">Certified CSC Operator</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:8px;padding:8px 14px;">
                            <span class="fa fa-check-circle" style="color:#fc5e28;"></span>
                            <span style="color:#fff;font-size:13px;font-weight:500;">Zero Rejections</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:8px;padding:8px 14px;">
                            <span class="fa fa-whatsapp" style="color:#25D366;"></span>
                            <span style="color:#fff;font-size:13px;font-weight:500;">WhatsApp Support</span>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;background:rgba(255,255,255,0.08);border:1px solid rgba(255,255,255,0.15);border-radius:8px;padding:8px 14px;">
                            <span class="fa fa-magic" style="color:#a78bfa;"></span>
                            <span style="color:#fff;font-size:13px;font-weight:500;">AI-Powered Support</span>
                        </div>
                    </div>

                    <a href="{{ url('/services') }}"
                        style="display:inline-flex;align-items:center;gap:10px;background:#fc5e28;color:#fff;font-weight:700;font-size:14px;letter-spacing:1px;text-transform:uppercase;padding:14px 28px;border-radius:8px;text-decoration:none;transition:all 0.3s;"
                        onmouseover="this.style.background='#e04d1c'" onmouseout="this.style.background='#fc5e28'">
                        <span class="fa fa-list"></span> Explore All Our Services
                    </a>
                </div>
            </div>

            {{-- RIGHT — Stat cards grid --}}
            <div class="col-md-6 d-flex align-items-center py-5 pl-md-4">
                <div class="psk-stat-grid" style="display:grid;grid-template-columns:1fr 1fr;gap:16px;width:100%;">

                    {{-- Stat 1 --}}
                    <div class="ftco-animate" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:16px;padding:28px 22px;backdrop-filter:blur(8px);transition:transform 0.3s,background 0.3s;"
                        onmouseover="this.style.background='rgba(252,94,40,0.18)';this.style.transform='translateY(-4px)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.06)';this.style.transform='translateY(0)'">
                        <div style="width:48px;height:48px;background:rgba(252,94,40,0.20);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <span class="flaticon-engineer" style="color:#fc5e28;font-size:22px;"></span>
                        </div>
                        <strong class="number" data-number="75000"
                            style="display:block;font-size:40px;font-weight:900;color:#fff;line-height:1;margin-bottom:6px;">0</strong>
                        <span style="color:rgba(255,255,255,0.65);font-size:13px;text-transform:uppercase;letter-spacing:1.5px;font-weight:500;">Services Completed</span>
                        <div style="width:32px;height:3px;background:#fc5e28;border-radius:2px;margin-top:12px;"></div>
                    </div>

                    {{-- Stat 2 --}}
                    <div class="ftco-animate" style="background:rgba(252,94,40,0.85);border:1px solid rgba(252,94,40,0.3);border-radius:16px;padding:28px 22px;transition:transform 0.3s,background 0.3s;"
                        onmouseover="this.style.transform='translateY(-4px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                        <div style="width:48px;height:48px;background:rgba(255,255,255,0.20);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <span class="flaticon-worker-1" style="color:#fff;font-size:22px;"></span>
                        </div>
                        <strong class="number" data-number="50000"
                            style="display:block;font-size:40px;font-weight:900;color:#fff;line-height:1;margin-bottom:6px;">0</strong>
                        <span style="color:rgba(255,255,255,0.85);font-size:13px;text-transform:uppercase;letter-spacing:1.5px;font-weight:500;">Happy Citizens Served</span>
                        <div style="width:32px;height:3px;background:rgba(255,255,255,0.5);border-radius:2px;margin-top:12px;"></div>
                    </div>

                    {{-- Stat 3 --}}
                    <div class="ftco-animate" style="background:rgba(252,94,40,0.85);border:1px solid rgba(252,94,40,0.3);border-radius:16px;padding:28px 22px;transition:transform 0.3s,background 0.3s;"
                        onmouseover="this.style.transform='translateY(-4px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                        <div style="width:48px;height:48px;background:rgba(255,255,255,0.20);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <span class="flaticon-engineer-1" style="color:#fff;font-size:22px;"></span>
                        </div>
                        <strong class="number" data-number="22"
                            style="display:block;font-size:40px;font-weight:900;color:#fff;line-height:1;margin-bottom:6px;">0</strong>
                        <span style="color:rgba(255,255,255,0.85);font-size:13px;text-transform:uppercase;letter-spacing:1.5px;font-weight:500;">Districts in Punjab</span>
                        <div style="width:32px;height:3px;background:rgba(255,255,255,0.5);border-radius:2px;margin-top:12px;"></div>
                    </div>

                    {{-- Stat 4 --}}
                    <div class="ftco-animate" style="background:rgba(255,255,255,0.06);border:1px solid rgba(255,255,255,0.12);border-radius:16px;padding:28px 22px;backdrop-filter:blur(8px);transition:transform 0.3s,background 0.3s;"
                        onmouseover="this.style.background='rgba(252,94,40,0.18)';this.style.transform='translateY(-4px)'"
                        onmouseout="this.style.background='rgba(255,255,255,0.06)';this.style.transform='translateY(0)'">
                        <div style="width:48px;height:48px;background:rgba(252,94,40,0.20);border-radius:12px;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                            <span class="flaticon-worker-1" style="color:#fc5e28;font-size:22px;"></span>
                        </div>
                        <strong class="number" data-number="50"
                            style="display:block;font-size:40px;font-weight:900;color:#fff;line-height:1;margin-bottom:6px;">0</strong>
                        <span style="color:rgba(255,255,255,0.65);font-size:13px;text-transform:uppercase;letter-spacing:1.5px;font-weight:500;">Govt. Services Available</span>
                        <div style="width:32px;height:3px;background:#fc5e28;border-radius:2px;margin-top:12px;"></div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</section>
{{-- ═══════════════════════════════════════════════ --}}
{{-- STATS COUNTER SECTION                          --}}
{{-- ═══════════════════════════════════════════════ --}}
{{-- ═══════════════════════════════════════════════ --}}
{{-- HOW WE WORK — PROCESS STEPS                    --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">Simple Process</span>
                <h2 class="mb-4">How Punjab Saathi Works</h2>
                <p class="text-muted">Getting your government work done is as simple as 4 easy steps — all from WhatsApp or our website.</p>
            </div>
        </div>

        <div class="row">
            @php
            $steps = [
            [
            'step' => '01',
            'icon' => 'fa-whatsapp',
            'title' => 'Contact Us on WhatsApp',
            'desc' => 'Send us a WhatsApp message or call us. Tell us which service you need — we reply within 30 minutes.',
            'color' => '#25D366',
            'bg' => 'rgba(37,211,102,0.10)',
            ],
            [
            'step' => '02',
            'icon' => 'fa-file-photo-o',
            'title' => 'Send Your Documents',
            'desc' => 'We tell you exactly which documents are needed. You send clear photos on WhatsApp — no visit required.',
            'color' => '#fc5e28',
            'bg' => 'rgba(252,94,40,0.10)',
            ],
            [
            'step' => '03',
            'icon' => 'fa-desktop',
            'title' => 'We Process Online',
            'desc' => 'Our trained operators fill and submit your application on the official government portal — 100% accurately.',
            'color' => '#3b82f6',
            'bg' => 'rgba(59,130,246,0.10)',
            ],
            [
            'step' => '04',
            'icon' => 'fa-check-circle',
            'title' => 'You Receive Your Document',
            'desc' => 'We send you the acknowledgement and final document on WhatsApp. Done — without leaving your home.',
            'color' => '#fc5e28',
            'bg' => 'rgba(252,94,40,0.10)',
            ],
            ];
            @endphp

            @foreach($steps as $i => $s)
            <div class="col-md-3 ftco-animate mb-4">

                {{-- Connector arrow (not after last card) --}}
                <div class="psk-step-wrap" style="position:relative;">

                    <div class="psk-step-card" style="
                        background:#fff;
                        border-radius:16px;
                        padding:32px 24px 28px;
                        text-align:center;
                        position:relative;
                        overflow:hidden;
                        box-shadow:0 4px 24px rgba(0,0,0,0.07);
                        border:1px solid #f0f0f0;
                        transition:transform 0.3s ease, box-shadow 0.3s ease;
                        cursor:default;
                    "
                        onmouseover="this.style.transform='translateY(-8px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.13)';"
                        onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 4px 24px rgba(0,0,0,0.07)';">

                        {{-- Big watermark step number --}}
                        <div style="
                            position:absolute;top:-8px;right:14px;
                            font-size:5rem;font-weight:900;line-height:1;
                            color:rgba(0,0,0,0.04);
                            user-select:none;pointer-events:none;">
                            {{ $s['step'] }}
                        </div>

                        {{-- Step badge --}}
                        <div style="
                            display:inline-block;
                            background:{{ $s['bg'] }};
                            color:{{ $s['color'] }};
                            font-size:11px;font-weight:700;
                            letter-spacing:2px;text-transform:uppercase;
                            padding:4px 12px;border-radius:30px;
                            margin-bottom:18px;">
                            Step {{ $s['step'] }}
                        </div>

                        {{-- Icon circle --}}
                        <div style="
                            width:64px;height:64px;
                            background:{{ $s['bg'] }};
                            border-radius:50%;
                            display:flex;align-items:center;justify-content:center;
                            margin:0 auto 18px;">
                            <span class="fa {{ $s['icon'] }}"
                                style="font-size:26px;color:{{ $s['color'] }};"></span>
                        </div>

                        <h3 style="font-size:1rem;font-weight:700;color:#040e26;margin-bottom:10px;">
                            {{ $s['title'] }}
                        </h3>
                        <p style="font-size:0.875rem;color:#6b7280;line-height:1.7;margin:0;">
                            {{ $s['desc'] }}
                        </p>

                        {{-- Bottom accent line --}}
                        <div style="
                            position:absolute;bottom:0;left:50%;transform:translateX(-50%);
                            width:40px;height:3px;
                            background:{{ $s['color'] }};
                            border-radius:2px 2px 0 0;">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Step connector dots --}}
        <div class="row justify-content-center mt-2 d-none d-md-flex">
            <div class="col-md-10">
                <div style="display:flex;align-items:center;justify-content:space-around;padding:0 60px;">
                    @for($i = 0; $i < 3; $i++)
                        <div style="display:flex;align-items:center;flex:1;">
                        <div style="flex:1;height:2px;background:linear-gradient(90deg,#fc5e28,rgba(252,94,40,0.2));border-radius:2px;"></div>
                        <span class="fa fa-chevron-right" style="color:#fc5e28;font-size:12px;margin:0 4px;"></span>
                </div>
                @endfor
            </div>
        </div>
    </div>

    </div>
</section>


{{-- ═══════════════════════════════════════════════ --}}
{{-- WHY CHOOSE US                                  --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section bg-half-light">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">Why Choose Us</span>
                <h2 class="mb-4">Why 50,000+ Punjab People Trust Us</h2>
                <p class="text-muted">There are many service centres in Punjab — here is what makes Punjab Saathi different.</p>
            </div>
        </div>

        <div class="row">
            @php
            $reasons = [
            [
            'icon' => 'fa-home',
            'title' => 'Serve Entire Punjab from Home',
            'desc' => 'You do not need to visit us physically. We serve customers from every district of Punjab online — Amritsar, Ludhiana, Patiala, Bathinda, Jalandhar and beyond.',
            ],
            [
            'icon' => 'fa-language',
            'title' => 'Punjabi, Hindi & English',
            'desc' => 'We communicate in the language you are most comfortable with — Punjabi, Hindi, or English. Government forms are explained in simple words.',
            ],
            [
            'icon' => 'fa-shield',
            'title' => '100% Safe & Secure',
            'desc' => 'Your documents are handled with complete confidentiality. We never share or misuse customer data. Your privacy is our responsibility.',
            ],
            [
            'icon' => 'fa-rupee',
            'title' => 'Affordable & Transparent Pricing',
            'desc' => 'We charge fair, fixed prices for every service — no hidden fees, no surprises. You know the exact cost before we start.',
            ],
            [
            'icon' => 'fa-clock-o',
            'title' => 'Fast Turnaround Time',
            'desc' => 'Most services are completed within 1–3 working days. We keep you updated at every step — no more chasing government offices.',
            ],
            [
            'icon' => 'fa-headphones',
            'title' => 'Personal Support Always',
            'desc' => 'You always talk to a real person — not a bot. Call us or WhatsApp us and get a genuine, helpful reply within 30 minutes.',
            ],
            ];
            @endphp

            @foreach($reasons as $r)
            <div class="col-md-4 ftco-animate">
                <div class="media block-6 services d-flex mb-4">
                    <div class="icon justify-content-center align-items-center d-flex">
                        <span class="fa {{ $r['icon'] }}"></span>
                    </div>
                    <div class="media-body pl-4">
                        <h3 class="heading mb-2">{{ $r['title'] }}</h3>
                        <p>{{ $r['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════ --}}
{{-- DISTRICTS WE COVER                             --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">Coverage</span>
                <h2 class="mb-4">We Serve All 22 Districts of Punjab</h2>
                <p class="text-muted">No matter which district you are in — we can help you with government services fully online.</p>
            </div>
        </div>

        <div class="row ftco-animate">
            <div class="col-12">
                <div class="d-flex flex-wrap justify-content-center" style="gap:10px;">
                    @php
                    $districts = [
                    'Amritsar','Barnala','Bathinda','Faridkot','Fatehgarh Sahib',
                    'Fazilka','Ferozepur','Gurdaspur','Hoshiarpur','Jalandhar',
                    'Kapurthala','Ludhiana','Mansa','Moga','Mohali (SAS Nagar)',
                    'Muktsar','Nawanshahr','Pathankot','Patiala','Rupnagar',
                    'Sangrur','Tarn Taran'
                    ];
                    @endphp
                    @foreach($districts as $d)
                    <span class="badge"
                        style="background:#f4f4f4;color:#333;padding:8px 16px;border-radius:20px;font-size:0.9rem;border:1px solid #e0e0e0;font-weight:500;">
                        <span class="fa fa-map-marker text-primary mr-1"></span> {{ $d }}
                    </span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════ --}}
{{-- TESTIMONIALS — same real Google Reviews component as homepage --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section ftco-no-pt ftco-no-pb testimony-section img psk-testimony">
    <div class="overlay"></div>
    <div class="container">
        <div class="row ftco-animate justify-content-center align-items-center">
            <div class="col-md-6 p-4 pl-md-0 py-md-5 pr-md-5 aside-stretch d-flex align-items-center">
                <div class="heading-section heading-section-white">
                    <span class="subheading" style="color:#fff;">What Citizens Say</span>
                    <h2 class="mb-4" style="font-size:40px;">Real reviews from real Punjab families who trusted us</h2>
                    <p style="color:rgba(255,255,255,0.8);">From Ludhiana to Amritsar, from Patiala to Jalandhar — citizens share their experience.</p>

                    @if($reviewAvgRating)
                    <div class="psk-review-stat">
                        <div class="psk-review-stat__score">{{ number_format($reviewAvgRating, 1) }}</div>
                        <div>
                            <div class="psk-review-stat__stars">
                                @for($i = 0; $i < round($reviewAvgRating); $i++)<span class="fa fa-star"></span>@endfor
                            </div>
                            <div class="psk-review-stat__label">
                                Verified Google Reviews
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            <div class="col-md-6 pl-md-5 py-4 py-md-5 aside-stretch-right">
                <div class="carousel-testimony owl-carousel ftco-owl">
                    @foreach($googleReviews as $review)
                    <div class="item">
                        <div class="psk-testimony-card">
                            <span class="psk-testimony-card__bigquote fa fa-quote-right"></span>
                            <div class="psk-testimony-card__stars">
                                @for($i = 0; $i < $review->rating; $i++)<span class="fa fa-star"></span>@endfor
                            </div>
                            <p class="psk-testimony-card__text">{{ $review->review_text }}</p>
                            <div class="psk-testimony-card__footer">
                                <div class="psk-testimony-card__avatar" style="background:{{ $review->avatar_color }};">
                                    {{ $review->initial }}
                                </div>
                                <div>
                                    <p class="psk-testimony-card__name">
                                        {{ $review->reviewer_name }}
                                        @if($review->city)
                                            <span class="psk-testimony-card__city">— {{ $review->city }}</span>
                                        @endif
                                    </p>
                                    <span class="psk-testimony-card__source">
                                        Google Review
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-testimony.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
@endpush

@push('plugin-scripts')
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
@endpush

{{-- ═══════════════════════════════════════════════ --}}
{{-- CTA BANNER — same style as homepage intro      --}}
{{-- ═══════════════════════════════════════════════ --}}
{{-- ═══════════════════════════════════════════════════════ --}}
{{-- REPLACE the old ftco-intro CTA section with this      --}}
{{-- AI-Powered Assistant Section                          --}}
{{-- ═══════════════════════════════════════════════════════ --}}

<section class="ftco-section psk-ai-section" id="ai-assistant-section">
    <div class="container">

        {{-- Section heading --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 text-center">
                <span class="subheading" style="color:#25D366;font-size:12px;letter-spacing:2px;text-transform:uppercase;font-weight:600;">
                    <span class="fa fa-circle" style="font-size:8px;vertical-align:middle;margin-right:6px;"></span>Live Now · Powered by Punjab Saathi
                </span>
                <h2 style="font-size:38px;font-weight:800;color:#040e26;margin-top:8px;line-height:1.25;">
                    Punjab's First AI-Powered<br>
                    <span style="color:#fc5e28;">Service Assistant</span>
                </h2>
                <p style="font-size:17px;color:#5a6a7a;margin-top:16px;max-width:680px;margin-left:auto;margin-right:auto;line-height:1.75;">
                    No more calls. No more waiting. Our AI assistant is live on this website right now —
                    ask questions, check your application status, and find your nearest CSC centre,
                    24/7, in Punjabi, Hindi or English.
                </p>
            </div>
        </div>

        {{-- Feature cards --}}
        <div class="row justify-content-center mb-5">

            {{-- Card 1 — AI Chat --}}
            <div class="col-md-4 mb-4">
                <div class="psk-ai-card">
                    <div class="psk-ai-card__icon" style="background:rgba(252,94,40,0.10);">
                        <span class="fa fa-comments" style="color:#fc5e28;font-size:28px;"></span>
                    </div>
                    <h3>AI Chat Assistant</h3>
                    <p>Ask anything in Punjabi, Hindi or English. Our AI bot answers instantly — service charges, required documents, eligibility, timelines — everything.</p>
                    <div class="psk-ai-card__badge">
                        <span class="fa fa-circle" style="color:#fc5e28;font-size:8px;vertical-align:middle;margin-right:5px;"></span>
                        Available 24 × 7
                    </div>
                </div>
            </div>

            {{-- Card 2 — CSC Locator --}}
            <div class="col-md-4 mb-4">
                <div class="psk-ai-card psk-ai-card--featured">
                    <div class="psk-ai-card__badge--top">⭐ Most Useful</div>
                    <div class="psk-ai-card__icon" style="background:rgba(255,255,255,0.20);">
                        <span class="fa fa-map-marker" style="color:#fff;font-size:28px;"></span>
                    </div>
                    <h3 style="color:#fff;">CSC Centre Locator</h3>
                    <p style="color:rgba(255,255,255,0.88);">Just ask "CSC centre near [your city or PIN code]" and our AI instantly searches our live database of 36,000+ CSC centres across Punjab and shows you the nearest ones — with contact details.</p>
                    <div class="psk-ai-card__badge" style="background:rgba(255,255,255,0.20);color:#fff;">
                        <span class="fa fa-check-circle" style="font-size:10px;margin-right:5px;"></span>
                        36,000+ Centres Searchable
                    </div>
                </div>
            </div>

            {{-- Card 3 — Status Tracker --}}
            <div class="col-md-4 mb-4">
                <div class="psk-ai-card">
                    <div class="psk-ai-card__icon" style="background:rgba(252,94,40,0.10);">
                        <span class="fa fa-search" style="color:#fc5e28;font-size:28px;"></span>
                    </div>
                    <h3>Live Status Tracker</h3>
                    <p>Just send your application number on WhatsApp or website. AI checks the government portal instantly and tells you exactly where your application stands.</p>
                    <div class="psk-ai-card__badge">
                        <span class="fa fa-circle" style="color:#28a745;font-size:8px;vertical-align:middle;margin-right:5px;"></span>
                        Real-Time Updates
                    </div>
                </div>
            </div>

        </div>

        {{-- Services AI will handle --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 text-center">
                <p style="font-size:13px;text-transform:uppercase;letter-spacing:2px;color:#fc5e28;font-weight:600;margin-bottom:16px;">
                    Ask Our AI Assistant About Any of These Services
                </p>
                <div class="psk-ai-tags">
                    <span>PAN Card</span>
                    <span>Income Certificate</span>
                    <span>Caste Certificate</span>
                    <span>Aadhaar Update</span>
                    <span>Scholarship Form</span>
                    <span>Voter ID</span>
                    <span>Birth Certificate</span>
                    <span>Jamabandi / Fard</span>
                    <span>E-Shram Card</span>
                    <span>PM Kisan</span>
                    <span>Driving Licence</span>
                    <span>50+ More</span>
                </div>
            </div>
        </div>

        {{-- Notify CTA --}}
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="psk-ai-notify">
                    <div class="psk-ai-notify__pulse" style="background:#25D366;"></div>
                    <h4 style="color:#040e26;font-weight:700;margin-bottom:8px;"><span class="fa fa-bolt mr-2" style="color:#fc5e28;"></span>Live Now — Try It Yourself</h4>
                    <p style="color:#5a6a7a;margin-bottom:24px;font-size:15px;">
                        Click the chat icon in the bottom-right corner of your screen, or tap below to
                        start chatting with our AI assistant right now.
                    </p>
                    <div class="d-flex justify-content-center flex-wrap" style="gap:14px;">
                        <button type="button" onclick="document.getElementById('psk-chatbot-btn')?.click();"
                            class="btn btn-primary px-4 py-3">
                            <span class="fa fa-comments mr-2"></span> Chat With AI Now
                        </button>
                        <a href="{{ url('/services') }}"
                            class="btn btn-secondary px-4 py-3">
                            <span class="fa fa-list mr-2"></span> View All Services
                        </a>
                    </div>
                    <p style="font-size:13px;color:#aaa;margin-top:16px;">
                        Prefer WhatsApp or a phone call? We're also available Mon–Sat, 9 AM–7 PM.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Floating WhatsApp Button --}}
<a href="https://wa.me/917710556330"
    target="_blank"
    rel="noopener"
    title="Chat with Punjab Saathi on WhatsApp"
    style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:#fff;width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.7rem;box-shadow:0 4px 18px rgba(37,211,102,0.45);text-decoration:none;">
    <span class="fa fa-whatsapp"></span>
</a>
<script>
    // PSK Counter — fires once when the stats section scrolls into view
    document.addEventListener('DOMContentLoaded', function() {
        function animateCounter(el) {
            var target = parseInt(el.getAttribute('data-number'), 10);
            var duration = 2000;
            var start = null;

            function step(timestamp) {
                if (!start) start = timestamp;
                var progress = Math.min((timestamp - start) / duration, 1);
                var eased = 1 - Math.pow(1 - progress, 3);
                el.textContent = Math.floor(eased * target).toLocaleString();
                if (progress < 1) requestAnimationFrame(step);
                else el.textContent = target.toLocaleString();
            }
            requestAnimationFrame(step);
        }

        var triggered = false;

        function checkVisibility() {
            if (triggered) return;
            var section = document.querySelector('.psk-counter-section');
            if (!section) return;
            var rect = section.getBoundingClientRect();
            if (rect.top < window.innerHeight - 100) {
                triggered = true;
                section.querySelectorAll('.number[data-number]').forEach(function(el) {
                    animateCounter(el);
                });
            }
        }

        window.addEventListener('scroll', checkVisibility, {
            passive: true
        });
        checkVisibility();
    });
</script>
@endsection