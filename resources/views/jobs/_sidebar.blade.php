{{-- ─────────────────────────────────────────────────────────
     Save as: resources/views/jobs/_sidebar.blade.php
     Usage:   @include('jobs._sidebar')
     ───────────────────────────────────────────────────────── --}}

<style>
.sb-card { background:#fff; border-radius:8px; box-shadow:0 2px 10px rgba(4,14,38,.08); overflow:hidden; margin-bottom:20px; }
.sb-head { background:#040e26; padding:10px 14px; display:flex; align-items:center; gap:8px; }
.sb-head i { color:#fc5e28; font-size:13px; }
.sb-head span { font-family:'Poppins',sans-serif; font-weight:700; font-size:12px; color:#fff; text-transform:uppercase; letter-spacing:.5px; }
.sb-body { padding:14px; }
.cat-link-list { list-style:none; padding:0; margin:0; }
.cat-link-list li a { display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #f5f6f8; font-size:12px; font-weight:700; color:#040e26; text-decoration:none; transition:color .15s; }
.cat-link-list li:last-child a { border-bottom:none; }
.cat-link-list li a:hover, .cat-link-list li a.active-cat { color:#fc5e28; }
.cat-link-list li a .cnt { background:rgba(252,94,40,.12); color:#fc5e28; font-size:10px; font-weight:800; padding:1px 7px; border-radius:10px; }
.recent-list { list-style:none; padding:0; margin:0; }
.recent-list li { padding:8px 0; border-bottom:1px solid #f5f6f8; }
.recent-list li:last-child { border-bottom:none; }
.recent-list li a { font-size:12px; font-weight:600; color:#040e26; display:block; line-height:1.4; text-decoration:none; }
.recent-list li a:hover { color:#fc5e28; }
.recent-list li .meta { font-size:10px; color:#9ca3af; margin-top:2px; }
.wa-widget { background:linear-gradient(135deg,#25D366,#1da851); border-radius:8px; padding:16px; text-align:center; }
.wa-widget i { font-size:30px; color:#fff; display:block; margin-bottom:6px; }
.wa-widget h6 { font-family:'Poppins',sans-serif; font-weight:800; color:#fff; margin-bottom:4px; font-size:14px; }
.wa-widget p { font-size:11px; color:rgba(255,255,255,.85); margin-bottom:10px; }
.wa-widget a { display:inline-flex; align-items:center; gap:6px; background:#fff; color:#25D366; font-weight:800; font-size:12px; padding:8px 18px; border-radius:20px; text-decoration:none; }
.wa-widget a:hover { transform:translateY(-1px); box-shadow:0 4px 10px rgba(0,0,0,.15); }
</style>

{{-- WhatsApp --}}
<div class="wa-widget mb-4">
    <i class="fab fa-whatsapp"></i>
    <h6>Need Form Help?</h6>
    <p>We fill your govt job form — zero errors, zero rejections</p>
    <a href="https://wa.me/917710556330" target="_blank">
        <i class="fab fa-whatsapp"></i> WhatsApp Us
    </a>
</div>

{{-- Categories --}}
<div class="sb-card">
    <div class="sb-head"><i class="fas fa-th-large"></i><span>Job Categories</span></div>
    <div class="sb-body">
        <ul class="cat-link-list">
            <li>
                <a href="{{ route('jobs.index') }}" class="{{ !request('category') && request()->routeIs('jobs.index') ? 'active-cat' : '' }}">
                    All Jobs
                    <span class="cnt">{{ $stats['total'] ?? '' }}</span>
                </a>
            </li>
            @foreach($categories as $cat)
            <li>
                <a href="{{ route('jobs.category', $cat->slug) }}"
                   class="{{ (isset($category) && $category->slug === $cat->slug) ? 'active-cat' : '' }}">
                    <span><i class="fas {{ $cat->icon ?? 'fa-circle' }} mr-1" style="font-size:10px;"></i> {{ $cat->name }}</span>
                    <span class="cnt">{{ $cat->jobs_count }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- Quick Links --}}
<div class="sb-card">
    <div class="sb-head"><i class="fas fa-link"></i><span>Quick Links</span></div>
    <div class="sb-body">
        <ul class="cat-link-list">
            <li><a href="{{ route('jobs.index') }}"><i class="fas fa-briefcase mr-2" style="color:#fc5e28;font-size:11px;"></i>Latest Jobs</a></li>
            <li><a href="{{ route('jobs.admit-cards') }}"><i class="fas fa-id-card mr-2" style="color:#1d4ed8;font-size:11px;"></i>Admit Cards</a></li>
            <li><a href="{{ route('jobs.results') }}"><i class="fas fa-trophy mr-2" style="color:#16a34a;font-size:11px;"></i>Results</a></li>
            <li><a href="{{ route('jobs.answer-keys') }}"><i class="fas fa-key mr-2" style="color:#d97706;font-size:11px;"></i>Answer Keys</a></li>
            <li><a href="{{ route('jobs.form-help') }}"><i class="fas fa-file-alt mr-2" style="color:#7c3aed;font-size:11px;"></i>Form Filling Help</a></li>
        </ul>
    </div>
</div>

{{-- Recent Jobs --}}
@if(isset($recentJobs) && $recentJobs->count())
<div class="sb-card">
    <div class="sb-head"><i class="fas fa-clock"></i><span>Recent Jobs</span></div>
    <div class="sb-body">
        <ul class="recent-list">
            @foreach($recentJobs as $rj)
            <li>
                <a href="{{ route('jobs.show', $rj->slug) }}">{{ $rj->title }}</a>
                <div class="meta">
                    <i class="fas fa-calendar" style="font-size:9px;margin-right:3px;"></i>
                    @if($rj->apply_end) Last Date: {{ $rj->apply_end->format('d M Y') }}
                    @else {{ ucfirst($rj->status) }} @endif
                </div>
            </li>
            @endforeach
        </ul>
    </div>
</div>
@endif
