@props(['categories', 'title' => 'Browse by Category'])

<div class="card border-0 shadow-sm mb-4" style="border-radius:10px;">
    <div class="card-header text-white font-weight-bold" style="background:#fc5e28;border-radius:10px 10px 0 0;font-size:0.85rem;">
        <span class="fa fa-th-list mr-2"></span>{{ $title }}
    </div>
    <div class="card-body p-2">
        <ul class="list-unstyled mb-0">
            @foreach($categories as $cat)
            <li>
                <a href="{{ route('categories.show', $cat->slug) }}"
                   class="d-flex align-items-center justify-content-between px-2 py-2 rounded text-dark"
                   style="font-size:0.85rem;text-decoration:none;"
                   onmouseover="this.style.background='#fff3ef'" onmouseout="this.style.background='transparent'">
                    <span><span class="fa fa-folder-o mr-2" style="color:#fc5e28;"></span>{{ $cat->name }}</span>
                    <span class="badge badge-secondary" style="font-size:0.7rem;">{{ $cat->forms_count }}</span>
                </a>
                @if($cat->children->isNotEmpty())
                <ul class="list-unstyled pl-3 mb-1">
                    @foreach($cat->children as $child)
                    <li>
                        <a href="{{ route('categories.show', $child->slug) }}"
                           class="d-block px-2 py-1 text-muted rounded"
                           style="font-size:0.78rem;text-decoration:none;"
                           onmouseover="this.style.color='#fc5e28'" onmouseout="this.style.color=''">
                            <span class="fa fa-angle-right mr-1"></span>{{ $child->name }}
                        </a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
        </ul>
    </div>
</div>

{{ $slot }}