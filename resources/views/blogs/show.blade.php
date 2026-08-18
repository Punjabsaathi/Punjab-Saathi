@extends('layouts.app')

@section('title', $post->seo_title . ' - Punjab Saathi')
@section('meta_description', $post->seo_description)

@push('head')
<link rel="canonical" href="{{ $post->canonical_url ?: route('blog.show', $post->slug) }}">
<meta property="og:title" content="{{ $post->seo_title }}">
<meta property="og:description" content="{{ $post->seo_description }}">
<meta property="og:type" content="article">
<meta property="og:url" content="{{ route('blog.show', $post->slug) }}">
@if($post->featured_image)
<meta property="og:image" content="{{ asset('storage/'.$post->featured_image) }}">
@endif

@php
    $articleJson = json_encode([
        '@context'      => 'https://schema.org',
        '@type'         => 'Article',
        'headline'      => $post->title,
        'description'   => $post->seo_description,
        'datePublished' => $post->published_at?->toIso8601String(),
        'dateModified'  => $post->updated_at->toIso8601String(),
        'author'        => ['@type' => 'Person', 'name' => $post->author?->name ?? 'Punjab Saathi'],
        'publisher'     => ['@type' => 'Organization', 'name' => 'Punjab Saathi', 'url' => url('/')],
    ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $faqJson = null;
    if ($post->schema_faq && is_array($post->schema_faq) && count($post->schema_faq)) {
        $faqJson = json_encode([
            '@context'   => 'https://schema.org',
            '@type'      => 'FAQPage',
            'mainEntity' => collect($post->schema_faq)->map(fn($f) => [
                '@type'          => 'Question',
                'name'           => $f['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['answer']],
            ])->toArray(),
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
@endphp

<script type="application/ld+json">{!! $articleJson !!}</script>
@if($faqJson)
<script type="application/ld+json">{!! $faqJson !!}</script>
@endif
@endpush

{{-- layouts.app only renders @stack('styles') / @stack('scripts') —
     there's no @stack('head'), so anything pushed to 'head' (including
     the canonical/OG tags and schema scripts above, which predate this
     redesign) never actually renders. That's a separate, pre-existing
     issue I'm not fixing here since it means editing the shared layout
     — flagging it separately. This stylesheet link goes in 'styles',
     which the layout does render, so the redesign actually loads. --}}
@push('styles')
<link rel="stylesheet" href="{{ asset('css/psk-blog.css') }}">
@endpush

@section('content')

<div class="psk-reading-progress" id="pskReadingProgress"></div>

@php $heroBg = $post->featured_image ? asset('storage/'.$post->featured_image) : asset('images/blog-post-default-thumbnail.jpg'); @endphp

{{-- HERO --}}
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('{{ $heroBg }}');" data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-start">
            <div class="col-md-9 ftco-animate pb-5">
                <p class="breadcrumbs">
                    <span class="mr-2"><a href="{{ url('/') }}">Home <i class="fa fa-chevron-right"></i></a></span>
                    <span class="mr-2"><a href="{{ route('blog.index') }}">Blog <i class="fa fa-chevron-right"></i></a></span>
                    <span>{{ Str::limit($post->title, 40) }} <i class="fa fa-chevron-right"></i></span>
                </p>
                <h1 class="mb-0 bread">{{ $post->title }}</h1>
            </div>
        </div>
    </div>
</section>

{{-- AD SLOT: leaderboard, 728x90. Empty and invisible until real ad
     markup is placed inside. --}}
<div class="text-center" style="background:#f7f8fa;border-bottom:1px solid #eef0f3;">
    <div class="container">
        <div class="psk-ad-slot py-3 mb-0" data-ad-size="728x90"><!-- ad: 728x90 --></div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            {{-- MAIN CONTENT --}}
            <div class="col-lg-8">

                {{-- Post meta --}}
                <div class="psk-article-meta">
                    <div class="psk-article-author">
                        <div class="psk-article-author__avatar">{{ strtoupper(substr($post->author?->name ?? 'P', 0, 1)) }}</div>
                        <div>
                            <span class="psk-article-author__name">{{ $post->author?->name ?? 'Punjab Saathi' }}</span>
                            <span class="psk-article-author__role">Author</span>
                        </div>
                    </div>
                    @if($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="psk-blog-card__cat">{{ $post->category->name }}</a>
                    @endif
                    <span class="psk-article-stat"><span class="fa fa-calendar"></span>{{ $post->published_at?->format('d M Y') }}</span>
                    <span class="psk-article-stat"><span class="fa fa-clock-o"></span>{{ $post->reading_time }} min read</span>
                    <span class="psk-article-stat"><span class="fa fa-eye"></span>{{ number_format($post->views) }} views</span>
                </div>

                {{-- Tags --}}
                @if($post->tags && is_array($post->tags) && count($post->tags))
                <div class="psk-article-tags">
                    {{-- Non-clickable, matching the original: the tags
                         array has nothing to link to (BlogController
                         doesn't filter posts by tag), so a link here
                         would be new dead-end behavior rather than a
                         design change. --}}
                    @foreach($post->tags as $tag)
                    <span><span class="fa fa-tag mr-1"></span>{{ $tag }}</span>
                    @endforeach
                </div>
                @endif

                {{-- Table of Contents now lives in the sidebar (top of the
                     right column on desktop) — see blogs/partials/sidebar.
                     The JS below still finds it by ID (#toc / #toc-list)
                     regardless of where in the page it sits. --}}

                {{-- AD SLOT: in-content, 336x280 native. Empty and invisible
                     until filled. --}}
                <div class="text-center">
                    <div class="psk-ad-slot" data-ad-size="336x280" style="max-width:336px;"><!-- ad: 336x280 --></div>
                </div>

                {{-- Blog Content --}}
                <div class="psk-article-body" id="blog-content">
                    {!! $post->content !!}
                </div>

                {{-- AD SLOT: in-content bottom, 336x280 native --}}
                <div class="text-center">
                    <div class="psk-ad-slot" data-ad-size="336x280" style="max-width:336px;"><!-- ad: 336x280 --></div>
                </div>

                {{-- FAQ Section — visual reskin only; still driven by the
                     same Bootstrap data-toggle="collapse" wiring. --}}
                @if($post->schema_faq && is_array($post->schema_faq) && count($post->schema_faq))
                <div class="psk-faq-section-block">
                    <div class="psk-faq-block-head">
                        <span class="psk-faq-eyebrow"><i class="fa fa-question-circle"></i> Have Questions?</span>
                        <h3>Frequently Asked Questions</h3>
                    </div>
                    <div id="accordion">
                        @foreach($post->schema_faq as $i => $faq)
                        <div class="card psk-faq-card">
                            <div class="card-header" id="faq-heading-{{ $i }}">
                                <button class="btn btn-link psk-faq-btn text-left w-100"
                                        data-toggle="collapse" data-target="#faq-body-{{ $i }}"
                                        aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                                    <span class="psk-faq-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span class="psk-faq-q-text">{{ $faq['question'] }}</span>
                                    <span class="psk-faq-chevron"><i class="fa fa-chevron-down"></i></span>
                                </button>
                            </div>
                            <div id="faq-body-{{ $i }}" class="collapse {{ $i === 0 ? 'show' : '' }}">
                                <div class="card-body psk-faq-answer">{{ $faq['answer'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Share --}}
                <div class="psk-share-bar">
                    <span class="psk-share-bar__label">Share this post:</span>
                    @php
                        $shareUrl   = urlencode(route('blog.show', $post->slug));
                        $shareTitle = urlencode($post->title);
                    @endphp
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"
                       class="psk-share-btn psk-share-btn--fb" title="Share on Facebook"><i class="fa fa-facebook"></i></a>
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank"
                       class="psk-share-btn psk-share-btn--tw" title="Share on Twitter"><i class="fa fa-twitter"></i></a>
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
                       class="psk-share-btn psk-share-btn--wa" title="Share on WhatsApp"><i class="fa fa-whatsapp"></i></a>
                </div>

                {{-- Related Posts --}}
                @if($related->count())
                <div class="mb-5">
                    <div class="psk-blog-section-head" style="margin-bottom:18px;">
                        <h2 style="font-size:1.25rem;">Related Posts</h2>
                    </div>
                    <div class="psk-related-grid">
                        @foreach($related as $r)
                        <a href="{{ route('blog.show', $r->slug) }}" class="psk-related-card">
                            <div class="psk-related-card__img" style="background-image:url('{{ $r->featured_image ? asset('storage/'.$r->featured_image) : asset('images/blog-post-default-thumbnail.jpg') }}');"></div>
                            <div class="psk-related-card__body">
                                <div class="psk-related-card__title">{{ Str::limit($r->title, 60) }}</div>
                                <span class="psk-related-card__date">{{ $r->published_at?->format('d M Y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- COMMENTS --}}
                @if($post->allow_comments)
                <div class="mt-5 pt-4 border-top">

                    @if(session('comment_success'))
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle mr-2"></i>{{ session('comment_success') }}
                    </div>
                    @endif

                    <h4 class="mb-4">
                        <i class="fa fa-comments mr-2" style="color:#fc5e28;"></i>
                        Comments ({{ $comments->count() }})
                    </h4>

                    @forelse($comments as $comment)
                    <div class="d-flex mb-4" id="comment-{{ $comment->id }}">
                        <div class="mr-3 flex-shrink-0">
                            <div class="psk-comment__avatar">{{ strtoupper(substr($comment->name, 0, 1)) }}</div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="psk-comment__body">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <strong style="font-size:15px;">{{ $comment->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-2" style="font-size:14px;line-height:1.7;">{{ $comment->comment }}</p>
                                <button class="btn btn-link btn-sm p-0 text-muted reply-btn"
                                        data-id="{{ $comment->id }}" data-name="{{ $comment->name }}"
                                        style="font-size:12px;">
                                    <i class="fa fa-reply mr-1"></i> Reply
                                </button>
                            </div>

                            @foreach($comment->replies as $reply)
                            <div class="d-flex mt-3 ml-4">
                                <div class="mr-3 flex-shrink-0">
                                    <div class="psk-comment__reply-avatar">{{ strtoupper(substr($reply->name, 0, 1)) }}</div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="psk-comment__reply-body">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong style="font-size:14px;">{{ $reply->name }}</strong>
                                            <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                        </div>
                                        <p class="mb-0" style="font-size:13px;line-height:1.7;">{{ $reply->comment }}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <p class="text-muted mb-4">No comments yet. Be the first to comment!</p>
                    @endforelse

                    {{-- Comment Form --}}
                    <div class="psk-comment-form mt-4" id="comment-form-wrap">
                        <h5 class="mb-3 font-weight-bold">Leave a Comment</h5>
                        <p class="text-muted small mb-4">Your email will not be published. All comments are reviewed before appearing.</p>

                        <form action="{{ route('blog.comment', $post->slug) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" id="parent_id" value="">

                            <div id="reply-notice" class="alert alert-info d-none" style="font-size:14px;">
                                Replying to: <strong id="reply-name"></strong>
                                <button type="button" id="cancel-reply" class="btn btn-link btn-sm p-0 ml-2 text-danger">Cancel</button>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Comment <span class="text-danger">*</span></label>
                                <textarea name="comment" rows="5" maxlength="1000"
                                          class="form-control @error('comment') is-invalid @enderror"
                                          required>{{ old('comment') }}</textarea>
                                @error('comment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fa fa-paper-plane mr-2"></i> Post Comment
                            </button>
                        </form>
                    </div>

                </div>
                @endif

            </div>

            {{-- SIDEBAR --}}
            @include('blogs.partials.sidebar', ['categories' => $categories, 'recent' => $recent, 'popular' => $popular, 'tocPost' => $post])

        </div>
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Table of Contents
    var content = document.getElementById('blog-content');
    var tocList = document.getElementById('toc-list');
    if (content && tocList) {
        var headings = content.querySelectorAll('h2, h3');
        if (headings.length < 2) {
            var toc = document.getElementById('toc');
            if (toc) toc.style.display = 'none';
        } else {
            headings.forEach(function (heading, i) {
                var id = 'heading-' + i;
                heading.id = id;
                var li = document.createElement('li');
                if (heading.tagName === 'H3') {
                    li.style.marginLeft = '16px';
                    li.style.listStyleType = 'circle';
                }
                var a = document.createElement('a');
                a.href = '#' + id;
                a.textContent = heading.textContent;
                li.appendChild(a);
                tocList.appendChild(li);
            });
        }
    }

    // Reply buttons
    document.querySelectorAll('.reply-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('parent_id').value = this.dataset.id;
            document.getElementById('reply-name').textContent = this.dataset.name;
            document.getElementById('reply-notice').classList.remove('d-none');
            document.getElementById('comment-form-wrap').scrollIntoView({ behavior: 'smooth' });
        });
    });

    var cancelBtn = document.getElementById('cancel-reply');
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
            document.getElementById('parent_id').value = '';
            document.getElementById('reply-notice').classList.add('d-none');
        });
    }

    // Reading progress bar — purely visual, tracks scroll position
    // against the article body's own height.
    var progressBar = document.getElementById('pskReadingProgress');
    var articleBody = document.getElementById('blog-content');
    if (progressBar && articleBody) {
        var onScroll = function () {
            var start = articleBody.offsetTop - 100;
            var total = articleBody.offsetHeight;
            var scrolled = window.scrollY - start;
            var pct = Math.max(0, Math.min(100, (scrolled / total) * 100));
            progressBar.style.width = pct + '%';
        };
        window.addEventListener('scroll', onScroll, { passive: true });
        onScroll();
    }

});
</script>
@endpush

@endsection
