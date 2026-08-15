@extends('layouts.app')

@section('title', 'Blog - Punjab Saathi')
@section('meta_description', 'Read helpful guides and news about Public services in Punjab.')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-blog.css') }}">
@endpush

@section('content')

{{-- HERO --}}
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/blog.jpg') }}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span>Blog <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">Our Blog</h1>
            </div>
        </div>
    </div>
</section>

{{-- AD SLOT: top banner, 728x90 leaderboard. Empty and invisible
     until real ad markup is dropped in — the reserved spot and its
     spacing already exist so that won't shift anything below it. --}}
<div class="container">
    <div class="psk-ad-slot mt-4" data-ad-size="728x90"><!-- ad: 728x90 --></div>
</div>

<section class="ftco-section" style="padding-top: 24px;">
    <div class="container">
        <div class="row">

            <div class="col-lg-8">

                {{-- CATEGORY PILLS --}}
                @if($categories->isNotEmpty())
                <div class="psk-blog-pills">
                    <a href="{{ route('blog.index') }}" class="psk-blog-pill active">
                        <span class="fa fa-th"></span> All
                    </a>
                    @foreach($categories as $cat)
                    <a href="{{ route('blog.category', $cat->slug) }}" class="psk-blog-pill">
                        {{ $cat->name }} <span class="badge">{{ $cat->blogs_count }}</span>
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- FEATURED POST — one post, full width, clearly bigger
                     and more prominent than the grid cards below (large
                     image, larger type, excerpt visible, explicit
                     "Featured" tag) so it reads as a distinct section
                     instead of just another card. --}}
                @php $featuredPost = $featured->first(); @endphp
                @if($featuredPost)
                <a href="{{ route('blog.show', $featuredPost->slug) }}" class="psk-featured-post">
                    <div class="psk-featured-post__img" style="background-image:url('{{ $featuredPost->featured_image ? asset('storage/'.$featuredPost->featured_image) : asset('images/image_1.jpg') }}');"></div>
                    <div class="psk-featured-post__body">
                        <span class="psk-featured-tag"><span class="fa fa-star"></span> Featured</span>
                        @if($featuredPost->category)
                        <span class="psk-featured-post__cat">{{ $featuredPost->category->name }}</span>
                        @endif
                        <h2 class="psk-featured-post__title">{{ $featuredPost->title }}</h2>
                        <p class="psk-featured-post__excerpt">{{ Str::limit($featuredPost->excerpt, 150) }}</p>
                        <div class="psk-featured-post__meta">
                            <span><span class="fa fa-calendar"></span>{{ $featuredPost->published_at?->format('d M Y') }}</span>
                            <span><span class="fa fa-clock-o"></span>{{ $featuredPost->reading_time }} min read</span>
                        </div>
                        <span class="psk-featured-post__cta">Read Full Article <span class="fa fa-arrow-right"></span></span>
                    </div>
                </a>
                @endif

                {{-- POST GRID — excludes the post already shown above as
                     featured, so the same article never appears twice on
                     one page. --}}
                @php $gridPosts = $featuredPost ? $posts->except([$featuredPost->id]) : $posts; @endphp

                <div class="psk-blog-section-head">
                    <h2>Latest Articles</h2>
                    <span class="psk-blog-count">{{ $posts->total() }} article{{ $posts->total() !== 1 ? 's' : '' }}</span>
                </div>

                @if($gridPosts->isEmpty())
                <div class="psk-blog-empty">
                    <span class="fa fa-file-text-o"></span>
                    <h5>No blog posts published yet</h5>
                    <p class="mb-0">Check back soon for helpful guides and updates.</p>
                </div>
                @else
                <div class="psk-blog-grid">
                    @foreach($gridPosts as $post)
                    <div class="psk-blog-card">
                        <a href="{{ route('blog.show', $post->slug) }}" class="psk-blog-card__img-link" aria-label="{{ $post->title }}">
                            <div class="psk-blog-card__img" style="background-image:url('{{ $post->featured_image ? asset('storage/'.$post->featured_image) : asset('images/image_1.jpg') }}');"></div>
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

                    {{-- AD SLOT: native in-feed ad every 6 posts. Empty and
                         invisible until filled — spans the full grid width
                         via CSS so it won't disturb the 2-column card
                         layout when it's populated later. --}}
                    @if($loop->iteration % 6 === 0 && !$loop->last)
                    <div class="psk-ad-slot" style="grid-column:1/-1;" data-ad-size="in-feed"><!-- ad: in-feed --></div>
                    @endif
                    @endforeach
                </div>
                @endif

                @if($posts->hasPages())
                <div class="mt-5 d-flex justify-content-center">{{ $posts->links() }}</div>
                @endif
            </div>

            {{-- SIDEBAR --}}
            @include('blogs.partials.sidebar', ['categories' => $categories, 'recent' => $recent, 'popular' => $popular])

        </div>
    </div>
</section>

@endsection
