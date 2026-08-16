@extends('layouts.app')

@section('title', 'Refund & Cancellation Policy - Punjab Saathi')
@section('meta_description', 'Refund and Cancellation Policy for Punjab Saathi\'s government application facilitation services.')

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
                        <p>Once a refund request is approved, we aim to process the refund to your original payment method within <strong>[REFUND PROCESSING DAYS] working days</strong>. Please note that the time for the amount to reflect in your bank account or payment app after we process it depends on your bank or payment provider, and is outside our control.</p>
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
<style>
.psk-legal-hero {
    position: relative; background: #040e26; padding: 130px 0 50px; overflow: hidden; color: #fff;
}
.psk-legal-hero__bg {
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle at 12% 20%, rgba(252,94,40,0.20) 0, transparent 40%),
        radial-gradient(circle at 88% 15%, rgba(252,94,40,0.12) 0, transparent 35%),
        radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1.5px);
    background-size: auto, auto, 26px 26px;
}
.psk-legal-hero .container { position: relative; z-index: 1; }
.psk-legal-hero__breadcrumbs { color: rgba(255,255,255,0.55); font-size: 0.82rem; margin-bottom: 20px; }
.psk-legal-hero__breadcrumbs a { color: rgba(255,255,255,0.75); text-decoration: none; }
.psk-legal-hero__title { font-size: 2.1rem; font-weight: 800; color: #fff; margin-bottom: 10px; }
.psk-legal-hero__sub { color: rgba(255,255,255,0.72); font-size: 1rem; margin-bottom: 20px; max-width: 620px; }
.psk-legal-hero__pill {
    display: inline-flex; align-items: center; background: rgba(255,255,255,0.1);
    border: 1px solid rgba(255,255,255,0.22); padding: 8px 18px; border-radius: 24px;
    font-size: 0.85rem; font-weight: 600; color: rgba(255,255,255,0.9);
}
.psk-legal-hero__pill .fa { color: #fc5e28; }

.psk-legal-toc {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 22px; position: sticky; top: 90px;
}
.psk-legal-toc h2 {
    font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.6px;
    color: #9ca3af; margin: 0 0 12px; font-weight: 700;
}
.psk-legal-toc ol { margin: 0; padding-left: 18px; }
.psk-legal-toc li { margin-bottom: 9px; font-size: 0.87rem; }
.psk-legal-toc a { color: #374151; text-decoration: none; }
.psk-legal-toc a:hover { color: #fc5e28; }

.psk-legal-card {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 34px 38px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.psk-legal-card section { margin-bottom: 32px; scroll-margin-top: 100px; }
.psk-legal-card section:last-child { margin-bottom: 0; }
.psk-legal-card h2 {
    font-size: 1.25rem; font-weight: 800; color: #040e26;
    margin: 0 0 14px; padding-bottom: 10px; border-bottom: 2px solid #fff1ea;
}
.psk-legal-card h3 { font-size: 1rem; font-weight: 700; color: #040e26; margin: 18px 0 8px; }
.psk-legal-card p { margin: 0 0 14px; color: #4b5563; line-height: 1.75; }
.psk-legal-card ul, .psk-legal-card ol { margin: 0 0 14px; padding-left: 22px; }
.psk-legal-card li { margin-bottom: 7px; color: #4b5563; }
.psk-legal-card strong { color: #040e26; }
.psk-legal-card a { color: #fc5e28; }

.psk-legal-callout {
    background: rgba(252,94,40,0.06); border-left: 4px solid #fc5e28; border-radius: 8px;
    padding: 16px 18px; margin: 0 0 18px; font-size: 0.95rem; color: #5a3a1e;
}
.psk-legal-callout strong { display: block; margin-bottom: 4px; color: #c2410c; }

.psk-legal-contact {
    background: #f8f9fb; border: 1px solid #e2e6ea; border-radius: 10px; padding: 20px 22px;
}
.psk-legal-contact p { color: #374151; }

@media (max-width: 991.98px) {
    .psk-legal-toc { position: static; margin-bottom: 20px; }
}
@media (max-width: 767.98px) {
    .psk-legal-hero { padding: 100px 0 36px; }
    .psk-legal-hero__title { font-size: 1.5rem; }
    .psk-legal-card { padding: 24px 20px; }
}
</style>
@endpush
