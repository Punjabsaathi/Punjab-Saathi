@extends('layouts.app')

@section('title', 'Form Categories – Punjab Seva Kendra')
@section('meta_description', 'Browse all government form categories — PAN Card, Passport, Aadhaar, Voter ID, Income Certificate and more.')

@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image:url('{{ asset('images/bg_1.jpg') }}');"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span>Form Categories <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-3 bread">Browse Form Categories</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">

        <div class="row justify-content-center mb-5">
            <div class="col-md-8 text-center heading-section ftco-animate">
                <span class="subheading">All Categories</span>
                <h2 class="mb-3">Government Form Categories</h2>
                <p class="text-muted">{{ $categories->count() }} categories available</p>
            </div>
        </div>

        <div class="row">
            @foreach($categories as $cat)
            <div class="col-md-4 col-sm-6 ftco-animate mb-4">
                <a href="{{ route('categories.show', $cat->slug) }}" style="text-decoration:none;">
                    <div class="card border-0 shadow-sm h-100" style="border-radius:12px;transition:all .2s;"
                         onmouseover="this.style.transform='translateY(-4px)'"
                         onmouseout="this.style.transform=''">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center mb-3">
                                <div class="mr-3 d-flex align-items-center justify-content-center rounded"
                                     style="width:50px;height:50px;background:{{ $cat->color }}20;flex-shrink:0;">
                                    <span class="fa fa-folder-open" style="color:{{ $cat->color }};font-size:1.4rem;"></span>
                                </div>
                                <div>
                                    <h5 class="mb-0 text-dark" style="font-weight:700;font-size:1rem;">{{ $cat->name }}</h5>
                                    <small class="text-muted">{{ $cat->forms_count }} forms</small>
                                </div>
                            </div>
                            @if($cat->description)
                                <p class="text-muted mb-2" style="font-size:0.83rem;line-height:1.6;">
                                    {{ \Illuminate\Support\Str::limit($cat->description, 90) }}
                                </p>
                            @endif
                            @if($cat->children->isNotEmpty())
                            <div style="border-top:1px solid #f0f0f0;padding-top:8px;margin-top:8px;">
                                @foreach($cat->children->take(4) as $child)
                                    <span class="badge badge-light mr-1 mb-1" style="font-size:0.73rem;">{{ $child->name }}</span>
                                @endforeach
                                @if($cat->children->count() > 4)
                                    <span class="badge badge-light mb-1" style="font-size:0.73rem;">+{{ $cat->children->count() - 4 }} more</span>
                                @endif
                            </div>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3 px-4">
                            <span style="color:#fc5e28;font-size:0.82rem;font-weight:600;">
                                View Forms <span class="fa fa-arrow-right ml-1"></span>
                            </span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>

    </div>
</section>

@endsection