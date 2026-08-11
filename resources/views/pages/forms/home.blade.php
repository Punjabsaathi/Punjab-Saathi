@extends('layouts.app')

@section('seo_title', config('app.name') . ' – Download Government Forms Online | Punjab')
@section('meta_description', 'Punjab Seva Kendra — Download PAN Card, Passport, Aadhaar, Voter ID, Driving License, Income Certificate, Caste Certificate and hundreds of other government forms online.')
@section('og_title', config('app.name') . ' – Download Government Forms Online')

@section('content')

{{-- Hero --}}
<section class="bg-gradient-to-br from-blue-800 to-blue-950 text-white rounded-2xl p-8 lg:p-12 mb-10 text-center">
    <h1 class="text-3xl lg:text-5xl font-extrabold mb-4 leading-tight">
        Download Government Forms<br><span class="text-yellow-400">Instantly & Free</span>
    </h1>
    <p class="text-blue-200 text-lg mb-8 max-w-2xl mx-auto">
        PAN Card, Passport, Aadhaar, Voter ID, Driving License, Income Certificate and hundreds more — all in one place.
    </p>
    <form action="{{ route('search') }}" method="GET"
          class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
        <input type="text" name="q" placeholder="Search forms, e.g. PAN Card, Passport…"
               class="flex-1 rounded-xl px-5 py-3 text-gray-800 text-sm focus:outline-none focus:ring-4 focus:ring-yellow-400">
        <button type="submit"
                class="bg-yellow-400 hover:bg-yellow-500 text-blue-900 font-bold px-6 py-3 rounded-xl transition text-sm shrink-0">
            Search Forms
        </button>
    </form>
    <div class="mt-6 flex flex-wrap justify-center gap-3 text-sm">
        @foreach(['PAN Card','Passport','Aadhaar','Voter ID','Driving License','Income Certificate'] as $q)
            <a href="{{ route('search', ['q' => $q]) }}"
               class="text-blue-200 hover:text-yellow-400 transition bg-blue-700/50 px-3 py-1 rounded-full text-xs">
                {{ $q }}
            </a>
        @endforeach
    </div>
</section>

{{-- Categories grid --}}
<section class="mb-12">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-2xl font-bold text-gray-800">Browse by Category</h2>
        <a href="{{ route('categories.index') }}" class="text-sm text-blue-600 hover:underline">View all →</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($categories as $cat)
        <a href="{{ route('categories.show', $cat->slug) }}"
           class="group bg-white rounded-2xl border border-gray-100 hover:border-blue-300 shadow-sm hover:shadow-md p-4 flex flex-col items-center text-center transition">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3"
                 style="background-color: {{ $cat->color }}20;">
                <svg class="w-6 h-6" style="color: {{ $cat->color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <span class="text-sm font-semibold text-gray-700 group-hover:text-blue-700 transition leading-tight">{{ $cat->name }}</span>
            <span class="text-xs text-gray-400 mt-1">{{ $cat->forms_count }} forms</span>
        </a>
        @endforeach
    </div>
</section>

{{-- Featured Forms --}}
@if($featured->isNotEmpty())
<section class="mb-12">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-2xl font-bold text-gray-800">⭐ Featured Forms</h2>
        <a href="{{ route('forms.index') }}" class="text-sm text-blue-600 hover:underline">View all →</a>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        @foreach($featured as $form)
            <x-form-card :form="$form" />
        @endforeach
    </div>
</section>
@endif

{{-- Popular Downloads + Recent two-column --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    {{-- Popular --}}
    @if($popular->isNotEmpty())
    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            🔥 <span>Most Downloaded</span>
        </h2>
        <ul class="divide-y divide-gray-100">
            @foreach($popular as $form)
            <li class="py-3 flex items-center gap-3">
                <span class="text-blue-200 font-bold text-lg w-7 text-center shrink-0">{{ $loop->iteration }}</span>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('forms.show', $form->slug) }}"
                       class="text-sm font-medium text-gray-800 hover:text-blue-700 line-clamp-1">
                        {{ $form->title }}
                    </a>
                    <p class="text-xs text-gray-400">{{ $form->category->name }} · {{ number_format($form->download_count) }} downloads</p>
                </div>
                <a href="{{ route('forms.download', $form->slug) }}"
                   class="shrink-0 text-blue-600 hover:text-blue-800 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                </a>
            </li>
            @endforeach
        </ul>
    </section>
    @endif

    {{-- Recently Added --}}
    @if($recent->isNotEmpty())
    <section class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
            🆕 <span>Recently Added</span>
        </h2>
        <ul class="divide-y divide-gray-100">
            @foreach($recent as $form)
            <li class="py-3 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{ route('forms.show', $form->slug) }}"
                       class="text-sm font-medium text-gray-800 hover:text-blue-700 line-clamp-1">
                        {{ $form->title }}
                    </a>
                    <p class="text-xs text-gray-400">{{ $form->category->name }} · {{ optional($form->published_date)->format('d M Y') }}</p>
                </div>
                <a href="{{ route('forms.download', $form->slug) }}"
                   class="shrink-0 bg-blue-600 hover:bg-blue-700 text-white text-xs px-3 py-1 rounded-lg transition">
                    Download
                </a>
            </li>
            @endforeach
        </ul>
    </section>
    @endif
</div>

{{-- Trust strip --}}
<section class="bg-blue-50 rounded-2xl p-6 text-center">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-blue-800">
        <div><div class="text-3xl font-extrabold text-blue-700">500+</div><div class="text-sm mt-1">Forms Available</div></div>
        <div><div class="text-3xl font-extrabold text-blue-700">15+</div><div class="text-sm mt-1">Categories</div></div>
        <div><div class="text-3xl font-extrabold text-blue-700">Free</div><div class="text-sm mt-1">No Registration</div></div>
        <div><div class="text-3xl font-extrabold text-blue-700">PDF</div><div class="text-sm mt-1">Ready to Print</div></div>
    </div>
</section>

@endsection
