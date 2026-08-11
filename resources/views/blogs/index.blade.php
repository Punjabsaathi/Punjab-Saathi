        @extends('layouts.app')

        @section('title', 'Blog - Punjab Seva Kendra')
        @section('meta_description', 'Read helpful guides and news about government services in Punjab.')

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
        <section class="ftco-section bg-light">
            <div class="container">
                <div class="row">

                    {{-- POSTS GRID --}}
                    <div class="col-lg-8">
                        <div class="row">
                            @forelse($posts as $post)
                            <div class="col-md-6 ftco-animate mb-4">
                                <div class="blog-entry bg-white shadow-sm h-100" style="border-radius:8px;overflow:hidden;">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="block-20 d-block"
                                    style="background-image:url('{{ $post->featured_image ? asset('storage/'.$post->featured_image) : asset('images/image_1.jpg') }}');height:200px;background-size:cover;background-position:center;">
                                    </a>
                                    <div class="text p-4">
                                        @if($post->category)
                                        <a href="{{ route('blog.category', $post->category->slug) }}"
                                        class="badge badge-primary mb-2" style="font-size:11px;">
                                            {{ $post->category->name }}
                                        </a>
                                        @endif
                                        <div class="meta mb-2">
                                            <span class="mr-3 text-muted small">
                                                <i class="fa fa-calendar mr-1"></i>
                                                {{ $post->published_at?->format('d M Y') }}
                                            </span>
                                            <span class="text-muted small">
                                                <i class="fa fa-clock-o mr-1"></i>
                                                {{ $post->reading_time }} min read
                                            </span>
                                        </div>
                                        <h3 class="heading mb-2" style="font-size:17px;">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="text-dark">
                                                {{ $post->title }}
                                            </a>
                                        </h3>
                                        <p class="text-muted small mb-3">{{ Str::limit($post->excerpt, 100) }}</p>
                                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-secondary btn-sm">
                                            Read More <i class="fa fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if($loop->iteration % 6 === 0 && !$loop->last)
                            <div class="col-12 my-3 text-center">
                                <div style="background:#f0f0f0;border:2px dashed #ccc;padding:15px;">
                                    <span class="text-muted small">Advertisement - 728x90</span>
                                </div>
                            </div>
                            @endif

                            @empty
                            <div class="col-12">
                                <p class="text-center text-muted py-5">No blog posts published yet.</p>
                            </div>
                            @endforelse
                        </div>

                        <div class="mt-4">{{ $posts->links() }}</div>
                    </div>

                    {{-- SIDEBAR --}}
                    @include('blogs.partials.sidebar', ['categories' => $categories, 'recent' => $recent, 'popular' => $popular])

                </div>
            </div>
        </section>

        @endsection
