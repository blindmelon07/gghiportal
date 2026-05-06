<div class="py-12 px-4 md:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        {{-- Article --}}
        <article class="lg:col-span-3">
            {{-- Image Slider with Lightbox --}}
            @if($slideImages->isNotEmpty())
            @php $images = $slideImages->pluck('image_path')->toArray(); @endphp
            <div
                x-data="{
                    current: 0,
                    total: {{ $slideImages->count() }},
                    lightbox: false,
                    lightboxIndex: 0,
                    images: {{ json_encode($images) }},
                    prev() { this.current = (this.current - 1 + this.total) % this.total; },
                    next() { this.current = (this.current + 1) % this.total; },
                    openLightbox(i) { this.lightboxIndex = i; this.lightbox = true; },
                    lbPrev() { this.lightboxIndex = (this.lightboxIndex - 1 + this.total) % this.total; },
                    lbNext() { this.lightboxIndex = (this.lightboxIndex + 1) % this.total; },
                }"
                @keydown.escape.window="lightbox = false"
                @keydown.arrow-left.window="lightbox && lbPrev()"
                @keydown.arrow-right.window="lightbox && lbNext()"
                class="mb-8">

                {{-- Slider --}}
                <div class="relative w-full h-72 md:h-[30rem] rounded-2xl overflow-hidden bg-gray-900 shadow-lg group cursor-zoom-in"
                    @click="openLightbox(current)">

                    @foreach($slideImages as $i => $img)
                    <div
                        x-show="current === {{ $i }}"
                        x-transition:enter="transition-opacity duration-500"
                        x-transition:enter-start="opacity-0"
                        x-transition:enter-end="opacity-100"
                        x-transition:leave="transition-opacity duration-500"
                        x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="absolute inset-0"
                        @if($i > 0) style="display:none" @endif>
                        <img src="{{ $img->image_path }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.02]">
                    </div>
                    @endforeach

                    {{-- Click-to-zoom hint --}}
                    <div class="absolute top-3 right-3 bg-black/40 text-white text-xs px-2 py-1 rounded-full opacity-0 group-hover:opacity-100 transition-opacity z-10 pointer-events-none">
                        🔍 Click to zoom
                    </div>

                    @if($slideImages->count() > 1)
                    <button type="button" @click.stop="prev()"
                        class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full w-10 h-10 flex items-center justify-center transition-all z-10 text-2xl opacity-0 group-hover:opacity-100 backdrop-blur-sm">
                        &#8249;
                    </button>
                    <button type="button" @click.stop="next()"
                        class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/40 hover:bg-black/70 text-white rounded-full w-10 h-10 flex items-center justify-center transition-all z-10 text-2xl opacity-0 group-hover:opacity-100 backdrop-blur-sm">
                        &#8250;
                    </button>

                    {{-- Slide counter --}}
                    <div class="absolute top-3 left-3 bg-black/40 text-white text-xs px-2.5 py-1 rounded-full z-10 backdrop-blur-sm">
                        <span x-text="current + 1"></span> / {{ $slideImages->count() }}
                    </div>

                    {{-- Dots --}}
                    <div class="absolute bottom-4 left-0 right-0 flex justify-center gap-2 z-10">
                        @foreach($slideImages as $i => $img)
                        <button type="button" @click.stop="current = {{ $i }}"
                            :class="current === {{ $i }} ? 'bg-white w-6 shadow-md' : 'bg-white/50 hover:bg-white/80 w-2'"
                            class="h-2 rounded-full transition-all duration-300"></button>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Thumbnail strip --}}
                @if($slideImages->count() > 1)
                <div class="flex gap-2 mt-3 overflow-x-auto pb-1">
                    @foreach($slideImages as $i => $img)
                    <button type="button" @click="current = {{ $i }}"
                        :class="current === {{ $i }} ? 'ring-2 ring-brand-500 ring-offset-1 opacity-100' : 'opacity-50 hover:opacity-80'"
                        class="flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden transition-all duration-200">
                        <img src="{{ $img->image_path }}" alt="Slide {{ $i + 1 }}" class="w-full h-full object-cover">
                    </button>
                    @endforeach
                </div>
                @endif

                {{-- Lightbox --}}
                <div
                    x-show="lightbox"
                    x-transition:enter="transition-opacity duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
                    style="display:none"
                    @click.self="lightbox = false">

                    {{-- Close button --}}
                    <button type="button" @click="lightbox = false"
                        class="absolute top-4 right-4 text-white bg-white/10 hover:bg-white/20 rounded-full w-10 h-10 flex items-center justify-center text-xl transition-colors z-10">
                        ✕
                    </button>

                    {{-- Counter --}}
                    <div class="absolute top-4 left-1/2 -translate-x-1/2 text-white/70 text-sm">
                        <span x-text="lightboxIndex + 1"></span> / {{ $slideImages->count() }}
                    </div>

                    {{-- Image --}}
                    <img :src="images[lightboxIndex]" alt="{{ $post->title }}"
                        class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl select-none">

                    @if($slideImages->count() > 1)
                    {{-- Prev/Next --}}
                    <button type="button" @click="lbPrev()"
                        class="absolute left-4 top-1/2 -translate-y-1/2 text-white bg-white/10 hover:bg-white/20 rounded-full w-12 h-12 flex items-center justify-center text-3xl transition-colors">
                        &#8249;
                    </button>
                    <button type="button" @click="lbNext()"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-white bg-white/10 hover:bg-white/20 rounded-full w-12 h-12 flex items-center justify-center text-3xl transition-colors">
                        &#8250;
                    </button>
                    @endif
                </div>
            </div>
            @elseif($post->cover_image_path)
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
