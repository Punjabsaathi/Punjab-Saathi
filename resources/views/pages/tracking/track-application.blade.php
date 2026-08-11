@extends('layouts.app')

@section('title', 'Track Your Application - Punjab Seva Kendra')

@section('content')

{{-- ═══════════════════════════════════════════════ --}}
{{-- HERO SECTION — same as about/other pages       --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/track-application.jpg') }}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2">
                        <a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a>
                    </span>
                    <span>Track Application <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Track Your Application</h1>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════ --}}
{{-- SEARCH SECTION                                 --}}
{{-- ═══════════════════════════════════════════════ --}}
<section class="ftco-section" id="track-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-2">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">Application Tracking</span>
                <h2 class="mb-4">Enter Your Reference Number</h2>
                <p class="text-muted">Your reference number was sent to you via WhatsApp or email after submitting your application. It looks like <strong>PSK-2025-XXXXXX</strong>.</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-7 ftco-animate">
                <form method="POST" action="{{ route('application.search') }}">
                    @csrf
                    <div class="input-group" style="box-shadow: 0 8px 32px rgba(4,14,38,0.10); border-radius: 12px; overflow: hidden;">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="background:#040e26; border:none; padding: 0 20px;">
                                <span class="fa fa-search" style="color:#fc5e28; font-size:18px;"></span>
                            </span>
                        </div>
                        <input
                            type="text"
                            name="reference_no"
                            class="form-control @error('reference_no') is-invalid @enderror"
                            placeholder="e.g. PSK-2025-ABC123"
                            value="{{ old('reference_no', request('reference_no')) }}"
                            style="border:none; font-size:16px; padding: 18px 20px; letter-spacing:1px;"
                            autofocus
                        >
                        <div class="input-group-append">
                            <button type="submit"
                                class="btn btn-primary"
                                style="background:#fc5e28; border:none; padding: 0 32px; font-weight:700; font-size:15px; letter-spacing:1px; text-transform:uppercase;">
                                <span class="fa fa-arrow-right mr-2"></span> Track
                            </button>
                        </div>
                    </div>

                    @error('reference_no')
                        <div class="text-center mt-3">
                            <span style="color:#dc3545; font-size:14px;">
                                <span class="fa fa-exclamation-circle mr-1"></span> {{ $message }}
                            </span>
                        </div>
                    @enderror
                </form>

                {{-- Helper tips --}}
                <div class="d-flex justify-content-center flex-wrap mt-4" style="gap:16px;">
                    <span style="font-size:13px; color:#888;">
                        <span class="fa fa-whatsapp text-success mr-1"></span> Reference sent on WhatsApp
                    </span>
                    <span style="font-size:13px; color:#888;">
                        <span class="fa fa-envelope text-primary mr-1"></span> Also sent via Email
                    </span>
                    <span style="font-size:13px; color:#888;">
                        <span class="fa fa-lock text-warning mr-1"></span> Only you can see your status
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════ --}}
{{-- RESULT SECTION — shown only when found         --}}
{{-- ═══════════════════════════════════════════════ --}}
@isset($application)
<section class="ftco-section ftco-no-pt" id="result-section">
    <div class="container">

        {{-- ─── Application Summary Card ─── --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 ftco-animate">
                <div style="background:#fff; border-radius:16px; box-shadow:0 8px 40px rgba(4,14,38,0.10); overflow:hidden; border:1px solid #f0f0f0;">

                    {{-- Card header --}}
                    <div style="background:#040e26; padding:24px 32px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                        <div>
                            <p style="color:rgba(255,255,255,0.6); font-size:12px; letter-spacing:2px; text-transform:uppercase; margin:0 0 6px;">Reference Number</p>
                            <h3 style="color:#fff; font-weight:900; font-size:24px; margin:0; letter-spacing:2px; font-family:monospace;">
                                {{ $application->reference_no }}
                            </h3>
                        </div>
                        <div style="text-align:right;">
                            @php
                                $statusConfig = match($application->status) {
                                    'pending'    => ['bg' => '#fff3cd', 'color' => '#856404', 'icon' => 'fa-clock-o',       'label' => 'Pending'],
                                    'in_review'  => ['bg' => '#cce5ff', 'color' => '#004085', 'icon' => 'fa-eye',           'label' => 'In Review'],
                                    'processing' => ['bg' => '#d4edda', 'color' => '#155724', 'icon' => 'fa-cog',           'label' => 'Processing'],
                                    'completed'  => ['bg' => '#d4edda', 'color' => '#155724', 'icon' => 'fa-check-circle',  'label' => 'Completed'],
                                    'rejected'   => ['bg' => '#f8d7da', 'color' => '#721c24', 'icon' => 'fa-times-circle',  'label' => 'Rejected'],
                                    default      => ['bg' => '#e2e3e5', 'color' => '#383d41', 'icon' => 'fa-question-circle','label' => ucfirst($application->status)],
                                };
                            @endphp
                            <span style="
                                display:inline-flex; align-items:center; gap:8px;
                                background:{{ $statusConfig['bg'] }};
                                color:{{ $statusConfig['color'] }};
                                padding:10px 20px; border-radius:30px;
                                font-weight:700; font-size:15px;">
                                <span class="fa {{ $statusConfig['icon'] }}"></span>
                                {{ $statusConfig['label'] }}
                            </span>
                        </div>
                    </div>

                    {{-- Application details grid --}}
                    <div style="padding:28px 32px;">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-4">
                                <p style="font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:1.5px; margin:0 0 4px;">Applicant Name</p>
                                <p style="font-weight:600; color:#040e26; margin:0;">{{ $application->name }}</p>
                            </div>
                            <div class="col-md-3 col-6 mb-4">
                                <p style="font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:1.5px; margin:0 0 4px;">Service Applied</p>
                                <p style="font-weight:600; color:#040e26; margin:0;">{{ $application->service->title ?? '—' }}</p>
                            </div>
                            <div class="col-md-3 col-6 mb-4">
                                <p style="font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:1.5px; margin:0 0 4px;">Submitted On</p>
                                <p style="font-weight:600; color:#040e26; margin:0;">{{ $application->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="col-md-3 col-6 mb-4">
                                <p style="font-size:11px; color:#aaa; text-transform:uppercase; letter-spacing:1.5px; margin:0 0 4px;">Last Updated</p>
                                <p style="font-weight:600; color:#040e26; margin:0;">{{ $application->updated_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ─── Progress Bar ─── --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 ftco-animate">
                @php
                    $steps = ['pending', 'in_review', 'processing', 'completed'];
                    $stepLabels = ['Received', 'In Review', 'Processing', 'Completed'];
                    $stepIcons  = ['fa-inbox', 'fa-eye', 'fa-cog', 'fa-check-circle'];
                    $currentIndex = array_search($application->status, $steps);
                    if ($application->status === 'rejected') $currentIndex = -1;
                @endphp

                @if($application->status !== 'rejected')
                <div style="background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(4,14,38,0.08); padding:32px; border:1px solid #f0f0f0;">
                    <p style="font-size:12px; color:#aaa; text-transform:uppercase; letter-spacing:2px; margin:0 0 24px; text-align:center;">Application Progress</p>
                    <div style="display:flex; align-items:flex-start; justify-content:space-between; position:relative;">

                        {{-- Progress line --}}
                        <div style="position:absolute; top:22px; left:10%; right:10%; height:3px; background:#e9ecef; z-index:0; border-radius:2px;">
                            <div style="height:100%; background:#fc5e28; border-radius:2px; width:{{ $currentIndex >= 0 ? ($currentIndex / (count($steps)-1)) * 100 : 0 }}%; transition:width 1s ease;"></div>
                        </div>

                        @foreach($steps as $i => $step)
                        @php $done = $currentIndex >= $i; @endphp
                        <div style="flex:1; text-align:center; position:relative; z-index:1;">
                            <div style="
                                width:46px; height:46px; border-radius:50%; margin:0 auto 12px;
                                display:flex; align-items:center; justify-content:center;
                                background:{{ $done ? '#fc5e28' : '#e9ecef' }};
                                border:3px solid {{ $done ? '#fc5e28' : '#dee2e6' }};
                                transition:all 0.5s ease;
                                box-shadow: {{ $done ? '0 4px 14px rgba(252,94,40,0.35)' : 'none' }};
                            ">
                                <span class="fa {{ $stepIcons[$i] }}" style="color:{{ $done ? '#fff' : '#aaa' }}; font-size:16px;"></span>
                            </div>
                            <p style="font-size:12px; font-weight:{{ $done ? '700' : '500' }}; color:{{ $done ? '#040e26' : '#aaa' }}; margin:0; line-height:1.3;">
                                {{ $stepLabels[$i] }}
                            </p>
                        </div>
                        @endforeach

                    </div>
                </div>
                @else
                {{-- Rejected state --}}
                <div style="background:#fff5f5; border:1px solid #f5c6cb; border-radius:16px; padding:28px 32px; text-align:center;">
                    <span class="fa fa-times-circle" style="font-size:48px; color:#dc3545; margin-bottom:16px; display:block;"></span>
                    <h4 style="color:#721c24; font-weight:700; margin-bottom:8px;">Application Rejected</h4>
                    <p style="color:#856464; margin:0;">Please contact us on WhatsApp for more details about the rejection and how to reapply.</p>
                </div>
                @endif
            </div>
        </div>

        {{-- ─── Tracking History Timeline ─── --}}
        @if(!empty($application->admin_notes))
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 ftco-animate">
                <div style="background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(4,14,38,0.08); overflow:hidden; border:1px solid #f0f0f0;">

                    {{-- Header --}}
                    <div style="padding:20px 32px; border-bottom:1px solid #f0f0f0; display:flex; align-items:center; gap:12px;">
                        <div style="width:36px; height:36px; background:rgba(252,94,40,0.1); border-radius:8px; display:flex; align-items:center; justify-content:center;">
                            <span class="fa fa-history" style="color:#fc5e28;"></span>
                        </div>
                        <h4 style="margin:0; font-weight:700; color:#040e26; font-size:18px;">Update History</h4>
                    </div>

                    {{-- Timeline --}}
                    <div style="padding:28px 32px;">
                        @foreach(array_reverse($application->admin_notes) as $i => $entry)
                        @php
                            $entryConfig = match($entry['status'] ?? 'pending') {
                                'pending'    => ['color' => '#856404', 'bg' => '#fff3cd', 'border' => '#ffc107', 'icon' => 'fa-clock-o',      'label' => 'Pending'],
                                'in_review'  => ['color' => '#004085', 'bg' => '#cce5ff', 'border' => '#007bff', 'icon' => 'fa-eye',          'label' => 'In Review'],
                                'processing' => ['color' => '#155724', 'bg' => '#d4edda', 'border' => '#28a745', 'icon' => 'fa-cog',          'label' => 'Processing'],
                                'completed'  => ['color' => '#155724', 'bg' => '#d4edda', 'border' => '#28a745', 'icon' => 'fa-check-circle', 'label' => 'Completed'],
                                'rejected'   => ['color' => '#721c24', 'bg' => '#f8d7da', 'border' => '#dc3545', 'icon' => 'fa-times-circle', 'label' => 'Rejected'],
                                default      => ['color' => '#383d41', 'bg' => '#e2e3e5', 'border' => '#aaa',    'icon' => 'fa-info-circle',  'label' => 'Update'],
                            };
                            $isLatest = $i === 0;
                        @endphp

                        <div style="display:flex; gap:20px; {{ !$loop->last ? 'margin-bottom:0;' : '' }}">

                            {{-- Timeline dot + line --}}
                            <div style="display:flex; flex-direction:column; align-items:center; flex-shrink:0;">
                                <div style="
                                    width:44px; height:44px; border-radius:50%;
                                    background:{{ $entryConfig['bg'] }};
                                    border:2px solid {{ $entryConfig['border'] }};
                                    display:flex; align-items:center; justify-content:center;
                                    flex-shrink:0;
                                    {{ $isLatest ? 'box-shadow:0 0 0 4px ' . $entryConfig['bg'] . ';' : '' }}
                                ">
                                    <span class="fa {{ $entryConfig['icon'] }}" style="color:{{ $entryConfig['color'] }}; font-size:16px;"></span>
                                </div>
                                @if(!$loop->last)
                                <div style="width:2px; flex:1; min-height:24px; background:#e9ecef; margin:6px 0;"></div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div style="flex:1; padding-bottom:{{ !$loop->last ? '24px' : '0' }};">
                                <div style="display:flex; align-items:center; flex-wrap:wrap; gap:10px; margin-bottom:8px;">
                                    <span style="
                                        background:{{ $entryConfig['bg'] }};
                                        color:{{ $entryConfig['color'] }};
                                        font-size:12px; font-weight:700;
                                        padding:4px 12px; border-radius:20px;
                                        border:1px solid {{ $entryConfig['border'] }};
                                    ">
                                        {{ $entryConfig['label'] }}
                                    </span>
                                    @if($isLatest)
                                    <span style="background:#fc5e28; color:#fff; font-size:10px; font-weight:700; padding:3px 10px; border-radius:20px; letter-spacing:1px; text-transform:uppercase;">
                                        Latest Update
                                    </span>
                                    @endif
                                    <span style="font-size:12px; color:#aaa; margin-left:auto;">
                                        <span class="fa fa-calendar mr-1"></span>
                                        {{ $entry['at'] ?? '—' }}
                                    </span>
                                </div>

                                <div style="background:#f8f9fa; border-radius:10px; padding:16px 20px; border-left:3px solid {{ $entryConfig['border'] }};">
                                    <p style="margin:0; color:#333; font-size:15px; line-height:1.7;">
                                        {{ $entry['note'] ?? '—' }}
                                    </p>
                                </div>
                            </div>

                        </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
        @else
        {{-- No updates yet --}}
        <div class="row justify-content-center mb-5">
            <div class="col-md-10 ftco-animate">
                <div style="background:#fff; border-radius:16px; box-shadow:0 4px 24px rgba(4,14,38,0.08); padding:40px; text-align:center; border:1px solid #f0f0f0;">
                    <span class="fa fa-clock-o" style="font-size:48px; color:#ffc107; margin-bottom:16px; display:block;"></span>
                    <h4 style="color:#040e26; font-weight:700; margin-bottom:8px;">No Updates Yet</h4>
                    <p style="color:#888; margin:0;">Your application has been received and is pending review. We will update you on WhatsApp once processing begins.</p>
                </div>
            </div>
        </div>
        @endif

        {{-- ─── Help Box ─── --}}
        <div class="row justify-content-center">
            <div class="col-md-10 ftco-animate">
                <div style="background:linear-gradient(135deg,#040e26 0%,#0a1f4e 100%); border-radius:16px; padding:32px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:20px;">
                    <div>
                        <h4 style="color:#fff; font-weight:700; margin:0 0 6px;">Need Help With Your Application?</h4>
                        <p style="color:rgba(255,255,255,0.7); margin:0; font-size:15px;">Our team is available Mon–Sat, 9 AM to 7 PM</p>
                    </div>
                    <div style="display:flex; gap:12px; flex-wrap:wrap;">
                        <a href="https://wa.me/91XXXXXXXXXX?text=My+reference+number+is+{{ $application->reference_no }}"
                            target="_blank"
                            style="display:inline-flex; align-items:center; gap:8px; background:#25D366; color:#fff; font-weight:700; font-size:14px; padding:12px 22px; border-radius:8px; text-decoration:none;">
                            <span class="fa fa-whatsapp"></span> WhatsApp Us
                        </a>
                        <a href="{{ url('/contact') }}"
                            style="display:inline-flex; align-items:center; gap:8px; background:rgba(255,255,255,0.1); color:#fff; font-weight:700; font-size:14px; padding:12px 22px; border-radius:8px; text-decoration:none; border:1px solid rgba(255,255,255,0.2);">
                            <span class="fa fa-phone"></span> Call Us
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endisset

{{-- ─── How to find reference number (shown when no result yet) ─── --}}
@empty($application)
<section class="ftco-section ftco-no-pt bg-half-light">
    <div class="container">
        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">Need Help?</span>
                <h2 class="mb-4">Where to Find Your Reference Number</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            @php
            $tips = [
                ['icon' => 'fa-whatsapp', 'color' => '#25D366', 'bg' => 'rgba(37,211,102,0.1)', 'title' => 'WhatsApp Message', 'desc' => 'We send your reference number on WhatsApp immediately after you submit your application. Search for "PSK-" in your WhatsApp chats.'],
                ['icon' => 'fa-envelope', 'color' => '#007bff', 'bg' => 'rgba(0,123,255,0.1)',  'title' => 'Email Confirmation', 'desc' => 'Check your email inbox (and spam folder) for a confirmation email from Punjab Seva Kendra. The reference number is in the subject line.'],
                ['icon' => 'fa-headphones','color' => '#fc5e28', 'bg' => 'rgba(252,94,40,0.1)', 'title' => 'Contact Support',   'desc' => 'Can\'t find it? WhatsApp us your full name and phone number — we will look up your application and share the reference number.'],
            ];
            @endphp

            @foreach($tips as $tip)
            <div class="col-md-4 ftco-animate mb-4">
                <div class="media block-6 services d-flex">
                    <div class="icon justify-content-center align-items-center d-flex" style="background:{{ $tip['bg'] }}; color:{{ $tip['color'] }};">
                        <span class="fa {{ $tip['icon'] }}" style="color:{{ $tip['color'] }};"></span>
                    </div>
                    <div class="media-body pl-4">
                        <h3 class="heading mb-2">{{ $tip['title'] }}</h3>
                        <p>{{ $tip['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endempty

{{-- Floating WhatsApp Button --}}
<a href="https://wa.me/91XXXXXXXXXX?text=Hello%2C%20I%20need%20help%20tracking%20my%20application"
    target="_blank"
    rel="noopener"
    title="Chat with Punjab Seva Kendra on WhatsApp"
    style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:#fff;width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.7rem;box-shadow:0 4px 18px rgba(37,211,102,0.45);text-decoration:none;">
    <span class="fa fa-whatsapp"></span>
</a>

@endsection