@extends('layouts.app')

@section('title', 'Privacy Policy - Punjab Saathi')
@section('meta_description', 'How Punjab Saathi collects, uses, and protects your personal information when helping you apply for government services.')

@section('content')

<section class="psk-legal-hero">
    <div class="psk-legal-hero__bg"></div>
    <div class="container">
        <p class="psk-legal-hero__breadcrumbs">
            <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
            <span>Privacy Policy</span>
        </p>
        <h1 class="psk-legal-hero__title">Privacy Policy</h1>
        <p class="psk-legal-hero__sub">How Punjab Saathi collects, uses, and protects your personal information.</p>
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
                        <li><a href="#introduction">Introduction</a></li>
                        <li><a href="#information-we-collect">Information We Collect</a></li>
                        <li><a href="#why-we-collect">Why We Collect This Information</a></li>
                        <li><a href="#how-we-use">How We Use Your Information</a></li>
                        <li><a href="#storage-security">Data Storage &amp; Security</a></li>
                        <li><a href="#sharing">Sharing of Information</a></li>
                        <li><a href="#retention">Data Retention</a></li>
                        <li><a href="#cookies">Cookies &amp; Analytics</a></li>
                        <li><a href="#your-rights">Your Rights</a></li>
                        <li><a href="#childrens-privacy">Children's Privacy</a></li>
                        <li><a href="#changes">Changes to This Policy</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                    </ol>
                    <h2 style="margin-top:20px;">Related Policies</h2>
                    <ol>
                        <li><a href="{{ route('terms-conditions') }}">Terms &amp; Conditions</a></li>
                        <li><a href="{{ route('refund-cancellation-policy') }}">Refund &amp; Cancellation</a></li>
                        <li><a href="{{ route('disclaimer') }}">Disclaimer</a></li>
                    </ol>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="psk-legal-card">

                    <section id="introduction">
                        <h2>1. Introduction</h2>
                        <p>Punjab Saathi ("we", "us", "our") operates the website punjabsaathi.in and an authorised Common Service Centre (CSC) at Shop No. 1, Lal Market, Near OHM Omjee Cinema, Grand Trunk Rd, 143001, Amritsar, Punjab, India.</p>
                        <p>We help citizens apply for government documents, certificates, ID cards, and welfare schemes by submitting applications on their behalf through official government portals. Because of the nature of this work, we sometimes need to collect sensitive personal and identity information from you.</p>
                        <div class="psk-legal-callout">
                            <strong>Important</strong>
                            Punjab Saathi is a private facilitation service and is not a government department, ministry, or office. We assist you in using official government portals — we do not operate them.
                        </div>
                        <p>This Privacy Policy explains what information we collect, why we collect it, how we use and protect it, and what rights you have. By using our services, you agree to the practices described in this policy.</p>
                    </section>

                    <section id="information-we-collect">
                        <h2>2. Information We Collect</h2>
                        <p>Depending on the government service you ask us to help with, we may collect:</p>
                        <ul>
                            <li><strong>Identity information</strong> — such as your Aadhaar number, PAN number, Voter ID number, and other government-issued ID numbers.</li>
                            <li><strong>Personal details</strong> — full name, date of birth, gender, caste/category, marital status, and family details, where required by the specific application form.</li>
                            <li><strong>Contact information</strong> — mobile number, email address, and residential address.</li>
                            <li><strong>Address proof documents</strong> — such as ration card, utility bills, or rent agreements, when required by the government form.</li>
                            <li><strong>Photographs</strong> — passport-size photos required for ID cards, certificates, or scheme enrolment.</li>
                            <li><strong>Biometric data</strong> — fingerprint or iris scans, only where the specific government service requires biometric authentication (for example, certain Aadhaar-linked services), and only using authorised government biometric devices at our centre.</li>
                            <li><strong>Payment information</strong> — transaction details for the service fee you pay us. We do not store your full card, UPI, or bank details — payments are processed by our third-party payment gateway partner.</li>
                            <li><strong>Application-specific documents</strong> — such as birth/death certificates, income proof, educational certificates, or land records, as needed for the specific service.</li>
                        </ul>
                    </section>

                    <section id="why-we-collect">
                        <h2>3. Why We Collect This Information</h2>
                        <p>We only collect information that is necessary to:</p>
                        <ul>
                            <li>Fill and submit your application accurately on the relevant official government portal, on your behalf and with your consent.</li>
                            <li>Verify your identity, where the government service requires identity verification.</li>
                            <li>Communicate with you about the status of your application.</li>
                            <li>Process your service fee payment.</li>
                            <li>Deliver your completed document to you, by doorstep delivery or pickup from our kendra.</li>
                            <li>Comply with record-keeping requirements that apply to authorised CSC operators.</li>
                        </ul>
                    </section>

                    <section id="how-we-use">
                        <h2>4. How We Use Your Information</h2>
                        <p>We use your information strictly for the purpose you gave it to us — to complete the specific government application or service you requested. We do not use your Aadhaar, biometric data, or other identity information for any purpose beyond what is needed to process your request, and we do not use this data for marketing.</p>
                        <p>We may use your mobile number or email to send you updates about your application status, service reminders, or important notices related to services you have used.</p>
                    </section>

                    <section id="storage-security">
                        <h2>5. Data Storage &amp; Security</h2>
                        <p>We take reasonable technical and organisational steps to protect your personal information, including:</p>
                        <ul>
                            <li>Storing digital records on secured systems with restricted, need-to-know access limited to trained staff handling your application.</li>
                            <li>Storing physical copies of documents (where collected) securely at our centre, and disposing of them safely once they are no longer required.</li>
                            <li>Using secure, encrypted connections for online payments through our payment gateway partner.</li>
                            <li>Not storing your full payment card or bank account details on our own systems.</li>
                        </ul>
                        <p>While we take security seriously, no method of storage or transmission over the internet is 100% secure. We cannot guarantee absolute security, but we work to protect your information to the best of our ability.</p>
                    </section>

                    <section id="sharing">
                        <h2>6. Sharing of Information</h2>
                        <p>We do <strong>not</strong> sell, rent, or trade your personal information. We only share your information in the following situations:</p>
                        <ul>
                            <li><strong>With the relevant government department or portal</strong> — this is the core purpose of our service. Your information is submitted to the official government system for the specific application you requested.</li>
                            <li><strong>With our payment gateway partner</strong> — to process your service fee payment securely.</li>
                            <li><strong>With delivery personnel</strong> — where you have opted for doorstep delivery, limited contact and address details are shared to deliver your completed document.</li>
                            <li><strong>Where required by law</strong> — if we are legally required to disclose information to law enforcement or regulatory authorities.</li>
                        </ul>
                    </section>

                    <section id="retention">
                        <h2>7. Data Retention</h2>
                        <p>We retain your personal information only for as long as necessary to complete your application, deliver your document, resolve any related queries, and meet any record-keeping requirements applicable to authorised CSC operators under Indian law. After this period, information is either securely deleted or archived with restricted access.</p>
                    </section>

                    <section id="cookies">
                        <h2>8. Cookies &amp; Analytics</h2>
                        <p>Our website may use cookies and similar technologies to remember your preferences, keep you signed in where applicable, and understand how visitors use our website (for example, which pages are most visited) so we can improve it. This may include standard analytics tools.</p>
                        <p>You can control or disable cookies through your browser settings. Disabling cookies may affect some website features, but will not affect your ability to visit our centre or contact us for services.</p>
                    </section>

                    <section id="your-rights">
                        <h2>9. Your Rights</h2>
                        <p>You have the right to:</p>
                        <ul>
                            <li>Ask us what personal information we hold about you related to your applications.</li>
                            <li>Ask us to correct inaccurate information before it is submitted to a government portal.</li>
                            <li>Ask us questions about how your information is being used.</li>
                            <li>Withdraw consent for us to process a pending application, subject to our <a href="{{ route('refund-cancellation-policy') }}">Refund &amp; Cancellation Policy</a>.</li>
                        </ul>
                        <p>To exercise any of these rights, please contact us using the details in Section 12 below.</p>
                    </section>

                    <section id="childrens-privacy">
                        <h2>10. Children's Privacy</h2>
                        <p>Some government services (such as birth certificates or school-related certificates) may require us to process information belonging to a minor, submitted by their parent or legal guardian. In such cases, we collect this information directly from, and with the consent of, the parent or guardian, not from the child.</p>
                    </section>

                    <section id="changes">
                        <h2>11. Changes to This Policy</h2>
                        <p>We may update this Privacy Policy from time to time to reflect changes in our services or in applicable law. The updated version will be posted on this page with a revised effective date. We encourage you to review this page periodically.</p>
                    </section>

                    <section id="contact">
                        <h2>12. Contact Us</h2>
                        <p>If you have any questions, concerns, or requests regarding this Privacy Policy or how your information is handled, please contact:</p>
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

/* ── TOC sidebar ── */
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

/* ── Content card ── */
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
