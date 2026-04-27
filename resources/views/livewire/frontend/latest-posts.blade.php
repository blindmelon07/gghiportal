<div>
    <div class="text-center mb-12">
        <p class="text-brand-500 text-sm font-semibold uppercase tracking-widest mb-2">Health Blog</p>
        <h2 class="text-3xl md:text-4xl font-bold text-brand-900" style="font-family:'Playfair Display',serif">Latest News & Articles</h2>
    </div>

    @if($posts->isEmpty())
    <p class="text-center text-gray-400">No published posts yet.</p>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <article class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow overflow-hidden flex flex-col">
            <div class="relative h-48 overflow-hidden bg-brand-50">
                @if($post->cover_image_path)
                    <img src="{{ $post->cover_image_path }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-brand-50">
                        <svg class="w-12 h-12 text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                @endif
                @if($post->category)
                <span class="absolute top-3 left-3 bg-brand-500 text-white text-xs font-medium px-2.5 py-1 rounded-full">{{ $post->category }}</span>
                @endif
            </div>
            <div class="p-5 flex flex-col flex-1">
                <h3 class="font-bold text-gray-800 text-base leading-snug mb-2 hover:text-brand-600 transition-colors">
                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                </h3>
                @if($post->excerpt)
                <p class="text-gray-500 text-sm leading-relaxed mb-4 flex-1 line-clamp-2">{{ $post->excerpt }}</p>
                @endif
                <div class="flex items-center justify-between mt-auto pt-3 border-t border-gray-50">
                    <div>
                        <p class="text-xs font-medium text-gray-700">{{ $post->author_name }}</p>
                        <p class="text-xs text-gray-400">{{ $post->published_at?->format('M d, Y') }}</p>
                    </div>
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-brand-500 text-xs font-semibold hover:text-brand-700">Read More →</a>
                </div>
            </div>
        </article>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('blog.index') }}" class="bg-white border border-brand-500 text-brand-500 hover:bg-brand-500 hover:text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 text-sm inline-block">
            View All Articles
        </a>
    </div>
    @endif
</div>
