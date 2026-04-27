<div class="py-16 px-4 md:px-8 max-w-7xl mx-auto">
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-brand-900 mb-2" style="font-family:'Playfair Display',serif">Health Blog & News</h1>
        <p class="text-gray-500">Stay informed with the latest health tips, news, and research from our experts.</p>
    </div>

    {{-- Search & Filter --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-8">
        <div class="relative flex-1">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search articles..."
                class="w-full pl-9 pr-4 py-2.5 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent">
        </div>
        @if($categories->isNotEmpty())
        <select wire:model.live="category" class="border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat }}">{{ $cat }}</option>
            @endforeach
        </select>
        @endif
    </div>

    {{-- Posts Grid --}}
    @if($posts->isEmpty())
    <div class="text-center py-20 text-gray-400">
        <p class="text-lg mb-2">No posts found.</p>
        @if($search || $category)
        <button wire:click="$set('search', ''); $set('category', '')" class="text-brand-500 text-sm hover:underline">Clear filters</button>
        @endif
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden flex flex-col">
            <div class="h-44 overflow-hidden bg-brand-50">
                @if($post->cover_image_path)
                    <img src="{{ $post->cover_image_path }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-10 h-10 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01"/>
                        </svg>
                    </div>
                @endif
            </div>
            <div class="p-5 flex flex-col flex-1">
                @if($post->category)
                <span class="text-xs font-semibold text-brand-500 mb-2">{{ $post->category }}</span>
                @endif
                <h2 class="font-bold text-gray-800 mb-2 leading-snug hover:text-brand-600 transition-colors">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h2>
                @if($post->excerpt)
                <p class="text-gray-500 text-sm leading-relaxed line-clamp-2 mb-4 flex-1">{{ $post->excerpt }}</p>
                @endif
                <div class="flex items-center justify-between pt-3 border-t border-gray-50 mt-auto">
                    <div>
                        <p class="text-xs font-medium text-gray-700">{{ $post->author_name }}</p>
                        <p class="text-xs text-gray-400">{{ $post->published_at?->format('M d, Y') }}</p>
                    </div>
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-brand-500 text-xs font-semibold hover:text-brand-700">Read →</a>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    @endif
</div>
