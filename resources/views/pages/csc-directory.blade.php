@extends('layouts.app')

@section('title', 'Find a CSC Center Near You - Punjab Saathi')
@section('meta_description', 'Search ' . number_format($stats['total_centers']) . '+ Common Service Centers (CSC) across all districts of Punjab by pincode, or find the nearest CSC center to your current location.')

@push('head')
{{-- Canonical always points at the clean, unfiltered URL — search/filter
     query strings (?district=, ?pincode=, ?page=) shouldn't be treated
     as separate pages competing with each other for the same ranking. --}}
<link rel="canonical" href="{{ route('csc.directory') }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="Find a CSC Center Near You - Punjab Saathi">
<meta property="og:description" content="Search {{ number_format($stats['total_centers']) }}+ Common Service Centers (CSC) across all districts of Punjab.">
<meta property="og:url"         content="{{ route('csc.directory') }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="Find a CSC Center Near You - Punjab Saathi">
<meta name="twitter:description" content="Search {{ number_format($stats['total_centers']) }}+ Common Service Centers (CSC) across all districts of Punjab.">
<meta name="twitter:image"       content="{{ asset('images/og-default.jpg') }}">
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- HERO — headline, live stats, segmented search           --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="psk-csc-hero">
    <div class="psk-csc-hero__bg"></div>
    <div class="container">
        <p class="psk-csc-hero__breadcrumbs">
            <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
            <span>Find a CSC Center</span>
        </p>

        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="psk-csc-hero__title">Find a CSC Center Near You</h1>
                <p class="psk-csc-hero__sub">
                    Search Common Service Centers across every district of Punjab — by PIN code,
                    or instantly using your current location.
                </p>

                {{-- Segmented search control --}}
                <div class="psk-csc-search" id="csc-search">
                    <div class="psk-csc-search__tabs">
                        <button type="button" class="psk-csc-search__tab active" data-tab="pincode">
                            <span class="fa fa-map-marker mr-1"></span> Search by PIN Code
                        </button>
                        <button type="button" class="psk-csc-search__tab" data-tab="nearme">
                            <span class="fa fa-location-arrow mr-1"></span> Find Near Me
                        </button>
                    </div>

                    <div class="psk-csc-search__panel active" data-panel="pincode">
                        <form method="GET" action="{{ route('csc.directory') }}" class="psk-csc-search__form">
                            <input type="text" name="pincode" value="{{ request('pincode') }}"
                                   maxlength="6" inputmode="numeric" placeholder="Enter 6-digit PIN code"
                                   class="psk-csc-search__input" required pattern="[0-9]{6}">
                            <button type="submit" class="btn btn-primary psk-csc-search__btn">
                                <span class="fa fa-search mr-1"></span> Search
                            </button>
                        </form>
                    </div>

                    <div class="psk-csc-search__panel" data-panel="nearme">
                        <button type="button" id="btn-use-location" class="btn btn-primary psk-csc-search__btn psk-csc-search__btn--full">
                            <span class="fa fa-location-arrow mr-1"></span> Find CSC Center Near Me
                        </button>
                        <p class="psk-csc-search__hint">We'll ask for your location just once to find the nearest centers.</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 d-none d-lg-block">
                <div class="psk-csc-hero__visual">
                    <span class="fa fa-map-marker psk-csc-hero__pin psk-csc-hero__pin--1"></span>
                    <span class="fa fa-map-marker psk-csc-hero__pin psk-csc-hero__pin--2"></span>
                    <span class="fa fa-map-marker psk-csc-hero__pin psk-csc-hero__pin--3"></span>
                    <div class="psk-csc-hero__card">
                        <span class="fa fa-check-circle" style="color:#25D366;"></span>
                        <div>
                            <strong>Verified CSC Network</strong>
                            <span>Real government-registered centers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats bar — integrated into hero, not a separate section --}}
        <div class="psk-csc-stats">
            <div class="psk-csc-stats__item">
                <span class="psk-csc-stats__num">{{ number_format($stats['total_centers']) }}+</span>
                <span class="psk-csc-stats__label">CSC Centers</span>
            </div>
            <div class="psk-csc-stats__item">
                <span class="psk-csc-stats__num">{{ $stats['district_count'] }}</span>
                <span class="psk-csc-stats__label">Districts</span>
            </div>
            <div class="psk-csc-stats__item">
                <span class="psk-csc-stats__num">Punjab</span>
                <span class="psk-csc-stats__label">Full Coverage</span>
            </div>
            <div class="psk-csc-stats__item">
                <span class="psk-csc-stats__num">24/7</span>
                <span class="psk-csc-stats__label">Online Search</span>
            </div>
        </div>
    </div>
</section>

{{-- Location permission modal (shown only when "Find Near Me" needs it) --}}
<div id="loc-modal-backdrop" class="psk-loc-modal-backdrop">
    <div class="psk-loc-modal" id="loc-modal">
        <div class="psk-loc-modal__ring state-ask" id="loc-icon-ring">
            <i class="fa fa-map-marker" id="loc-icon"></i>
        </div>
        <h4 id="loc-title">Location Access Needed</h4>
        <p class="psk-loc-modal__sub" id="loc-sub">
            We use your location only to find CSC centers near you — it isn't stored anywhere.
        </p>

        <div id="loc-denied-section" style="display:none;">
            <div class="psk-loc-modal__unblock">
                <strong><span class="fa fa-unlock-alt mr-1"></span>How to allow location:</strong>
                <ol>
                    <li>Click the lock/info icon in your browser's address bar</li>
                    <li>Find "Location" and set it to "Allow"</li>
                    <li>Reload this page and try again</li>
                </ol>
            </div>
        </div>

        <button id="btn-modal-allow" class="btn btn-primary w-100" type="button">
            <span class="fa fa-location-arrow mr-1" id="btn-icon"></span>
            <span id="btn-label">Allow Location Access</span>
        </button>
        <button id="btn-modal-dismiss" class="psk-loc-modal__dismiss" type="button">Cancel</button>
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- RESULTS                                                  --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="ftco-section psk-csc-results-section">
    <div class="container">

        @if($mode === null)

            <div class="psk-csc-prompt">
                <span class="fa fa-search"></span>
                <h3>Search above to find CSC centers</h3>
                <p>Enter a PIN code or use your current location to see centers near you.</p>
            </div>

            {{-- Quick-links row — keeps this state useful instead of empty while
                 no search has run yet --}}
            <div class="row psk-csc-quicklinks">
                <div class="col-md-4 mb-4">
                    <a href="https://wa.me/917710556330?text=Hello%2C%20I%20need%20help%20finding%20a%20CSC%20center"
                       target="_blank" rel="noopener" class="psk-csc-quickcard">
                        <div class="psk-csc-quickcard__icon" style="background:rgba(37,211,102,0.1);">
                            <span class="fa fa-whatsapp" style="color:#25D366;"></span>
                        </div>
                        <h4>Prefer WhatsApp?</h4>
                        <p>Chat with us directly and we'll help you find the nearest center.</p>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="{{ url('/services') }}" class="psk-csc-quickcard">
                        <div class="psk-csc-quickcard__icon" style="background:rgba(252,94,40,0.1);">
                            <span class="fa fa-list" style="color:#fc5e28;"></span>
                        </div>
                        <h4>Browse All Services</h4>
                        <p>Aadhaar, PAN, certificates, and more — see everything you can apply for.</p>
                    </a>
                </div>
                <div class="col-md-4 mb-4">
                    <a href="{{ route('application.track') }}" class="psk-csc-quickcard">
                        <div class="psk-csc-quickcard__icon" style="background:rgba(14,165,233,0.1);">
                            <span class="fa fa-search" style="color:#0ea5e9;"></span>
                        </div>
                        <h4>Track Your Application</h4>
                        <p>Already applied for a service? Check your application status here.</p>
                    </a>
                </div>
            </div>

        @else

            <div class="row">
                {{-- ── Filters column ──────────────────────────── --}}
                <div class="col-lg-3 mb-4">
                  <div class="psk-csc-sidebar-sticky">
                    <div class="psk-csc-filters" id="csc-filters">
                        <div class="psk-csc-filters__header" id="filters-toggle">
                            <span><span class="fa fa-sliders mr-2"></span>Refine Results</span>
                            <span class="fa fa-chevron-down d-lg-none"></span>
                        </div>
                        <div class="psk-csc-filters__body" id="filters-body">
                            <form method="GET" action="{{ route('csc.directory') }}">
                                @if($mode === 'pincode')
                                    <input type="hidden" name="pincode" value="{{ request('pincode') }}">
                                @else
                                    <input type="hidden" name="lat" value="{{ request('lat') }}">
                                    <input type="hidden" name="lng" value="{{ request('lng') }}">
                                @endif

                                <div class="psk-csc-filter-group">
                                    <label class="psk-csc-filters__label">District</label>
                                    <div class="psk-csc-select">
                                        <span class="fa fa-map-o psk-csc-select__icon"></span>
                                        <select name="district" onchange="this.form.submit()">
                                            <option value="">All Districts</option>
                                            @foreach($districts as $d)
                                                <option value="{{ $d }}" {{ request('district') === $d ? 'selected' : '' }}>{{ $d }}</option>
                                            @endforeach
                                        </select>
                                        <span class="fa fa-angle-down psk-csc-select__chevron"></span>
                                    </div>
                                </div>

                                @if($mode === 'nearest')
                                <div class="psk-csc-filter-group">
                                    <label class="psk-csc-filters__label">Distance</label>
                                    <div class="psk-csc-select">
                                        <span class="fa fa-arrows-h psk-csc-select__icon"></span>
                                        <select name="radius" onchange="this.form.submit()">
                                            @foreach([10 => '10 km', 25 => '25 km', 50 => '50 km', 100 => '100 km'] as $km => $label)
                                                <option value="{{ $km }}" {{ (int) request('radius', 50) === $km ? 'selected' : '' }}>Within {{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <span class="fa fa-angle-down psk-csc-select__chevron"></span>
                                    </div>
                                </div>
                                @endif

                                <div class="psk-csc-filter-group">
                                    <label class="psk-csc-filters__label">Trust</label>
                                    <label class="psk-csc-toggle-chip">
                                        <input type="checkbox" name="verified" value="1"
                                               {{ request('verified') ? 'checked' : '' }} onchange="this.form.submit()">
                                        <span class="psk-csc-toggle-chip__box"><span class="fa fa-check-circle mr-1"></span>Verified centers only</span>
                                    </label>
                                </div>

                                @if(request('district') || request('verified'))
                                <a href="{{ route('csc.directory', request()->only(['pincode', 'lat', 'lng'])) }}" class="psk-csc-filters__clear">
                                    <span class="fa fa-times mr-1"></span>Clear filters
                                </a>
                                @endif
                            </form>
                        </div>
                    </div>

                    {{-- WhatsApp help card — same pattern used in the Jobs sidebar --}}
                    <div class="psk-csc-sidebar-wa">
                        <span class="fa fa-whatsapp"></span>
                        <h4>Can't Find Your Center?</h4>
                        <p>Message us and we'll help you locate the nearest CSC center directly.</p>
                        <a href="https://wa.me/917710556330?text=Hello%2C%20I%20need%20help%20finding%20a%20CSC%20center" target="_blank" rel="noopener">
                            <span class="fa fa-whatsapp mr-1"></span> WhatsApp Us
                        </a>
                    </div>

                    {{-- Quick links card --}}
                    <div class="psk-csc-sidebar-links">
                        <h4><span class="fa fa-link mr-2"></span>Quick Links</h4>
                        <ul>
                            <li><a href="{{ url('/services') }}"><span class="fa fa-list mr-2"></span>Browse All Services</a></li>
                            <li><a href="{{ route('application.track') }}"><span class="fa fa-search mr-2"></span>Track Your Application</a></li>
                            <li><a href="{{ route('agent.registration') }}"><span class="fa fa-plus-circle mr-2"></span>Register Your CSC Center</a></li>
                            <li><a href="{{ url('/jobs') }}"><span class="fa fa-briefcase mr-2"></span>Government Job Alerts</a></li>
                        </ul>
                    </div>
                  </div>
                </div>

                {{-- ── Results column ──────────────────────────── --}}
                <div class="col-lg-9">

                    <div class="psk-csc-results-bar">
                        <p class="psk-csc-results-count">
                            <strong>{{ $centers->total() }}</strong> CSC center{{ $centers->total() === 1 ? '' : 's' }} found
                            @if($mode === 'pincode') for PIN code <strong>{{ request('pincode') }}</strong> @endif
                            @if($mode === 'nearest') near you @endif
                            @if($mode === 'district') in <strong>{{ request('district') }}</strong> @endif
                        </p>
                    </div>

                    <div class="row">
                        <div class="col-12">

                            @forelse($centers as $center)
                            @php
                                $cardName = $center->kiosk_name ?: $center->vle_name;
                                $cardLocation = trim(collect([$center->sub_district, $center->district])->filter()->implode(', '));
                            @endphp
                            <div class="psk-csc-card ftco-animate">
                                <div class="psk-csc-card__icon">
                                    <span class="fa fa-building-o"></span>
                                </div>

                                <div class="psk-csc-card__body">
                                    @if($center->is_verified)
                                    <span class="psk-csc-card__badge"><span class="fa fa-check-circle mr-1"></span>Verified CSC</span>
                                    @endif

                                    <h3 class="psk-csc-card__name">
                                        <a href="{{ route('csc.show', $center) }}">{{ $cardName }}</a>
                                    </h3>
                                    <p class="psk-csc-card__location">
                                        <span class="fa fa-map-marker mr-1"></span>{{ $cardLocation ?: 'Punjab' }}
                                        @if($center->pincode) — {{ $center->pincode }} @endif
                                    </p>
                                </div>

                                <div class="psk-csc-card__side">
                                    @if($mode === 'nearest' && isset($center->distance_km))
                                    <span class="psk-csc-card__distance">{{ number_format($center->distance_km, 1) }} km away</span>
                                    @endif
                                    <div class="psk-csc-card__actions">
                                        <a href="{{ route('csc.show', $center) }}" class="btn btn-outline-primary btn-sm">View Center</a>
                                        @php
                                            $waText = "Hello, I found this CSC center on Punjab Saathi and need help:\n"
                                                . "Center: {$cardName}\n"
                                                . "Location: " . ($cardLocation ?: 'Punjab') . ($center->pincode ? " — {$center->pincode}" : '');
                                        @endphp
                                        <a href="https://wa.me/917710556330?text={{ urlencode($waText) }}"
                                           target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                                            <span class="fa fa-whatsapp mr-1"></span>Connect via Punjab Saathi
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="psk-csc-empty">
                                <span class="fa fa-map-marker"></span>
                                <h3>No CSC centers found in this area</h3>
                                <p>Try another PIN code, expand your search radius, or clear filters.</p>
                                <div class="psk-csc-empty__actions">
                                    <a href="{{ route('csc.directory') }}" class="btn btn-outline-primary">Search Another Location</a>
                                    <button type="button" class="btn btn-primary" onclick="document.getElementById('btn-use-location') && document.getElementById('btn-use-location').click(); document.querySelector('[data-tab=nearme]') && document.querySelector('[data-tab=nearme]').click();">
                                        Find Centers Near Me
                                    </button>
                                </div>
                            </div>
                            @endforelse

                            @if($centers->hasPages())
                            <div class="psk-csc-pagination">{{ $centers->links('pagination::bootstrap-4') }}</div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        @endif

    </div>
</section>

{{-- ═══════════════════════════════════════════════════════ --}}
{{-- REGISTER YOUR CSC — CTA                                  --}}
{{-- ═══════════════════════════════════════════════════════ --}}
<section class="psk-csc-cta">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="psk-csc-cta__title">Own a CSC Center?</h2>
                <p class="psk-csc-cta__sub">
                    Register your center on Punjab Saathi and help citizens in your area find your services easily —
                    it takes less than two minutes.
                </p>
            </div>
            <div class="col-md-4 text-md-right mt-3 mt-md-0">
                <a href="{{ route('agent.registration') }}" class="btn btn-primary btn-lg psk-csc-cta__btn">
                    <span class="fa fa-plus-circle mr-2"></span>Register Your CSC Center
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-csc-directory.css') }}">
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Segmented search tabs ─────────────────────────────── */
    var tabs = document.querySelectorAll('.psk-csc-search__tab');
    tabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
            tabs.forEach(function (t) { t.classList.remove('active'); });
            tab.classList.add('active');
            document.querySelectorAll('.psk-csc-search__panel').forEach(function (p) {
                p.classList.toggle('active', p.dataset.panel === tab.dataset.tab);
            });
        });
    });

    /* ── Mobile filters accordion ──────────────────────────── */
    var filtersToggle = document.getElementById('filters-toggle');
    var filtersBody = document.getElementById('filters-body');
    if (filtersToggle && filtersBody) {
        filtersToggle.addEventListener('click', function () {
            filtersBody.classList.toggle('open');
        });
    }

    /* ── Location permission modal + "Find Near Me" flow ──── */
    (function () {
        var btnUseLocation = document.getElementById('btn-use-location');
        var backdrop  = document.getElementById('loc-modal-backdrop');
        var btnAllow  = document.getElementById('btn-modal-allow');
        var btnDismiss = document.getElementById('btn-modal-dismiss');
        var iconRing  = document.getElementById('loc-icon-ring');
        var locIcon   = document.getElementById('loc-icon');
        var locTitle  = document.getElementById('loc-title');
        var locSub    = document.getElementById('loc-sub');
        var deniedSec = document.getElementById('loc-denied-section');
        var btnIcon   = document.getElementById('btn-icon');
        var btnLabel  = document.getElementById('btn-label');

        if (!btnUseLocation) return;

        function showModal() { backdrop.classList.add('show'); }
        function hideModal() { backdrop.classList.remove('show'); }

        function showAskState() {
            iconRing.className = 'psk-loc-modal__ring state-ask';
            locIcon.style.color = '#fc5e28';
            locTitle.textContent = 'Location Access Needed';
            locSub.textContent = "We use your location only to find CSC centers near you — it isn't stored anywhere.";
            deniedSec.style.display = 'none';
            btnIcon.className = 'fa fa-location-arrow mr-1';
            btnLabel.textContent = 'Allow Location Access';
            btnAllow.disabled = false;
            showModal();
        }

        function showDeniedState() {
            iconRing.className = 'psk-loc-modal__ring state-denied';
            locTitle.textContent = 'Location Access Blocked';
            locSub.textContent = "You've previously blocked location access. Follow the steps below, then try again.";
            deniedSec.style.display = 'block';
            btnIcon.className = 'fa fa-refresh mr-1';
            btnLabel.textContent = "I've Allowed It — Try Again";
            btnAllow.disabled = false;
            showModal();
        }

        function goToNearest(lat, lng) {
            var url = new URL('{{ route('csc.directory') }}', window.location.origin);
            url.searchParams.set('lat', lat);
            url.searchParams.set('lng', lng);
            window.location.href = url.toString();
        }

        function doGetPosition() {
            btnAllow.disabled = true;
            btnIcon.className = 'fa fa-spinner fa-spin mr-1';
            btnLabel.textContent = 'Finding CSC centers near you…';

            if (!navigator.geolocation) {
                showDeniedState();
                return;
            }
            navigator.geolocation.getCurrentPosition(
                function (pos) { goToNearest(pos.coords.latitude, pos.coords.longitude); },
                function (err) {
                    if (err.code === 1) { showDeniedState(); }
                    else {
                        btnAllow.disabled = false;
                        btnIcon.className = 'fa fa-refresh mr-1';
                        btnLabel.textContent = 'Try Again';
                    }
                },
                { timeout: 10000, maximumAge: 0 }
            );
        }

        btnUseLocation.addEventListener('click', function () {
            if (navigator.permissions) {
                navigator.permissions.query({ name: 'geolocation' }).then(function (r) {
                    if (r.state === 'granted') { doGetPosition(); }
                    else if (r.state === 'denied') { showDeniedState(); }
                    else { showAskState(); }
                }).catch(showAskState);
            } else {
                showAskState();
            }
        });

        btnAllow.addEventListener('click', doGetPosition);
        btnDismiss.addEventListener('click', hideModal);
    })();
});
</script>
@endpush
