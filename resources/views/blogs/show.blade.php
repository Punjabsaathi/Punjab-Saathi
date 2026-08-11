@extends('layouts.app')

@section('title', $post->seo_title . ' - Punjab Seva Kendra')
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
        'author'        => ['@type' => 'Person', 'name' => $post->author?->name ?? 'Punjab Seva Kendra'],
        'publisher'     => ['@type' => 'Organization', 'name' => 'Punjab Seva Kendra', 'url' => url('/')],
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

<style>
#toc { background:#f8f9fa;border-left:4px solid #fc5e28;padding:20px 20px 20px 24px;border-radius:6px;margin-bottom:30px; }
#toc h5 { font-weight:700;margin-bottom:12px;font-size:15px; }
#toc ol { padding-left:20px;margin:0; }
#toc li { margin-bottom:6px; }
#toc a { color:#333;font-size:14px;text-decoration:none; }
#toc a:hover { color:#fc5e28; }
.blog-content h2 { font-size:24px;font-weight:700;margin:35px 0 15px;padding-top:10px; }
.blog-content h3 { font-size:20px;font-weight:600;margin:28px 0 12px; }
.blog-content p  { line-height:1.9;margin-bottom:18px; }
.blog-content img { max-width:100%;border-radius:8px;margin:20px 0; }
.blog-content blockquote { border-left:4px solid #fc5e28;padding:12px 20px;background:#fff8f5;margin:24px 0;font-style:italic; }
.blog-content ul, .blog-content ol { padding-left:24px;margin-bottom:18px;line-height:1.9; }
.blog-content a { color:#fc5e28; }
</style>
@endpush

@section('content')

@php $heroBg = $post->featured_image ? asset('storage/'.$post->featured_image) : asset('images/bg_1.jpg'); @endphp

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

{{-- AD - LEADERBOARD --}}
<div class="text-center py-3" style="background:#f8f9fa;border-top:1px solid #eee;border-bottom:1px solid #eee;">
    <div class="container">
        <div style="display:inline-flex;align-items:center;justify-content:space-between;width:100%;max-width:728px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);border-radius:8px;overflow:hidden;height:90px;box-shadow:0 2px 8px rgba(0,0,0,0.15);">
            <div style="padding:16px 24px;color:#fff;">
                <div style="font-size:11px;opacity:0.8;letter-spacing:1px;text-transform:uppercase;margin-bottom:4px;">Sponsored</div>
                <div style="font-size:18px;font-weight:700;">Apply for Aadhaar Online</div>
                <div style="font-size:13px;opacity:0.9;">Fast. Easy. Government Approved.</div>
            </div>
            <div style="padding:16px 24px;flex-shrink:0;">
                <a href="#" style="background:#fff;color:#667eea;font-weight:700;font-size:13px;padding:10px 20px;border-radius:6px;text-decoration:none;display:inline-block;">Apply Now</a>
            </div>
        </div>
        <div style="font-size:10px;color:#aaa;margin-top:4px;">Advertisement</div>
    </div>
</div>

<section class="ftco-section">
    <div class="container">
        <div class="row">

            {{-- MAIN CONTENT --}}
            <div class="col-lg-8">

                {{-- Post meta --}}
                <div class="d-flex align-items-center flex-wrap mb-4 pb-3 border-bottom" style="gap:16px;">
                    @if($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}"
                       class="badge badge-primary px-3 py-2" style="font-size:12px;">
                        {{ $post->category->name }}
                    </a>
                    @endif
                    <span class="text-muted small"><i class="fa fa-user mr-1"></i> {{ $post->author?->name ?? 'Punjab Seva Kendra' }}</span>
                    <span class="text-muted small"><i class="fa fa-calendar mr-1"></i> {{ $post->published_at?->format('d M Y') }}</span>
                    <span class="text-muted small"><i class="fa fa-clock-o mr-1"></i> {{ $post->reading_time }} min read</span>
                    <span class="text-muted small"><i class="fa fa-eye mr-1"></i> {{ number_format($post->views) }} views</span>
                </div>

                {{-- Tags --}}
                @if($post->tags && is_array($post->tags) && count($post->tags))
                <div class="mb-3">
                    @foreach($post->tags as $tag)
                    <span class="badge badge-light border mr-1 mb-1 py-1 px-2" style="font-size:12px;">
                        <i class="fa fa-tag mr-1 text-muted"></i>{{ $tag }}
                    </span>
                    @endforeach
                </div>
                @endif

                {{-- Table of Contents --}}
                <div id="toc">
                    <h5><i class="fa fa-list mr-2" style="color:#fc5e28;"></i> Table of Contents</h5>
                    <ol id="toc-list"></ol>
                </div>

                {{-- AD - IN-CONTENT TOP --}}
                <div class="text-center my-4">
                    <div style="display:inline-block;width:100%;max-width:336px;background:linear-gradient(135deg,#f093fb 0%,#f5576c 100%);border-radius:10px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.15);">
                        <div style="padding:24px;color:#fff;text-align:center;">
                            <div style="font-size:10px;opacity:0.8;letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Advertisement</div>
                            <div style="font-size:32px;margin-bottom:8px;">📄</div>
                            <div style="font-size:17px;font-weight:700;margin-bottom:6px;">PAN Card in 48 Hours</div>
                            <div style="font-size:13px;opacity:0.9;margin-bottom:16px;">No office visit needed. Apply from home.</div>
                            <a href="#" style="background:#fff;color:#f5576c;font-weight:700;font-size:13px;padding:10px 24px;border-radius:20px;text-decoration:none;display:inline-block;">Get Started →</a>
                        </div>
                    </div>
                    <div style="font-size:10px;color:#aaa;margin-top:4px;">Advertisement</div>
                </div>

                {{-- Blog Content --}}
                <div class="blog-content" id="blog-content">
                    {!! $post->content !!}
                </div>

                {{-- AD - IN-CONTENT BOTTOM --}}
                <div class="text-center my-4">
                    <div style="display:inline-block;width:100%;max-width:336px;background:linear-gradient(135deg,#4facfe 0%,#00f2fe 100%);border-radius:10px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.15);">
                        <div style="padding:24px;color:#fff;text-align:center;">
                            <div style="font-size:10px;opacity:0.8;letter-spacing:1px;text-transform:uppercase;margin-bottom:8px;">Advertisement</div>
                            <div style="font-size:32px;margin-bottom:8px;">🏛️</div>
                            <div style="font-size:17px;font-weight:700;margin-bottom:6px;">Income Certificate</div>
                            <div style="font-size:13px;opacity:0.9;margin-bottom:16px;">Punjab Govt Approved. Fast Processing.</div>
                            <a href="#" style="background:#fff;color:#4facfe;font-weight:700;font-size:13px;padding:10px 24px;border-radius:20px;text-decoration:none;display:inline-block;">Apply Now →</a>
                        </div>
                    </div>
                    <div style="font-size:10px;color:#aaa;margin-top:4px;">Advertisement</div>
                </div>

                {{-- FAQ Section --}}
                @if($post->schema_faq && is_array($post->schema_faq) && count($post->schema_faq))
                <div class="mt-5 mb-4">
                    <h3 class="mb-4"><i class="fa fa-question-circle mr-2" style="color:#fc5e28;"></i> Frequently Asked Questions</h3>
                    <div id="accordion">
                        @foreach($post->schema_faq as $i => $faq)
                        <div class="card border-0 mb-2 shadow-sm">
                            <div class="card-header bg-white" id="faq-heading-{{ $i }}">
                                <button class="btn btn-link text-dark text-left w-100 font-weight-bold"
                                        data-toggle="collapse" data-target="#faq-body-{{ $i }}"
                                        aria-expanded="{{ $i === 0 ? 'true' : 'false' }}">
                                    <i class="fa fa-plus mr-2 text-primary"></i>{{ $faq['question'] }}
                                </button>
                            </div>
                            <div id="faq-body-{{ $i }}" class="collapse {{ $i === 0 ? 'show' : '' }}">
                                <div class="card-body text-muted">{{ $faq['answer'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Share --}}
                <div class="mt-5 pt-4 border-top">
                    <h5 class="mb-3">Share this post:</h5>
                    @php
                        $shareUrl   = urlencode(route('blog.show', $post->slug));
                        $shareTitle = urlencode($post->title);
                    @endphp
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"
                       class="btn btn-sm btn-primary mr-2"><i class="fa fa-facebook mr-1"></i> Facebook</a>
                    <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank"
                       class="btn btn-sm btn-info mr-2"><i class="fa fa-twitter mr-1"></i> Twitter</a>
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
                       class="btn btn-sm btn-success mr-2"><i class="fa fa-whatsapp mr-1"></i> WhatsApp</a>
                </div>

                {{-- Related Posts --}}
                @if($related->count())
                <div class="mt-5">
                    <h4 class="mb-4">Related Posts</h4>
                    <div class="row">
                        @foreach($related as $r)
                        <div class="col-md-4 mb-3">
                            <div class="card border-0 shadow-sm h-100">
                                <a href="{{ route('blog.show', $r->slug) }}">
                                    <img src="{{ $r->featured_image ? asset('storage/'.$r->featured_image) : asset('images/image_1.jpg') }}"
                                         class="card-img-top" style="height:140px;object-fit:cover;" alt="{{ $r->image_alt ?? '' }}">
                                </a>
                                <div class="card-body p-3">
                                    <h6 class="card-title mb-1">
                                        <a href="{{ route('blog.show', $r->slug) }}" class="text-dark" style="font-size:14px;">
                                            {{ Str::limit($r->title, 60) }}
                                        </a>
                                    </h6>
                                    <small class="text-muted">{{ $r->published_at?->format('d M Y') }}</small>
                                </div>
                            </div>
                        </div>
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
                            <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#fc5e28,#e04d1c);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:18px;">
                                {{ strtoupper(substr($comment->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="bg-light p-3 rounded">
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
                                    <div style="width:36px;height:36px;border-radius:50%;background:#6c757d;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:14px;">
                                        {{ strtoupper(substr($reply->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="bg-white border p-3 rounded">
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
                    <div class="mt-4" id="comment-form-wrap">
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
            @include('blogs.partials.sidebar', ['categories' => $categories, 'recent' => $recent, 'popular' => $popular])

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

});
</script>
@endpush

@endsection
