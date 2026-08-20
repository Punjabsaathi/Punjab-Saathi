@extends('layouts.app')

@section('title', 'Refund & Cancellation Policy - Punjab Saathi')
@section('meta_description', 'Refund and Cancellation Policy for Punjab Saathi\'s government application facilitation services.')

@push('head')
<link rel="canonical" href="{{ route('refund-cancellation-policy') }}">
<meta name="robots" content="index, follow">
<meta property="og:type"        content="website">
<meta property="og:title"       content="Refund & Cancellation Policy - Punjab Saathi">
<meta property="og:description" content="Refund and Cancellation Policy for Punjab Saathi's government application facilitation services.">
<meta property="og:url"         content="{{ route('refund-cancellation-policy') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Refund & Cancellation Policy', 'url' => route('refund-cancellation-policy')],
])) !!}</script>
@endpush

@section('content')

<section class="psk-legal-hero">
    <div class="psk-legal-hero__bg"></div>
    <div class="container">
        <p class="psk-legal-hero__breadcrumbs">
            <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
            <span>Refund &amp; Cancellation Policy</span>
        </p>
        <h1 class="psk-legal-hero__title">Refund &amp; Cancellation Policy</h1>
        <p class="psk-legal-hero__sub">When you can cancel a request, and how refunds work at Punjab Saathi.</p>
        <span class="psk-legal-hero__pill"><span class="fa fa-calendar-check-o mr-2"></span>Effective Date: 1 August 2026</span>
    </div>
</section>

<div class="psk-disclaimer-bar" role="note">
    <div class="container">
        <span class="fa fa-info-circle mr-2"></span>
        <strong>Note:</strong> Punjab Saathi is a <strong>private assistance platform</strong> and is
        <strong>not an official government website</strong>. We help citizens apply through authorised
        government portals as a Common Service Centre (CSC).
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            <div class="col-lg-3 mb-4">
                <div class="psk-legal-toc">
                    <h2>On This Page</h2>
                    <ol>
                        <li><a href="#overview">Overview</a></li>
                        <li><a href="#refund-possible">When a Refund Is Possible</a></li>
                        <li><a href="#refund-not-possible">When a Refund Is Not Possible</a></li>
                        <li><a href="#government-fees">Government Fees</a></li>
                        <li><a href="#how-to-cancel">How to Request a Cancellation</a></li>
                        <li><a href="#refund-timeline">Refund Processing Timeline</a></li>
                        <li><a href="#partial-refunds">Partial Refunds</a></li>
                        <li><a href="#failed-payments">Failed or Duplicate Payments</a></li>
                        <li><a href="#contact">Contact for Refund Requests</a></li>
                    </ol>
                    <h2 style="margin-top:20px;">Related Policies</h2>
                    <ol>
                        <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms-conditions') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                    </ol>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="psk-legal-card">

                    <section id="overview">
                        <h2>1. Overview</h2>
                        <p>This policy explains when you can cancel a service request with Punjab Saathi, when a refund of our service fee is possible, and how the refund process works. This policy applies to the service fee we charge for our assistance — it does not apply to any official government fee, which is explained separately in Section 4.</p>
                    </section>

                    <section id="refund-possible">
                        <h2>2. When a Refund Is Possible</h2>
                        <p>A refund of our service fee is generally possible when:</p>
                        <ul>
                            <li>You cancel your request <strong>before</strong> we have submitted your application on the relevant government portal.</li>
                            <li>We are unable to process your request due to an error on our part.</li>
                            <li>A duplicate payment was made for the same service by mistake.</li>
                        </ul>
                        <p>In these cases, we will refund the service fee you paid, in line with the timeline in Section 6.</p>
                    </section>

                    <section id="refund-not-possible">
                        <h2>3. When a Refund Is Not Possible</h2>
                        <div class="psk-legal-callout">
                            <strong>Once your application has been submitted to a government portal, the service fee is non-refundable.</strong>
                            This is because the fee covers the work we have already completed on your behalf — reviewing your documents, correctly filling your application, and submitting it through the official government system.
                        </div>
                        <p>Refunds are also not possible where:</p>
                        <ul>
                            <li>Your application is rejected, delayed, or requires resubmission due to a government department's decision, process, or technical issue — this is outside our control and is addressed in our <a href="{{ route('disclaimer') }}">Disclaimer</a>.</li>
                            <li>You provided incorrect, incomplete, or fraudulent information or documents, which affected the application.</li>
                            <li>You simply change your mind after the application has already been submitted.</li>
                        </ul>
                    </section>

                    <section id="government-fees">
                        <h2>4. Government Fees</h2>
                        <p>Where your service involves an official government fee (such as an application fee, scheme fee, or stamp duty) paid through us to a government portal, this amount is <strong>separate from our service fee</strong> and, once submitted to the government portal, is <strong>non-refundable through Punjab Saathi</strong>. Any refund of a government fee itself, if applicable, can only be processed by the relevant government department under its own rules — Punjab Saathi has no control over this.</p>
                    </section>

                    <section id="how-to-cancel">
                        <h2>5. How to Request a Cancellation</h2>
                        <p>To request a cancellation or refund, please contact us as soon as possible, ideally before we begin processing your application, using any of the following:</p>
                        <div class="psk-legal-contact">
                            <p class="mb-1"><strong>Phone:</strong> <a href="tel:+917710556330">+91 7710556330</a></p>
                            <p class="mb-1"><strong>Email:</strong> <a href="mailto:info@punjabsaathi.in">info@punjabsaathi.in</a></p>
                            <p class="mb-0"><strong>In person:</strong> Shop No. 1, Lal Market, Near OHM Omjee Cinema, Grand Trunk Rd, 143001, Amritsar, Punjab</p>
                        </div>
                        <p style="margin-top:14px;">Please have your payment receipt, application reference (if any), and registered mobile number ready when contacting us — this helps us process your request faster.</p>
                    </section>

                    <section id="refund-timeline">
                        <h2>6. Refund Processing Timeline</h2>
                        <p>Once a refund request is approved, we aim to process the refund to your original payment method within <strong>5 working days</strong>. Please note that the time for the amount to reflect in your bank account or payment app after we process it depends on your bank or payment provider, and is outside our control.</p>
                    </section>

                    <section id="partial-refunds">
                        <h2>7. Partial Refunds</h2>
                        <p>In some cases, a partial refund may be offered instead of a full refund — for example, where some work has already been done on your application (such as document review or data entry) before you requested cancellation, but the application had not yet been submitted to the government portal. In such cases, we will explain the deduction to you before processing the refund.</p>
                    </section>

                    <section id="failed-payments">
                        <h2>8. Failed or Duplicate Payments</h2>
                        <p>If a payment fails but an amount is deducted from your account, or if you are charged more than once for the same service due to a technical error, please contact us with your payment reference and transaction details. We will verify the issue with our payment gateway partner and refund any excess or duplicate amount.</p>
                    </section>

                    <section id="contact">
                        <h2>9. Contact for Refund Requests</h2>
                        <div class="psk-legal-contact">
                            <p class="mb-1"><strong>Punjab Saathi</strong></p>
                            <p class="mb-1">Shop No. 1, Lal Market, Near OHM Omjee Cinema, Grand Trunk Rd, 143001, Amritsar, Punjab, India</p>
                            <p class="mb-1">Phone: <a href="tel:+917710556330">+91 7710556330</a></p>
                            <p class="mb-0">Email: <a href="mailto:info@punjabsaathi.in">info@punjabsaathi.in</a></p>
                        </div>
                    </section>

                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-legal.css') }}">
@endpush
