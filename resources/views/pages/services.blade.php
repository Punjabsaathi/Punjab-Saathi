@extends('layouts.app')

@section('title', 'Government Services in Punjab - Punjab Seva Kendra | Aadhaar, PAN, Certificates & More')

@section('meta_description', 'Punjab Seva Kendra offers ' . $totalServices . '+ government services online — Aadhaar update, PAN card, income certificate, caste certificate, voter ID, birth certificate, ration card, and more. Fast, affordable, doorstep delivery across all 22 districts of Punjab.')

@section('content')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- HERO / PAGE BANNER                                      --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image: url('{{ asset('images/services.jpg') }}');"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>Services <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-3 bread">Government Services in Punjab</h1>
                <p style="color:rgba(255,255,255,0.85);font-size:1.05rem;max-width:600px;line-height:1.7;">
                    {{ $totalServices }}+ government services processed online — correctly, quickly, and delivered to your door.
                    Serving every district of Punjab.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- TRUST BAR — Quick stats strip                          --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="ftco-section ftco-no-pt ftco-no-pb psk-trust-bar" style="background:#fc5e28;">
    <div class="container">
        <div class="row no-gutters psk-trust-bar__inner">
            @php
            $trustItems = [
                ['icon' => 'fa-check-circle', 'number' => '75,000+',            'label' => 'Services Completed'],
                ['icon' => 'fa-users',         'number' => '50,000+',            'label' => 'Citizens Served'],
                ['icon' => 'fa-list',          'number' => $totalServices . '+', 'label' => 'Services Available'],
                ['icon' => 'fa-map-marker',    'number' => '22',                 'label' => 'Districts Covered'],
                ['icon' => 'fa-clock-o',       'number' => '1–3 Days',           'label' => 'Average Turnaround'],
            ];
            @endphp
            @foreach($trustItems as $item)
            <div class="col psk-trust-bar__item ftco-animate">
                <span class="fa {{ $item['icon'] }}"></span>
                <strong>{{ $item['number'] }}</strong>
                <span>{{ $item['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- INTRO + HOW IT WORKS STRIP                             --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="ftco-section ftco-no-pb" id="services-intro">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-9 text-center heading-section ftco-animate">
                <span class="subheading">What We Do</span>
                <h2 class="mb-3">Punjab's Trusted Online Government Service Centre</h2>
                <p class="text-muted" style="font-size:1rem;line-height:1.8;">
                    Punjab Seva Kendra is an authorised Common Service Centre (CSC) helping families, students,
                    farmers, and businesses across Punjab get government documents and certificates — without
                    standing in queues, without wasted trips, and without rejected applications.
                    Simply WhatsApp us, send your documents, and we handle the rest.
                </p>
            </div>
        </div>

        {{-- Mini process strip --}}
        <div class="row justify-content-center ftco-animate mb-2">
            <div class="col-md-10">
                <div class="psk-mini-steps">
                    @php
                    $miniSteps = [
                        ['icon' => 'fa-whatsapp',     'color' => '#25D366', 'label' => '1. WhatsApp Us'],
                        ['icon' => 'fa-arrow-right',  'color' => '#ccc',    'label' => '', 'arrow' => true],
                        ['icon' => 'fa-file-photo-o', 'color' => '#fc5e28', 'label' => '2. Send Documents'],
                        ['icon' => 'fa-arrow-right',  'color' => '#ccc',    'label' => '', 'arrow' => true],
                        ['icon' => 'fa-desktop',      'color' => '#3b82f6', 'label' => '3. We Process Online'],
                        ['icon' => 'fa-arrow-right',  'color' => '#ccc',    'label' => '', 'arrow' => true],
                        ['icon' => 'fa-check-circle', 'color' => '#fc5e28', 'label' => '4. You Get Your Document'],
                    ];
                    @endphp
                    @foreach($miniSteps as $ms)
                    @if(!empty($ms['arrow']))
                        <div class="psk-mini-steps__arrow"><span class="fa fa-long-arrow-right"></span></div>
                    @else
                        <div class="psk-mini-steps__step">
                            <div class="psk-mini-steps__icon" style="background:{{ $ms['color'] }}15;border-color:{{ $ms['color'] }}30;">
                                <span class="fa {{ $ms['icon'] }}" style="color:{{ $ms['color'] }};"></span>
                            </div>
                            <span>{{ $ms['label'] }}</span>
                        </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- CATEGORY FILTER TABS                                   --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@php
$categoryConfig = [
    'identity' => [
        'label'      => 'Identity & ID Cards',
        'icon'       => 'fa-id-card',
        'color'      => '#fc5e28',
        'heading'    => 'Identity & ID Card Services',
        'subheading' => 'Aadhaar, PAN, Voter ID, Driving Licence — all processed online by certified operators.',
        'shade'      => false,
    ],
    'certificates' => [
        'label'      => 'Revenue & Certificates',
        'icon'       => 'fa-file-text',
        'color'      => '#059669',
        'heading'    => 'Revenue & Certificate Services',
        'subheading' => 'Income certificate, caste certificate, property records, and all revenue department documents for Punjab.',
        'shade'      => true,
    ],
    'registrations' => [
        'label'      => 'Registrations',
        'icon'       => 'fa-registered',
        'color'      => '#0ea5e9',
        'heading'    => 'Registration Services',
        'subheading' => 'Birth, death, ration card, and all essential registrations processed online for Punjab citizens.',
        'shade'      => false,
    ],
    'schemes' => [
        'label'      => 'Govt. Schemes',
        'icon'       => 'fa-heart',
        'color'      => '#8b5cf6',
        'heading'    => 'Government Scheme Enrolment',
        'subheading' => 'Pension, PM-KISAN, Ayushman Bharat, scholarship — get enrolled in the schemes you deserve.',
        'shade'      => true,
    ],
    'jobs' => [
        'label'      => 'Jobs & Forms',
        'icon'       => 'fa-briefcase',
        'color'      => '#3b82f6',
        'heading'    => 'Government Jobs, Forms & Admit Cards',
        'subheading' => 'Job alerts, exam form filling, admit card downloads, and result updates for Punjab government jobs.',
        'shade'      => false,
    ],
];
@endphp

<section class="ftco-section ftco-no-pb psk-filter-section" id="service-categories">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-center ftco-animate">
                <span class="subheading">Browse by Category</span>
                <h2 class="mb-3">All Government Services We Offer</h2>
                <p class="text-muted">Click any category below to jump directly to those services.</p>

                <div class="psk-filter-tabs" id="serviceTabs">
                    <button class="psk-filter-tab active" data-filter="all">
                        <span class="fa fa-th mr-1"></span> All Services
                    </button>
                    @foreach($categoryConfig as $key => $cat)
                        @if($services->has($key))
                        <button class="psk-filter-tab" data-filter="{{ $key }}">
                            <span class="fa {{ $cat['icon'] }} mr-1"></span> {{ $cat['label'] }}
                        </button>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- SERVICE SECTIONS — fully dynamic from DB                --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@foreach($categoryConfig as $key => $cat)
    @if($services->has($key))

    <section class="ftco-section ftco-no-pt psk-services-section {{ $cat['shade'] ? 'bg-half-light' : '' }}"
             id="cat-{{ $key }}"
             data-category="{{ $key }}">
        <div class="container">

            <div class="psk-cat-header ftco-animate">
                <div class="psk-cat-header__icon" style="background:{{ $cat['color'] }}18;">
                    <span class="fa {{ $cat['icon'] }}" style="color:{{ $cat['color'] }};"></span>
                </div>
                <div>
                    <h3 class="psk-cat-header__title">{{ $cat['heading'] }}</h3>
                    <p class="psk-cat-header__sub">{{ $cat['subheading'] }}</p>
                </div>
            </div>

            <div class="row psk-service-grid">
                @foreach($services->get($key) as $svc)
                <div class="col-md-4 ftco-animate psk-service-item" data-category="{{ $key }}">
                    <div class="psk-service-card">

                        @if($svc->is_popular)
                        <div class="psk-service-card__popular">⭐ Most Requested</div>
                        @endif

                        <div class="psk-service-card__header">
                            <div class="psk-service-card__icon" style="background:{{ $svc->color ?? $cat['color'] }}15;">
                                <span class="fa {{ $svc->icon ?? $cat['icon'] }}" style="color:{{ $svc->color ?? $cat['color'] }};"></span>
                            </div>
                            <div>
                                <span class="psk-service-card__tag">{{ $svc->tag }}</span>
                                <h4 class="psk-service-card__title">{{ $svc->title }}</h4>
                            </div>
                        </div>

                        <p class="psk-service-card__desc">{{ $svc->short_desc }}</p>

                        @if($svc->documents->isNotEmpty())
                        <div class="psk-service-card__docs">
                            <p class="psk-service-card__docs-label">
                                <span class="fa fa-paperclip mr-1"></span> Documents typically needed:
                            </p>
                            <ul>
                                @foreach($svc->documents->take(4) as $doc)
                                <li>
                                    <span class="fa fa-check text-primary mr-1"></span>
                                    {{ $doc->label }}
                                    @if(!empty($doc->note))
                                        <span class="doc-note">— {{ $doc->note }}</span>
                                    @endif
                                </li>
                                @endforeach
                                @if($svc->documents->count() > 4)
                                <li style="color:#94a3b8;font-style:italic;">
                                    <span class="fa fa-ellipsis-h mr-1"></span>
                                    +{{ $svc->documents->count() - 4 }} more documents
                                </li>
                                @endif
                            </ul>
                        </div>
                        @endif

                        <div class="psk-service-card__footer">
                            <span class="psk-service-card__time">
                                <span class="fa fa-clock-o mr-1"></span> {{ $svc->processing_time }}
                            </span>
                            <a href="{{ route('services.show', $svc->slug) }}"
                               class="btn btn-sm btn-primary">
                                <span class="fa fa-paper-plane mr-1"></span> Apply Now
                            </a>
                        </div>

                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>

    @endif
@endforeach

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- FAQ SECTION                                            --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="ftco-section" id="faq-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">FAQ</span>
                <h2 class="mb-4">Frequently Asked Questions</h2>
                <p class="text-muted">Everything you want to know before applying for a government service through Punjab Seva Kendra.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-9 ftco-animate">
                @php
                $faqs = [
                    [
                        'q' => 'Do I need to visit your office to apply for a service?',
                        'a' => 'No. We serve customers fully online. You can send your document photos via WhatsApp and we process everything remotely. You do not need to visit us in person — though you are welcome to if you prefer.',
                    ],
                    [
                        'q' => 'Which districts of Punjab do you serve?',
                        'a' => 'We serve all 22 districts of Punjab including Ludhiana, Amritsar, Jalandhar, Patiala, Bathinda, Mohali, Pathankot, Gurdaspur, Hoshiarpur, Moga, Ferozepur, and more. All services are available online across Punjab.',
                    ],
                    [
                        'q' => 'How long does it take to get my certificate or document?',
                        'a' => 'Processing time depends on the service and government department. Most services like income certificate, caste certificate, and PAN card are completed within 3–7 working days. Quick services like Nakal / Fard and E-Shram card are often done within 1–2 days. We share a timeline when you contact us.',
                    ],
                    [
                        'q' => 'Are you an authorised government service centre?',
                        'a' => 'Yes. Punjab Seva Kendra is an authorised Common Service Centre (CSC) operating under the Digital India initiative. Our operators are trained and certified to handle all state and central government portals.',
                    ],
                    [
                        'q' => 'What happens if my application gets rejected?',
                        'a' => 'We review every application thoroughly before submission to prevent rejections. In the rare case of a rejection due to a government or data issue, we refile the application at no additional charge.',
                    ],
                    [
                        'q' => 'How do I pay for your services?',
                        'a' => 'You can pay via UPI (PhonePe, Google Pay, Paytm), bank transfer, or cash (at our office). We share the service charge before starting any work — no hidden fees.',
                    ],
                    [
                        'q' => 'Can you explain the process in Punjabi or Hindi?',
                        'a' => 'Absolutely. Our team communicates in Punjabi, Hindi, and English. All document requirements, fees, and processes are explained clearly in the language you are most comfortable with.',
                    ],
                ];
                @endphp
                <div class="accordion psk-faq-accordion" id="faqAccordion">
                    @foreach($faqs as $i => $faq)
                    <div class="card psk-faq-card">
                        <div class="card-header psk-faq-card__header" id="faqHead{{ $i }}">
                            <button class="psk-faq-btn {{ $i > 0 ? 'collapsed' : '' }}"
                                    type="button"
                                    data-toggle="collapse"
                                    data-target="#faqBody{{ $i }}"
                                    aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                                    aria-controls="faqBody{{ $i }}">
                                <span class="fa fa-question-circle psk-faq-btn__icon"></span>
                                {{ $faq['q'] }}
                                <span class="fa fa-chevron-down psk-faq-btn__chevron"></span>
                            </button>
                        </div>
                        <div id="faqBody{{ $i }}"
                             class="collapse {{ $i === 0 ? 'show' : '' }}"
                             aria-labelledby="faqHead{{ $i }}"
                             data-parent="#faqAccordion">
                            <div class="card-body psk-faq-card__body">
                                {{ $faq['a'] }}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- WHATSAPP FLOATING BUTTON                               --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<a href="https://wa.me/91XXXXXXXXXX?text=Hello%2C%20I%20need%20help%20with%20a%20government%20service"
   target="_blank"
   rel="noopener"
   title="Chat with Punjab Seva Kendra on WhatsApp"
   style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:#fff;width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.7rem;box-shadow:0 4px 18px rgba(37,211,102,0.45);text-decoration:none;">
    <span class="fa fa-whatsapp"></span>
</a>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE-SPECIFIC CSS                                      --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@push('styles')
<style>
/* ── TRUST BAR ─────────────────────────────────────── */
.psk-trust-bar__inner {
    display: flex;
    flex-wrap: wrap;
}
.psk-trust-bar__item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 4px;
    padding: 18px 12px;
    color: #fff;
    text-align: center;
    border-right: 1px solid rgba(255,255,255,0.2);
}
.psk-trust-bar__item:last-child { border-right: none; }
.psk-trust-bar__item .fa {
    font-size: 1.3rem;
    margin-bottom: 4px;
    opacity: 0.9;
}
.psk-trust-bar__item strong {
    font-size: 1.15rem;
    font-weight: 800;
    line-height: 1;
}
.psk-trust-bar__item span {
    font-size: 0.75rem;
    opacity: 0.85;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* ── MINI STEPS ────────────────────────────────────── */
.psk-mini-steps {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    gap: 8px;
    padding: 24px 0 0;
}
.psk-mini-steps__step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}
.psk-mini-steps__icon {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    border: 2px solid transparent;
    display: flex;
    align-items: center;
    justify-content: center;
}
.psk-mini-steps__icon .fa { font-size: 1.3rem; }
.psk-mini-steps__step span {
    font-size: 0.75rem;
    font-weight: 600;
    color: #444;
    text-align: center;
    max-width: 90px;
    line-height: 1.3;
}
.psk-mini-steps__arrow {
    color: #ccc;
    font-size: 1.2rem;
    margin-bottom: 22px;
    padding: 0 4px;
}

/* ── FILTER TABS ───────────────────────────────────── */
.psk-filter-tabs {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 8px;
    margin-top: 20px;
}
.psk-filter-tab {
    background: #f4f4f4;
    border: 1px solid #e0e0e0;
    color: #555;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 8px 18px;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.2s ease;
    outline: none;
    letter-spacing: 0.3px;
}
.psk-filter-tab:hover {
    background: #fc5e28;
    color: #fff;
    border-color: #fc5e28;
}
.psk-filter-tab.active {
    background: #fc5e28;
    color: #fff;
    border-color: #fc5e28;
    box-shadow: 0 3px 12px rgba(252,94,40,0.30);
}

/* ── CATEGORY HEADER ───────────────────────────────── */
.psk-cat-header {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 24px 0 28px;
    border-bottom: 2px solid #f0f0f0;
    margin-bottom: 32px;
}
.psk-cat-header__icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.psk-cat-header__icon .fa { font-size: 1.5rem; }
.psk-cat-header__title {
    font-size: 1.35rem;
    font-weight: 800;
    color: #040e26;
    margin: 0 0 4px;
}
.psk-cat-header__sub {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

/* ── SERVICE GRID ──────────────────────────────────── */
.psk-service-grid {
    row-gap: 28px;
}

/* ── SERVICE CARD ──────────────────────────────────── */
.psk-service-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #e2e6ea;
    padding: 22px 20px 18px;
    height: 100%;
    display: flex;
    flex-direction: column;
    position: relative;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.psk-service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 14px 38px rgba(0,0,0,0.12);
    border-color: #fc5e28;
}
.psk-service-card__popular {
    position: absolute;
    top: 0;
    right: 0;
    background: #fc5e28;
    color: #fff;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 0 14px 0 10px;
    letter-spacing: 0.3px;
}
.psk-service-card__header {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 12px;
}
.psk-service-card__icon {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.psk-service-card__icon .fa { font-size: 1.2rem; }
.psk-service-card__tag {
    display: block;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #aaa;
    margin-bottom: 2px;
}
.psk-service-card__title {
    font-size: 0.92rem;
    font-weight: 700;
    color: #040e26;
    margin: 0;
    line-height: 1.35;
}
.psk-service-card__desc {
    font-size: 0.845rem;
    color: #555;
    line-height: 1.65;
    margin-bottom: 14px;
    flex: 1;
}
.psk-service-card__docs {
    background: #f4f6f9;
    border-radius: 8px;
    border: 1px solid #e8eaed;
    padding: 10px 14px;
    margin-bottom: 14px;
}
.psk-service-card__docs-label {
    font-size: 0.75rem;
    font-weight: 700;
    color: #777;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 6px;
}
.psk-service-card__docs ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.psk-service-card__docs ul li {
    font-size: 0.78rem;
    color: #555;
    line-height: 1.85;
}
.doc-note { color: #94a3b8; }
/* Cards on grey bg-half-light sections get stronger shadow */
.bg-half-light .psk-service-card {
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}
.bg-half-light .psk-service-card:hover {
    box-shadow: 0 16px 40px rgba(0,0,0,0.14);
}
.psk-service-card__footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    border-top: 1px solid #f0f0f0;
    padding-top: 12px;
    margin-top: auto;
}
.psk-service-card__time {
    font-size: 0.78rem;
    font-weight: 600;
    color: #888;
}

/* ── FAQ ───────────────────────────────────────────── */
.psk-faq-card {
    border: 1px solid #eee;
    border-radius: 10px !important;
    margin-bottom: 10px;
    overflow: hidden;
}
.psk-faq-card .card-header { background: #fff; padding: 0; border: none; }
.psk-faq-btn {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    padding: 18px 20px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #040e26;
    display: flex;
    align-items: center;
    gap: 10px;
    cursor: pointer;
}
.psk-faq-btn:focus { outline: none; }
.psk-faq-btn__icon { color: #fc5e28; flex-shrink: 0; }
.psk-faq-btn__chevron {
    margin-left: auto;
    font-size: 0.75rem;
    color: #aaa;
    transition: transform 0.25s;
    flex-shrink: 0;
}
.psk-faq-btn[aria-expanded="true"] .psk-faq-btn__chevron {
    transform: rotate(180deg);
}
.psk-faq-card__body {
    font-size: 0.9rem;
    color: #555;
    line-height: 1.75;
    padding: 0 20px 18px 44px;
}

/* ── HIDDEN FILTER STATE ───────────────────────────── */
.psk-service-item.psk-hidden {
    display: none !important;
}

/* ── RESPONSIVE ────────────────────────────────────── */
@media (max-width: 767px) {
    .psk-trust-bar__item { border-right: none; border-bottom: 1px solid rgba(255,255,255,0.15); }
    .psk-mini-steps__arrow { display: none; }
    .psk-cat-header { flex-direction: column; align-items: flex-start; gap: 10px; }
    .psk-faq-card__body { padding-left: 20px; }
    .psk-service-grid { row-gap: 20px; }
}
</style>
@endpush

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE-SPECIFIC JS — Category Filter                      --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@push('scripts')
<script>
(function () {
    var tabs     = document.querySelectorAll('.psk-filter-tab');
    var items    = document.querySelectorAll('.psk-service-item');
    var sections = document.querySelectorAll('.psk-services-section');

    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            var filter = this.getAttribute('data-filter');

            // Update active tab
            tabs.forEach(function (t) { t.classList.remove('active'); });
            this.classList.add('active');

            if (filter === 'all') {
                // Show all items
                items.forEach(function (item) { item.classList.remove('psk-hidden'); });
                // Show all section wrappers
                sections.forEach(function (s) { s.style.display = ''; });
            } else {
                // Hide items that don't match; show matching ones
                items.forEach(function (item) {
                    if (item.getAttribute('data-category') === filter) {
                        item.classList.remove('psk-hidden');
                    } else {
                        item.classList.add('psk-hidden');
                    }
                });
                // Hide sections with no visible items
                sections.forEach(function (section) {
                    var visible = section.querySelectorAll('.psk-service-item:not(.psk-hidden)');
                    section.style.display = visible.length > 0 ? '' : 'none';
                });
                // Smooth scroll to first visible section
                var firstVisible = document.querySelector('.psk-services-section[style=""]');
                if (firstVisible) {
                    setTimeout(function () {
                        firstVisible.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 80);
                }
            }
        });
    });
})();
</script>
@endpush

@endsection