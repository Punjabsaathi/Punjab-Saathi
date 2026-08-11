    @extends('layouts.app')
    @section('title', 'Punjab Saathi - Online Government Services in Punjab')

    @section('content')

    <section class="hero-wrap js-fullheight" style="background-image: url('{{ asset('images/punjab-seva-kendra.jpg') }}');" data-stellar-background-ratio="0.5">
        <div class="overlay"></div>
        <div class="container">
            <div class="row no-gutters slider-text js-fullheight align-items-center" data-scrollax-parent="true">
                <div class="col-lg-7 ftco-animate">
                    <div class="mt-5">
                        <h1 class="mb-4">
                            ਸਰਕਾਰੀ ਸੇਵਾਵਾਂ Online<br>
                            <span style="color:#f4c542;">ਹੁਣ ਔਨਲਾਈਨ - ਘਰ ਬੈਠੇ </span>
                        </h1>
                        <p class="mb-2" style="font-size:1.1rem;">
                            Get  your government certificates online now, documents, and applications processed <strong>fast, correctly, and affordably</strong> — without standing in long queues.
                        </p>
                        <p class="mb-4" style="font-size:0.95rem;opacity:0.85;">
                            Aadhaar &middot; PAN &middot; Income Certificate &middot; Caste Certificate &middot; Voter ID &middot; and 50+ more services across Punjab.
                        </p>
                        <p>
                            <a href="{{ url('/services') }}" class="btn btn-primary px-4 py-3">
                                <span class="fa fa-list mr-2"></span>All Services
                            </a>
                            <a href="https://wa.me/917710556330" class="btn btn-white px-4 py-3" target="_blank" rel="noopener">
                                <span class="fa fa-whatsapp mr-2"></span>WhatsApp Us
                            </a>
                        </p>
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
                            <h2 class="mb-4">Punjab Saathi - Your Digital Government Service Partner</h2>
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
                        <p class="mb-0">
                            <a href="#" class="btn btn-primary px-4 py-3" data-toggle="modal" data-target="#exampleModalCenter">
                                <span class="fa fa-file-text mr-2"></span>Apply for a Service
                            </a>
                            &nbsp;
                            <a href="https://wa.me/917710556330" class="btn btn-white px-4 py-3" target="_blank" rel="noopener">
                                <span class="fa fa-whatsapp mr-2"></span>Chat on WhatsApp
                            </a>
                        </p>
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
                $categoryConfig = [
                    'identity' => [
                        'label'   => 'Identity and ID Cards',
                        'desc'    => 'Aadhaar enrolment and correction, PAN card apply and update, Voter ID, Driving Licence — all in one place.',
                        'img'     => 'services-1.jpg',
                        'btnText' => 'See All ID Services',
                    ],
                    'certificates' => [
                        'label'   => 'Revenue and Certificates',
                        'desc'    => 'Caste certificate, residence certificate, property nakal, fard, and other revenue department documents.',
                        'img'     => 'services-2.jpg',
                        'btnText' => 'See All Certificates',
                    ],
                    'registrations' => [
                        'label'   => 'Registrations and Schemes',
                        'desc'    => 'Birth and death registration, ration card, pension schemes and government welfare scheme enrolment.',
                        'img'     => 'services-3.jpg',
                        'btnText' => 'Explore All Services',
                    ],
                    'schemes' => [
                        'label'   => 'Government Schemes',
                        'desc'    => 'Pension, PM-KISAN, Ayushman Bharat, scholarships — get enrolled in the schemes you qualify for.',
                        'img'     => 'services-1.jpg',
                        'btnText' => 'Explore Schemes',
                    ],
                    'jobs' => [
                        'label'   => 'Jobs and Form Filling',
                        'desc'    => 'Punjab Government job alerts, exam form filling, admit card downloads, and recruitment updates.',
                        'img'     => 'services-2.jpg',
                        'btnText' => 'View Job Services',
                    ],
                ];

                $activeCategories = collect($categoryConfig)
                    ->filter(function($cat, $key) use ($serviceCategories) {
                        return $serviceCategories->has($key);
                    });
            @endphp

            <div class="row">
                @foreach($activeCategories as $key => $cat)
                <div class="col-md-4">
                    <div class="services-wrap ftco-animate">
                        <div class="img" style="background-image: url({{ asset('images/' . $cat['img']) }});"></div>
                        <div class="text">
                            <h2>{{ $cat['label'] }}</h2>
                            <p>{{ $cat['desc'] }}</p>
                            <p style="font-size:0.8rem;color:#aaa;">
                                <span class="fa fa-list mr-1"></span>
                                {{ $serviceCategories->get($key)->count() }} services available
                            </p>
                            <a href="{{ url('/services#cat-' . $key) }}" class="btn-custom">
                                {{ $cat['btnText'] }}
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
                        <p>From Amritsar to Pathankot, from Ludhiana to Ferozepur — citizens across Punjab rely on us for fast, correct, and affordable government services. We are an authorised CSC with a team trained on all state and central government portals.</p>
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
                            <a href="{{ url('/govt-jobs') }}" class="btn btn-primary mt-2">View Latest Job Alerts</a>
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
                            <a href="{{ url('/admit-card') }}" class="btn btn-primary mt-2">Get Admit Card Help</a>
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
                            <a href="{{ url('/form-filling') }}" class="btn btn-primary mt-2">Get Form Filling Help</a>
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
            @php
            $popularServices = [
                ['icon' => 'fa-id-card',     'title' => 'Aadhaar Card Update',          'tag' => 'Identity',            'desc' => 'Name, DOB, address, and mobile number correction on Aadhaar.'],
                ['icon' => 'fa-file-text-o', 'title' => 'Income Certificate',           'tag' => 'Revenue Dept.',       'desc' => 'Required for scholarships, loans, and government schemes.'],
                ['icon' => 'fa-users',       'title' => 'Caste Certificate',            'tag' => 'Revenue Dept.',       'desc' => 'SC/ST/OBC/EWS certificates for jobs, admissions, and schemes.'],
                ['icon' => 'fa-credit-card', 'title' => 'PAN Card Apply or Correction', 'tag' => 'Income Tax',          'desc' => 'New PAN or corrections for individuals and businesses.'],
                ['icon' => 'fa-home',        'title' => 'Property Nakal or Fard',       'tag' => 'Patwari / Jamabandi', 'desc' => 'Land record copies for property matters and legal purposes.'],
                ['icon' => 'fa-heartbeat',   'title' => 'Birth and Death Certificate',  'tag' => 'Municipality',        'desc' => 'Online application for birth and death registration across Punjab.'],
            ];
            @endphp
            <div class="row">
                @foreach($popularServices as $svc)
                <div class="col-md-4">
                    <div class="project">
                        <a href="{{ url('/services') }}" class="img image-popup d-flex align-items-center" style="background-image: url({{ asset('images/project-1.jpg') }});">
                        </a>
                        <div class="text">
                            <span class="subheading">{{ $svc['tag'] }}</span>
                            <h3>{{ $svc['title'] }}</h3>
                            <p>{{ $svc['desc'] }}</p>
                            <a href="{{ url('/services') }}" class="btn btn-sm btn-primary mt-1">Apply Now</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>


    <section class="ftco-section ftco-no-pt ftco-no-pb testimony-section img">
        <div class="overlay"></div>
        <div class="container">
            <div class="row ftco-animate justify-content-center">
                <div class="col-md-6 p-4 pl-md-0 py-md-5 pr-md-5 aside-stretch d-flex align-items-center">
                    <div class="heading-section heading-section-white">
                        <span class="subheading" style="color:#fff;">Read Testimonials</span>
                        <h2 class="mb-4" style="font-size:40px;">Thousands of Punjab families trust us with their most important paperwork</h2>
                        <p style="color:rgba(255,255,255,0.8);">Real reviews from real citizens across Ludhiana, Amritsar, Jalandhar, Patiala, and beyond.</p>
                    </div>
                </div>
                <div class="col-md-6 pl-md-5 py-4 py-md-5 aside-stretch-right">
                    <div class="carousel-testimony owl-carousel ftco-owl">
                        @php
                        $testimonials = [
                            ['img' => 'person_1.jpg', 'name' => 'Gurpreet Singh', 'loc' => 'Ludhiana',  'text' => 'Mera income certificate sirf 2 din vich ready ho gaya. Staff bahut helpful hai te process completely online si. Bohot vadhia seva!'],
                            ['img' => 'person_2.jpg', 'name' => 'Harjinder Kaur', 'loc' => 'Amritsar',  'text' => "My daughter's scholarship form was submitted perfectly. Punjab Saathi saved us from going to the block office three times. Highly recommended."],
                            ['img' => 'person_3.jpg', 'name' => 'Rajesh Kumar',   'loc' => 'Jalandhar', 'text' => 'Aadhaar address correction in just one visit. The team knew exactly what documents were needed. Very professional and affordable service.'],
                        ];
                        @endphp
                        @foreach($testimonials as $t)
                        <div class="item">
                            <div class="testimony-wrap py-4 pb-5 d-flex justify-content-between align-items-end">
                                <div class="user-img" style="background-image: url({{ asset('images/' . $t['img']) }})">
                                    <span class="quote d-flex align-items-center justify-content-center">
                                        <i class="fa fa-quote-left"></i>
                                    </span>
                                </div>
                                <div class="text">
                                    <p class="mb-4">{{ $t['text'] }}</p>
                                    <p class="name">{{ $t['name'] }}</p>
                                    <span class="position">Citizen, {{ $t['loc'] }}</span>
                                    <div class="mt-1" style="color:#f4c542;">
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
                                        <span class="fa fa-star"></span>
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
                ['img' => 'image_1.jpg', 'title' => 'How to Apply for Caste Certificate Online in Punjab (2024 Guide)',      'tag' => 'Certificates'],
                ['img' => 'image_2.jpg', 'title' => 'Aadhaar Address Change: Documents Required and Step-by-Step Process',   'tag' => 'Aadhaar Services'],
                ['img' => 'image_3.jpg', 'title' => 'PM-KISAN New Registration: Who is Eligible and How to Apply in Punjab', 'tag' => 'Government Schemes'],
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