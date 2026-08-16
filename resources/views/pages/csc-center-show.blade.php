@extends('layouts.app')

@php
    $displayName = $center->kiosk_name ?: $center->vle_name;
    $locationLine = trim(collect([$center->sub_district, $center->district, 'Punjab'])->filter()->implode(', '));
    $hasCoords = $center->latitude && $center->longitude;
    $directionsUrl = $hasCoords
        ? 'https://www.google.com/maps/dir/?api=1&destination=' . $center->latitude . ',' . $center->longitude
        : null;
@endphp

@section('title', $displayName . ' - CSC Center in ' . $center->district . ' | Punjab Saathi')
@section('meta_description', 'CSC Center ' . $displayName . ' in ' . $locationLine . '. Get directions, contact details, and find nearby CSC centers on Punjab Saathi.')

@section('content')

<section class="psk-csc-profile-hero">
    <div class="overlay"></div>
    <div class="container">
        <p class="breadcrumbs">
            <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
            <span class="mr-2"><a href="{{ route('csc.directory') }}">Find a CSC Center <i class="fa fa-chevron-right"></i></a></span>
            <span>{{ $displayName }}</span>
        </p>

        @if($center->is_verified)
        <span class="psk-verified-pill">
            <span class="fa fa-check-circle mr-1"></span> Verified CSC Center
        </span>
        @endif

        <h1 class="psk-csc-profile-hero__name">{{ $displayName }}</h1>

        @if($displayName !== $center->vle_name)
        <p class="psk-csc-profile-hero__operator"><span class="fa fa-user mr-1"></span> Operated by {{ $center->vle_name }}</p>
        @endif

        <p class="psk-csc-profile-hero__location">
            <span class="fa fa-map-marker mr-1"></span> {{ $locationLine }}
            @if($center->pincode) — {{ $center->pincode }} @endif
        </p>

        <div class="psk-csc-profile-hero__actions">
            @if($directionsUrl)
            <a href="{{ $directionsUrl }}" target="_blank" rel="noopener" class="btn btn-primary">
                <span class="fa fa-location-arrow mr-1"></span> Get Directions
            </a>
            @endif
            @if($center->mobile)
            <a href="tel:{{ preg_replace('/\D/', '', $center->mobile) }}" class="btn btn-white btn-outline-primary">
                <span class="fa fa-phone mr-1"></span> Call Center
            </a>
            @endif
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="psk-csc-info-card">
                    <h2 class="psk-csc-info-card__title">Center Information</h2>
                    <div class="psk-csc-info-grid">
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-map-marker mr-1"></span>Address</span>
                            <span class="psk-csc-info-item__value">{{ $center->address ?: $locationLine }}</span>
                        </div>
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-building mr-1"></span>District</span>
                            <span class="psk-csc-info-item__value">{{ $center->district ?: '—' }}</span>
                        </div>
                        @if($center->sub_district)
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-map mr-1"></span>Sub-District</span>
                            <span class="psk-csc-info-item__value">{{ $center->sub_district }}</span>
                        </div>
                        @endif
                        @if($center->pincode)
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-envelope-o mr-1"></span>Pincode</span>
                            <span class="psk-csc-info-item__value">{{ $center->pincode }}</span>
                        </div>
                        @endif
                        @if($center->csc_id)
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-id-badge mr-1"></span>CSC ID</span>
                            <span class="psk-csc-info-item__value">{{ $center->csc_id }}</span>
                        </div>
                        @endif
                        <div class="psk-csc-info-item">
                            <span class="psk-csc-info-item__label"><span class="fa fa-clock-o mr-1"></span>Opening Hours</span>
                            <span class="psk-csc-info-item__value psk-csc-info-item__value--muted">Not on file — please contact the center directly</span>
                        </div>
                    </div>
                </div>

                <div class="psk-csc-info-card">
                    <h2 class="psk-csc-info-card__title">Services Available</h2>
                    <p class="text-muted mb-3" style="font-size:0.9rem;">
                        CSC centers across Punjab help with a wide range of government services. Specific services offered
                        can vary by center — for the full list of services Punjab Saathi can help you apply for, browse:
                    </p>
                    <a href="{{ url('/services') }}" class="btn btn-outline-primary">
                        <span class="fa fa-list mr-1"></span> Browse All Services
                    </a>
                </div>

            </div>

            <div class="col-lg-4">
                <div class="psk-csc-side-card">
                    <h3 class="psk-csc-side-card__title">Looking for a different center?</h3>
                    <p class="text-muted" style="font-size:0.88rem;">Search by pincode or find the CSC center nearest to you.</p>
                    <a href="{{ route('csc.directory') }}" class="btn btn-primary w-100">
                        <span class="fa fa-search mr-1"></span> Search CSC Centers
                    </a>
                </div>

                <div class="psk-csc-side-card psk-csc-side-card--cta">
                    <h3 class="psk-csc-side-card__title">Own this center?</h3>
                    <p style="font-size:0.88rem;color:rgba(255,255,255,0.8);">
                        If this is your CSC center and the details need updating, register with your CSC ID to update it.
                    </p>
                    <a href="{{ route('agent.registration') }}" class="btn btn-white btn-outline-primary w-100">
                        <span class="fa fa-edit mr-1"></span> Update / Register
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
.psk-csc-profile-hero {
    position: relative;
    background: #040e26;
    background-image: radial-gradient(circle at 15% 20%, rgba(252,94,40,0.18) 0, transparent 45%),
                       radial-gradient(circle at 85% 80%, rgba(252,94,40,0.12) 0, transparent 45%);
    padding: 100px 0 48px;
    color: #fff;
}
.psk-csc-profile-hero .breadcrumbs { color: rgba(255,255,255,0.6); font-size: 0.85rem; margin-bottom: 18px; }
.psk-csc-profile-hero .breadcrumbs a { color: rgba(255,255,255,0.75); text-decoration: none; }
.psk-verified-pill {
    display: inline-flex; align-items: center;
    background: rgba(37,211,102,0.15); color: #25D366;
    border: 1px solid rgba(37,211,102,0.35);
    font-size: 0.78rem; font-weight: 700; letter-spacing: 0.3px;
    padding: 5px 14px; border-radius: 20px; margin-bottom: 16px;
}
.psk-csc-profile-hero__name { font-size: 2.1rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
.psk-csc-profile-hero__operator { color: rgba(255,255,255,0.75); font-size: 0.95rem; margin-bottom: 4px; }
.psk-csc-profile-hero__location { color: rgba(255,255,255,0.75); font-size: 0.95rem; margin-bottom: 22px; }
.psk-csc-profile-hero__actions { display: flex; gap: 12px; flex-wrap: wrap; }

.psk-csc-info-card {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 28px 30px; margin-bottom: 24px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.psk-csc-info-card__title { font-size: 1.15rem; font-weight: 700; color: #1e2a3a; margin-bottom: 18px; }
.psk-csc-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px 24px; }
.psk-csc-info-item { display: flex; flex-direction: column; gap: 4px; }
.psk-csc-info-item__label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.4px; color: #9ca3af; }
.psk-csc-info-item__value { font-size: 0.95rem; color: #1e2a3a; font-weight: 500; }
.psk-csc-info-item__value--muted { color: #9ca3af; font-weight: 400; font-style: italic; font-size: 0.85rem; }

.psk-csc-side-card {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 26px; margin-bottom: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.psk-csc-side-card__title { font-size: 1rem; font-weight: 700; color: #1e2a3a; margin-bottom: 8px; }
.psk-csc-side-card--cta { background: #040e26; border-color: #040e26; }
.psk-csc-side-card--cta .psk-csc-side-card__title { color: #fff; }

@media (max-width: 767.98px) {
    .psk-csc-profile-hero { padding: 80px 0 36px; }
    .psk-csc-profile-hero__name { font-size: 1.5rem; }
    .psk-csc-info-grid { grid-template-columns: 1fr; }
    .psk-csc-info-card, .psk-csc-side-card { padding: 22px; }
}
</style>
@endpush
