@extends('layouts.app')

@section('title', 'Sarkari Naukri | Punjab Seva Kendra')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
/* ═══════════════════════════════════════════════
   ROOT VARIABLES
═══════════════════════════════════════════════ */
:root {
  --orange:      #fc5e28;
  --orange-dark: #e04d1c;
  --orange-light:rgba(252,94,40,.10);
  --navy:        #040e26;
  --gray-50:     #f8f9fb;
  --gray-100:    #f0f2f5;
  --gray-200:    #e4e7ec;
  --gray-400:    #9ca3af;
  --gray-600:    #4b5563;
  --gray-800:    #1f2937;
  --green:       #16a34a;
  --green-bg:    #dcfce7;
  --blue:        #1d4ed8;
  --blue-bg:     #dbeafe;
  --red:         #dc2626;
  --red-bg:      #fee2e2;
  --font-head:   'Poppins', sans-serif;
  --font-body:   'Nunito', sans-serif;
  --radius:      6px;
  --radius-lg:   10px;
  --shadow:      0 2px 10px rgba(4,14,38,.10);
  --shadow-sm:   0 1px 3px rgba(4,14,38,.08);
}

/* ── Page Hero ───────────────────────────── */
.sn-hero {
  background: linear-gradient(135deg, var(--navy) 0%, #0d275c 60%, #112278 100%);
  padding: 40px 0 28px;
  position: relative;
  overflow: hidden;
}
.sn-hero::before {
  content: '';
  position: absolute; inset: 0;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
}
.sn-hero .breadcrumb { background: transparent; padding: 0; margin-bottom: 10px; }
.sn-hero .breadcrumb-item a { color: var(--orange); }
.sn-hero .breadcrumb-item.active { color: rgba(255,255,255,.6); }
.sn-hero .breadcrumb-item + .breadcrumb-item::before { color: rgba(255,255,255,.4); }
.sn-hero h1 { font-family: var(--font-head); font-size: 2rem; font-weight: 800; color: #fff; margin-bottom: 6px; }
.sn-hero p { color: rgba(255,255,255,.72); font-size: 14px; margin: 0; }
.hero-stat-pill {
  display: inline-flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,.10); border: 1px solid rgba(255,255,255,.18);
  border-radius: 20px; padding: 5px 14px;
  font-size: 12px; font-weight: 700; color: rgba(255,255,255,.85);
}
.hero-stat-pill .num { color: var(--orange); font-size: 15px; }

/* ── Live Ticker ─────────────────────────── */
.sn-ticker {
  display: flex; align-items: center; overflow: hidden;
  height: 38px; background: #fff; border-bottom: 1px solid var(--gray-200);
}
.ticker-label {
  background: var(--orange); color: #fff;
  font-weight: 800; font-size: 11px; letter-spacing: 1px; text-transform: uppercase;
  padding: 0 14px; height: 38px;
  display: flex; align-items: center; gap: 6px;
  white-space: nowrap; flex-shrink: 0;
}
.ticker-dot { width: 7px; height: 7px; background: #fff; border-radius: 50%; animation: bpulse 1s infinite; }
@keyframes bpulse { 0%,100%{opacity:1}50%{opacity:.3} }
.ticker-track { flex: 1; overflow: hidden; }
.ticker-inner {
  display: flex; align-items: center; white-space: nowrap;
  height: 38px; animation: tickerScroll 45s linear infinite;
}
.ticker-inner:hover { animation-play-state: paused; }
@keyframes tickerScroll { 0%{transform:translateX(0)}100%{transform:translateX(-50%)} }
.ticker-item { display: inline-flex; align-items: center; gap: 6px; padding: 0 28px; font-size: 13px; font-weight: 600; color: var(--navy); }
.ticker-item a { color: var(--navy); }
.ticker-item a:hover { color: var(--orange); }
.ticker-badge { font-size: 9px; font-weight: 800; letter-spacing: 1px; padding: 1px 6px; border-radius: 3px; text-transform: uppercase; flex-shrink: 0; }
.tb-job    { background: var(--red-bg); color: var(--red); }
.tb-admit  { background: var(--blue-bg); color: var(--blue); }
.tb-result { background: var(--green-bg); color: var(--green); }

/* ── Tab Navigation ──────────────────────── */
.sn-tab-nav {
  display: flex; flex-wrap: wrap;
  background: #fff; border-radius: var(--radius-lg);
  box-shadow: var(--shadow); overflow: hidden;
  margin-bottom: 20px;
}
.sn-tab-btn {
  flex: 1; min-width: 110px; display: flex;
  flex-direction: column; align-items: center; justify-content: center;
  padding: 14px 10px; border: none; background: transparent;
  cursor: pointer; font-family: var(--font-head);
  font-weight: 700; font-size: 12px; color: var(--gray-600);
  letter-spacing: .3px; border-bottom: 3px solid transparent;
  transition: all .2s; gap: 5px; text-transform: uppercase;
}
.sn-tab-btn i { font-size: 16px; }
.sn-tab-btn:hover { color: var(--orange); background: var(--orange-light); }
.sn-tab-btn.active { color: var(--orange); border-bottom-color: var(--orange); background: var(--orange-light); }
.sn-tab-count {
  background: var(--orange); color: #fff;
  font-size: 9px; font-weight: 800;
  padding: 1px 6px; border-radius: 10px; margin-left: 4px;
}

/* ── Tab Panels ──────────────────────────── */
.sn-panel { display: none; }
.sn-panel.active { display: block; }

/* ── Filter Bar ──────────────────────────── */
.sn-filter {
  background: #fff; border-radius: var(--radius-lg);
  box-shadow: var(--shadow-sm); padding: 14px 16px;
  margin-bottom: 14px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center;
}
.sn-search {
  flex: 1; min-width: 180px; display: flex; align-items: center;
  border: 1px solid var(--gray-200); border-radius: var(--radius); overflow: hidden;
}
.sn-search i { padding: 0 10px; color: var(--gray-400); font-size: 13px; flex-shrink: 0; }
.sn-search input {
  border: none; outline: none; flex: 1; padding: 8px 10px 8px 0;
  font-size: 13px; font-family: var(--font-body); color: var(--gray-800); background: transparent;
}
.sn-select {
  border: 1px solid var(--gray-200); border-radius: var(--radius);
  padding: 8px 12px; font-size: 13px; font-family: var(--font-body);
  background: #fff; cursor: pointer; outline: none; min-width: 140px; color: var(--gray-800);
}
.sn-filter-count { margin-left: auto; color: var(--gray-400); font-size: 12px; font-weight: 600; white-space: nowrap; }
.btn-clr {
  background: var(--gray-100); border: 1px solid var(--gray-200);
  color: var(--gray-600); font-size: 12px; font-weight: 700;
  padding: 7px 12px; border-radius: var(--radius); cursor: pointer; white-space: nowrap;
}
.btn-clr:hover { background: var(--gray-200); }

/* ── Category Pills ──────────────────────── */
.cat-pills { display: flex; flex-wrap: wrap; gap: 7px; margin-bottom: 14px; }
.cat-pill {
  display: inline-flex; align-items: center; gap: 4px;
  padding: 5px 13px; border-radius: 20px; border: 2px solid var(--gray-200);
  background: #fff; font-size: 12px; font-weight: 700; color: var(--gray-600);
  cursor: pointer; transition: all .15s; white-space: nowrap;
}
.cat-pill:hover, .cat-pill.active { border-color: var(--orange); background: var(--orange); color: #fff; }
.cat-pill .cnt { background: rgba(0,0,0,.12); padding: 0 5px; border-radius: 10px; font-size: 10px; }

/* ── Table Card ──────────────────────────── */
.sn-table-card {
  background: #fff; border-radius: var(--radius-lg);
  box-shadow: var(--shadow); overflow: hidden; margin-bottom: 16px;
}
.sn-card-head {
  display: flex; align-items: center; justify-content: space-between;
  padding: 12px 16px; background: var(--navy); flex-wrap: wrap; gap: 8px;
}
.sn-card-head h5 {
  font-family: var(--font-head); font-weight: 700;
  font-size: 13px; color: #fff; margin: 0;
  display: flex; align-items: center; gap: 8px;
}
.sn-card-head h5 i { color: var(--orange); }
.sn-card-hint { color: rgba(255,255,255,.5); font-size: 11px; }

table.sn-table { width: 100%; border-collapse: collapse; }
table.sn-table thead th {
  background: var(--gray-100); color: var(--navy);
  font-family: var(--font-head); font-weight: 700;
  font-size: 11px; text-transform: uppercase; letter-spacing: .5px;
  padding: 10px 12px; white-space: nowrap;
  border-bottom: 2px solid var(--gray-200);
}
table.sn-table tbody tr { border-bottom: 1px solid #f5f6f8; transition: background .15s; }
table.sn-table tbody tr:hover { background: #fafbfd; }
table.sn-table tbody td { padding: 12px; vertical-align: middle; font-size: 13px; }
table.sn-table tbody tr:last-child { border-bottom: none; }

.job-title { font-family: var(--font-head); font-weight: 700; color: var(--navy); font-size: 13px; line-height: 1.3; }
.job-title a { color: var(--navy); }
.job-title a:hover { color: var(--orange); }
.job-dept { color: var(--gray-400); font-size: 11px; margin-top: 2px; }
.badge-new {
  display: inline-block; background: var(--red-bg); color: var(--red);
  font-size: 9px; font-weight: 800; letter-spacing: 1px;
  padding: 1px 6px; border-radius: 3px; text-transform: uppercase;
  vertical-align: middle; margin-left: 5px;
  animation: nblink 1.5s ease-in-out infinite;
}
@keyframes nblink { 0%,100%{opacity:1}50%{opacity:.4} }
.vacancy-num { font-family: var(--font-head); font-weight: 800; color: var(--orange); font-size: 15px; text-align: center; }
.cat-badge { background: var(--orange-light); color: var(--orange); font-size: 10px; font-weight: 800; padding: 2px 10px; border-radius: 12px; white-space: nowrap; }
.date-urgent { color: var(--red); font-weight: 700; font-size: 12px; }
.date-normal { color: var(--gray-600); font-weight: 700; font-size: 12px; }
.date-dash   { color: var(--gray-400); font-size: 12px; }

.s-badge { display: inline-flex; align-items: center; gap: 4px; font-size: 10px; font-weight: 800; letter-spacing: .5px; text-transform: uppercase; padding: 3px 10px; border-radius: 12px; white-space: nowrap; }
.s-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; display: inline-block; }
.s-active   { background: var(--green-bg); color: var(--green); }   .s-active::before   { background: var(--green); }
.s-upcoming { background: var(--blue-bg);  color: var(--blue); }    .s-upcoming::before  { background: var(--blue); }
.s-expired  { background: var(--gray-100); color: var(--gray-600); } .s-expired::before  { background: var(--gray-400); }

.sn-actions { display: flex; flex-wrap: wrap; gap: 5px; justify-content: center; }
.btn-view, .btn-apply, .btn-dl {
  display: inline-flex; align-items: center; gap: 4px;
  font-size: 11px; font-weight: 700; padding: 5px 11px;
  border-radius: 4px; border: none; cursor: pointer; text-decoration: none; white-space: nowrap;
}
.btn-view  { background: var(--navy); color: #fff; transition: background .15s; }
.btn-view:hover  { background: var(--orange); color: #fff; text-decoration: none; }
.btn-apply { background: var(--orange); color: #fff; transition: background .15s; }
.btn-apply:hover { background: var(--orange-dark); color: #fff; text-decoration: none; }
.btn-dl    { background: transparent; color: var(--orange); border: 1.5px solid var(--orange); transition: all .15s; }
.btn-dl:hover    { background: var(--orange); color: #fff; text-decoration: none; }

/* ── Pagination ──────────────────────────── */
.sn-pagination {
  display: flex; justify-content: center; gap: 5px; flex-wrap: wrap;
  padding: 14px 16px; background: var(--gray-50); border-top: 1px solid var(--gray-200);
}
.pg-btn {
  width: 34px; height: 34px; border-radius: var(--radius);
  border: 1px solid var(--gray-200); background: #fff; color: var(--gray-600);
  font-size: 12px; font-weight: 700; cursor: pointer;
  transition: all .15s; display: flex; align-items: center; justify-content: center;
}
.pg-btn:hover { border-color: var(--orange); color: var(--orange); }
.pg-btn.active { background: var(--orange); border-color: var(--orange); color: #fff; }
.pg-btn.wide { width: auto; padding: 0 12px; }
.pg-btn:disabled { opacity: .4; cursor: not-allowed; }

/* ── Loading / Empty ─────────────────────── */
.sn-loading { text-align: center; padding: 40px !important; }
.sn-spinner {
  width: 32px; height: 32px;
  border: 3px solid var(--gray-200); border-top-color: var(--orange);
  border-radius: 50%; animation: spin .8s linear infinite; margin: 0 auto 10px;
}
@keyframes spin { to { transform: rotate(360deg); } }
.sn-empty { text-align: center; padding: 48px 20px; }
.sn-empty i { font-size: 40px; color: var(--gray-200); margin-bottom: 12px; }
.sn-empty p { color: var(--gray-400); font-size: 13px; }

/* ── Sidebar ─────────────────────────────── */
.sn-sidebar-card { background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); overflow: hidden; margin-bottom: 16px; }
.sn-sidebar-head { background: var(--navy); padding: 10px 14px; display: flex; align-items: center; gap: 8px; }
.sn-sidebar-head i { color: var(--orange); font-size: 13px; }
.sn-sidebar-head span { font-family: var(--font-head); font-weight: 700; font-size: 12px; color: #fff; text-transform: uppercase; letter-spacing: .5px; }
.sn-sidebar-body { padding: 12px 14px; }
.stat-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.stat-box { background: var(--gray-50); border: 1px solid var(--gray-200); border-radius: var(--radius); padding: 10px; text-align: center; }
.stat-box .num { font-family: var(--font-head); font-weight: 800; color: var(--orange); font-size: 20px; line-height: 1; }
.stat-box .lbl { font-size: 10px; font-weight: 700; color: var(--gray-400); text-transform: uppercase; letter-spacing: .5px; margin-top: 3px; }
.sn-cat-list { list-style: none; padding: 0; margin: 0; }
.sn-cat-list li a { display: flex; justify-content: space-between; align-items: center; padding: 8px 0; border-bottom: 1px solid #f5f6f8; font-size: 12px; font-weight: 700; color: var(--navy); transition: color .15s; }
.sn-cat-list li a:hover { color: var(--orange); text-decoration: none; }
.sn-cat-list li a .cnt { background: var(--orange-light); color: var(--orange); font-size: 10px; font-weight: 800; padding: 1px 7px; border-radius: 10px; }
.sn-latest-list { list-style: none; padding: 0; margin: 0; }
.sn-latest-list li { padding: 8px 0; border-bottom: 1px solid #f5f6f8; }
.sn-latest-list li:last-child { border-bottom: none; }
.sn-latest-list li a { font-size: 12px; font-weight: 600; color: var(--navy); line-height: 1.4; display: block; }
.sn-latest-list li a:hover { color: var(--orange); text-decoration: none; }
.sn-latest-list li .meta { font-size: 10px; color: var(--gray-400); margin-top: 2px; }
.wa-cta { background: linear-gradient(135deg, #25D366, #1da851); border-radius: var(--radius-lg); padding: 16px; text-align: center; margin-bottom: 16px; }
.wa-cta i { font-size: 28px; color: #fff; margin-bottom: 6px; display: block; }
.wa-cta h6 { font-family: var(--font-head); font-weight: 800; color: #fff; margin-bottom: 4px; }
.wa-cta p { font-size: 11px; color: rgba(255,255,255,.85); margin-bottom: 10px; }
.wa-cta a { display: inline-flex; align-items: center; gap: 6px; background: #fff; color: #25D366; font-weight: 800; font-size: 12px; padding: 8px 18px; border-radius: 20px; }
.wa-cta a:hover { text-decoration: none; transform: translateY(-1px); }

/* ── Modal ───────────────────────────────── */
.modal-header { background: var(--navy); }
.modal-title { font-family: var(--font-head); font-weight: 700; font-size: 15px; color: #fff; }
.modal-header .close { color: #fff; opacity: .8; }
.modal-header .close:hover { opacity: 1; }
.dl-section { margin-bottom: 16px; }
.dl-section h6 { font-family: var(--font-head); font-weight: 700; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: var(--orange); border-bottom: 1px solid var(--gray-200); padding-bottom: 6px; margin-bottom: 10px; }
.dl-row { display: flex; padding: 7px 0; border-bottom: 1px solid #f8f9fb; font-size: 13px; }
.dl-lbl { width: 38%; color: var(--gray-600); font-weight: 700; flex-shrink: 0; }
.dl-val { flex: 1; color: var(--navy); font-weight: 600; }
.dl-btns { display: flex; flex-wrap: wrap; gap: 8px; }

/* ── Form Help ───────────────────────────── */
.form-card { background: #fff; border-radius: var(--radius-lg); box-shadow: var(--shadow); overflow: hidden; }
.form-card-head { background: var(--navy); padding: 16px 20px; }
.form-card-head h5 { font-family: var(--font-head); font-weight: 800; color: #fff; margin: 0 0 4px; font-size: 15px; }
.form-card-head p { color: rgba(255,255,255,.65); font-size: 12px; margin: 0; }
.form-card-body { padding: 20px; }
.form-card .form-group label { font-weight: 700; font-size: 12px; color: var(--navy); text-transform: uppercase; letter-spacing: .3px; margin-bottom: 5px; }
.form-card .form-group .req { color: var(--orange); }
.form-card .form-control { border: 1px solid var(--gray-200); border-radius: var(--radius); font-size: 13px; padding: 9px 13px; transition: border-color .2s; }
.form-card .form-control:focus { border-color: var(--orange); box-shadow: 0 0 0 3px rgba(252,94,40,.12); outline: none; }
.btn-submit-form { width: 100%; background: var(--orange); color: #fff; font-family: var(--font-head); font-weight: 800; font-size: 14px; padding: 12px; border: none; border-radius: var(--radius); cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: background .2s; }
.btn-submit-form:hover { background: var(--orange-dark); }
.btn-submit-form:disabled { opacity: .7; cursor: not-allowed; }
.why-list { list-style: none; padding: 0; margin: 0; }
.why-list li { display: flex; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f5f6f8; font-size: 13px; color: var(--gray-600); }
.why-list li i { color: var(--green); font-size: 14px; flex-shrink: 0; margin-top: 1px; }
.form-success { text-align: center; padding: 36px 20px; }
.form-success .ok-icon { width: 64px; height: 64px; background: var(--green-bg); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; }
.form-success .ok-icon i { font-size: 28px; color: var(--green); }
.form-success h5 { font-family: var(--font-head); font-weight: 800; color: var(--navy); margin-bottom: 8px; }

/* ── WhatsApp Float ──────────────────────── */
.wa-float {
  position: fixed; bottom: 24px; right: 24px;
  width: 52px; height: 52px; background: #25D366;
  border-radius: 50%; display: flex; align-items: center; justify-content: center;
  box-shadow: 0 4px 16px rgba(37,211,102,.45);
  z-index: 9999; transition: transform .2s; font-size: 24px; color: #fff;
}
.wa-float:hover { transform: scale(1.1); color: #fff; }

/* ── Responsive ──────────────────────────── */
@media (max-width:768px) {
  .sn-hero h1 { font-size: 1.5rem; }
  .sn-tab-btn { font-size: 10px; padding: 10px 6px; min-width: 80px; }
  table.sn-table thead th:nth-child(3),
  table.sn-table tbody td:nth-child(3),
  table.sn-table thead th:nth-child(4),
  table.sn-table tbody td:nth-child(4),
  table.sn-table thead th:nth-child(5),
  table.sn-table tbody td:nth-child(5) { display: none; }
}
</style>
@endpush

@section('content')

{{-- ── Page Hero ─────────────────────────── --}}
<section class="sn-hero">
  <div class="container" style="position:relative;z-index:1;">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
        <li class="breadcrumb-item active">Sarkari Naukri</li>
      </ol>
    </nav>
    <h1><i class="fas fa-briefcase mr-2" style="color:var(--orange);"></i>Latest Sarkari Naukri Alerts</h1>
    <p>PSSSB · Punjab Police · SSC · RRB · Banking · NHM — All Punjab Government Jobs at One Place</p>
    <div class="d-flex flex-wrap mt-3" style="gap:10px;">
      <div class="hero-stat-pill"><span class="num" id="statTotal">—</span>&nbsp;Total Jobs</div>
      <div class="hero-stat-pill"><span class="num" id="statActive">—</span>&nbsp;Active</div>
      <div class="hero-stat-pill"><span class="num" id="statUpcoming">—</span>&nbsp;Upcoming</div>
      <div class="hero-stat-pill"><span class="num" id="statCards">—</span>&nbsp;Admit Cards</div>
      <div class="hero-stat-pill"><span class="num" id="statResults">—</span>&nbsp;Results</div>
      <div class="hero-stat-pill"><span class="num" id="statAK">—</span>&nbsp;Answer Keys</div>
    </div>
  </div>
</section>

{{-- ── Live Ticker ──────────────────────── --}}
<div class="sn-ticker">
  <div class="ticker-label">
    <div class="ticker-dot"></div>
    <i class="fas fa-bell" style="font-size:11px;"></i>
    LIVE UPDATES
  </div>
  <div class="ticker-track">
    <div class="ticker-inner" id="tickerInner">
      <span class="ticker-item" style="color:var(--gray-400);"><i class="fas fa-circle-notch fa-spin"></i>&nbsp;Loading latest updates...</span>
    </div>
  </div>
</div>

{{-- ── Main Content ─────────────────────── --}}
<section class="py-4">
  <div class="container-fluid">
    <div class="row">

      {{-- ── SIDEBAR ── --}}
      <div class="col-lg-3 col-xl-2 order-lg-2 mb-4">

        <div class="wa-cta">
          <i class="fab fa-whatsapp"></i>
          <h6>Need Form Help?</h6>
          <p>We fill your govt job form — zero errors, zero rejections</p>
          <a href="https://wa.me/91XXXXXXXXXX" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp Us</a>
        </div>

        <div class="sn-sidebar-card">
          <div class="sn-sidebar-head"><i class="fas fa-chart-bar"></i><span>Statistics</span></div>
          <div class="sn-sidebar-body">
            <div class="stat-grid">
              <div class="stat-box"><div class="num" id="sTotal">—</div><div class="lbl">Total</div></div>
              <div class="stat-box"><div class="num" id="sActive">—</div><div class="lbl">Active</div></div>
              <div class="stat-box"><div class="num" id="sUpcoming">—</div><div class="lbl">Upcoming</div></div>
              <div class="stat-box"><div class="num" id="sCards">—</div><div class="lbl">Admit Cards</div></div>
            </div>
          </div>
        </div>

        <div class="sn-sidebar-card">
          <div class="sn-sidebar-head"><i class="fas fa-th-large"></i><span>Categories</span></div>
          <div class="sn-sidebar-body">
            <ul class="sn-cat-list" id="catSidebarList">
              <li><a href="#"><i class="fas fa-circle-notch fa-spin" style="color:var(--gray-400);font-size:11px;"></i></a></li>
            </ul>
          </div>
        </div>

        <div class="sn-sidebar-card">
          <div class="sn-sidebar-head"><i class="fas fa-clock"></i><span>Recent Jobs</span></div>
          <div class="sn-sidebar-body">
            <ul class="sn-latest-list" id="sidebarLatest">
              <li><a href="#"><i class="fas fa-circle-notch fa-spin" style="color:var(--gray-400);font-size:11px;"></i></a></li>
            </ul>
          </div>
        </div>

      </div>

      {{-- ── MAIN AREA ── --}}
      <div class="col-lg-9 col-xl-10 order-lg-1">

        {{-- Tab Buttons --}}
        <div class="sn-tab-nav">
          <button class="sn-tab-btn active" data-tab="jobs" onclick="switchTab('jobs')">
            <i class="fas fa-briefcase"></i> Job Alerts
            <span class="sn-tab-count" id="tcJobs">0</span>
          </button>
          <button class="sn-tab-btn" data-tab="admitCards" onclick="switchTab('admitCards')">
            <i class="fas fa-id-card"></i> Admit Cards
            <span class="sn-tab-count" id="tcAdmit">0</span>
          </button>
          <button class="sn-tab-btn" data-tab="results" onclick="switchTab('results')">
            <i class="fas fa-trophy"></i> Results
            <span class="sn-tab-count" id="tcResults">0</span>
          </button>
          <button class="sn-tab-btn" data-tab="answerKeys" onclick="switchTab('answerKeys')">
            <i class="fas fa-key"></i> Answer Keys
            <span class="sn-tab-count" id="tcAK">0</span>
          </button>
          <button class="sn-tab-btn" data-tab="formHelp" onclick="switchTab('formHelp')">
            <i class="fas fa-file-alt"></i> Form Help
          </button>
        </div>

        {{-- ──────────────────────────────────────
             PANEL: JOB ALERTS
        ────────────────────────────────────── --}}
        <div class="sn-panel active" id="panel-jobs">

          {{-- Category Pills --}}
          <div class="cat-pills" id="catPills">
            <span class="cat-pill active" data-cat="" onclick="filterCat(this,'')">All Categories</span>
          </div>

          {{-- Filter Bar --}}
          <div class="sn-filter">
            <div class="sn-search">
              <i class="fas fa-search"></i>
              <input type="search" id="jobSearch" placeholder="Search by title or department..." oninput="debounce(loadJobs,400)()">
            </div>
            <select class="sn-select" id="jobStatus" onchange="loadJobs()">
              <option value="">All Status</option>
              <option value="active">Active</option>
              <option value="upcoming">Upcoming</option>
              <option value="expired">Expired</option>
            </select>
            <button class="btn-clr" onclick="clearJobFilters()"><i class="fas fa-times mr-1"></i>Clear</button>
            <span class="sn-filter-count" id="jobTotal">Loading...</span>
          </div>

          {{-- Table --}}
          <div class="sn-table-card">
            <div class="sn-card-head">
              <h5><i class="fas fa-list-ul"></i> Latest Government Job Notifications</h5>
              <span class="sn-card-hint"><i class="fas fa-info-circle mr-1"></i>Click "View" for full details</span>
            </div>
            <div class="table-responsive">
              <table class="sn-table">
                <thead>
                  <tr>
                    <th style="min-width:220px;">Post Name / Department</th>
                    <th style="text-align:center;">Vacancies</th>
                    <th style="text-align:center;">Category</th>
                    <th style="text-align:center;">Apply Start</th>
                    <th style="text-align:center;">Last Date</th>
                    <th style="text-align:center;">Status</th>
                    <th style="text-align:center;min-width:180px;">Actions</th>
                  </tr>
                </thead>
                <tbody id="jobTableBody">
                  <tr><td colspan="7" class="sn-loading"><div class="sn-spinner"></div>Loading jobs...</td></tr>
                </tbody>
              </table>
            </div>
            <div class="sn-pagination" id="jobPagination" style="display:none;"></div>
          </div>
        </div>{{-- /panel-jobs --}}

        {{-- ──────────────────────────────────────
             PANEL: ADMIT CARDS
        ────────────────────────────────────── --}}
        <div class="sn-panel" id="panel-admitCards">
          <div class="sn-filter">
            <div class="sn-search">
              <i class="fas fa-search"></i>
              <input type="search" id="admitSearch" placeholder="Search admit cards..." oninput="debounce(loadAdmitCards,400)()">
            </div>
            <button class="btn-clr" onclick="document.getElementById('admitSearch').value='';loadAdmitCards()"><i class="fas fa-times mr-1"></i>Clear</button>
            <span class="sn-filter-count" id="admitTotal">Loading...</span>
          </div>
          <div class="sn-table-card">
            <div class="sn-card-head">
              <h5><i class="fas fa-id-card"></i> Admit Cards / Hall Tickets</h5>
              <span class="sn-card-hint"><i class="fas fa-download mr-1"></i>Download your hall ticket</span>
            </div>
            <div class="table-responsive">
              <table class="sn-table">
                <thead>
                  <tr>
                    <th style="min-width:220px;">Admit Card Title</th>
                    <th>For Job Post</th>
                    <th style="text-align:center;">Release Date</th>
                    <th style="text-align:center;">Exam Date</th>
                    <th style="text-align:center;">Download</th>
                  </tr>
                </thead>
                <tbody id="admitTableBody">
                  <tr><td colspan="5" class="sn-loading"><div class="sn-spinner"></div>Loading...</td></tr>
                </tbody>
              </table>
            </div>
            <div class="sn-pagination" id="admitPagination" style="display:none;"></div>
          </div>
        </div>

        {{-- ──────────────────────────────────────
             PANEL: RESULTS
        ────────────────────────────────────── --}}
        <div class="sn-panel" id="panel-results">
          <div class="sn-filter">
            <div class="sn-search">
              <i class="fas fa-search"></i>
              <input type="search" id="resultSearch" placeholder="Search results..." oninput="debounce(loadResults,400)()">
            </div>
            <button class="btn-clr" onclick="document.getElementById('resultSearch').value='';loadResults()"><i class="fas fa-times mr-1"></i>Clear</button>
            <span class="sn-filter-count" id="resultTotal">Loading...</span>
          </div>
          <div class="sn-table-card">
            <div class="sn-card-head">
              <h5><i class="fas fa-trophy"></i> Exam Results</h5>
            </div>
            <div class="table-responsive">
              <table class="sn-table">
                <thead>
                  <tr>
                    <th style="min-width:220px;">Result Title</th>
                    <th>For Job Post</th>
                    <th style="text-align:center;">Result Date</th>
                    <th style="text-align:center;">Cut Off Marks</th>
                    <th style="text-align:center;">Download</th>
                  </tr>
                </thead>
                <tbody id="resultTableBody">
                  <tr><td colspan="5" class="sn-loading"><div class="sn-spinner"></div>Loading...</td></tr>
                </tbody>
              </table>
            </div>
            <div class="sn-pagination" id="resultPagination" style="display:none;"></div>
          </div>
        </div>

        {{-- ──────────────────────────────────────
             PANEL: ANSWER KEYS
        ────────────────────────────────────── --}}
        <div class="sn-panel" id="panel-answerKeys">
          <div class="sn-filter">
            <div class="sn-search">
              <i class="fas fa-search"></i>
              <input type="search" id="akSearch" placeholder="Search answer keys..." oninput="debounce(loadAnswerKeys,400)()">
            </div>
            <button class="btn-clr" onclick="document.getElementById('akSearch').value='';loadAnswerKeys()"><i class="fas fa-times mr-1"></i>Clear</button>
            <span class="sn-filter-count" id="akTotal">Loading...</span>
          </div>
          <div class="sn-table-card">
            <div class="sn-card-head">
              <h5><i class="fas fa-key"></i> Official Answer Keys</h5>
            </div>
            <div class="table-responsive">
              <table class="sn-table">
                <thead>
                  <tr>
                    <th style="min-width:220px;">Answer Key Title</th>
                    <th>For Job Post</th>
                    <th style="text-align:center;">Release Date</th>
                    <th style="text-align:center;">Objection Deadline</th>
                    <th style="text-align:center;">Download</th>
                  </tr>
                </thead>
                <tbody id="akTableBody">
                  <tr><td colspan="5" class="sn-loading"><div class="sn-spinner"></div>Loading...</td></tr>
                </tbody>
              </table>
            </div>
            <div class="sn-pagination" id="akPagination" style="display:none;"></div>
          </div>
        </div>

        {{-- ──────────────────────────────────────
             PANEL: FORM HELP
        ────────────────────────────────────── --}}
        <div class="sn-panel" id="panel-formHelp">
          <div class="row">
            <div class="col-md-7 mb-4">
              <div class="form-card">
                <div class="form-card-head">
                  <h5><i class="fas fa-file-alt mr-2"></i>Request Form Filling Assistance</h5>
                  <p>Fill the details below — we will call you back within a few hours.</p>
                </div>
                <div class="form-card-body" id="formBody">
                  <form id="helpForm" novalidate>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Full Name <span class="req">*</span></label>
                          <input type="text" class="form-control" id="fName" placeholder="Your full name" required>
                          <div class="invalid-feedback">Minimum 2 characters required.</div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Mobile Number <span class="req">*</span></label>
                          <input type="tel" class="form-control" id="fPhone" placeholder="10-digit mobile number" required>
                          <div class="invalid-feedback">Enter a valid 10-digit number.</div>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Service Required <span class="req">*</span></label>
                      <select class="form-control" id="fService" required>
                        <option value="">-- Select a service --</option>
                        <option value="job_form">Government Job Form Filling</option>
                        <option value="admit_card">Admit Card Download Help</option>
                        <option value="result">Result Check Help</option>
                        <option value="answer_key">Answer Key Assistance</option>
                        <option value="other">Other / General Query</option>
                      </select>
                      <div class="invalid-feedback">Please select a service.</div>
                    </div>
                    <div class="form-group">
                      <label>Job Name <small class="text-muted font-weight-normal">(Optional)</small></label>
                      <input type="text" class="form-control" id="fJobName" placeholder="e.g. PSSSB Clerk, Punjab Police Constable">
                    </div>
                    <div class="form-group">
                      <label>Message <small class="text-muted font-weight-normal">(Optional)</small></label>
                      <textarea class="form-control" id="fMessage" rows="3" placeholder="Any additional details..."></textarea>
                    </div>
                    <button type="submit" class="btn-submit-form" id="submitBtn">
                      <i class="fas fa-paper-plane mr-2"></i>Submit Request
                    </button>
                    <p id="formErrMsg" style="color:var(--red);font-size:12px;margin-top:10px;display:none;"></p>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="sn-sidebar-card mb-3">
                <div class="sn-sidebar-head"><i class="fas fa-star"></i><span>Why Choose Us</span></div>
                <div class="sn-sidebar-body">
                  <ul class="why-list">
                    <li><i class="fas fa-check-circle"></i>100% accurate form filling — zero rejections</li>
                    <li><i class="fas fa-check-circle"></i>Eligibility verification before applying</li>
                    <li><i class="fas fa-check-circle"></i>Complete document review included</li>
                    <li><i class="fas fa-check-circle"></i>WhatsApp support throughout process</li>
                    <li><i class="fas fa-check-circle"></i>Affordable &amp; transparent pricing</li>
                    <li><i class="fas fa-check-circle"></i>5000+ successful applications filed</li>
                  </ul>
                </div>
              </div>
              <div class="wa-cta">
                <i class="fab fa-whatsapp"></i>
                <h6>Prefer Talking Directly?</h6>
                <p>Call or WhatsApp us — we respond within minutes</p>
                <a href="https://wa.me/91XXXXXXXXXX" target="_blank"><i class="fab fa-whatsapp"></i> Chat on WhatsApp</a>
              </div>
            </div>
          </div>
        </div>

      </div>{{-- /col main --}}
    </div>{{-- /row --}}
  </div>
</section>

{{-- ── Job Detail Modal ─────────────────── --}}
<div class="modal fade" id="jobModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Job Details</h5>
        <button type="button" class="close" data-dismiss="modal"><span style="color:#fff;">&times;</span></button>
      </div>
      <div class="modal-body" id="modalBody">
        <div class="text-center p-4"><div class="sn-spinner"></div></div>
      </div>
    </div>
  </div>
</div>

{{-- WhatsApp Float --}}
<a href="https://wa.me/91XXXXXXXXXX" target="_blank" class="wa-float" title="WhatsApp Us">
  <i class="fab fa-whatsapp"></i>
</a>

@endsection

@push('scripts')
<script>
/* ─────────────────────────────────────────────
   CONFIG  ← paste your Replit API URL here
───────────────────────────────────────────── */
const API = '{{ $apiUrl }}';
const LIMIT = 15;

/* ─────────────────────────────────────────────
   STATE
───────────────────────────────────────────── */
const S = {
  jobs:       { page:0, search:'', status:'', category:'' },
  admitCards: { page:0, search:'' },
  results:    { page:0, search:'' },
  answerKeys: { page:0, search:'' },
};
let categories = [];
let dtimers = {};

/* ─────────────────────────────────────────────
   HELPERS
───────────────────────────────────────────── */
function debounce(fn, ms) {
  return function() {
    clearTimeout(dtimers[fn.name]);
    dtimers[fn.name] = setTimeout(fn, ms);
  };
}
function esc(s) {
  return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function isNew(d)    { return d && (Date.now()-new Date(d).getTime())/(864e5) <= 10; }
function isUrgent(d) { if(!d)return false; const diff=(new Date(d)-Date.now())/864e5; return diff>=0&&diff<=7; }
function fmtDate(s) {
  if(!s) return '<span class="date-dash">—</span>';
  const cls = isUrgent(s) ? 'date-urgent' : 'date-normal';
  return `<span class="${cls}">${esc(s)}${isUrgent(s)?' <i class="fas fa-fire" title="Closing soon!"></i>':''}</span>`;
}
function sBadge(status) {
  const m = {active:'s-active',upcoming:'s-upcoming',expired:'s-expired'};
  const l = {active:'Active',upcoming:'Upcoming',expired:'Expired'};
  return `<span class="s-badge ${m[status]||'s-expired'}">${l[status]||status}</span>`;
}
function empty(id, cols, msg) {
  document.getElementById(id).innerHTML =
    `<tr><td colspan="${cols}"><div class="sn-empty"><i class="fas fa-search"></i><p>${msg||'No records found.'}</p></div></td></tr>`;
}
function renderPager(id, page, total, fn) {
  const pages = Math.ceil(total/LIMIT);
  const el = document.getElementById(id);
  if(pages<=1){el.style.display='none';return;}
  el.style.display='flex';
  let h = `<button class="pg-btn wide" onclick="${fn}(${page-1})" ${page===0?'disabled':''}><i class="fas fa-chevron-left"></i> Prev</button>`;
  const s=Math.max(0,page-2), e=Math.min(pages,s+5);
  for(let i=s;i<e;i++) h+=`<button class="pg-btn${i===page?' active':''}" onclick="${fn}(${i})">${i+1}</button>`;
  h+=`<button class="pg-btn wide" onclick="${fn}(${page+1})" ${page>=pages-1?'disabled':''}>Next <i class="fas fa-chevron-right"></i></button>`;
  el.innerHTML=h;
}

/* ─────────────────────────────────────────────
   TAB SWITCHING
───────────────────────────────────────────── */
function switchTab(tab) {
  document.querySelectorAll('.sn-tab-btn').forEach(b=>b.classList.remove('active'));
  document.querySelectorAll('.sn-panel').forEach(p=>p.classList.remove('active'));
  document.querySelector(`[data-tab="${tab}"]`).classList.add('active');
  document.getElementById(`panel-${tab}`).classList.add('active');
  // lazy-load
  if(tab==='admitCards' && document.getElementById('admitTableBody').innerHTML.includes('Loading')) loadAdmitCards(0);
  if(tab==='results'    && document.getElementById('resultTableBody').innerHTML.includes('Loading')) loadResults(0);
  if(tab==='answerKeys' && document.getElementById('akTableBody').innerHTML.includes('Loading')) loadAnswerKeys(0);
  window.scrollTo({top:document.querySelector('.sn-tab-nav').offsetTop-80,behavior:'smooth'});
}

/* ─────────────────────────────────────────────
   STATS
───────────────────────────────────────────── */
async function loadStats() {
  try {
    const d = await (await fetch(`${API}/stats`)).json();
    document.getElementById('statTotal').textContent   = d.totalJobs??0;
    document.getElementById('statActive').textContent  = d.activeJobs??0;
    document.getElementById('statUpcoming').textContent= d.upcomingJobs??0;
    document.getElementById('statCards').textContent   = d.totalAdmitCards??0;
    document.getElementById('statResults').textContent = d.totalResults??0;
    document.getElementById('statAK').textContent      = d.totalAnswerKeys??0;
    document.getElementById('sTotal').textContent      = d.totalJobs??0;
    document.getElementById('sActive').textContent     = d.activeJobs??0;
    document.getElementById('sUpcoming').textContent   = d.upcomingJobs??0;
    document.getElementById('sCards').textContent      = d.totalAdmitCards??0;
    document.getElementById('tcAdmit').textContent     = d.totalAdmitCards??0;
    document.getElementById('tcResults').textContent   = d.totalResults??0;
    document.getElementById('tcAK').textContent        = d.totalAnswerKeys??0;
  } catch(e){}
}

/* ─────────────────────────────────────────────
   CATEGORIES
───────────────────────────────────────────── */
async function loadCategories() {
  try {
    categories = await (await fetch(`${API}/categories`)).json();
    const pills = document.getElementById('catPills');
    categories.forEach(c => {
      const el = document.createElement('span');
      el.className='cat-pill'; el.dataset.cat=c.slug;
      el.innerHTML=`${esc(c.name)} <span class="cnt">${c.jobCount}</span>`;
      el.onclick=function(){ filterCat(this,c.slug); };
      pills.appendChild(el);
    });
    document.getElementById('catSidebarList').innerHTML =
      categories.map(c=>`<li><a href="#" onclick="filterCat(null,'${esc(c.slug)}');switchTab('jobs');return false;">${esc(c.name)}<span class="cnt">${c.jobCount}</span></a></li>`).join('');
  } catch(e){}
}

/* ─────────────────────────────────────────────
   JOB ALERTS
───────────────────────────────────────────── */
function filterCat(el, cat) {
  S.jobs.category=cat; S.jobs.page=0;
  document.querySelectorAll('.cat-pill').forEach(p=>p.classList.remove('active'));
  (el || document.querySelector(`.cat-pill[data-cat="${cat}"]`) || document.querySelector('.cat-pill[data-cat=""]')).classList.add('active');
  loadJobs();
}
function clearJobFilters() {
  document.getElementById('jobSearch').value='';
  document.getElementById('jobStatus').value='';
  S.jobs={page:0,search:'',status:'',category:''};
  document.querySelectorAll('.cat-pill').forEach(p=>p.classList.remove('active'));
  document.querySelector('.cat-pill[data-cat=""]').classList.add('active');
  loadJobs();
}
async function loadJobs(page) {
  if(page!==undefined) S.jobs.page=page;
  S.jobs.search=document.getElementById('jobSearch')?.value||'';
  S.jobs.status=document.getElementById('jobStatus')?.value||'';
  const tbody=document.getElementById('jobTableBody');
  tbody.innerHTML='<tr><td colspan="7" class="sn-loading"><div class="sn-spinner"></div>Loading jobs...</td></tr>';
  const p=new URLSearchParams({limit:LIMIT,offset:S.jobs.page*LIMIT,...(S.jobs.search?{search:S.jobs.search}:{}),...(S.jobs.status?{status:S.jobs.status}:{}),...(S.jobs.category?{category:S.jobs.category}:{})});
  try {
    const {data:jobs,total}=await (await fetch(`${API}/jobs?${p}`)).json();
    document.getElementById('jobTotal').textContent=`${total} job${total!==1?'s':''} found`;
    document.getElementById('tcJobs').textContent=total;
    if(!jobs?.length){empty('jobTableBody',7,'No jobs found. Try adjusting your filters.');document.getElementById('jobPagination').style.display='none';return;}
    tbody.innerHTML=jobs.map(j=>`
      <tr>
        <td>
          <div class="job-title"><a href="#" onclick="viewJob('${esc(j.slug)}');return false;">${esc(j.title)}</a>${isNew(j.createdAt)?'<span class="badge-new">NEW</span>':''}</div>
          <div class="job-dept"><i class="fas fa-building" style="font-size:10px;margin-right:3px;"></i>${esc(j.department)}</div>
        </td>
        <td><div class="vacancy-num">${j.totalPosts}</div></td>
        <td style="text-align:center;"><span class="cat-badge">${esc(j.categoryName)}</span></td>
        <td>${fmtDate(j.applyStart)}</td>
        <td>${fmtDate(j.applyEnd)}</td>
        <td style="text-align:center;">${sBadge(j.status)}</td>
        <td>
          <div class="sn-actions">
            <button class="btn-view" onclick="viewJob('${esc(j.slug)}')"><i class="fas fa-eye"></i> View</button>
            ${j.applyLink?`<a href="${esc(j.applyLink)}" target="_blank" class="btn-apply"><i class="fas fa-external-link-alt"></i> Apply</a>`:''}
            ${j.notificationLink?`<a href="${esc(j.notificationLink)}" target="_blank" class="btn-dl"><i class="fas fa-file-pdf"></i> Notif</a>`:''}
          </div>
        </td>
      </tr>`).join('');
    renderPager('jobPagination',S.jobs.page,total,'loadJobs');
    // update sidebar recent
    document.getElementById('sidebarLatest').innerHTML=jobs.slice(0,5).map(j=>`
      <li><a href="#" onclick="viewJob('${esc(j.slug)}');return false;">${esc(j.title)}</a>
      <div class="meta"><i class="fas fa-calendar" style="font-size:9px;margin-right:3px;"></i>${j.applyEnd?'Last Date: '+j.applyEnd:j.status}</div></li>`).join('');
  } catch(e){tbody.innerHTML=`<tr><td colspan="7" class="sn-loading"><i class="fas fa-exclamation-triangle" style="color:var(--red);"></i> Failed to load. <button onclick="loadJobs()" style="background:none;border:none;color:var(--orange);font-weight:700;cursor:pointer;">Retry</button></td></tr>`;}
}

/* ─────────────────────────────────────────────
   JOB MODAL
───────────────────────────────────────────── */
async function viewJob(slug) {
  $('#jobModal').modal('show');
  document.getElementById('modalTitle').textContent='Loading...';
  document.getElementById('modalBody').innerHTML='<div class="text-center p-4"><div class="sn-spinner"></div></div>';
  try {
    const r=await fetch(`${API}/jobs/${encodeURIComponent(slug)}`);
    if(!r.ok)throw 0;
    const{job,admitCards,results,answerKeys}=await r.json();
    document.getElementById('modalTitle').innerHTML=`<i class="fas fa-briefcase mr-2" style="color:var(--orange);"></i>${esc(job.title)}`;
    let h=`
      <div class="dl-section"><h6><i class="fas fa-info-circle mr-1"></i>Job Details</h6>
        <div class="dl-row"><span class="dl-lbl">Department</span><span class="dl-val">${esc(job.department)}</span></div>
        <div class="dl-row"><span class="dl-lbl">Category</span><span class="dl-val">${esc(job.categoryName)}</span></div>
        <div class="dl-row"><span class="dl-lbl">Total Vacancies</span><span class="dl-val" style="color:var(--orange);font-size:16px;font-weight:800;">${job.totalPosts}</span></div>
        ${job.qualification?`<div class="dl-row"><span class="dl-lbl">Qualification</span><span class="dl-val">${esc(job.qualification)}</span></div>`:''}
        ${(job.ageMin||job.ageMax)?`<div class="dl-row"><span class="dl-lbl">Age Limit</span><span class="dl-val">${job.ageMin?job.ageMin+' – ':'Up to '}${job.ageMax} years</span></div>`:''}
        <div class="dl-row"><span class="dl-lbl">Status</span><span class="dl-val">${sBadge(job.status)}</span></div>
      </div>
      <div class="dl-section"><h6><i class="fas fa-calendar mr-1"></i>Important Dates</h6>
        <div class="dl-row"><span class="dl-lbl">Apply Start</span><span class="dl-val">${job.applyStart||'—'}</span></div>
        <div class="dl-row"><span class="dl-lbl">Last Date to Apply</span><span class="dl-val" style="color:var(--red);font-weight:800;">${job.applyEnd||'—'}</span></div>
        <div class="dl-row"><span class="dl-lbl">Exam Date</span><span class="dl-val">${job.examDate||'—'}</span></div>
      </div>`;
    if(job.notificationLink||job.applyLink||job.syllabusLink){
      h+=`<div class="dl-section"><h6><i class="fas fa-download mr-1"></i>Download Links</h6><div class="dl-btns">
        ${job.notificationLink?`<a href="${esc(job.notificationLink)}" target="_blank" class="btn-dl"><i class="fas fa-file-pdf"></i> Notification PDF</a>`:''}
        ${job.applyLink?`<a href="${esc(job.applyLink)}" target="_blank" class="btn-apply"><i class="fas fa-external-link-alt"></i> Apply Online</a>`:''}
        ${job.syllabusLink?`<a href="${esc(job.syllabusLink)}" target="_blank" class="btn-dl"><i class="fas fa-book"></i> Syllabus</a>`:''}
      </div></div>`;
    }
    if(admitCards?.length) h+=`<div class="dl-section"><h6><i class="fas fa-id-card mr-1"></i>Admit Cards</h6>${admitCards.map(a=>`<div class="dl-row"><span class="dl-lbl">${esc(a.title)}<br><small style="color:var(--gray-400);">Exam: ${a.examDate||'—'}</small></span><span class="dl-val"><a href="${esc(a.downloadLink)}" target="_blank" class="btn-dl" style="font-size:11px;"><i class="fas fa-download"></i> Download</a></span></div>`).join('')}</div>`;
    if(results?.length)    h+=`<div class="dl-section"><h6><i class="fas fa-trophy mr-1"></i>Results</h6>${results.map(r=>`<div class="dl-row"><span class="dl-lbl">${esc(r.title)}<br><small style="color:var(--gray-400);">Cut Off: ${r.cutOffMarks||'—'}</small></span><span class="dl-val"><a href="${esc(r.downloadLink)}" target="_blank" class="btn-dl" style="font-size:11px;"><i class="fas fa-download"></i> Download</a></span></div>`).join('')}</div>`;
    if(answerKeys?.length) h+=`<div class="dl-section"><h6><i class="fas fa-key mr-1"></i>Answer Keys</h6>${answerKeys.map(a=>`<div class="dl-row"><span class="dl-lbl">${esc(a.title)}<br><small style="color:var(--red);font-weight:700;">Objection Deadline: ${a.objectionEndDate||'—'}</small></span><span class="dl-val"><a href="${esc(a.downloadLink)}" target="_blank" class="btn-dl" style="font-size:11px;"><i class="fas fa-download"></i> Download</a></span></div>`).join('')}</div>`;
    h+=`<div class="text-center mt-3"><button onclick="switchTab('formHelp');$('#jobModal').modal('hide');document.getElementById('fJobName').value='${esc(job.title)}';" class="btn-apply" style="font-size:13px;padding:10px 22px;"><i class="fas fa-file-alt mr-1"></i> Need Help Applying? Get Form Help</button></div>`;
    document.getElementById('modalBody').innerHTML=h;
  } catch(e){document.getElementById('modalBody').innerHTML='<p class="text-center text-muted p-4">Failed to load job details. Please try again.</p>';}
}

/* ─────────────────────────────────────────────
   ADMIT CARDS
───────────────────────────────────────────── */
async function loadAdmitCards(page) {
  if(page!==undefined) S.admitCards.page=page;
  S.admitCards.search=document.getElementById('admitSearch')?.value||'';
  const tbody=document.getElementById('admitTableBody');
  tbody.innerHTML='<tr><td colspan="5" class="sn-loading"><div class="sn-spinner"></div>Loading...</td></tr>';
  const p=new URLSearchParams({limit:LIMIT,offset:S.admitCards.page*LIMIT,...(S.admitCards.search?{search:S.admitCards.search}:{})});
  try {
    const{data,total}=await (await fetch(`${API}/admit-cards?${p}`)).json();
    document.getElementById('admitTotal').textContent=`${total} found`;
    document.getElementById('tcAdmit').textContent=total;
    if(!data?.length){empty('admitTableBody',5,'No admit cards found.');document.getElementById('admitPagination').style.display='none';return;}
    tbody.innerHTML=data.map(a=>`<tr><td><div class="job-title">${esc(a.title)}</div></td><td><a href="#" onclick="viewJob('${esc(a.jobSlug)}');return false;" style="font-size:12px;font-weight:700;color:var(--orange);">${esc(a.jobTitle)}</a></td><td style="text-align:center;font-size:12px;">${a.releaseDate||'—'}</td><td style="text-align:center;font-size:12px;font-weight:700;">${a.examDate||'—'}</td><td style="text-align:center;"><a href="${esc(a.downloadLink)}" target="_blank" class="btn-apply"><i class="fas fa-download"></i> Download</a></td></tr>`).join('');
    renderPager('admitPagination',S.admitCards.page,total,'loadAdmitCards');
  } catch(e){empty('admitTableBody',5,'Failed to load. Please retry.');}
}

/* ─────────────────────────────────────────────
   RESULTS
───────────────────────────────────────────── */
async function loadResults(page) {
  if(page!==undefined) S.results.page=page;
  S.results.search=document.getElementById('resultSearch')?.value||'';
  const tbody=document.getElementById('resultTableBody');
  tbody.innerHTML='<tr><td colspan="5" class="sn-loading"><div class="sn-spinner"></div>Loading...</td></tr>';
  const p=new URLSearchParams({limit:LIMIT,offset:S.results.page*LIMIT,...(S.results.search?{search:S.results.search}:{})});
  try {
    const{data,total}=await (await fetch(`${API}/results?${p}`)).json();
    document.getElementById('resultTotal').textContent=`${total} found`;
    document.getElementById('tcResults').textContent=total;
    if(!data?.length){empty('resultTableBody',5,'No results declared yet.');document.getElementById('resultPagination').style.display='none';return;}
    tbody.innerHTML=data.map(r=>`<tr><td><div class="job-title">${esc(r.title)}</div></td><td><a href="#" onclick="viewJob('${esc(r.jobSlug)}');return false;" style="font-size:12px;font-weight:700;color:var(--orange);">${esc(r.jobTitle)}</a></td><td style="text-align:center;font-size:12px;">${r.resultDate||'—'}</td><td style="text-align:center;font-size:12px;font-weight:700;">${r.cutOffMarks?esc(r.cutOffMarks):'—'}</td><td style="text-align:center;"><a href="${esc(r.downloadLink)}" target="_blank" class="btn-apply"><i class="fas fa-download"></i> Download</a></td></tr>`).join('');
    renderPager('resultPagination',S.results.page,total,'loadResults');
  } catch(e){empty('resultTableBody',5,'Failed to load.');}
}

/* ─────────────────────────────────────────────
   ANSWER KEYS
───────────────────────────────────────────── */
async function loadAnswerKeys(page) {
  if(page!==undefined) S.answerKeys.page=page;
  S.answerKeys.search=document.getElementById('akSearch')?.value||'';
  const tbody=document.getElementById('akTableBody');
  tbody.innerHTML='<tr><td colspan="5" class="sn-loading"><div class="sn-spinner"></div>Loading...</td></tr>';
  const p=new URLSearchParams({limit:LIMIT,offset:S.answerKeys.page*LIMIT,...(S.answerKeys.search?{search:S.answerKeys.search}:{})});
  try {
    const{data,total}=await (await fetch(`${API}/answer-keys?${p}`)).json();
    document.getElementById('akTotal').textContent=`${total} found`;
    document.getElementById('tcAK').textContent=total;
    if(!data?.length){empty('akTableBody',5,'No answer keys released yet.');document.getElementById('akPagination').style.display='none';return;}
    tbody.innerHTML=data.map(a=>`<tr><td><div class="job-title">${esc(a.title)}</div></td><td><a href="#" onclick="viewJob('${esc(a.jobSlug)}');return false;" style="font-size:12px;font-weight:700;color:var(--orange);">${esc(a.jobTitle)}</a></td><td style="text-align:center;font-size:12px;">${a.releaseDate||'—'}</td><td style="text-align:center;font-size:12px;font-weight:700;color:var(--red);">${a.objectionEndDate||'—'}</td><td style="text-align:center;"><a href="${esc(a.downloadLink)}" target="_blank" class="btn-apply"><i class="fas fa-download"></i> Download</a></td></tr>`).join('');
    renderPager('akPagination',S.answerKeys.page,total,'loadAnswerKeys');
  } catch(e){empty('akTableBody',5,'Failed to load.');}
}

/* ─────────────────────────────────────────────
   TICKER
───────────────────────────────────────────── */
async function loadTicker() {
  try {
    const[j,a,r]=await Promise.all([
      fetch(`${API}/jobs?limit=8&status=active`).then(r=>r.json()),
      fetch(`${API}/admit-cards?limit=4`).then(r=>r.json()),
      fetch(`${API}/results?limit=4`).then(r=>r.json()),
    ]);
    let items='';
    (j.data||[]).forEach(x=>{ items+=`<span class="ticker-item"><span class="ticker-badge tb-job">JOBS</span><a href="#" onclick="viewJob('${esc(x.slug)}');return false;">${esc(x.title)}</a>${x.applyEnd?` — Last Date: <b style="color:var(--red)">${x.applyEnd}</b>`:''}</span><span style="color:var(--gray-200);padding:0 4px;font-size:18px;">|</span>`; });
    (a.data||[]).forEach(x=>{ items+=`<span class="ticker-item"><span class="ticker-badge tb-admit">ADMIT</span><a href="#" onclick="switchTab('admitCards');return false;">${esc(x.title)}</a></span><span style="color:var(--gray-200);padding:0 4px;font-size:18px;">|</span>`; });
    (r.data||[]).forEach(x=>{ items+=`<span class="ticker-item"><span class="ticker-badge tb-result">RESULT</span><a href="#" onclick="switchTab('results');return false;">${esc(x.title)}</a></span><span style="color:var(--gray-200);padding:0 4px;font-size:18px;">|</span>`; });
    if(items) document.getElementById('tickerInner').innerHTML=items+items;
  } catch(e){}
}

/* ─────────────────────────────────────────────
   FORM SUBMIT
───────────────────────────────────────────── */
document.getElementById('helpForm')?.addEventListener('submit', async function(e) {
  e.preventDefault();
  const name=document.getElementById('fName').value.trim();
  const phone=document.getElementById('fPhone').value.trim();
  const service=document.getElementById('fService').value;
  const jobName=document.getElementById('fJobName').value.trim();
  const message=document.getElementById('fMessage').value.trim();
  const errEl=document.getElementById('formErrMsg');
  let ok=true;
  if(!name||name.length<2){document.getElementById('fName').classList.add('is-invalid');ok=false;}else{document.getElementById('fName').classList.remove('is-invalid');}
  if(!phone||phone.replace(/\D/g,'').length<10){document.getElementById('fPhone').classList.add('is-invalid');ok=false;}else{document.getElementById('fPhone').classList.remove('is-invalid');}
  if(!service){document.getElementById('fService').classList.add('is-invalid');ok=false;}else{document.getElementById('fService').classList.remove('is-invalid');}
  if(!ok)return;
  const btn=document.getElementById('submitBtn');
  btn.disabled=true; btn.innerHTML='<i class="fas fa-circle-notch fa-spin mr-2"></i>Submitting...'; errEl.style.display='none';
  try {
    const res=await fetch(`${API}/form-help`,{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name,phone,serviceType:service,jobName:jobName||undefined,message:message||undefined})});
    if(!res.ok)throw 0;
    document.getElementById('formBody').innerHTML=`<div class="form-success"><div class="ok-icon"><i class="fas fa-check"></i></div><h5>Request Received!</h5><p>We've received your request, <strong>${esc(name)}</strong>.<br>Our team will call you on <strong>${esc(phone)}</strong> within a few hours.</p><button onclick="location.reload()" class="btn-submit-form" style="width:auto;padding:10px 28px;margin-top:10px;">Submit Another Request</button></div>`;
  } catch(err) {
    errEl.textContent='Something went wrong. Please WhatsApp us directly.'; errEl.style.display='block';
    btn.disabled=false; btn.innerHTML='<i class="fas fa-paper-plane mr-2"></i>Submit Request';
  }
});

/* ─────────────────────────────────────────────
   INIT — run on tab switch from URL hash
───────────────────────────────────────────── */
(async function init() {
  await Promise.all([loadStats(), loadCategories()]);
  loadJobs(0);
  loadTicker();
  // Support ?tab=admitCards etc. from dropdown links
  const tabParam = new URLSearchParams(location.search).get('tab');
  if(tabParam && ['jobs','admitCards','results','answerKeys','formHelp'].includes(tabParam)) {
    switchTab(tabParam);
  }
})();
</script>
@endpush
