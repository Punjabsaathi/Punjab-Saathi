@extends('layouts.app')

@section('title', $category->name . ' - Blog - Punjab Saathi')
@section('meta_description', $category->description ?? 'Browse posts in ' . $category->name)

@push('head')
<link rel="canonical" href="{{ route('blog.category', $category->slug) }}{{ request('page') > 1 ? '?page='.request('page') : '' }}">
<meta name="robots" content="index, follow">

<meta property="og:type"        content="website">
<meta property="og:title"       content="{{ $category->name . ' - Blog - Punjab Saathi' }}">
<meta property="og:description" content="{{ $category->description ?? 'Browse posts in ' . $category->name }}">
<meta property="og:url"         content="{{ route('blog.category', $category->slug) }}">
<meta property="og:site_name"   content="Punjab Saathi">
<meta property="og:image"       content="{{ asset('images/og-default.jpg') }}">

<meta name="twitter:card"        content="summary_large_image">
<meta name="twitter:title"       content="{{ $category->name . ' - Blog - Punjab Saathi' }}">
<meta name="twitter:description" content="{{ $category->description ?? 'Browse posts in ' . $category->name }}">

<script type="application/ld+json">{!! \App\Support\Seo::json(\App\Support\Seo::breadcrumbSchema([
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Blog', 'url' => route('blog.index')],
    ['name' => $category->name, 'url' => route('blog.category', $category->slug)],
])) !!}</script>

@if($posts->count())
<script type="application/ld+json">{!! \App\Support\Seo::json([
    '@context' => 'https://schema.org',
    '@type'    => 'ItemList',
    'itemListElement' => collect($posts->items())->values()->map(fn ($post, $i) => [
        '@type'    => 'ListItem',
        'position' => (($posts->currentPage() - 1) * $posts->perPage()) + $i + 1,
        'url'      => route('blog.show', $post->slug),
        'name'     => $post->title,
    ])->all(),
]) !!}</script>
@endif
@endpush

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-blog.css') }}">
@endpush

@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/lpg-gas-connection-service.webp') }}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="{{ route('blog.index') }}">Blog <i class="fa fa-chevron-right"></i></a></span>
                    <span>{{ $category->name }} <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">{{ $category->name }}</h1>
            </div>
        </div>
    </div>
</section>

<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">

                @if($categories->isNotEmpty())
                <div class="psk-blog-pills">
                    <a href="{{ route('blog.index') }}" class="psk-blog-pill">
                        <span class="fa fa-th"></span> All
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat->slug) }}" class="psk-blog-pill {{ $cat->slug === $category->slug ? 'active' : '' }}">
                        {{ $cat->name }} <span class="badge">{{ $cat->blogs_count }}</span>
                    </a>
                    @endforeach
                </div>
                @endif

                <div class="psk-blog-section-head">
                    <h2>{{ $category->name }}</h2>
                    <span class="psk-blog-count">{{ $posts->total() }} article{{ $posts->total() !== 1 ? 's' : '' }}</span>
                </div>

                @if($posts->isEmpty())
                <div class="psk-blog-empty">
                    <span class="fa fa-file-text-o"></span>
                    <h5>No posts in this category yet</h5>
                    <p class="mb-0">Check back soon, or browse other categories in the sidebar.</p>
                </div>
                @else
                <div class="psk-blog-grid">
                    @foreach($posts as $post)
                    <div class="psk-blog-card">
                        <a href="{{ route('blog.show', $post->slug) }}" class="psk-blog-card__img-link" aria-label="{{ $post->title }}">
                            <div class="psk-blog-card__img" style="background-image:url('{{ $post->featured_image ? asset('storage/'.$post->featured_image) : asset('images/blog-post-default-thumbnail.webp') }}');"></div>
                        </a>
                        <div class="psk-blog-card__body">
                            @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="psk-blog-card__cat">{{ $post->category->name }}</a>
                            @endif
                            <h3 class="psk-blog-card__title">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h3>
                            <p class="psk-blog-card__excerpt">{{ Str::limit($post->excerpt, 110) }}</p>
                            <div class="psk-blog-card__footer">
                                <span class="psk-blog-card__meta">
                                    <span><span class="fa fa-calendar"></span>{{ $post->published_at?->format('d M Y') }}</span>
                                    <span><span class="fa fa-clock-o"></span>{{ $post->reading_time }} min</span>
                                </span>
                                <a href="{{ route('blog.show', $post->slug) }}" class="psk-blog-card__readmore">
                                    Read <span class="fa fa-arrow-right"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                @if($posts->hasPages())
                <div class="mt-5 d-flex justify-content-center">{{ $posts->links() }}</div>
                @endif
            </div>

            @include('blogs.partials.sidebar', compact('categories', 'recent', 'popular'))
        </div>
    </div>
</section>

@endsection
