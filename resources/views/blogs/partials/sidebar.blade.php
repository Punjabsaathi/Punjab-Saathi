<div class="col-lg-4 sidebar ftco-animate">

    {{-- AD - SIDEBAR TOP --}}
    <div class="text-center mb-4">
        <div style="background:#f0f0f0;border:2px dashed #ccc;padding:20px;">
            <span class="text-muted small">Advertisement - 300x250</span>
        </div>
    </div>

    {{-- SEARCH --}}
    <div class="sidebar-box mb-4">
        <form action="{{ route('blog.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search posts...">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>

    {{-- CATEGORIES --}}
    <div class="sidebar-box mb-4 p-4 bg-white shadow-sm" style="border-radius:8px;">
        <h3 class="sidebar-h3 mb-3" style="font-size:18px;font-weight:700;border-left:4px solid #fc5e28;padding-left:12px;">
            Categories
        </h3>
        <ul class="list-unstyled mb-0">
            @foreach($categories as $cat)
            <li class="mb-2">
                <a href="{{ route('blog.category', $cat->slug) }}"
                   class="d-flex justify-content-between align-items-center text-dark text-decoration-none py-1 border-bottom">
                    <span><i class="fa fa-folder-o mr-2 text-primary"></i>{{ $cat->name }}</span>
                    <span class="badge badge-primary badge-pill">{{ $cat->blogs_count }}</span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    {{-- RECENT POSTS --}}
    <div class="sidebar-box mb-4 p-4 bg-white shadow-sm" style="border-radius:8px;">
        <h3 class="sidebar-h3 mb-3" style="font-size:18px;font-weight:700;border-left:4px solid #fc5e28;padding-left:12px;">
            Recent Posts
        </h3>
        @foreach($recent as $r)
        <div class="d-flex mb-3">
            <a href="{{ route('blog.show', $r->slug) }}" class="mr-3 flex-shrink-0">
                <img src="{{ $r->featured_image ? asset('storage/'.$r->featured_image) : asset('images/image_1.jpg') }}"
                     style="width:60px;height:50px;object-fit:cover;border-radius:6px;" alt="{{ $r->image_alt ?? '' }}">
            </a>
            <div>
                <a href="{{ route('blog.show', $r->slug) }}" class="text-dark"
                   style="font-size:13px;font-weight:600;line-height:1.4;display:block;">
                    {{ Str::limit($r->title, 55) }}
                </a>
                <small class="text-muted"><i class="fa fa-calendar mr-1"></i>{{ $r->published_at?->format('d M Y') }}</small>
            </div>
        </div>
        @endforeach
    </div>

    {{-- POPULAR POSTS --}}
    <div class="sidebar-box mb-4 p-4 bg-white shadow-sm" style="border-radius:8px;">
        <h3 class="sidebar-h3 mb-3" style="font-size:18px;font-weight:700;border-left:4px solid #fc5e28;padding-left:12px;">
            Most Popular
        </h3>
        @foreach($popular as $i => $p)
        <div class="d-flex mb-3 align-items-start">
            <span style="font-size:22px;font-weight:800;color:#eee;min-width:30px;line-height:1;">{{ $i + 1 }}</span>
            <a href="{{ route('blog.show', $p->slug) }}" class="text-dark ml-2"
               style="font-size:13px;font-weight:600;line-height:1.4;">
                {{ Str::limit($p->title, 55) }}
                <small class="d-block text-muted mt-1">
                    <i class="fa fa-eye mr-1"></i>{{ number_format($p->views) }} views
                </small>
            </a>
        </div>
        @endforeach
    </div>

    {{-- AD - SIDEBAR BOTTOM --}}
    <div class="text-center mb-4">
        <div style="background:#f0f0f0;border:2px dashed #ccc;padding:20px;">
            <span class="text-muted small">Advertisement - 300x600 Half Page</span>
        </div>
    </div>

</div>
