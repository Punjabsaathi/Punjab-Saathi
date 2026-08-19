<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'Punjab Saathi'))</title>
    <meta name="description" content="@yield('meta_description', 'Punjab Saathi - Online Public Services in Punjab')">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/favicon-48x48.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/android-chrome-192x192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/apple-touch-icon.png') }}">

    {{-- Pages push canonical URLs, Open Graph tags, and JSON-LD schema
         here via @push('head') (e.g. blogs/show.blade.php). This stack
         was never rendered before, so all of that silently disappeared
         on every page that used it — this is the fix. --}}
    @stack('head')

    {{-- Establishes the connection to these two external CDNs while the
         rest of <head> is still parsing, instead of only starting the
         DNS lookup + TLS handshake once the browser reaches the <link>
         tag below — shaves the round-trip latency off the critical
         rendering path for the very first thing every page loads. --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://stackpath.bootstrapcdn.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        {{-- In <head>, after your existing style.css --}}
    <link rel="stylesheet" href="{{ asset('css/psk-services-detail.css') }}">
    {{-- owl.carousel / magnific-popup / bootstrap-datepicker / jquery.timepicker
         used to load on EVERY page regardless of need. Datepicker and
         timepicker were confirmed completely unused anywhere on the site
         (removed outright, along with the dead JS that initialised them —
         see main.js). owl.carousel and magnific-popup ARE genuinely used,
         but only on home/about — those two pages now pull them in here
         via @push('styles') instead of every page paying for them. --}}
    @stack('styles')
</head>
<body>

    @include('components.topbar')

    <div id="pskHeaderWrap" class="psk-header-wrap">
        @include('components.header')
        @include('components.navbar')
    </div>

    <main>
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.modal-inquiry')

    {{-- TEMPORARY — for manual testing only, per explicit request. Remove
         this include (or comment it out) before the chatbot is meant to
         go live for real visitors. --}}
    @include('chatbot.Widget')

    <div id="ftco-loader" class="show fullscreen">
        <svg class="circular" width="48px" height="48px">
            <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/>
            <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#F96D00"/>
        </svg>
    </div>

    {{-- Shown while a form marked data-psk-loading is submitting — see public/js/psk-form-loader.js --}}
    <div id="psk-form-loader" class="psk-form-loader" role="status" aria-live="polite" aria-hidden="true">
        <div class="psk-form-loader__box">
            <div class="psk-form-loader__logo-badge">
                <img src="{{ asset('images/punjab-saathi-logo.png') }}" alt="Punjab Saathi" class="psk-form-loader__logo">
            </div>
            <svg class="psk-form-loader__spinner" viewBox="0 0 50 50">
                <circle class="psk-form-loader__track" cx="25" cy="25" r="20" fill="none"></circle>
                <circle class="psk-form-loader__arc" cx="25" cy="25" r="20" fill="none"></circle>
            </svg>
            <p class="psk-form-loader__text" id="psk-form-loader-text">Submitting…</p>
            <p class="psk-form-loader__hint" id="psk-form-loader-hint">Please don't close or refresh this page</p>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/scrollax.min.js') }}"></script>
    {{-- Page-specific plugins (owl.carousel, magnific-popup) that main.js
         below calls into — must load BEFORE main.js, which is why this is
         a separate stack from @stack('scripts') further down (that one
         renders AFTER main.js, too late for anything main.js calls on
         page load). main.js itself guards each call with an
         `if ($.fn.pluginName)` check, so pages that don't push anything
         into this stack are unaffected. --}}
    @stack('plugin-scripts')
    <script src="{{ asset('js/main.js') }}"></script>
    {{-- Before </body>, after your existing scripts --}}
    <script src="{{ asset('js/psk-services-detail.js') }}"></script>
    <script src="{{ asset('js/psk-form-loader.js') }}"></script>

    @stack('scripts')
    
</body>
</html>
<!-- <a href="https://wa.me/917710556330"
    target="_blank"
    rel="noopener"
    title="Chat with Punjab Saathi on WhatsApp"
    style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:#fff;width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.7rem;box-shadow:0 4px 18px rgba(37,211,102,0.45);text-decoration:none;">
    <span class="fa fa-whatsapp"></span>
</a> -->