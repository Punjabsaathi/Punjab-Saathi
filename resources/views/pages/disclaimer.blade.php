@extends('layouts.app')

@section('title', 'Disclaimer - Punjab Saathi')
@section('meta_description', 'Important disclaimer — Punjab Saathi is a private CSC facilitation service and is not a government body or department.')

@push('head')
<link rel="canonical" href="{{ route('disclaimer') }}">
<meta name="robots" content="index, follow">
<meta property="og:type"        content="website">
<meta property="og:title"       content="Disclaimer - Punjab Saathi">
<meta property="og:description" content="Important disclaimer — Punjab Saathi is a private CSC facilitation service and is not a government body or department.">
<meta property="og:url"         content="{{ route('disclaimer') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Disclaimer', 'url' => route('disclaimer')],
])) !!}</script>
@endpush

@section('content')

<section class="psk-legal-hero">
    <div class="psk-legal-hero__bg"></div>
    <div class="container">
        <p class="psk-legal-hero__breadcrumbs">
            <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
            <span>Disclaimer</span>
        </p>
        <h1 class="psk-legal-hero__title">Disclaimer</h1>
        <p class="psk-legal-hero__sub">Please read this important information about who we are and what we do.</p>
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
                        <li><a href="#general">General Disclaimer</a></li>
                        <li><a href="#not-government">Not a Government Entity</a></li>
                        <li><a href="#no-guarantee">No Guarantee of Outcome</a></li>
                        <li><a href="#site-info">Accuracy of Website Information</a></li>
                        <li><a href="#timelines">Processing Time Estimates</a></li>
                        <li><a href="#third-party">Third-Party Portals &amp; Links</a></li>
                        <li><a href="#liability">Limitation of Liability</a></li>
                        <li><a href="#changes">Changes to This Disclaimer</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ol>
                    <h2 style="margin-top:20px;">Related Policies</h2>
                    <ol>
                        <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('terms-conditions') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('refund-cancellation-policy') }}">Refund &amp; Cancellation</a></li>
                    </ol>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="psk-legal-card">

                    <section id="general">
                        <h2>1. General Disclaimer</h2>
                        <p>The information provided by Punjab Saathi on punjabsaathi.in and at our physical centre is offered as a facilitation and assistance service. While we take care to help you correctly, all services are provided on an "as available" basis, and the final outcome of any government application depends on the relevant government department, not on Punjab Saathi.</p>
                    </section>

                    <section id="not-government">
                        <h2>2. Not a Government Entity</h2>
                        <div class="psk-legal-callout">
                            <strong>Punjab Saathi is a private business and is NOT a government department, ministry, office, or agency.</strong>
                            We have no official affiliation with the Government of India, the Government of Punjab, or any of their departments, beyond our authorisation to operate as a Common Service Centre (CSC) that helps citizens access government portals.
                        </div>
                        <p>We are an intermediary that helps you use official government websites correctly. We do not represent, and should not be understood to represent, any government body. Any government emblem, scheme name, or department name mentioned on our website or by our staff is used only to describe the service we help you apply for — it does not imply endorsement by that government body.</p>
                    </section>

                    <section id="no-guarantee">
                        <h2>3. No Guarantee of Outcome</h2>
                        <p>The approval or rejection of any application, certificate, ID card, or scheme benefit is <strong>solely at the discretion of the concerned government department</strong>. Punjab Saathi does not guarantee that any application will be approved, processed within a particular time, or result in a particular outcome. We are not responsible for a government department's decision to reject, delay, or request further information for any application.</p>
                    </section>

                    <section id="site-info">
                        <h2>4. Accuracy of Website Information</h2>
                        <p>Information published on our website — including scheme eligibility criteria, blog articles, guides, required-document lists, and fee information — is provided for <strong>general guidance only</strong>. Government rules, eligibility criteria, required documents, and fees can change at any time based on government policy updates, and we may not always be able to update our website immediately when this happens.</p>
                        <p>Please treat website content as a helpful starting point, not as a final or official source. For the latest official information, please also confirm with us directly or refer to the relevant government department.</p>
                    </section>

                    <section id="timelines">
                        <h2>5. Processing Time Estimates</h2>
                        <p>Any processing times, turnaround estimates, or delivery timelines mentioned on our website, by our staff, or in any communication are <strong>estimates only</strong> and are not guaranteed. Actual timelines depend on the concerned government department or portal and can change without notice.</p>
                    </section>

                    <section id="third-party">
                        <h2>6. Third-Party Portals &amp; Links</h2>
                        <p>Our services involve submitting your application through official third-party government portals that we do not own or operate. We are not responsible for the availability, functioning, security, or content of these government websites. Our website may also contain links to external websites (such as government portals) for your convenience — we are not responsible for the content or practices of those external sites.</p>
                    </section>

                    <section id="liability">
                        <h2>7. Limitation of Liability</h2>
                        <p>To the extent permitted by law, Punjab Saathi is not liable for any loss, delay, inconvenience, or damage arising from:</p>
                        <ul>
                            <li>Decisions, delays, or errors by any government department or portal.</li>
                            <li>Changes in government policy, eligibility criteria, or fees after information was provided to you.</li>
                            <li>Downtime, technical issues, or unavailability of any government website.</li>
                            <li>Inaccurate or incomplete information or documents provided by you.</li>
                        </ul>
                        <p>This Disclaimer should be read together with our <a href="{{ route('terms-conditions') }}">Terms &amp; Conditions</a>.</p>
                    </section>

                    <section id="changes">
                        <h2>8. Changes to This Disclaimer</h2>
                        <p>We may update this Disclaimer from time to time to reflect changes in our services or applicable government rules. The updated version will be posted on this page with a revised effective date.</p>
                    </section>

                    <section id="contact">
                        <h2>9. Contact Us</h2>
                        <p>If you have any questions about this Disclaimer, please contact:</p>
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
