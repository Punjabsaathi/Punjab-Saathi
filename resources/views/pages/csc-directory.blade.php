@extends('layouts.app')

@section('title', 'Find a CSC Center Near You - Punjab Saathi')
@section('meta_description', 'Search ' . number_format($stats['total_centers']) . '+ Common Service Centers (CSC) across all districts of Punjab by pincode, or find the nearest CSC center to your current location.')

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
                                        @if($center->latitude && $center->longitude)
                                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $center->latitude }},{{ $center->longitude }}"
                                           target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                                            <span class="fa fa-location-arrow mr-1"></span>Directions
                                        </a>
                                        @endif
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
<style>
/* ═══ HERO ═══════════════════════════════════════════ */
.psk-csc-hero {
    position: relative;
    background: #040e26;
    padding: 130px 0 0;
    overflow: hidden;
    color: #fff;
}
.psk-csc-hero__bg {
    position: absolute; inset: 0;
    background-image:
        radial-gradient(circle at 10% 15%, rgba(252,94,40,0.20) 0, transparent 40%),
        radial-gradient(circle at 90% 10%, rgba(252,94,40,0.12) 0, transparent 35%),
        radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1.5px);
    background-size: auto, auto, 26px 26px;
}
.psk-csc-hero .container { position: relative; z-index: 1; }
.psk-csc-hero__breadcrumbs { color: rgba(255,255,255,0.55); font-size: 0.82rem; margin-bottom: 22px; }
.psk-csc-hero__breadcrumbs a { color: rgba(255,255,255,0.75); text-decoration: none; }
.psk-csc-hero__title { font-size: 2.6rem; font-weight: 800; color: #fff; margin-bottom: 14px; line-height: 1.2; }
.psk-csc-hero__sub { color: rgba(255,255,255,0.72); font-size: 1.05rem; line-height: 1.7; max-width: 520px; margin-bottom: 28px; }

/* ── Segmented search ── */
.psk-csc-search { background: #fff; border-radius: 16px; padding: 8px; box-shadow: 0 20px 60px rgba(0,0,0,0.35); max-width: 520px; }
.psk-csc-search__tabs { display: flex; gap: 4px; margin-bottom: 8px; }
.psk-csc-search__tab {
    flex: 1; background: transparent; border: none; padding: 12px 10px;
    font-size: 0.82rem; font-weight: 700; color: #6b7280; border-radius: 10px;
    cursor: pointer; transition: all 0.2s ease; text-transform: uppercase; letter-spacing: 0.3px;
}
.psk-csc-search__tab.active { background: rgba(252,94,40,0.1); color: #fc5e28; }
.psk-csc-search__panel { display: none; padding: 6px; }
.psk-csc-search__panel.active { display: block; }
.psk-csc-search__form { display: flex; gap: 8px; }
.psk-csc-search__input {
    flex: 1; border: 1px solid #e5e7eb; border-radius: 10px; padding: 12px 16px;
    font-size: 0.95rem; color: #1e2a3a; outline: none;
}
.psk-csc-search__input:focus { border-color: #fc5e28; }
.psk-csc-search__btn { border-radius: 10px !important; white-space: nowrap; }
.psk-csc-search__btn--full { width: 100%; }
.psk-csc-search__hint { font-size: 0.78rem; color: #9ca3af; text-align: center; margin: 10px 0 4px; }

/* ── Hero visual (desktop only) ── */
.psk-csc-hero__visual { position: relative; height: 280px; }
.psk-csc-hero__pin { position: absolute; color: #fc5e28; font-size: 1.6rem; opacity: 0.85; animation: pskFloat 3.5s ease-in-out infinite; }
.psk-csc-hero__pin--1 { top: 10%; left: 20%; animation-delay: 0s; }
.psk-csc-hero__pin--2 { top: 55%; left: 60%; font-size: 2rem; animation-delay: 0.6s; }
.psk-csc-hero__pin--3 { top: 30%; left: 75%; font-size: 1.2rem; animation-delay: 1.2s; }
@keyframes pskFloat { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-10px); } }
.psk-csc-hero__card {
    position: absolute; bottom: 20px; left: 10%; right: 10%;
    background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15);
    backdrop-filter: blur(8px); border-radius: 14px; padding: 16px 20px;
    display: flex; align-items: center; gap: 14px; font-size: 1.3rem;
}
.psk-csc-hero__card strong { display: block; font-size: 0.9rem; color: #fff; }
.psk-csc-hero__card span:last-child { font-size: 0.78rem; color: rgba(255,255,255,0.6); }

/* ── Stats bar ── */
.psk-csc-stats {
    display: flex; flex-wrap: wrap; gap: 0;
    margin-top: 44px; border-top: 1px solid rgba(255,255,255,0.12);
    padding: 26px 0;
}
.psk-csc-stats__item { flex: 1; min-width: 130px; text-align: center; border-right: 1px solid rgba(255,255,255,0.12); }
.psk-csc-stats__item:last-child { border-right: none; }
.psk-csc-stats__num { display: block; font-size: 1.7rem; font-weight: 800; color: #fc5e28; }
.psk-csc-stats__label { display: block; font-size: 0.78rem; color: rgba(255,255,255,0.65); text-transform: uppercase; letter-spacing: 0.5px; margin-top: 2px; }

/* ═══ LOCATION MODAL ═══════════════════════════════════ */
.psk-loc-modal-backdrop {
    display: none; position: fixed; inset: 0; background: rgba(4,14,38,0.6);
    backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;
}
.psk-loc-modal-backdrop.show { display: flex; }
.psk-loc-modal { background: #fff; border-radius: 20px; padding: 34px 30px; max-width: 420px; width: 90%; text-align: center; }
.psk-loc-modal__ring { width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; background: linear-gradient(135deg,#fff3ee,#ffe0d4); }
.psk-loc-modal__ring i { font-size: 28px; color: #fc5e28; }
.psk-loc-modal__ring.state-denied { background: linear-gradient(135deg,#fff0f0,#ffd6d6); }
.psk-loc-modal__ring.state-denied i { color: #dc3545; }
.psk-loc-modal h4 { font-size: 18px; font-weight: 700; color: #1e2a3a; margin-bottom: 8px; }
.psk-loc-modal__sub { font-size: 13.5px; color: #6b7280; line-height: 1.6; margin-bottom: 18px; }
.psk-loc-modal__unblock { background: #f9fafb; border-radius: 10px; padding: 14px 16px; margin-bottom: 16px; text-align: left; font-size: 12.5px; color: #374151; }
.psk-loc-modal__unblock ol { margin: 8px 0 0; padding-left: 18px; }
.psk-loc-modal__dismiss { background: none; border: none; margin-top: 10px; font-size: 12.5px; color: #9ca3af; text-decoration: underline; cursor: pointer; }

/* ═══ RESULTS ═══════════════════════════════════════════ */
.psk-csc-results-section { padding-top: 3em; }
.psk-csc-prompt { text-align: center; padding: 60px 20px; color: #6b7280; }
.psk-csc-prompt .fa { font-size: 2.4rem; color: #e2e6ea; margin-bottom: 14px; display: block; }
.psk-csc-prompt h3 { font-size: 1.2rem; color: #1e2a3a; margin-bottom: 6px; }

.psk-csc-quicklinks { margin-top: 20px; }
.psk-csc-quickcard {
    display: block; height: 100%; background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 28px 26px; text-decoration: none; box-shadow: 0 2px 12px rgba(0,0,0,0.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.psk-csc-quickcard:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); border-color: #fc5e28; text-decoration: none; }
.psk-csc-quickcard__icon {
    width: 52px; height: 52px; border-radius: 12px; display: flex; align-items: center;
    justify-content: center; font-size: 1.3rem; margin-bottom: 16px;
}
.psk-csc-quickcard h4 { font-size: 1rem; font-weight: 700; color: #1e2a3a; margin-bottom: 6px; }
.psk-csc-quickcard p { font-size: 0.85rem; color: #6b7280; margin: 0; line-height: 1.6; }

/* ── Sidebar: filters + WhatsApp + quick links move together as one
   sticky unit — this is what avoids the earlier overlap bug (that
   happened when only the filters card was sticky and the cards below
   it weren't). */
.psk-csc-sidebar-sticky { position: sticky; top: 20px; }

/* ── Filters ── */
.psk-csc-filters {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 22px; box-shadow: 0 2px 14px rgba(0,0,0,0.05);
}
.psk-csc-filters__header {
    display: flex; justify-content: space-between; align-items: center;
    font-weight: 700; color: #1e2a3a; font-size: 0.95rem;
    padding-bottom: 16px; margin-bottom: 18px; border-bottom: 1px solid #f0f0f0;
}
.psk-csc-filters__header .fa-sliders { color: #fc5e28; }

.psk-csc-filter-group { margin-bottom: 20px; }
.psk-csc-filter-group:last-of-type { margin-bottom: 0; }
.psk-csc-filters__label {
    display: block; font-size: 0.72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: 0.5px; color: #9ca3af; margin-bottom: 8px;
}

/* Custom-styled select — replaces the plain browser <select> look */
.psk-csc-select { position: relative; }
.psk-csc-select__icon {
    position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
    color: #fc5e28; font-size: 0.9rem; pointer-events: none;
}
.psk-csc-select__chevron {
    position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
    color: #9ca3af; font-size: 0.85rem; pointer-events: none;
}
.psk-csc-select select {
    appearance: none; -webkit-appearance: none; -moz-appearance: none;
    width: 100%; background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 10px;
    padding: 11px 34px 11px 38px; font-size: 0.88rem; color: #1e2a3a; font-weight: 500;
    cursor: pointer; transition: border-color 0.2s ease, background 0.2s ease;
}
.psk-csc-select select:hover { border-color: #fc5e28; background: #fff; }
.psk-csc-select select:focus { outline: none; border-color: #fc5e28; background: #fff; box-shadow: 0 0 0 3px rgba(252,94,40,0.1); }

/* Toggle chip — replaces the plain checkbox */
.psk-csc-toggle-chip { display: block; cursor: pointer; margin: 0; }
.psk-csc-toggle-chip input { position: absolute; opacity: 0; width: 0; height: 0; }
.psk-csc-toggle-chip__box {
    display: flex; align-items: center; gap: 6px;
    background: #f8f9fa; border: 1px solid #e5e7eb; border-radius: 10px;
    padding: 11px 14px; font-size: 0.85rem; font-weight: 600; color: #6b7280;
    transition: all 0.2s ease;
}
.psk-csc-toggle-chip__box .fa { color: #cbd5e1; transition: color 0.2s ease; }
.psk-csc-toggle-chip input:checked + .psk-csc-toggle-chip__box {
    background: rgba(37,211,102,0.08); border-color: rgba(37,211,102,0.4); color: #1aab50;
}
.psk-csc-toggle-chip input:checked + .psk-csc-toggle-chip__box .fa { color: #25D366; }
.psk-csc-toggle-chip input:focus-visible + .psk-csc-toggle-chip__box { box-shadow: 0 0 0 3px rgba(252,94,40,0.15); }

.psk-csc-filters__clear {
    display: flex; align-items: center; justify-content: center; gap: 4px;
    margin-top: 18px; padding-top: 16px; border-top: 1px solid #f0f0f0;
    font-size: 0.82rem; color: #fc5e28; text-decoration: none; font-weight: 700;
}
.psk-csc-filters__clear:hover { color: #e04d1a; }

/* ── Sidebar WhatsApp card ── */
.psk-csc-sidebar-wa {
    background: linear-gradient(160deg, #25D366 0%, #1aab50 100%);
    border-radius: 16px; padding: 24px 22px; margin-top: 20px; text-align: center; color: #fff;
}
.psk-csc-sidebar-wa .fa-whatsapp { font-size: 2rem; margin-bottom: 10px; display: block; }
.psk-csc-sidebar-wa h4 { font-size: 1rem; font-weight: 700; margin-bottom: 6px; color: #fff; }
.psk-csc-sidebar-wa p { font-size: 0.82rem; color: rgba(255,255,255,0.85); margin-bottom: 16px; line-height: 1.5; }
.psk-csc-sidebar-wa a {
    display: inline-flex; align-items: center; background: #fff; color: #1aab50 !important;
    font-weight: 700; font-size: 0.85rem; padding: 10px 20px; border-radius: 10px; text-decoration: none;
}
.psk-csc-sidebar-wa a:hover { background: #f0fdf4; }

/* ── Sidebar quick links card ── */
.psk-csc-sidebar-links {
    background: #fff; border: 1px solid #e2e6ea; border-radius: 16px;
    padding: 22px; margin-top: 20px; box-shadow: 0 2px 12px rgba(0,0,0,0.05);
}
.psk-csc-sidebar-links h4 { font-size: 0.9rem; font-weight: 700; color: #1e2a3a; margin-bottom: 14px; }
.psk-csc-sidebar-links h4 .fa { color: #fc5e28; }
.psk-csc-sidebar-links ul { list-style: none; margin: 0; padding: 0; }
.psk-csc-sidebar-links li { border-top: 1px solid #f4f5f7; }
.psk-csc-sidebar-links li:first-child { border-top: none; }
.psk-csc-sidebar-links a {
    display: flex; align-items: center; padding: 11px 2px; font-size: 0.85rem;
    color: #4b5563; text-decoration: none; transition: color 0.2s ease;
}
.psk-csc-sidebar-links a:hover { color: #fc5e28; }
.psk-csc-sidebar-links a .fa { color: #9ca3af; width: 16px; }
.psk-csc-sidebar-links a:hover .fa { color: #fc5e28; }

/* ── Results bar ── */
.psk-csc-results-bar { margin-bottom: 18px; }
.psk-csc-results-count { color: #6b7280; font-size: 0.92rem; margin: 0; }

/* ── Result card — horizontal layout so wide cards fill their width
   with content/actions instead of leaving space blank under short text ── */
.psk-csc-card {
    position: relative; display: flex; align-items: center; gap: 20px;
    background: #fff; border: 1px solid #e2e6ea; border-radius: 14px;
    padding: 20px 24px; margin-bottom: 16px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
}
.psk-csc-card:hover { transform: translateY(-3px); box-shadow: 0 12px 32px rgba(0,0,0,0.1); border-color: #fc5e28; }
.psk-csc-card__icon {
    flex-shrink: 0; width: 52px; height: 52px; border-radius: 12px;
    background: rgba(252,94,40,0.08); display: flex; align-items: center; justify-content: center;
}
.psk-csc-card__icon .fa { color: #fc5e28; font-size: 1.3rem; }
.psk-csc-card__body { flex: 1; min-width: 0; }
.psk-csc-card__badge {
    display: inline-flex; align-items: center; background: rgba(37,211,102,0.1); color: #1aab50;
    font-size: 0.72rem; font-weight: 700; padding: 4px 12px; border-radius: 20px; margin-bottom: 8px;
}
.psk-csc-card__name { font-size: 1.05rem; font-weight: 700; margin-bottom: 4px; }
.psk-csc-card__name a { color: #1e2a3a; text-decoration: none; }
.psk-csc-card__name a:hover { color: #fc5e28; }
.psk-csc-card__location { color: #6b7280; font-size: 0.85rem; margin: 0; }
.psk-csc-card__side {
    flex-shrink: 0; display: flex; flex-direction: column; align-items: flex-end; gap: 10px;
}
.psk-csc-card__distance {
    display: inline-block; background: rgba(252,94,40,0.1); color: #fc5e28;
    font-weight: 700; font-size: 0.8rem; padding: 4px 12px; border-radius: 20px; white-space: nowrap;
}
.psk-csc-card__actions { display: flex; gap: 10px; }

/* ── Empty state ── */
.psk-csc-empty { text-align: center; padding: 60px 20px; background: #fff; border: 1px solid #e2e6ea; border-radius: 14px; }
.psk-csc-empty .fa { font-size: 2.4rem; color: #e2e6ea; margin-bottom: 14px; display: block; }
.psk-csc-empty h3 { font-size: 1.15rem; color: #1e2a3a; margin-bottom: 6px; }
.psk-csc-empty p { color: #6b7280; margin-bottom: 20px; }
.psk-csc-empty__actions { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }

.psk-csc-pagination .pagination { justify-content: center; margin-top: 10px; }
.psk-csc-pagination .page-link { color: #1e2a3a; border-color: #e2e6ea; }
.psk-csc-pagination .page-item.active .page-link { background: #fc5e28; border-color: #fc5e28; }

/* ═══ REGISTER CTA ═══════════════════════════════════════ */
.psk-csc-cta { background: linear-gradient(135deg, #fc5e28 0%, #e04010 100%); padding: 56px 0; }
.psk-csc-cta__title { color: #fff; font-size: 1.7rem; font-weight: 800; margin-bottom: 8px; }
.psk-csc-cta__sub { color: rgba(255,255,255,0.9); font-size: 1rem; margin: 0; max-width: 560px; }
.btn.btn-primary.psk-csc-cta__btn { background: #fff !important; color: #fc5e28 !important; border-color: #fff !important; }
.btn.btn-primary.psk-csc-cta__btn:hover { background: #f8f9fa !important; color: #e04d1a !important; }

/* ═══ RESPONSIVE ═══════════════════════════════════════════ */
@media (max-width: 991.98px) {
    .psk-csc-filters__body { display: none; margin-top: 14px; }
    .psk-csc-filters__body.open { display: block; }
    .psk-csc-sidebar-sticky { position: static; }
}
@media (max-width: 767.98px) {
    .psk-csc-hero { padding-top: 100px; }
    .psk-csc-hero__title { font-size: 1.7rem; }
    .psk-csc-stats { padding: 18px 0; }
    .psk-csc-stats__item { min-width: 45%; margin-bottom: 14px; }
    .psk-csc-search { max-width: 100%; }
    .psk-csc-search__form { flex-direction: column; }
    .psk-csc-search__btn { width: 100%; }
    .psk-csc-card { flex-direction: column; align-items: stretch; }
    .psk-csc-card__icon { display: none; }
    .psk-csc-card__side { align-items: stretch; margin-top: 12px; padding-top: 12px; border-top: 1px solid #f0f0f0; }
    .psk-csc-card__distance { align-self: flex-start; }
    .psk-csc-card__actions { flex-direction: column; }
    .psk-csc-card__actions .btn { width: 100%; }
    .psk-csc-cta { text-align: center; }
    .psk-csc-cta .text-md-right { text-align: center !important; }
}
</style>
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
