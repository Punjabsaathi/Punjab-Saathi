@extends('layouts.app')

@section('title', $category->name . ' - Blog - Punjab Seva Kendra')
@section('meta_description', $category->description ?? 'Browse posts in ' . $category->name)

@section('content')

<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ asset('images/bg_1.jpg') }}');" data-stellar-background-ratio="0.5">
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

<section class="ftco-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    @forelse($posts as $post)
                    <div class="col-md-6 ftco-animate mb-4">
                        <div class="blog-entry bg-white shadow-sm h-100" style="border-radius:8px;overflow:hidden;">
                            <a href="{{ route('blog.show', $post->slug) }}" class="block-20 d-block"
                               style="background-image:url('{{ $post->featured_image ? asset('storage/'.$post->featured_image) : asset('images/image_1.jpg') }}');height:200px;background-size:cover;background-position:center;"></a>
                            <div class="text p-4">
                                <div class="meta mb-2">
                                    <span class="text-muted small">
                                        <i class="fa fa-calendar mr-1"></i>{{ $post->published_at?->format('d M Y') }}
                                    </span>
                                </div>
                                <h3 class="heading mb-2" style="font-size:17px;">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-dark">{{ $post->title }}</a>
                                </h3>
                                <p class="text-muted small mb-3">{{ Str::limit($post->excerpt, 100) }}</p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-secondary btn-sm">Read More</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12">
                        <p class="text-center text-muted py-5">No posts in this category yet.</p>
                    </div>
                    @endforelse
                </div>
                <div class="mt-4">{{ $posts->links() }}</div>
            </div>

            @include('blogs.partials.sidebar', compact('categories', 'recent', 'popular'))
        </div>
    </div>
</section>

@endsection
