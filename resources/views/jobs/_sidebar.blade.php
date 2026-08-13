{{-- ─────────────────────────────────────────────────────────
     Save as: resources/views/jobs/_sidebar.blade.php
     Usage:   @include('jobs._sidebar')

     Reuses .psk-sidebar-card / .psk-sidebar-card__title from
     psk-services-detail.css (already loaded sitewide) instead of a
     page-specific card style, so this sidebar looks like the one on
     /services/{slug}. Link-list styling lives in psk-jobs.css.

     This partial is also included by jobs/show.blade.php, which has
     its own separate design and never loads FontAwesome 6 or
     psk-jobs.css itself — the icons and list styling here would be
     silently unstyled there otherwise (raw bullets, missing icons).
     Pushing the dependencies from inside the partial guarantees they
     load on every page that includes it, regardless of what that
     page itself pulls in.
     ───────────────────────────────────────────────────────── --}}

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/psk-jobs.css') }}">
@endpush

{{-- WhatsApp --}}
<div class="psk-sidebar-wa mb-4">
    <i class="fab fa-whatsapp"></i>
    <h6>Need Form Help?</h6>
    <p>We fill your govt job form — zero errors, zero rejections</p>
    <a href="https://wa.me/917710556330" target="_blank">
        <i class="fab fa-whatsapp"></i> WhatsApp Us
    </a>
</div>

{{-- Categories --}}
<div class="psk-sidebar-card">
    <h3 class="psk-sidebar-card__title"><span class="fas fa-th-large mr-2"></span> Job Categories</h3>
    <ul class="psk-sidebar-link-list">
        <li>
            <a href="{{ route('jobs.index') }}" class="{{ !request('category') && request()->routeIs('jobs.index') ? 'psk-active' : '' }}">
                All Jobs
                <span class="psk-sidebar-link-list__count">{{ $stats['total'] ?? '' }}</span>
            </a>
        </li>
        @foreach($categories as $cat)
        <li>
            <a href="{{ route('jobs.category', $cat->slug) }}"
               class="{{ (isset($category) && $category->slug === $cat->slug) ? 'psk-active' : '' }}">
                <span><i class="fas {{ $cat->icon ?? 'fa-circle' }} mr-1" style="font-size:10px;"></i> {{ $cat->name }}</span>
                <span class="psk-sidebar-link-list__count">{{ $cat->jobs_count }}</span>
            </a>
        </li>
        @endforeach
    </ul>
</div>

{{-- Quick Links --}}
<div class="psk-sidebar-card">
    <h3 class="psk-sidebar-card__title"><span class="fas fa-link mr-2"></span> Quick Links</h3>
    <ul class="psk-sidebar-link-list">
        <li><a href="{{ route('jobs.index') }}"><i class="fas fa-briefcase"></i>Latest Jobs</a></li>
        <li><a href="{{ route('jobs.admit-cards') }}"><i class="fas fa-id-card"></i>Admit Cards</a></li>
        <li><a href="{{ route('jobs.results') }}"><i class="fas fa-trophy"></i>Results</a></li>
        <li><a href="{{ route('jobs.answer-keys') }}"><i class="fas fa-key"></i>Answer Keys</a></li>
        <li><a href="{{ route('jobs.form-help') }}"><i class="fas fa-file-alt"></i>Form Filling Help</a></li>
    </ul>
</div>

{{-- Recent Jobs --}}
@if(isset($recentJobs) && $recentJobs->count())
<div class="psk-sidebar-card">
    <h3 class="psk-sidebar-card__title"><span class="fas fa-clock mr-2"></span> Recent Jobs</h3>
    <ul class="psk-sidebar-recent">
        @foreach($recentJobs as $rj)
        <li>
            <a href="{{ route('jobs.show', $rj->slug) }}">{{ $rj->title }}</a>
            <div class="psk-sidebar-recent__meta">
                <i class="fas fa-calendar" style="font-size:9px;margin-right:3px;"></i>
                @if($rj->apply_end) Last Date: {{ $rj->apply_end->format('d M Y') }}
                @else {{ ucfirst($rj->status) }} @endif
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endif
