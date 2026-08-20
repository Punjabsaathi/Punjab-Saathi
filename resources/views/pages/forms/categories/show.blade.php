@extends('layouts.app')

@section('title', ($category->meta_title ?? $category->name . ' Forms') . ' – Punjab Saathi')
@section('meta_description', $category->meta_description ?? 'Download ' . $category->name . ' forms online.')

@php
    $catTitle = ($category->meta_title ?? $category->name . ' Forms') . ' – Punjab Saathi';
    $catDesc  = $category->meta_description ?? 'Download ' . $category->name . ' forms online.';
@endphp

@push('head')
<link rel="canonical" href="{{ route('categories.show', $category->slug) }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="{{ $catTitle }}">
<meta property="og:description" content="{{ $catDesc }}">
<meta property="og:url"         content="{{ route('categories.show', $category->slug) }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $catTitle }}">
<meta name="twitter:description" content="{{ $catDesc }}">

<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Form Categories', 'url' => route('categories.index')],
    ['name' => $category->name, 'url' => route('categories.show', $category->slug)],
])) !!}</script>

@if($forms->count())
<script type="application/ld+json">{!! \App\Support\Seo::json([
    '@context' => 'https://schema.org',
    '@type'    => 'ItemList',
    'itemListElement' => collect($forms->items())->values()->map(fn ($form, $i) => [
        '@type'    => 'ListItem',
        'position' => (($forms->currentPage() - 1) * $forms->perPage()) + $i + 1,
        'url'      => route('forms.show', $form->slug),
        'name'     => $form->title,
    ])->all(),
]) !!}</script>
@endif
@endpush

@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight"
         style="background-image:url('{{ asset('images/punjab-saathi-csc-operator-helping-citizen.webp') }}');"
         data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="{{ route('categories.index') }}">Categories <i class="fa fa-chevron-right"></i></a></span>
                    @if($category->parent)
                        <span class="mr-2"><a href="{{ route('categories.show', $category->parent->slug) }}">{{ $category->parent->name }} <i class="fa fa-chevron-right"></i></a></span>
                    @endif
                    <span>{{ $category->name }} <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-3 bread">{{ $category->name }} Forms</h1>
                @if($category->description)
                    <p style="color:rgba(255,255,255,0.85);font-size:1.05rem;max-width:600px;line-height:1.7;">{{ $category->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            <div class="col-md-3 mb-5">
                <x-form-sidebar :categories="$allCategories">
                    @if($popular->isNotEmpty())
                    <div class="card border-0 shadow-sm mt-4" style="border-radius:10px;">
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

            <div class="col-md-9">

                <div class="p-4 mb-4" style="background:linear-gradient(135deg,#fc5e28,#e84b15);color:#fff;border-radius:12px;">
                    <div class="d-flex align-items-center">
                        <div class="mr-3 d-flex align-items-center justify-content-center rounded"
                             style="width:52px;height:52px;background:rgba(255,255,255,0.2);flex-shrink:0;">
                            <span class="fa fa-folder-open" style="font-size:1.6rem;"></span>
                        </div>
                        <div>
                            <h4 class="mb-1" style="font-weight:700;">{{ $category->name }}</h4>
                            <span style="font-size:0.85rem;opacity:0.9;">{{ $forms->total() }} forms available</span>
                        </div>
                    </div>
                </div>

                @if($category->children->isNotEmpty())
                <div class="mb-4">
                    @foreach($category->children as $child)
                        <a href="{{ route('categories.show', $child->slug) }}"
                           class="btn btn-sm btn-outline-secondary mr-2 mb-2" style="border-radius:20px;font-size:0.8rem;">
                            <span class="fa fa-folder-o mr-1"></span>{{ $child->name }}
                        </a>
                    @endforeach
                </div>
                @endif

                @if($forms->isEmpty())
                <div class="text-center py-5 text-muted">
                    <span class="fa fa-folder-open fa-3x mb-3 d-block" style="color:#ddd;"></span>
                    <h5>No forms yet in this category</h5>
                    <a href="{{ route('forms.index') }}" style="color:#fc5e28;">Browse all forms</a>
                </div>
                @else
                <div class="row">
                    @foreach($forms as $form)
                        <x-form-card :form="$form" />
                    @endforeach
                </div>
                <div class="mt-4">{{ $forms->links() }}</div>
                @endif

            </div>
        </div>
    </div>
</section>

@endsection