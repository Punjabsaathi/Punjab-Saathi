    @extends('layouts.app')
    @section('title', 'Punjab Saathi - Online Public Services in Punjab')
    @section('meta_description', 'Punjab Saathi offers fast, affordable online government services in Punjab — Aadhaar update, PAN card, income certificate, caste certificate, birth/death certificate, ration card and more, with doorstep delivery across all 22 districts.')

    @section('content')

    <section class="hero-wrap js-fullheight" style="background-image: url('{{ asset('images/punjab-seva-kendra.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-lg-7 ftco-animate">
                    <div class="mt-3 mt-md-5">
                        <h1 class="mb-4">
                            ਸਰਕਾਰੀ ਸੇਵਾਵਾਂ<br>
                            <span style="color:#f4c542;">ਹੁਣ ਔਨਲਾਈਨ - ਘਰ ਬੈਠੇ </span>
                        </h1>
                        <p class="mb-2" style="font-size:1.1rem;">
                            Getyour government certificates online now, documents, and applications processed <strong>fast, correctly, and affordably</strong> — without standing in long queues.
                        </p>
                        <p class="mb-4" style="font-size:0.95rem;opacity:0.85;">
                            Aadhaar &middot; PAN &middot; Income Certificate &middot; Caste Certificate &middot; Voter ID &middot; and 50+ more services across Punjab.
                        </p>
                        <div class="d-flex flex-wrap align-items-center psk-hero-btns">
                            <a href="{{ url('/services') }}" class="btn btn-primary px-4 py-3">
                                <span class="fa fa-list mr-2"></span>All Services
                            </a>
                            <a href="https://wa.me/917710556330" class="btn btn-white px-4 py-3" target="_blank" rel="noopener">
                                <span class="fa fa-whatsapp mr-2"></span>WhatsApp Us
                            </a>
                        </div>
                        <p class="mt-3" style="font-size:0.85rem;opacity:0.8;">
                            <span class="fa fa-phone mr-1"></span> Call: <strong>+91-7710556330</strong> &nbsp;|&nbsp;
                            <span class="fa fa-clock-o mr-1"></span> Mon-Sat: 9 AM - 7 PM
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section ftco-no-pt ftco-no-pb ftco-services-2">
        <div class="container">
            <div class="row no-gutters d-flex">
                <div class="col-lg-4 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services d-flex">
                        <div class="icon justify-content-center align-items-center d-flex"><span class="flaticon-engineer-1"></span></div>
                        <div class="media-body pl-4">
                            <h3 class="heading mb-3">100% Accurate Processing</h3>
                            <p>Every application is reviewed by trained operators before submission — no rejections due to errors or missing fields.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services services-2 d-flex">
                        <div class="icon justify-content-center align-items-center d-flex"><span class="flaticon-worker-1"></span></div>
                        <div class="media-body pl-4">
                            <h3 class="heading mb-3">Trusted by 15000+ Citizens</h3>
                            <p>Serving families, students, farmers, and businesses across all districts of Punjab.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 d-flex align-self-stretch ftco-animate">
                    <div class="media block-6 services d-flex">
                        <div class="icon justify-content-center align-items-center d-flex"><span class="flaticon-engineer"></span></div>
                        <div class="media-body pl-4">
                            <h3 class="heading mb-3">Fast Doorstep Delivery</h3>
                            <p>Completed documents and certificates delivered to your address, or collect from our kendra. No wasted trips.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section" id="about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 d-flex align-items-stretch">
                    <div class="about-wrap img w-100" style="background-image: url({{ asset('images/aboutus.jpg') }});">
                        <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-crane"></span></div>
                    </div>
                </div>
                <div class="col-md-6 py-5 pl-md-5">
                    <div class="row justify-content-center mb-4 pt-md-4">
                        <div class="col-md-12 heading-section ftco-animate">
                            <span class="subheading">About Us</span>
                            <h2 class="mb-4">Punjab Saathi - Your Digital Service Partner</h2>
                            <div class="d-flex about">
                                <div class="icon"><span class="flaticon-hammer"></span></div>
                                <h3>Helping Punjab citizens with government paperwork</h3>
                            </div>
                            <!-- <p>Punjab Saathi is a trusted, Common Service Centre (CSC) helping citizens across Punjab navigate complex government portals and document processes — quickly, affordably, and without stress.</p>
                            <p>Whether you need an income certificate for a scholarship, a caste certificate for a job, Aadhaar correction, or a PAN card for your business — our trained operators handle everything end-to-end so you don't have to.</p> -->
                            <ul class="list-unstyled mt-3" style="line-height:2;">
                                <!-- <li><span class="fa fa-check-circle text-primary mr-2"></span> Government-authorised CSC operator</li> -->
                                <!-- <li><span class="fa fa-check-circle text-primary mr-2"></span> 50+ services available in one place</li> -->
                                <!-- <li><span class="fa fa-check-circle text-primary mr-2"></span> Available in Punjabi, Hindi and English</li> -->
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> WhatsApp and phone support</li>
                            </ul>
                            <!-- <div class="d-flex video-image align-items-center mt-md-4">
                                <a href="#" class="video img d-flex align-items-center justify-content-center" style="background-image: url({{ asset('images/about-2.jpg') }});">
                                    <span class="fa fa-play-circle"></span>
                                </a>
                                <h4 class="ml-4">See how we process your documents — Watch video</h4>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-intro">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="img" style="background-image: url({{ asset('images/hivan.jpg') }});">
                        <div class="overlay"></div>
                        <h2>Need a Government Certificate or Document in Punjab?</h2>
                        <p>Apply online in minutes. Our operators handle the rest — correctly, the first time.</p>
                        <div class="d-flex flex-wrap align-items-center justify-content-center psk-hero-btns">
                            <a href="#" class="btn btn-primary px-4 py-3" data-toggle="modal" data-target="#exampleModalCenter">
                                <span class="fa fa-file-text mr-2"></span>Apply for a Service
                            </a>
                            <a href="https://wa.me/917710556330" class="btn btn-white px-4 py-3" target="_blank" rel="noopener">
                                <span class="fa fa-whatsapp mr-2"></span>Chat on WhatsApp
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section bg-half-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-2">
                <div class="col-md-8 text-center heading-section ftco-animate">
                    <span class="subheading">Our Services</span>
                    <h2 class="mb-4">Services We Offer in Punjab</h2>
                    <p class="text-muted">From certificates to registrations — all processed by certified operators, with doorstep delivery available.</p>
                </div>
            </div>

            @php
                $activeCategories = $categoryDisplay->filter(function($cat, $key) use ($serviceCategories) {
                    return $serviceCategories->has($key);
                });
            @endphp

            <div class="row">
                @foreach($activeCategories as $key => $cat)
                @php
                    $catImage = $serviceCategories->get($key)->first(fn($s) => $s->image_url)?->image_url
                        ?? $cat->image_url
                        ?? asset('images/registrations_and_schemes.webp');
                @endphp
                <div class="col-md-4">
                    <div class="services-wrap ftco-animate">
                        <div class="img" style="background-image: url('{{ $catImage }}');"></div>
                        <div class="text">
                            <h2>{{ $cat->name }}</h2>
                            <p style="font-size:0.8rem;color:#aaa;">
                                <span class="fa fa-list mr-1"></span>
                                {{ $serviceCategories->get($key)->count() }} services available
                            </p>
                            <a href="{{ url('/services#cat-' . $key) }}" class="btn-custom">
                                {{ $cat->button_text ?: 'View Services' }}
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="row mt-5">
        <div class="col-12 text-center">
            <a href="{{ url('/services') }}" class="btn btn-primary px-5 py-3" style="border-radius:50px; font-size:1rem; letter-spacing:1px; box-shadow: 0 6px 20px rgba(252,94,40,0.35);">
                <span class="fa fa-list mr-2"></span>
                View All {{ $serviceCategories->flatten()->count() }}+ Services
            </a>
        </div>
    </div>

        </div>
    </section>


    <section class="ftco-section ftco-no-pt ftco-no-pb ftco-counter">
        <div class="img image-overlay" style="background-image: url({{ asset('images/aboutus3.jpg') }});"></div>
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-6 py-5 bg-secondary aside-stretch">
                    <div class="heading-section heading-section-white p-4 pl-md-0 py-md-5 pr-md-5">
                        <span class="subheading">Punjab Saathi</span>
                        <h2 class="mb-4">Punjab's Most Trusted Online Service Provider</h2>
                        <p>From Amritsar to Pathankot, from Ludhiana to Ferozepur — people across Punjab rely on us for fast, correct, and affordable government services. We are an authorised CSC with a team trained on all state and central government portals.</p>
                        <a href="{{ url('/about') }}" class="btn btn-outline-light mt-2">Know More About Us</a>
                    </div>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div class="row">
                        <div class="col-md-12 d-flex counter-wrap ftco-animate">
                            <div class="block-18 bg-primary d-flex align-items-center justify-content-between">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-engineer"></span></div>
                                <div class="text">
                                    <strong class="number" data-number="75000">0</strong>
                                    <span>Services Completed</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 d-flex counter-wrap ftco-animate">
                            <div class="block-18 d-flex align-items-center justify-content-between">
                                <div class="icon d-flex align-items-center justify-content-center"><span class="flaticon-worker-1"></span></div>
                                <div class="text">
                                    <strong class="number" data-number="50000">0</strong>
                                    <span>Happy Citizens Served</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Add this NEW section right after "Popular Services in Punjab" and before Testimonials --}}

    <section class="ftco-section bg-light" id="gov-jobs-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-10 text-center heading-section ftco-animate">
                    <span class="subheading">Government Jobs & Form Help</span>
                    <h2 class="mb-4">Punjab Government Job Alerts, Admit Cards & Online Form Help</h2>
                    <p class="text-muted">
                        Stay updated with the latest Punjab Government jobs, admit cards, exam forms, and recruitment notifications.
                        We also help students and job seekers fill forms correctly and download admit cards without errors.
                    </p>
                </div>
            </div>

            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-4 ftco-animate">
                    <div class="services-wrap">
                        <div class="text p-4">
                            <div class="icon mb-3"><span class="fa fa-bell text-primary"></span></div>
                            <h3>Punjab Govt Job Alerts</h3>
                            <p>
                                Get updates for the latest Punjab Government jobs including Punjab Police, PSSSB, PSPCL,
                                Punjab Patwari, Clerk Jobs, Driver Jobs, Forest Guard, and more.
                            </p>
                            <ul class="list-unstyled mt-3" style="line-height:2;">
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Latest Punjab Govt Vacancy Updates</li>
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Eligibility & Age Limit Guidance</li>
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Job Last Date Reminders</li>
                            </ul>
                            <a href="{{ route('jobs.index') }}" class="btn btn-primary mt-2">View Latest Job Alerts</a>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4 ftco-animate">
                    <div class="services-wrap">
                        <div class="text p-4">
                            <div class="icon mb-3"><span class="fa fa-id-card-o text-primary"></span></div>
                            <h3>Admit Card & Exam Updates</h3>
                            <p>
                                Download Punjab Government exam admit cards, roll numbers,
                                result updates and important exam notifications on time.
                            </p>
                            <ul class="list-unstyled mt-3" style="line-height:2;">
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Admit Card Download Help</li>
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Roll Number & Exam Slip Support</li>
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Result & Answer Key Updates</li>
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Exam Date Notifications</li>
                            </ul>
                            <a href="{{ route('jobs.admit-cards') }}" class="btn btn-primary mt-2">Get Admit Card Help</a>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4 ftco-animate">
                    <div class="services-wrap">
                        <div class="text p-4">
                            <div class="icon mb-3"><span class="fa fa-file-text-o text-primary"></span></div>
                            <h3>Online Form Filling Help</h3>
                            <p>
                                We help students and job applicants fill online forms for government jobs,
                                entrance exams and university registrations with 100% accuracy.
                            </p>
                            <ul class="list-unstyled mt-3" style="line-height:2;">
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Government Job Form Filling</li>
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Exam Form & Document Upload Help</li>
                                <li><span class="fa fa-check-circle text-primary mr-2"></span> Passport Apply Support</li>
                            </ul>
                            <a href="{{ route('jobs.form-help') }}" class="btn btn-primary mt-2">Get Form Filling Help</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-7 text-center heading-section ftco-animate">
                    <span class="subheading">Most Requested Services</span>
                    <h2 class="mb-4">Popular Services in Punjab</h2>
                    <p class="text-muted">These are the services our customers apply for most frequently. Click to apply instantly.</p>
                </div>
            </div>
            <div class="row">
                @foreach($popularServices as $svc)
                @php
                    $svcCardImg = $svc->image_url ?: asset('images/forms.jpg');
                @endphp
                <div class="col-md-4">
                    <div class="project">
                        <a href="{{ route('services.show', $svc->slug) }}" class="img image-popup d-flex align-items-center" style="background-image: url('{{ $svcCardImg }}');">
                        </a>
                        <div class="text">
                            <span class="subheading">{{ $svc->tag }}</span>
                            <h3>{{ $svc->title }}</h3>
                            <p>{{ $svc->short_desc }}</p>
                            <a href="{{ route('services.show', $svc->slug) }}" class="btn btn-sm btn-primary mt-1">Apply Now</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="ftco-section ftco-no-pt ftco-no-pb testimony-section img psk-testimony">
        <div class="overlay"></div>
        <div class="container">
            <div class="row ftco-animate justify-content-center align-items-center">
                <div class="col-md-6 p-4 pl-md-0 py-md-5 pr-md-5 aside-stretch d-flex align-items-center">
                    <div class="heading-section heading-section-white">
                        <span class="subheading" style="color:#fff;">Read Testimonials</span>
                        <h2 class="mb-4" style="font-size:40px;">Thousands of Punjab families trust us with their most important paperwork</h2>
                        <p style="color:rgba(255,255,255,0.8);">Real reviews from real citizens across Ludhiana, Amritsar, Jalandhar, Patiala, and beyond.</p>

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
    <style>
    .psk-review-stat {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-top: 22px;
        padding-top: 22px;
        border-top: 1px solid rgba(255,255,255,0.18);
    }
    .psk-review-stat__score {
        font-size: 2.6rem;
        font-weight: 800;
        color: #fff;
        line-height: 1;
    }
    .psk-review-stat__stars { color: #f4c542; font-size: 0.95rem; margin-bottom: 4px; }
    .psk-review-stat__label { color: rgba(255,255,255,0.75); font-size: 0.85rem; }

    .psk-testimony-card {
        position: relative;
        background: rgba(255,255,255,0.06);
        border: 1px solid rgba(255,255,255,0.12);
        backdrop-filter: blur(6px);
        border-radius: 18px;
        padding: 34px 30px 28px;
        overflow: hidden;
    }
    .psk-testimony-card__bigquote {
        position: absolute;
        top: 14px;
        right: 22px;
        font-size: 3.5rem;
        color: rgba(252,94,40,0.18);
        line-height: 1;
    }
    .psk-testimony-card__stars { color: #f4c542; font-size: 0.95rem; margin-bottom: 14px; }
    .psk-testimony-card__text {
        color: rgba(255,255,255,0.92);
        font-size: 1.05rem;
        line-height: 1.75;
        min-height: 110px;
        margin-bottom: 22px;
        position: relative;
        z-index: 1;
    }
    .psk-testimony-card__footer {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-top: 18px;
        border-top: 1px solid rgba(255,255,255,0.14);
    }
    .psk-testimony-card__avatar {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 4px 14px rgba(0,0,0,0.25);
    }
    .psk-testimony-card__name { color: #fff; font-weight: 600; margin: 0; font-size: 0.95rem; }
    .psk-testimony-card__city { color: rgba(255,255,255,0.6); font-weight: 400; font-size: 0.85rem; }
    .psk-testimony-card__source { color: #fc5e28; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.4px; }

    .psk-testimony .owl-dots { text-align: left; margin-top: 22px; }
    .psk-testimony .owl-dots .owl-dot span {
        width: 8px;
        height: 8px;
        margin: 0 4px 0 0;
        background: rgba(255,255,255,0.3);
        transition: all 0.25s ease;
    }
    .psk-testimony .owl-dots .owl-dot.active span {
        width: 24px;
        border-radius: 5px;
        background: #fc5e28;
    }

    @media (max-width: 767px) {
        .psk-testimony-card { padding: 26px 22px 22px; }
        .psk-testimony-card__text { min-height: 0; }
    }
    </style>
    @endpush

    <section class="ftco-section bg-light">
        <div class="container">
            <div class="row justify-content-center mb-5 pb-3">
                <div class="col-md-10 heading-section text-center ftco-animate">
                    <span class="subheading">Our Blog</span>
                    <h2 class="mb-4">Helpful Guides and Latest Updates</h2>
                    <p class="text-muted">Stay informed about new schemes, document requirements, and step-by-step guides in Punjabi and Hindi.</p>
                </div>
            </div>
            @php
            $blogPosts = [
                ['img' => 'caste.webp', 'title' => 'How to Apply for Caste Certificate Online in Punjab (2024 Guide)',      'tag' => 'Certificates'],
                ['img' => 'adharcard.png', 'title' => 'Aadhaar Address Change: Documents Required and Step-by-Step Process',   'tag' => 'Aadhaar Services'],
                ['img' => 'ayush-bhoyar-d2gQdAbTtRc-unsplash.jpg', 'title' => 'PM-KISAN New Registration: Who is Eligible and How to Apply in Punjab', 'tag' => 'Government Schemes'],
            ];
            @endphp
            <div class="row d-flex">
                @foreach($blogPosts as $blog)
                <div class="col-lg-4 ftco-animate">
                    <div class="blog-entry">
                        <a href="{{ url('/blog') }}" class="block-20" style="background-image: url('{{ asset('images/' . $blog['img']) }}');"></a>
                        <div class="text d-block">
                            <div class="meta">
                                <p>
                                    <a href="#"><span class="fa fa-calendar mr-2"></span>{{ date('M d, Y') }}</a>
                                    <a href="#"><span class="fa fa-tag mr-2"></span>{{ $blog['tag'] }}</a>
                                </p>
                            </div>
                            <h3 class="heading"><a href="{{ url('/blog') }}">{{ $blog['title'] }}</a></h3>
                            <p><a href="{{ url('/blog') }}" class="btn btn-secondary py-2 px-3">Read Guide</a></p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endsection