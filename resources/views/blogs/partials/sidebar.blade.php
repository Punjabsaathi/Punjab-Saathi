{{-- ─────────────────────────────────────────────────────────
     resources/views/blogs/partials/sidebar.blade.php
     Cards reuse the sitewide .psk-sidebar-card shell (already loaded
     via psk-services-detail.css), so this sidebar matches the one on
     /services/{slug} and the Jobs section. Widget-specific styling
     lives in psk-blog.css.
     ───────────────────────────────────────────────────────── --}}
<div class="col-lg-4 psk-blog-sidebar">

    {{-- Table of contents — only present on the single-post page.
         Deliberately named $tocPost, not $post: @include shares the
         calling view's variable scope, and both index.blade.php and
         category.blade.php loop over their card grid with
         "@foreach($posts as $post)" — after that loop ends, $post is
         still set (to the last post) and would leak in here as a
         false positive if this checked @isset($post). blogs/show.php
         explicitly passes 'tocPost', which nothing else defines, so
         there's no risk of an accidental collision. Placed first so
         on desktop it sits at the top of the right column, level with
         the start of the article; the JS that populates #toc-list (in
         blogs/show.blade.php) targets it by ID, so it works the same
         regardless of where in the DOM it physically sits. --}}
    @isset($tocPost)
    <div id="toc" class="psk-toc psk-toc--sidebar">
        <h5><i class="fa fa-list mr-2" style="color:#fc5e28;"></i> Table of Contents</h5>
        <ol id="toc-list"></ol>
    </div>
    @endisset

    {{-- AD SLOT: sidebar top, 300x250 medium rectangle. Empty and
         invisible (display:none via :empty) until real ad markup is
         placed inside — the container and its position already exist
         so that's a content change later, not a layout change. --}}
    <div class="psk-ad-slot" data-ad-size="300x250"><!-- ad: 300x250 --></div>

    {{-- SEARCH --}}
    <div class="psk-sidebar-card">
        <form action="{{ route('blog.index') }}" method="GET" class="psk-blog-search">
            <input type="text" name="q" placeholder="Search articles…" value="{{ request('q') }}" aria-label="Search articles">
            <button type="submit" aria-label="Search"><span class="fa fa-search"></span></button>
        </form>
    </div>

    {{-- CATEGORIES --}}
    @if($categories->isNotEmpty())
    <div class="psk-sidebar-card">
        <h3 class="psk-sidebar-card__title"><span class="fa fa-folder-o mr-2"></span>Categories</h3>
        <ul class="psk-blog-cat-list">
            @foreach($categories as $cat)
            <li>
                <a href="{{ route('blog.category', $cat->slug) }}">
                    <span><span class="fa fa-angle-right"></span>{{ $cat->name }}</span>
                    <span class="psk-blog-cat-list__count">{{ $cat->blogs_count }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- RECENT POSTS --}}
    @if($recent->isNotEmpty())
    <div class="psk-sidebar-card">
        <h3 class="psk-sidebar-card__title"><span class="fa fa-clock-o mr-2"></span>Recent Posts</h3>
        @foreach($recent as $r)
        <div class="psk-blog-mini">
            <a href="{{ route('blog.show', $r->slug) }}" class="psk-blog-mini__thumb" aria-label="{{ $r->title }}"
               style="background-image:url('{{ $r->featured_image ? asset('storage/'.$r->featured_image) : asset('images/blog-post-default-thumbnail.webp') }}');"></a>
            <div>
                <a href="{{ route('blog.show', $r->slug) }}" class="psk-blog-mini__title">{{ Str::limit($r->title, 60) }}</a>
                <span class="psk-blog-mini__meta"><span class="fa fa-calendar mr-1"></span>{{ $r->published_at?->format('d M Y') }}</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- POPULAR POSTS --}}
    @if($popular->isNotEmpty())
    <div class="psk-sidebar-card">
        <h3 class="psk-sidebar-card__title"><span class="fa fa-fire mr-2"></span>Most Popular</h3>
        @foreach($popular as $i => $p)
        <div class="psk-blog-mini">
            <span class="psk-blog-mini__rank">{{ $i + 1 }}</span>
            <div>
                <a href="{{ route('blog.show', $p->slug) }}" class="psk-blog-mini__title">{{ Str::limit($p->title, 60) }}</a>
                <span class="psk-blog-mini__meta"><span class="fa fa-eye mr-1"></span>{{ number_format($p->views) }} views</span>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    {{-- WhatsApp CTA — reuses the sitewide .psk-sidebar-card +
         .psk-sidebar-wa combo already used on /services/{slug}, so
         this matches that sidebar exactly instead of inventing a new
         look. --}}
    <div class="psk-sidebar-card psk-sidebar-wa">
        <span class="fa fa-whatsapp psk-sidebar-wa__icon"></span>
        <h4>Need Help With a Service?</h4>
        <p>Chat with our team on WhatsApp — fast replies, zero office visits.</p>
        <a href="https://wa.me/917710556330" target="_blank" rel="noopener" class="btn psk-btn-whatsapp w-100">
            <span class="fa fa-whatsapp mr-1"></span> Chat on WhatsApp
        </a>
    </div>

    {{-- AD SLOT: sidebar bottom, 300x600 half page --}}
    <div class="psk-ad-slot" data-ad-size="300x600"><!-- ad: 300x600 --></div>

</div>
