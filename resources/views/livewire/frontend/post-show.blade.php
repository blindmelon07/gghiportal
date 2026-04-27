<div class="py-12 px-4 md:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        {{-- Article --}}
        <article class="lg:col-span-3">
            {{-- Cover Image --}}
            @if($post->cover_image_path)
            <img src="{{ $post->cover_image_path }}" alt="{{ $post->title }}" class="w-full h-64 md:h-80 object-cover rounded-2xl mb-8">
            @endif

            {{-- Meta --}}
            <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-5">
                @if($post->category)
                <span class="bg-brand-100 text-brand-600 text-xs font-semibold px-3 py-1 rounded-full">{{ $post->category }}</span>
                @endif
                <span>By <strong class="text-gray-700">{{ $post->author_name }}</strong></span>
                <span>{{ $post->published_at?->format('F d, Y') }}</span>
            </div>

            <h1 class="text-2xl md:text-4xl font-bold text-brand-900 mb-8 leading-tight" style="font-family:'Playfair Display',serif">{{ $post->title }}</h1>

            {{-- Body with Tailwind Typography --}}
            <div class="prose prose-lg prose-brand max-w-none
                prose-headings:font-bold prose-headings:text-brand-900
                prose-a:text-brand-500 prose-a:no-underline hover:prose-a:underline
                prose-strong:text-gray-800">
                {!! \Illuminate\Support\Str::markdown($post->body) !!}
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100">
                <a href="{{ route('blog.index') }}" class="text-brand-500 text-sm font-medium hover:underline">← Back to Blog</a>
            </div>
        </article>

        {{-- Sidebar --}}
        <aside class="lg:col-span-1">
            <div class="sticky top-20 space-y-6">
                {{-- Recent Posts --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                    <h3 class="font-bold text-gray-800 mb-4 text-sm">Recent Posts</h3>
                    <div class="space-y-3">
                        @foreach($recentPosts as $recent)
                        <a href="{{ route('blog.show', $recent->slug) }}" class="block group">
                            <p class="text-sm font-medium text-gray-700 group-hover:text-brand-600 transition-colors line-clamp-2">{{ $recent->title }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $recent->published_at?->format('M d, Y') }}</p>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Services Links --}}
                <div class="bg-brand-50 rounded-2xl border border-brand-100 p-5">
                    <h3 class="font-bold text-brand-800 mb-3 text-sm">Our Services</h3>
                    <ul class="space-y-1.5 text-sm">
                        @foreach(\App\Models\Service::active()->ordered()->limit(6)->get() as $service)
                        <li>
                            <a href="{{ route('services') }}" class="text-brand-600 hover:text-brand-800 transition-colors">{{ $service->title }}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>
