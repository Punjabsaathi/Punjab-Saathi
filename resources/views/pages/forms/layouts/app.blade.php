<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('seo_title', config('app.name') . ' – Download Government Forms')</title>
    <meta name="description" content="@yield('meta_description', 'Download government forms online. PAN Card, Passport, Aadhaar, Voter ID, Driving License and more.')">
    <meta name="keywords" content="@yield('meta_keywords', 'government forms, download forms, Punjab, PAN card, passport, aadhaar')">
    @hasSection('canonical')
    <link rel="canonical" href="@yield('canonical')">
    @else
    <link rel="canonical" href="{{ url()->current() }}">
    @endif

    {{-- Open Graph --}}
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:title" content="@yield('og_title', config('app.name'))">
    <meta property="og:description" content="@yield('meta_description', '')">
    <meta property="og:image" content="@yield('og_image', asset('images/og-default.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:locale" content="en_IN">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', config('app.name'))">
    <meta name="twitter:description" content="@yield('meta_description', '')">
    <meta name="twitter:image" content="@yield('og_image', asset('images/og-default.jpg'))">

    {{-- Schema.org --}}
    @hasSection('schema_markup')
    <script type="application/ld+json">@yield('schema_markup')</script>
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

{{-- Navbar --}}
<header class="bg-blue-800 text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        <a href="{{ route('home') }}" class="flex items-center gap-2 font-bold text-xl">
            <img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}" class="h-9 w-auto" onerror="this.style.display='none'">
            <span>{{ config('app.name', 'Punjab Seva Kendra') }}</span>
        </a>

        <nav class="hidden md:flex items-center gap-6 text-sm font-medium">
            <a href="{{ route('home') }}" class="hover:text-yellow-300 transition">Home</a>
            <a href="{{ route('categories.index') }}" class="hover:text-yellow-300 transition">Categories</a>
            <a href="{{ route('forms.index') }}" class="hover:text-yellow-300 transition">All Forms</a>
            <a href="{{ route('search') }}" class="hover:text-yellow-300 transition">Search</a>
        </nav>

        {{-- Search bar --}}
        <form action="{{ route('search') }}" method="GET" class="relative hidden lg:flex items-center">
            <input id="nav-search"
                   name="q"
                   type="text"
                   value="{{ request('q') }}"
                   placeholder="Search forms…"
                   autocomplete="off"
                   class="w-64 rounded-full px-4 py-1.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <button class="absolute right-3 text-gray-500 hover:text-blue-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
            </button>
            <div id="autocomplete-dropdown" class="absolute top-10 left-0 w-full bg-white shadow-xl rounded-lg z-50 hidden text-gray-800 text-sm divide-y"></div>
        </form>

        {{-- Mobile menu button --}}
        <button id="mobile-menu-btn" class="md:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Mobile nav --}}
    <div id="mobile-menu" class="hidden md:hidden bg-blue-900 px-4 pb-4 pt-2 space-y-2 text-sm">
        <a href="{{ route('home') }}" class="block py-1">Home</a>
        <a href="{{ route('categories.index') }}" class="block py-1">Categories</a>
        <a href="{{ route('forms.index') }}" class="block py-1">All Forms</a>
        <a href="{{ route('search') }}" class="block py-1">Search</a>
        <form action="{{ route('search') }}" method="GET" class="mt-2">
            <input name="q" type="text" placeholder="Search forms…" class="w-full rounded px-3 py-1.5 text-gray-800 text-sm focus:outline-none">
        </form>
    </div>
</header>

{{-- Breadcrumb --}}
@hasSection('breadcrumb')
<div class="bg-gray-100 border-b border-gray-200 text-sm">
    <div class="max-w-7xl mx-auto px-4 py-2 flex items-center gap-2 text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-blue-700">Home</a>
        @yield('breadcrumb')
    </div>
</div>
@endif

{{-- Main content --}}
<main class="max-w-7xl mx-auto px-4 py-8">
    @yield('content')
</main>

{{-- Footer --}}
<footer class="bg-blue-900 text-white mt-16 py-10">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
        <div>
            <h3 class="font-semibold text-yellow-400 mb-3">{{ config('app.name') }}</h3>
            <p class="text-blue-200">Your one-stop portal for downloading government forms and official documents online.</p>
        </div>
        <div>
            <h3 class="font-semibold text-yellow-400 mb-3">Quick Links</h3>
            <ul class="space-y-1 text-blue-200">
                <li><a href="{{ route('categories.index') }}" class="hover:text-white">All Categories</a></li>
                <li><a href="{{ route('forms.index') }}" class="hover:text-white">All Forms</a></li>
                <li><a href="{{ route('search') }}" class="hover:text-white">Search</a></li>
            </ul>
        </div>
        <div>
            <h3 class="font-semibold text-yellow-400 mb-3">Disclaimer</h3>
            <p class="text-blue-200">Forms are provided for convenience. Always verify with official government sources.</p>
        </div>
    </div>
    <div class="text-center text-blue-300 text-xs mt-8">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </div>
</footer>

@stack('scripts')
<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });

    // Search autocomplete
    const searchInput = document.getElementById('nav-search');
    const dropdown    = document.getElementById('autocomplete-dropdown');
    let debounce;

    searchInput?.addEventListener('input', function () {
        clearTimeout(debounce);
        const q = this.value.trim();
        if (q.length < 2) { dropdown.classList.add('hidden'); return; }
        debounce = setTimeout(() => {
            fetch(`/api/search/autocomplete?q=${encodeURIComponent(q)}`)
                .then(r => r.json())
                .then(data => {
                    if (!data.length) { dropdown.classList.add('hidden'); return; }
                    dropdown.innerHTML = data.map(item =>
                        `<a href="${item.url}" class="flex justify-between items-center px-4 py-2 hover:bg-blue-50 transition">
                            <span>${item.title}</span>
                            <span class="text-xs text-gray-400">${item.category}</span>
                         </a>`
                    ).join('');
                    dropdown.classList.remove('hidden');
                });
        }, 250);
    });

    document.addEventListener('click', e => {
        if (!dropdown.contains(e.target) && e.target !== searchInput) {
            dropdown.classList.add('hidden');
        }
    });
</script>
</body>
</html>
