@extends('layouts.app')

@section('title', 'Public Services in Punjab - Punjab Saathi | Aadhaar, PAN, Certificates & More')

@section('meta_description', 'Punjab Saathi helps you access ' . $totalServices . '+ government-related services online — Aadhaar update, PAN card, income certificate, caste certificate, voter ID, birth certificate, ration card, and more. Fast, affordable, doorstep assistance across all 22 districts of Punjab.')

@push('head')
<link rel="preload" as="image" href="{{ asset('images/government-services-support.webp') }}">

<link rel="canonical" href="{{ route('services.index') }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="Public Services in Punjab - Punjab Saathi | Aadhaar, PAN, Certificates & More">
<meta property="og:description" content="{{ 'Punjab Saathi helps you access ' . $totalServices . '+ government-related services online — Aadhaar update, PAN card, income certificate, caste certificate, voter ID, birth certificate, ration card, and more.' }}">
<meta property="og:url"         content="{{ route('services.index') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="Public Services in Punjab - Punjab Saathi | Aadhaar, PAN, Certificates & More">
<meta name="twitter:description" content="{{ 'Punjab Saathi helps you access ' . $totalServices . '+ government-related services online.' }}">

<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Services', 'url' => route('services.index')],
])) !!}</script>

<script type="application/ld+json">{!! \App\Support\Seo::json([
    '@context' => 'https://schema.org',
    '@type'    => 'ItemList',
    'itemListElement' => $services->flatten()->values()->map(fn ($svc, $i) => [
        '@type'    => 'ListItem',
        'position' => $i + 1,
        'url'      => route('services.show', $svc->slug),
        'name'     => $svc->title,
    ])->all(),
]) !!}</script>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- HERO / PAGE BANNER                                      --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image: url('{{ asset('images/government-services-support.webp') }}');"
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
                <h1 class="mb-3 bread">Public Services in Punjab</h1>
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
                ['icon' => 'fa-check-circle', 'number' => '7500+',            'label' => 'Services Completed'],
                ['icon' => 'fa-users',         'number' => '4900+',            'label' => 'Citizens Served'],
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
                <h2 class="mb-3">Punjab's Trusted Online Digitel Service Centre</h2>
                <p class="text-muted" style="font-size:1rem;line-height:1.8;">
                    Punjab Saathi is an authorised Common Service Centre (CSC) helping families, students,
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
    // Backend-managed category display data (name, icon, color, subheading,
    // image) — passed in as $categoryDisplay, keyed by slug. Alternating
    // section shading is derived from position rather than stored, so a
    // newly-added category automatically stripes correctly too.
    $categoryConfig = $categoryDisplay;
@endphp

<section class="ftco-section ftco-no-pb psk-filter-section" id="service-categories">
    <div class="container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10 text-center heading-section ftco-animate">
                <span class="subheading">Browse by Category</span>
                <h2 class="mb-3">All Services We Help You With</h2>
                <p class="text-muted">Click any category below to jump directly to those services.</p>

                <div class="psk-filter-tabs" id="serviceTabs">
                    <button class="psk-filter-tab active" data-filter="all">
                        <span class="fa fa-th mr-1"></span> All Services
                    </button>
                    @foreach($categoryConfig as $key => $cat)
                        @if($services->has($key))
                        <button class="psk-filter-tab" data-filter="{{ $key }}">
                            <span class="fa {{ $cat->icon }} mr-1"></span> {{ $cat->name }}
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
@php $catIndex = 0; @endphp
@foreach($categoryConfig as $key => $cat)
    @if($services->has($key))
    @php $catIndex++; @endphp

    <section class="ftco-section ftco-no-pt psk-services-section {{ $catIndex % 2 === 0 ? 'bg-half-light' : '' }}"
             id="cat-{{ $key }}"
             data-category="{{ $key }}">
        <div class="container">

            <div class="psk-cat-header ftco-animate">
                <div class="psk-cat-header__icon" style="background:{{ $cat->color }}18;">
                    <span class="fa {{ $cat->icon }}" style="color:{{ $cat->color }};"></span>
                </div>
                <div>
                    <h3 class="psk-cat-header__title">{{ $cat->name }}</h3>
                    <p class="psk-cat-header__sub">{{ $cat->subheading }}</p>
                </div>
            </div>

            <div class="row psk-service-grid">
                @foreach($services->get($key) as $svc)
                <div class="col-md-4 ftco-animate psk-service-item" data-category="{{ $key }}">
                    <div class="psk-service-card {{ $svc->is_popular ? 'psk-service-card--popular' : '' }}">

                        @if($svc->is_popular)
                        <div class="psk-service-card__popular">⭐ Most Requested</div>
                        @endif

                        <div class="psk-service-card__cover" style="background:linear-gradient(135deg, {{ $svc->color ?? $cat->color }}0D 0%, {{ $svc->color ?? $cat->color }}26 100%);">
                            <span class="psk-service-card__cover-icon">
                                <span class="fa {{ $svc->icon ?? $cat->icon }}" style="color:{{ $svc->color ?? $cat->color }};"></span>
                            </span>
                        </div>

                        <div class="psk-service-card__header">
                            <div class="psk-service-card__icon" style="background:{{ $svc->color ?? $cat->color }}15;">
                                <span class="fa {{ $svc->icon ?? $cat->icon }}" style="color:{{ $svc->color ?? $cat->color }};"></span>
                            </div>
                            <div>
                                <span class="psk-service-card__tag">{{ $svc->tag }}</span>
                                <h4 class="psk-service-card__title">{{ $svc->title }}</h4>
                            </div>
                        </div>

                        <p class="psk-service-card__desc">{{ $svc->short_desc }}</p>

                        <div class="psk-service-card__footer">
                            <span class="psk-service-card__time">
                                <span class="fa fa-clock-o mr-1"></span> {{ \Illuminate\Support\Str::before($svc->processing_time, ' ·') }}
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
                <p class="text-muted">Everything you want to know before applying for a government service through Punjab Saathi.</p>
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
                        'a' => 'Yes. Punjab Saathi is an authorised Common Service Centre (CSC) operating under the Digital India initiative. Our operators are trained and certified to handle all state and central government portals.',
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
<a href="https://wa.me/917710556330?text=Hello%2C%20I%20need%20help%20with%20a%20government%20service"
   target="_blank"
   rel="noopener"
   title="Chat with Punjab Saathi on WhatsApp"
   style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:#fff;width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.7rem;box-shadow:0 4px 18px rgba(37,211,102,0.45);text-decoration:none;">
    <span class="fa fa-whatsapp"></span>
</a>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- PAGE-SPECIFIC CSS                                      --}}
{{-- ═══════════════════════════════════════════════════════ --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-services-list.css') }}">
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
