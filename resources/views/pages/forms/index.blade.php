@extends('layouts.app')

@section('title', 'Download Government Forms – Punjab Saathi')
@section('meta_description', 'Browse and download all government forms — PAN Card, Passport, Aadhaar, Voter ID, Income Certificate and more.')

@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image:url('{{ asset('images/forms.jpg') }}');"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span>Download Forms <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-3 bread">Download Government Forms</h1>
                <p style="color:rgba(255,255,255,0.85);font-size:1.05rem;max-width:600px;line-height:1.7;">
                    Free PDF downloads — PAN Card, Passport, Aadhaar, Voter ID, Income Certificate and hundreds more.
                </p>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            {{-- Content column is first in the DOM (order-lg-2 puts it back
                 on the right on desktop) so mobile shows the actual forms
                 grid first instead of forcing a scroll past category/sort
                 filters to reach it — matches the Jobs page's column
                 order. The split also waits until "lg" (992px) instead of
                 "md" (768px), so a tablet gets the full-width layout
                 instead of squeezing a 3-column form grid into a 75%-width
                 column next to a narrow sidebar. --}}
            <div class="col-lg-9 order-lg-2">

                <form method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search forms…"
                               class="form-control" style="border-radius:25px 0 0 25px;">
                        <div class="input-group-append">
                            <button class="btn" style="background:#fc5e28;color:#fff;border-radius:0 25px 25px 0;">
                                <span class="fa fa-search"></span>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h4 class="mb-0" style="font-weight:700;">
                        @if(request('q')) Results for "{{ request('q') }}"
                        @elseif(request('category')) {{ ucwords(str_replace('-', ' ', request('category'))) }}
                        @else All Forms
                        @endif
                    </h4>
                    <small class="text-muted">{{ $forms->total() }} forms</small>
                </div>

                @if($featured->isNotEmpty() && !request()->hasAny(['q','category','sort']))
                <div class="mb-4">
                    <h5 class="mb-3" style="font-weight:700;color:#fc5e28;">
                        <span class="fa fa-star mr-2"></span>Featured Forms
                    </h5>
                    <div class="row">
                        @foreach($featured as $form)
                            <x-form-card :form="$form" />
                        @endforeach
                    </div>
                    <hr>
                </div>
                @endif

                @if($forms->isEmpty())
                <div class="text-center py-5 text-muted">
                    <span class="fa fa-search fa-3x mb-3 d-block"></span>
                    <h5>No forms found</h5>
                    <p>Try a different keyword or browse by category.</p>
                </div>
                @else
                <div class="row">
                    @foreach($forms as $form)
                        <x-form-card :form="$form" />
                    @endforeach
                </div>
                <!-- <div class="mt-4">{{ $forms->links() }}</div> -->
                @endif

            </div>

            <div class="col-lg-3 mb-5 order-lg-1">
                <x-form-sidebar :categories="$categories">

                    <div class="card border-0 shadow-sm mb-4" style="border-radius:10px;">
                        <div class="card-header font-weight-bold" style="background:#f8f9fa;font-size:0.85rem;border-radius:10px 10px 0 0;">
                            <span class="fa fa-sort mr-2" style="color:#fc5e28;"></span>Sort By
                        </div>
                        <div class="card-body p-3">
                            <form method="GET">
                                @if(request('q'))<input type="hidden" name="q" value="{{ request('q') }}">@endif
                                @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}">@endif
                                @foreach(['newest' => 'Newest First', 'popular' => 'Most Downloaded', 'az' => 'A – Z'] as $val => $label)
                                <div class="custom-control custom-radio py-1">
                                    <input type="radio" id="sort_{{ $val }}" name="sort" value="{{ $val }}"
                                           class="custom-control-input"
                                           {{ request('sort', 'newest') === $val ? 'checked' : '' }}
                                           onchange="this.form.submit()">
                                    <label class="custom-control-label" for="sort_{{ $val }}" style="font-size:0.85rem;">{{ $label }}</label>
                                </div>
                                @endforeach
                            </form>
                        </div>
                    </div>

                    @if($popular->isNotEmpty())
                    <div class="card border-0 shadow-sm" style="border-radius:10px;">
                        <div class="card-header text-white font-weight-bold" style="background:#fc5e28;border-radius:10px 10px 0 0;font-size:0.85rem;">
                            <span class="fa fa-fire mr-2"></span>Most Downloaded
                        </div>
                        <div class="card-body p-2">
                            <ul class="list-unstyled mb-0">
                                @foreach($popular as $pf)
                                <li class="py-2" style="border-bottom:1px solid #f5f5f5;">
                                    <a href="{{ route('forms.show', $pf->slug) }}" class="text-dark" style="font-size:0.82rem;text-decoration:none;">
                                        <span class="fa fa-download mr-1" style="color:#fc5e28;"></span>
                                        {{ \Illuminate\Support\Str::limit($pf->title, 45) }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif

                </x-form-sidebar>
            </div>
        </div>
    </div>
</section>

{{-- Floating WhatsApp Button --}}
<a href="https://wa.me/917710556330"
    target="_blank"
    rel="noopener"
    title="Chat with Punjab Saathi on WhatsApp"
    style="position:fixed;bottom:24px;right:24px;z-index:9999;background:#25D366;color:#fff;width:58px;height:58px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.7rem;box-shadow:0 4px 18px rgba(37,211,102,0.45);text-decoration:none;">
    <span class="fa fa-whatsapp"></span>
</a>

@endsection