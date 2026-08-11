{{-- ─────────────────────────────────────────────────────────
     Save as: resources/views/jobs/show.blade.php
     ───────────────────────────────────────────────────────── --}}
@extends('layouts.app')

@section('title', $metaTitle)
@section('meta_description', $metaDesc)

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
:root{--or:#fc5e28;--or-dark:#e04d1c;--or-bg:rgba(252,94,40,.10);--nv:#040e26;--gr:#f8f9fb;--bd:#e4e7ec;--txt:#4b5563;--grn:#16a34a;--grn-bg:#dcfce7;--blu:#1d4ed8;--blu-bg:#dbeafe;--red:#dc2626;--red-bg:#fee2e2;--rad:6px;--sha:0 2px 10px rgba(4,14,38,.10);}
/* ── Hero ── */
.jd-hero{background:linear-gradient(135deg,#040e26 0%,#0d275c 60%,#112278 100%);padding:32px 0 20px;position:relative;overflow:hidden;}
.jd-hero::before{content:'';position:absolute;inset:0;background:url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4z'/%3E%3C/g%3E%3C/svg%3E");}
.jd-hero .breadcrumb{background:transparent;padding:0;margin-bottom:8px;}
.jd-hero .breadcrumb-item a{color:var(--or);}
.jd-hero .breadcrumb-item.active{color:rgba(255,255,255,.6);}
.jd-hero .breadcrumb-item+.breadcrumb-item::before{color:rgba(255,255,255,.4);}
.jd-hero h1{font-family:'Poppins',sans-serif;font-size:1.7rem;font-weight:800;color:#fff;margin-bottom:8px;line-height:1.3;}
.jd-cat-badge{display:inline-flex;align-items:center;gap:6px;background:var(--or);color:#fff;font-size:11px;font-weight:800;padding:4px 13px;border-radius:12px;margin-bottom:8px;text-transform:uppercase;letter-spacing:.5px;}
.jd-stat-row{display:flex;flex-wrap:wrap;gap:12px;margin-top:12px;}
.jd-stat{display:flex;flex-direction:column;align-items:center;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);border-radius:6px;padding:10px 16px;text-align:center;min-width:90px;}
.jd-stat .num{font-family:'Poppins',sans-serif;font-size:18px;font-weight:800;color:var(--or);}
.jd-stat .lbl{font-size:10px;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.5px;margin-top:1px;}
.s-badge{display:inline-flex;align-items:center;gap:3px;font-size:10px;font-weight:800;letter-spacing:.4px;text-transform:uppercase;padding:3px 10px;border-radius:12px;}
.s-badge::before{content:'';width:5px;height:5px;border-radius:50%;display:inline-block;}
.sb-active{background:var(--grn-bg);color:var(--grn)}.sb-active::before{background:var(--grn);}
.sb-upcoming{background:var(--blu-bg);color:var(--blu)}.sb-upcoming::before{background:var(--blu);}
.sb-expired{background:#f3f4f6;color:#6b7280}.sb-expired::before{background:#9ca3af;}
/* ── Tab Nav ── */
.jd-tab-nav{display:flex;flex-wrap:wrap;background:#fff;border-radius:8px;box-shadow:var(--sha);overflow:hidden;margin-bottom:20px;border-bottom:2px solid var(--bd);}
.jd-tab-btn{flex:none;display:flex;align-items:center;gap:6px;padding:12px 16px;border:none;background:transparent;cursor:pointer;font-family:'Poppins',sans-serif;font-weight:700;font-size:12px;color:var(--txt);letter-spacing:.2px;border-bottom:3px solid transparent;margin-bottom:-2px;transition:all .2s;text-transform:uppercase;white-space:nowrap;}
.jd-tab-btn i{font-size:13px;}
.jd-tab-btn:hover{color:var(--or);background:var(--or-bg);}
.jd-tab-btn.active{color:var(--or);border-bottom-color:var(--or);background:var(--or-bg);}
.jd-tab-count{background:var(--or);color:#fff;font-size:9px;font-weight:800;padding:1px 5px;border-radius:10px;}
/* ── Tab Panels ── */
.jd-panel{display:none;}
.jd-panel.active{display:block;}
/* ── Info Cards ── */
.info-card{background:#fff;border-radius:8px;box-shadow:var(--sha);overflow:hidden;margin-bottom:16px;}
.ic-head{background:var(--nv);padding:12px 16px;display:flex;align-items:center;gap:10px;}
.ic-head i{color:var(--or);font-size:15px;}
.ic-head h5{font-family:'Poppins',sans-serif;font-weight:700;font-size:13px;color:#fff;margin:0;text-transform:uppercase;letter-spacing:.5px;}
.ic-body{padding:16px;}
.info-row{display:flex;padding:9px 0;border-bottom:1px solid #f5f6f8;}
.info-row:last-child{border-bottom:none;}
.info-label{width:200px;flex-shrink:0;font-size:12px;font-weight:700;color:var(--txt);}
.info-value{flex:1;font-size:13px;font-weight:600;color:var(--nv);}
.info-value a{color:var(--or);}
.info-value a:hover{text-decoration:underline;}
/* ── Process Steps ── */
.step-list{list-style:none;padding:0;margin:0;counter-reset:step;}
.step-list li{display:flex;gap:14px;padding:10px 0;border-bottom:1px solid #f5f6f8;counter-increment:step;}
.step-list li:last-child{border-bottom:none;}
.step-num{width:28px;height:28px;background:var(--or);color:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Poppins',sans-serif;font-weight:800;font-size:12px;flex-shrink:0;}
.step-txt{font-size:13px;color:var(--nv);font-weight:600;padding-top:4px;line-height:1.4;}
/* ── Check List ── */
.check-list{list-style:none;padding:0;margin:0;}
.check-list li{display:flex;gap:10px;padding:8px 0;border-bottom:1px solid #f5f6f8;font-size:13px;color:var(--nv);font-weight:600;}
.check-list li:last-child{border-bottom:none;}
.check-list li i{color:var(--grn);font-size:14px;flex-shrink:0;margin-top:1px;}
/* ── Fee Table ── */
.fee-table{width:100%;border-collapse:collapse;font-size:13px;}
.fee-table th{background:var(--gr);color:var(--nv);font-family:'Poppins',sans-serif;font-weight:700;font-size:11px;text-transform:uppercase;letter-spacing:.5px;padding:9px 12px;border-bottom:2px solid var(--bd);}
.fee-table td{padding:9px 12px;border-bottom:1px solid #f5f6f8;color:var(--nv);font-weight:600;}
.fee-table td:last-child{font-weight:800;color:var(--or);}
.fee-table tr:last-child td{border-bottom:none;}
/* ── Links Grid ── */
.links-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:10px;}
.link-btn{display:flex;align-items:center;gap:8px;padding:10px 13px;border-radius:6px;text-decoration:none;font-size:12px;font-weight:700;transition:all .2s;border:1.5px solid var(--bd);}
.link-btn:hover{transform:translateY(-2px);text-decoration:none;}
.link-btn i{font-size:15px;flex-shrink:0;}
.lb-pdf{color:var(--red);border-color:#fca5a5;background:#fff9f9;}.lb-pdf:hover{background:var(--red-bg);border-color:var(--red);color:var(--red)!important;}
.lb-apply{color:var(--grn);border-color:#86efac;background:#f0fff4;}.lb-apply:hover{background:var(--grn-bg);border-color:var(--grn);color:var(--grn)!important;}
.lb-web{color:var(--blu);border-color:#93c5fd;background:#f0f5ff;}.lb-web:hover{background:var(--blu-bg);border-color:var(--blu);color:var(--blu)!important;}
.lb-gen{color:var(--or);border-color:#fed7aa;background:#fff8f5;}.lb-gen:hover{background:var(--or-bg);border-color:var(--or);color:var(--or)!important;}
/* ── Syllabus ── */
.syllabus-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:12px;}
.syl-item{background:var(--gr);border:1px solid var(--bd);border-radius:6px;padding:12px;}
.syl-item h6{font-family:'Poppins',sans-serif;font-weight:800;color:var(--nv);font-size:12px;margin-bottom:6px;display:flex;align-items:center;gap:6px;}
.syl-item h6 i{color:var(--or);}
.syl-item p{font-size:12px;color:var(--txt);margin:0;line-height:1.6;}
/* ── Timeline ── */
.timeline{position:relative;padding-left:24px;}
.timeline::before{content:'';position:absolute;left:7px;top:0;bottom:0;width:2px;background:var(--bd);}
.tl-item{position:relative;margin-bottom:16px;}
.tl-dot{position:absolute;left:-21px;width:14px;height:14px;border-radius:50%;border:2px solid #fff;box-shadow:0 0 0 2px var(--bd);}
.tl-dot.type-notification{background:var(--blu);}
.tl-dot.type-admit_card{background:var(--or);}
.tl-dot.type-answer_key{background:#d97706;}
.tl-dot.type-result{background:var(--grn);}
.tl-dot.type-date_extended{background:var(--red);}
.tl-dot.type-general{background:#9ca3af;}
.tl-dot.type-correction{background:#7c3aed;}
.tl-content{background:#fff;border:1px solid var(--bd);border-radius:6px;padding:10px 13px;margin-left:4px;}
.tl-content h6{font-family:'Poppins',sans-serif;font-weight:700;font-size:13px;color:var(--nv);margin-bottom:3px;}
.tl-content p{font-size:12px;color:var(--txt);margin:0;}
.tl-date{font-size:10px;font-weight:700;color:#9ca3af;margin-bottom:4px;display:flex;align-items:center;gap:4px;}
/* ── FAQ ── */
.faq-item{border-bottom:1px solid var(--bd);padding:14px 0;}
.faq-item:first-child{padding-top:0;}
.faq-item:last-child{border-bottom:none;padding-bottom:0;}
.faq-q{display:flex;align-items:flex-start;gap:10px;font-family:'Poppins',sans-serif;font-weight:700;font-size:13px;color:var(--nv);margin-bottom:6px;}
.faq-q i{color:var(--or);font-size:14px;flex-shrink:0;margin-top:1px;}
.faq-a{font-size:13px;color:var(--txt);line-height:1.6;padding-left:24px;}
/* ── Admit/Result/AK Cards ── */
.doc-card{background:var(--gr);border:1px solid var(--bd);border-radius:6px;padding:13px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:8px;}
.doc-info h6{font-family:'Poppins',sans-serif;font-weight:700;font-size:13px;color:var(--nv);margin:0 0 4px;}
.doc-info p{font-size:11px;color:#9ca3af;margin:0;}
.btn-dl-doc{display:inline-flex;align-items:center;gap:5px;background:var(--or);color:#fff!important;font-size:11px;font-weight:700;padding:6px 13px;border-radius:4px;text-decoration:none;white-space:nowrap;transition:background .15s;}
.btn-dl-doc:hover{background:var(--or-dark);text-decoration:none;}
.btn-dl-outline{display:inline-flex;align-items:center;gap:5px;background:transparent;color:var(--or)!important;border:1.5px solid var(--or);font-size:11px;font-weight:700;padding:5px 12px;border-radius:4px;text-decoration:none;white-space:nowrap;transition:all .15s;}
.btn-dl-outline:hover{background:var(--or);color:#fff!important;text-decoration:none;}
/* ── Related Jobs ── */
.rj-item{display:flex;gap:10px;padding:10px 0;border-bottom:1px solid #f5f6f8;}
.rj-item:last-child{border-bottom:none;}
.rj-icon{width:36px;height:36px;background:var(--or-bg);border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
.rj-icon i{color:var(--or);font-size:14px;}
.rj-info a{font-size:12px;font-weight:700;color:var(--nv);display:block;line-height:1.3;text-decoration:none;}
.rj-info a:hover{color:var(--or);}
.rj-info span{font-size:10px;color:#9ca3af;}
/* ── WhatsApp Apply Cta ── */
.apply-cta{background:linear-gradient(135deg,var(--or),var(--or-dark));border-radius:8px;padding:16px;text-align:center;margin-bottom:16px;}
.apply-cta h6{font-family:'Poppins',sans-serif;font-weight:800;color:#fff;margin-bottom:4px;}
.apply-cta p{font-size:11px;color:rgba(255,255,255,.85);margin-bottom:10px;}
.apply-cta a{display:inline-flex;align-items:center;gap:6px;background:#fff;color:var(--or)!important;font-weight:800;font-size:12px;padding:8px 18px;border-radius:20px;text-decoration:none;}
.apply-cta a:hover{transform:translateY(-1px);}
</style>
@endpush

@section('content')

{{-- ── Job Hero ──────────────────────────────────────────── --}}
<section class="jd-hero">
    <div class="container" style="position:relative;z-index:1;">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jobs.index') }}">Sarkari Naukri</a></li>
                <li class="breadcrumb-item active">{{ Str::limit($job->title, 50) }}</li>
            </ol>
        </nav>

        <span class="jd-cat-badge">
            <i class="fas {{ $job->category->icon ?? 'fa-briefcase' }}"></i>
            {{ $job->category->name }}
        </span>

        <h1>{{ $job->title }}</h1>

        <div class="d-flex flex-wrap align-items-center" style="gap:8px;margin-bottom:12px;">
            @php $sb = $job->status_badge; @endphp
            <span class="s-badge {{ $sb['class'] }}">{{ $sb['label'] }}</span>
            @if($job->is_new) <span style="background:var(--red-bg);color:var(--red);font-size:10px;font-weight:800;padding:2px 8px;border-radius:3px;text-transform:uppercase;">NEW</span> @endif
            @if($job->is_urgent) <span style="background:var(--red);color:#fff;font-size:10px;font-weight:800;padding:2px 8px;border-radius:3px;text-transform:uppercase;"><i class="fas fa-fire mr-1"></i>Closing Soon</span> @endif
        </div>

        <div class="jd-stat-row">
            <div class="jd-stat">
                <div class="num">{{ number_format($job->total_posts) }}</div>
                <div class="lbl">Vacancies</div>
            </div>
            @if($job->apply_end)
            <div class="jd-stat">
                <div class="num" style="font-size:14px;">{{ $job->apply_end->format('d M Y') }}</div>
                <div class="lbl">Last Date</div>
            </div>
            @endif
            @if($job->exam_date)
            <div class="jd-stat">
                <div class="num" style="font-size:14px;">{{ $job->exam_date->format('d M Y') }}</div>
                <div class="lbl">Exam Date</div>
            </div>
            @endif
            @if($job->salary_pay_scale)
            <div class="jd-stat">
                <div class="num" style="font-size:13px;">{{ $job->salary_pay_scale }}</div>
                <div class="lbl">Pay Scale</div>
            </div>
            @endif
        </div>
    </div>
</section>

{{-- ── Main Content ─────────────────────────────────────── --}}
<section class="py-4">
    <div class="container">
        <div class="row">

            {{-- ── Detail Area ─────────────────────────────── --}}
            <div class="col-lg-8 col-xl-9">

                {{-- Tab Navigation --}}
                <div class="overflow-auto mb-0">
                    <div class="jd-tab-nav" style="flex-wrap:nowrap;min-width:max-content;">
                        <button class="jd-tab-btn active" onclick="jdTab('overview')"><i class="fas fa-info-circle"></i> Overview</button>
                        <button class="jd-tab-btn" onclick="jdTab('eligibility')"><i class="fas fa-user-check"></i> Eligibility</button>
                        <button class="jd-tab-btn" onclick="jdTab('selection')"><i class="fas fa-tasks"></i> Selection</button>
                        <button class="jd-tab-btn" onclick="jdTab('apply')"><i class="fas fa-file-signature"></i> Apply</button>
                        <button class="jd-tab-btn" onclick="jdTab('links')"><i class="fas fa-link"></i> Links</button>
                        <button class="jd-tab-btn" onclick="jdTab('syllabus')"><i class="fas fa-book"></i> Syllabus</button>
                        @if($job->admitCards->count())
                        <button class="jd-tab-btn" onclick="jdTab('admit')"><i class="fas fa-id-card"></i> Admit Card <span class="jd-tab-count">{{ $job->admitCards->count() }}</span></button>
                        @endif
                        @if($job->answerKeys->count())
                        <button class="jd-tab-btn" onclick="jdTab('answerkey')"><i class="fas fa-key"></i> Answer Key <span class="jd-tab-count">{{ $job->answerKeys->count() }}</span></button>
                        @endif
                        @if($job->results->count())
                        <button class="jd-tab-btn" onclick="jdTab('result')"><i class="fas fa-trophy"></i> Result <span class="jd-tab-count">{{ $job->results->count() }}</span></button>
                        @endif
                        @if($job->faqs->count())
                        <button class="jd-tab-btn" onclick="jdTab('faq')"><i class="fas fa-question-circle"></i> FAQs <span class="jd-tab-count">{{ $job->faqs->count() }}</span></button>
                        @endif
                        @if($job->updates->count())
                        <button class="jd-tab-btn" onclick="jdTab('updates')"><i class="fas fa-bell"></i> Updates <span class="jd-tab-count">{{ $job->updates->count() }}</span></button>
                        @endif
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 1: OVERVIEW
                ══════════════════════════════════════════ --}}
                <div class="jd-panel active" id="jdp-overview">
                    @if($job->short_description)
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-align-left"></i><h5>About This Job</h5></div>
                        <div class="ic-body">
                            <p style="font-size:13px;color:var(--txt);line-height:1.7;margin:0;">{{ $job->short_description }}</p>
                        </div>
                    </div>
                    @endif

                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-clipboard-list"></i><h5>Job Overview</h5></div>
                        <div class="ic-body">
                            <div class="info-row"><span class="info-label">Organisation</span><span class="info-value">{{ $job->department }}</span></div>
                            <div class="info-row"><span class="info-label">Post Name</span><span class="info-value font-weight-bold" style="color:var(--or);">{{ $job->title }}</span></div>
                            @if($job->ad_number)
                            <div class="info-row"><span class="info-label">Advertisement No.</span><span class="info-value">{{ $job->ad_number }}</span></div>
                            @endif
                            <div class="info-row"><span class="info-label">Total Vacancies</span><span class="info-value" style="font-family:'Poppins',sans-serif;font-size:20px;font-weight:800;color:var(--or);">{{ number_format($job->total_posts) }}</span></div>
                            @if($job->location)
                            <div class="info-row"><span class="info-label">Location</span><span class="info-value">{{ $job->location }}</span></div>
                            @endif
                            @if($job->salary_pay_scale)
                            <div class="info-row"><span class="info-label">Pay Scale / Salary</span><span class="info-value font-weight-bold">{{ $job->salary_pay_scale }}</span></div>
                            @endif
                            <div class="info-row"><span class="info-label">Application Mode</span><span class="info-value text-capitalize">{{ $job->application_mode }}</span></div>
                            @if($job->official_website)
                            <div class="info-row"><span class="info-label">Official Website</span><span class="info-value"><a href="{{ $job->official_website }}" target="_blank">{{ $job->official_website }}</a></span></div>
                            @endif
                            @if($job->publish_date)
                            <div class="info-row"><span class="info-label">Notification Date</span><span class="info-value">{{ $job->publish_date->format('d F Y') }}</span></div>
                            @endif
                            @if($job->apply_start)
                            <div class="info-row"><span class="info-label">Apply Start Date</span><span class="info-value">{{ $job->apply_start->format('d F Y') }}</span></div>
                            @endif
                            @if($job->apply_end)
                            <div class="info-row"><span class="info-label">Last Date to Apply</span><span class="info-value font-weight-bold" style="color:var(--red);">{{ $job->apply_end->format('d F Y') }}</span></div>
                            @endif
                            @if($job->exam_date)
                            <div class="info-row"><span class="info-label">Exam Date</span><span class="info-value font-weight-bold">{{ $job->exam_date->format('d F Y') }}</span></div>
                            @endif
                        </div>
                    </div>

                    @if($job->description)
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-file-alt"></i><h5>Detailed Description</h5></div>
                        <div class="ic-body">
                            <div style="font-size:13px;color:var(--txt);line-height:1.75;">{!! nl2br(e($job->description)) !!}</div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 2: ELIGIBILITY
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-eligibility">
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-graduation-cap"></i><h5>Education Qualification</h5></div>
                        <div class="ic-body">
                            @if($job->qualification)
                                <p style="font-size:13px;color:var(--nv);line-height:1.7;margin:0;font-weight:600;">{{ $job->qualification }}</p>
                            @else
                                <p style="color:#9ca3af;font-size:13px;margin:0;">See official notification for details.</p>
                            @endif
                        </div>
                    </div>

                    @if($job->age_min || $job->age_max || $job->age_relaxation)
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-user"></i><h5>Age Limit</h5></div>
                        <div class="ic-body">
                            @if($job->age_min || $job->age_max)
                            <div class="info-row">
                                <span class="info-label">Age Limit</span>
                                <span class="info-value font-weight-bold">
                                    @if($job->age_min && $job->age_max) {{ $job->age_min }} – {{ $job->age_max }} Years
                                    @elseif($job->age_max) Up to {{ $job->age_max }} Years
                                    @else {{ $job->age_min }}+ Years @endif
                                </span>
                            </div>
                            @endif
                            @if($job->age_relaxation)
                            <div class="info-row">
                                <span class="info-label">Age Relaxation</span>
                                <span class="info-value">{{ $job->age_relaxation }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    @if($job->experience_required)
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-briefcase"></i><h5>Experience Required</h5></div>
                        <div class="ic-body">
                            <p style="font-size:13px;color:var(--nv);line-height:1.7;font-weight:600;margin:0;">{{ $job->experience_required }}</p>
                        </div>
                    </div>
                    @endif

                    @if(!$job->qualification && !$job->age_min && !$job->age_max && !$job->experience_required)
                    <div class="info-card">
                        <div class="ic-body text-center py-4">
                            <i class="fas fa-file-pdf fa-2x mb-3" style="color:var(--or);"></i>
                            <p style="color:var(--txt);font-size:13px;">Eligibility details are in the official notification.</p>
                            @if($job->notification_link)
                            <a href="{{ $job->notification_link }}" target="_blank" class="btn-dl-doc mt-2"><i class="fas fa-download"></i> Download Notification PDF</a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 3: SELECTION PROCESS
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-selection">
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-tasks"></i><h5>Selection Process</h5></div>
                        <div class="ic-body">
                            @if($job->selection_process && count($job->selection_process))
                            <ul class="step-list">
                                @foreach($job->selection_process as $i => $step)
                                <li>
                                    <div class="step-num">{{ $i + 1 }}</div>
                                    <div class="step-txt">{{ $step }}</div>
                                </li>
                                @endforeach
                            </ul>
                            @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-alt fa-2x mb-3" style="color:var(--or);opacity:.5;"></i>
                                <p style="color:#9ca3af;font-size:13px;">Selection process details in the official notification.</p>
                                @if($job->notification_link)
                                <a href="{{ $job->notification_link }}" target="_blank" class="btn-dl-doc"><i class="fas fa-download"></i> Download Notification</a>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($job->exam_pattern && count($job->exam_pattern))
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-clipboard"></i><h5>Exam Pattern</h5></div>
                        <div class="ic-body">
                            <div class="table-responsive">
                                <table class="fee-table">
                                    <thead><tr><th>Subject</th><th>Questions</th><th>Marks</th><th>Duration</th></tr></thead>
                                    <tbody>
                                        @foreach($job->exam_pattern as $ep)
                                        <tr>
                                            <td>{{ $ep['subject'] ?? '—' }}</td>
                                            <td>{{ $ep['questions'] ?? '—' }}</td>
                                            <td>{{ $ep['marks'] ?? '—' }}</td>
                                            <td>{{ $ep['duration'] ?? '—' }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 4: APPLICATION PROCESS
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-apply">
                    @if($job->apply_link || $job->application_mode !== 'offline')
                    <div class="text-center mb-3">
                        @if($job->apply_link)
                        <a href="{{ $job->apply_link }}" target="_blank" class="btn-dl-doc" style="font-size:14px;padding:12px 28px;">
                            <i class="fas fa-external-link-alt"></i> Apply Online Now
                        </a>
                        @endif
                        <p style="font-size:11px;color:#9ca3af;margin-top:8px;">
                            @if($job->apply_end) Application closes on <strong style="color:var(--red);">{{ $job->apply_end->format('d F Y') }}</strong> @endif
                        </p>
                    </div>
                    @endif

                    @if($job->application_steps && count($job->application_steps))
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-list-ol"></i><h5>How to Apply — Step by Step</h5></div>
                        <div class="ic-body">
                            <ul class="step-list">
                                @foreach($job->application_steps as $i => $step)
                                <li>
                                    <div class="step-num">{{ $i + 1 }}</div>
                                    <div class="step-txt">{{ $step }}</div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($job->required_documents && count($job->required_documents))
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-folder-open"></i><h5>Required Documents</h5></div>
                        <div class="ic-body">
                            <ul class="check-list">
                                @foreach($job->required_documents as $doc)
                                <li><i class="fas fa-check-circle"></i> {{ $doc }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                    @if($job->application_fee && count($job->application_fee))
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-rupee-sign"></i><h5>Application Fee</h5></div>
                        <div class="ic-body">
                            <div class="table-responsive">
                                <table class="fee-table">
                                    <thead><tr><th>Category</th><th>Amount</th></tr></thead>
                                    <tbody>
                                        @foreach($job->application_fee as $cat => $amount)
                                        <tr>
                                            <td>{{ ucwords(str_replace('_', ' ', $cat)) }}</td>
                                            <td>@if($amount == 0) Free @else ₹{{ number_format($amount) }} @endif</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Need help applying --}}
                    <div style="background:linear-gradient(135deg,var(--nv),#0d275c);border-radius:8px;padding:20px;text-align:center;margin-bottom:16px;">
                        <h5 style="font-family:'Poppins',sans-serif;font-weight:800;color:#fff;margin-bottom:6px;">
                            <i class="fas fa-hands-helping mr-2" style="color:var(--or);"></i>Need Help Filling This Form?
                        </h5>
                        <p style="color:rgba(255,255,255,.72);font-size:12px;margin-bottom:12px;">Our experts will fill the complete application for you — zero errors, zero rejections.</p>
                        <div class="d-flex justify-content-center flex-wrap" style="gap:10px;">
                            <a href="{{ route('jobs.form-help') }}" class="btn-dl-doc"><i class="fas fa-file-alt"></i> Request Form Help</a>
                            <a href="https://wa.me/91XXXXXXXXXX?text=I need help applying for {{ urlencode($job->title) }}" target="_blank" style="display:inline-flex;align-items:center;gap:6px;background:#25D366;color:#fff;font-weight:800;font-size:12px;padding:8px 18px;border-radius:4px;text-decoration:none;">
                                <i class="fab fa-whatsapp"></i> WhatsApp Us
                            </a>
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 5: IMPORTANT LINKS
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-links">
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-link"></i><h5>Important Links</h5></div>
                        <div class="ic-body">
                            <div class="links-grid">
                                @if($job->notification_link)
                                <a href="{{ $job->notification_link }}" target="_blank" class="link-btn lb-pdf">
                                    <i class="fas fa-file-pdf"></i>
                                    <span>Official<br><strong>Notification PDF</strong></span>
                                </a>
                                @endif
                                @if($job->apply_link)
                                <a href="{{ $job->apply_link }}" target="_blank" class="link-btn lb-apply">
                                    <i class="fas fa-external-link-alt"></i>
                                    <span>Apply<br><strong>Online</strong></span>
                                </a>
                                @endif
                                @if($job->official_website)
                                <a href="{{ $job->official_website }}" target="_blank" class="link-btn lb-web">
                                    <i class="fas fa-globe"></i>
                                    <span>Official<br><strong>Website</strong></span>
                                </a>
                                @endif
                                @if($job->syllabus_link)
                                <a href="{{ $job->syllabus_link }}" target="_blank" class="link-btn lb-gen">
                                    <i class="fas fa-book"></i>
                                    <span>Exam<br><strong>Syllabus PDF</strong></span>
                                </a>
                                @endif
                                @if($job->correction_form_link)
                                <a href="{{ $job->correction_form_link }}" target="_blank" class="link-btn lb-gen">
                                    <i class="fas fa-edit"></i>
                                    <span>Correction<br><strong>Form Link</strong></span>
                                </a>
                                @endif
                                @if($job->merit_list_link)
                                <a href="{{ $job->merit_list_link }}" target="_blank" class="link-btn lb-apply">
                                    <i class="fas fa-list-ol"></i>
                                    <span>Merit<br><strong>List PDF</strong></span>
                                </a>
                                @endif
                                @if($job->cutoff_link)
                                <a href="{{ $job->cutoff_link }}" target="_blank" class="link-btn lb-gen">
                                    <i class="fas fa-chart-bar"></i>
                                    <span>Cut Off<br><strong>Marks PDF</strong></span>
                                </a>
                                @endif
                                @if($job->previous_papers_link)
                                <a href="{{ $job->previous_papers_link }}" target="_blank" class="link-btn lb-pdf">
                                    <i class="fas fa-file-archive"></i>
                                    <span>Previous<br><strong>Year Papers</strong></span>
                                </a>
                                @endif
                                {{-- Additional documents --}}
                                @foreach($job->documents as $doc)
                                <a href="{{ $doc->file_url }}" target="_blank" class="link-btn lb-gen">
                                    <i class="fas fa-download"></i>
                                    <span>{{ $doc->file_size ? $doc->file_size : '' }}<br><strong>{{ $doc->title }}</strong></span>
                                </a>
                                @endforeach
                            </div>

                            @if(!$job->notification_link && !$job->apply_link && !$job->official_website && !$job->syllabus_link && $job->documents->count() == 0)
                            <div class="text-center py-4">
                                <i class="fas fa-clock fa-2x mb-3" style="color:#e5e7eb;"></i>
                                <p style="color:#9ca3af;font-size:13px;">Links will be added when officially released. Check back soon.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 6: SYLLABUS
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-syllabus">
                    @if($job->syllabus && count($job->syllabus))
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-book-open"></i><h5>Subject-Wise Syllabus</h5></div>
                        <div class="ic-body">
                            <div class="syllabus-grid">
                                @foreach($job->syllabus as $subject => $topics)
                                <div class="syl-item">
                                    <h6><i class="fas fa-bookmark"></i> {{ $subject }}</h6>
                                    <p>{{ $topics }}</p>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($job->syllabus_link)
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-file-pdf"></i><h5>Download Syllabus</h5></div>
                        <div class="ic-body text-center">
                            <a href="{{ $job->syllabus_link }}" target="_blank" class="btn-dl-doc" style="font-size:13px;padding:10px 24px;">
                                <i class="fas fa-download mr-1"></i> Download Complete Syllabus PDF
                            </a>
                        </div>
                    </div>
                    @endif

                    @if(!($job->syllabus && count($job->syllabus)) && !$job->syllabus_link)
                    <div class="info-card">
                        <div class="ic-body text-center py-5">
                            <i class="fas fa-book fa-2x mb-3" style="color:#e5e7eb;"></i>
                            <p style="color:#9ca3af;font-size:13px;">Syllabus will be added once officially released.</p>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 7: ADMIT CARDS
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-admit">
                    @forelse($job->admitCards as $card)
                    <div class="doc-card">
                        <div class="doc-info">
                            <h6>{{ $card->title }}</h6>
                            <p>
                                @if($card->release_date) Released: {{ $card->release_date->format('d M Y') }} · @endif
                                @if($card->exam_date) Exam Date: <strong>{{ $card->exam_date->format('d M Y') }}</strong> @endif
                            </p>
                            @if($card->instructions)
                            <p style="margin-top:4px;font-size:11px;color:var(--txt);">{{ $card->instructions }}</p>
                            @endif
                        </div>
                        <a href="{{ $card->download_link }}" target="_blank" class="btn-dl-doc">
                            <i class="fas fa-download"></i> Download Admit Card
                        </a>
                    </div>
                    @empty
                    <div class="info-card">
                        <div class="ic-body text-center py-5">
                            <i class="fas fa-id-card fa-2x mb-3" style="color:#e5e7eb;"></i>
                            <p style="color:#9ca3af;font-size:13px;">Admit card not released yet. Check back closer to exam date.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 8: ANSWER KEY
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-answerkey">
                    @forelse($job->answerKeys as $ak)
                    <div class="doc-card">
                        <div class="doc-info">
                            <h6>{{ $ak->title }}</h6>
                            <p>
                                @if($ak->release_date) Released: {{ $ak->release_date->format('d M Y') }} @endif
                                @if($ak->objection_end_date) · Objection Deadline: <strong style="color:var(--red);">{{ $ak->objection_end_date->format('d M Y') }}</strong> @endif
                            </p>
                            @if($ak->objection_details)
                            <p style="margin-top:4px;font-size:11px;color:var(--txt);">{{ $ak->objection_details }}</p>
                            @endif
                        </div>
                        <a href="{{ $ak->download_link }}" target="_blank" class="btn-dl-doc">
                            <i class="fas fa-download"></i> Download Answer Key
                        </a>
                    </div>
                    @empty
                    <div class="info-card">
                        <div class="ic-body text-center py-5">
                            <i class="fas fa-key fa-2x mb-3" style="color:#e5e7eb;"></i>
                            <p style="color:#9ca3af;font-size:13px;">Answer key not released yet.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 9: RESULT
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-result">
                    @forelse($job->results as $result)
                    <div class="doc-card">
                        <div class="doc-info">
                            <h6>{{ $result->title }}</h6>
                            <p>
                                @if($result->result_date) Declared: <strong>{{ $result->result_date->format('d M Y') }}</strong> @endif
                                @if($result->cutoff_marks) · Cut Off: <strong style="color:var(--or);">{{ $result->cutoff_marks }}</strong> @endif
                            </p>
                            @if($result->notes)<p style="margin-top:4px;font-size:11px;">{{ $result->notes }}</p>@endif
                        </div>
                        <div class="d-flex flex-column" style="gap:6px;">
                            <a href="{{ $result->download_link }}" target="_blank" class="btn-dl-doc">
                                <i class="fas fa-download"></i> Result PDF
                            </a>
                            @if($result->merit_list_link)
                            <a href="{{ $result->merit_list_link }}" target="_blank" class="btn-dl-outline">
                                <i class="fas fa-list-ol"></i> Merit List
                            </a>
                            @endif
                            @if($result->scorecard_link)
                            <a href="{{ $result->scorecard_link }}" target="_blank" class="btn-dl-outline">
                                <i class="fas fa-file-alt"></i> Scorecard
                            </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="info-card">
                        <div class="ic-body text-center py-5">
                            <i class="fas fa-trophy fa-2x mb-3" style="color:#e5e7eb;"></i>
                            <p style="color:#9ca3af;font-size:13px;">Result not declared yet.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 10: FAQs
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-faq">
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-question-circle"></i><h5>Frequently Asked Questions</h5></div>
                        <div class="ic-body">
                            @forelse($job->faqs as $faq)
                            <div class="faq-item">
                                <div class="faq-q"><i class="fas fa-chevron-right"></i> {{ $faq->question }}</div>
                                <div class="faq-a">{{ $faq->answer }}</div>
                            </div>
                            @empty
                            <p style="color:#9ca3af;font-size:13px;text-align:center;padding:24px 0;">No FAQs added yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- ══════════════════════════════════════════
                     PANEL 11: UPDATES / TIMELINE
                ══════════════════════════════════════════ --}}
                <div class="jd-panel" id="jdp-updates">
                    <div class="info-card">
                        <div class="ic-head"><i class="fas fa-bell"></i><h5>Recruitment Updates & Timeline</h5></div>
                        <div class="ic-body">
                            @forelse($job->updates as $upd)
                            <div class="timeline">
                                <div class="tl-item">
                                    <div class="tl-dot type-{{ $upd->type }}"></div>
                                    <div class="tl-content">
                                        <div class="tl-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $upd->update_date->format('d M Y') }}
                                            <span style="background:var(--or-bg);color:var(--or);font-size:9px;font-weight:800;padding:1px 6px;border-radius:3px;margin-left:4px;text-transform:uppercase;">{{ str_replace('_',' ',$upd->type) }}</span>
                                        </div>
                                        <h6>{{ $upd->title }}</h6>
                                        @if($upd->description)<p>{{ $upd->description }}</p>@endif
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p style="color:#9ca3af;font-size:13px;text-align:center;padding:24px 0;">No updates yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>{{-- /detail col --}}

            {{-- ── Sidebar ─────────────────────────────────── --}}
            <div class="col-lg-4 col-xl-3">

                {{-- Apply CTA --}}
                @if($job->apply_link)
                <div class="apply-cta">
                    <h6><i class="fas fa-external-link-alt mr-2"></i>Apply Online</h6>
                    <p>Last Date: @if($job->apply_end) <strong>{{ $job->apply_end->format('d M Y') }}</strong> @else See notification @endif</p>
                    <a href="{{ $job->apply_link }}" target="_blank"><i class="fas fa-external-link-alt"></i> Apply Now</a>
                </div>
                @endif

                {{-- Related Jobs --}}
                @if($relatedJobs->count())
                <div class="sb-card">
                    <div class="sb-head"><i class="fas fa-briefcase"></i><span>Related Jobs</span></div>
                    <div class="sb-body">
                        @foreach($relatedJobs as $rj)
                        <div class="rj-item">
                            <div class="rj-icon"><i class="fas fa-briefcase"></i></div>
                            <div class="rj-info">
                                <a href="{{ route('jobs.show', $rj->slug) }}">{{ $rj->title }}</a>
                                <span>{{ $rj->department }} @if($rj->apply_end) · Last Date: {{ $rj->apply_end->format('d M') }} @endif</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @include('jobs._sidebar')
            </div>

        </div>
    </div>
</section>

@push('scripts')
<script>
function jdTab(name) {
    document.querySelectorAll('.jd-tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.jd-panel').forEach(p => p.classList.remove('active'));
    event.currentTarget.classList.add('active');
    const panel = document.getElementById('jdp-' + name);
    if (panel) panel.classList.add('active');
    window.scrollTo({ top: document.querySelector('.jd-tab-nav').offsetTop - 80, behavior: 'smooth' });
}
// Open tab from URL hash e.g. /jobs/my-job#admit
const hash = location.hash.replace('#','');
const validTabs = ['overview','eligibility','selection','apply','links','syllabus','admit','answerkey','result','faq','updates'];
if (hash && validTabs.includes(hash)) {
    const btn = document.querySelector(`.jd-tab-btn[onclick*="${hash}"]`);
    if (btn) btn.click();
}
</script>
@endpush

@endsection
