@props(['categories', 'title' => 'Browse by Category'])

<aside class="space-y-6">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
        <h3 class="font-semibold text-gray-700 mb-3 text-sm uppercase tracking-wide">{{ $title }}</h3>
        <ul class="space-y-1">
            @foreach($categories as $cat)
                <li>
                    <a href="{{ route('categories.show', $cat->slug) }}"
                       class="flex items-center justify-between py-1.5 px-2 rounded-lg text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition {{ request()->is('categories/'.$cat->slug.'*') ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                        <span class="flex items-center gap-2">
                            @if($cat->icon)
                                <x-dynamic-component :component="$cat->icon" class="w-4 h-4 text-blue-500"/>
                            @else
                                <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18"/>
                                </svg>
                            @endif
                            {{ $cat->name }}
                        </span>
                        <span class="text-xs text-gray-400 bg-gray-100 rounded-full px-2 py-0.5">{{ $cat->forms_count }}</span>
                    </a>
                    @if($cat->children->isNotEmpty())
                        <ul class="ml-6 mt-1 space-y-0.5">
                            @foreach($cat->children as $child)
                                <li>
                                    <a href="{{ route('categories.show', $child->slug) }}"
                                       class="flex items-center justify-between py-1 px-2 rounded text-xs text-gray-600 hover:text-blue-700 transition">
                                        <span>{{ $child->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>

    {{ $slot }}
</aside>
