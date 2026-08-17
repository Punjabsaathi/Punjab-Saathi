<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', config('app.name', 'Punjab Saathi'))</title>
    <meta name="description" content="@yield('meta_description', 'Punjab Saathi - Online Public Services in Punjab')">

    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('images/punjab-saathi-logo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/punjab-saathi-logo.png') }}">

    {{-- Pages push canonical URLs, Open Graph tags, and JSON-LD schema
         here via @push('head') (e.g. blogs/show.blade.php). This stack
         was never rendered before, so all of that silently disappeared
         on every page that used it — this is the fix. --}}
    @stack('head')

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">

        {{-- In <head>, after your existing style.css --}}
    <link rel="stylesheet" href="{{ asset('css/psk-services-detail.css') }}">
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
    <script src="{{ asset('js/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('js/jquery.animateNumber.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
    <script src="{{ asset('js/scrollax.min.js') }}"></script>
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