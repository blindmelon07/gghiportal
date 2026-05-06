<div class="py-12 px-4 md:px-8 max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-10">
        {{-- Article --}}
        <article class="lg:col-span-3">
            {{-- Image Slider with Lightbox --}}
            @if($slideImages->isNotEmpty())
            @php $images = $slideImages->pluck('image_path')->values()->toArray(); @endphp
            <div x-data="{
                    current: 0,
                    total: {{ count($images) }},
                    lightbox: false,
                    lightboxIndex: 0,
                    images: {{ Illuminate\Support\Js::from($images) }},
                    prev() { this.current = (this.current - 1 + this.total) % this.total },
                    next() { this.current = (this.current + 1) % this.total },
                    lbPrev() { this.lightboxIndex = (this.lightboxIndex - 1 + this.total) % this.total },
                    lbNext() { this.lightboxIndex = (this.lightboxIndex + 1) % this.total },
                }"
                @keydown.escape.window="lightbox = false"
                @keydown.arrow-left.window="if(lightbox) lbPrev()"
                @keydown.arrow-right.window="if(lightbox) lbNext()"
                style="margin-bottom:2rem">

                {{-- Main slider --}}
                <div style="position:relative;width:100%;height:480px;border-radius:1rem;overflow:hidden;background:#111;box-shadow:0 10px 40px rgba(0,0,0,.2);cursor:zoom-in"
                    @click="lightboxIndex = current; lightbox = true">

                    @foreach($slideImages as $i => $img)
                    <div style="position:absolute;inset:0;transition:opacity .5s"
                        x-show="current === {{ $i }}"
                        @if($i > 0) x-cloak @endif>
                        <img src="{{ $img->image_path }}" alt="{{ $post->title }}"
                            style="width:100%;height:100%;object-fit:cover;display:block">
                    </div>
                    @endforeach

                    @if(count($images) > 1)
                    {{-- Prev --}}
                    <button type="button" @click.stop="prev()"
                        style="position:absolute;left:12px;top:50%;transform:translateY(-50%);z-index:10;width:42px;height:42px;border-radius:50%;background:rgba(0,0,0,.5);color:#fff;border:none;font-size:24px;display:flex;align-items:center;justify-content:center;cursor:pointer">
                        &#8249;
                    </button>
                    {{-- Next --}}
                    <button type="button" @click.stop="next()"
                        style="position:absolute;right:12px;top:50%;transform:translateY(-50%);z-index:10;width:42px;height:42px;border-radius:50%;background:rgba(0,0,0,.5);color:#fff;border:none;font-size:24px;display:flex;align-items:center;justify-content:center;cursor:pointer">
                        &#8250;
                    </button>
                    {{-- Counter --}}
                    <div style="position:absolute;top:12px;left:12px;z-index:10;background:rgba(0,0,0,.5);color:#fff;font-size:12px;padding:3px 10px;border-radius:999px">
                        <span x-text="current + 1"></span> / {{ count($images) }}
                    </div>
                    {{-- Dots --}}
                    <div style="position:absolute;bottom:14px;left:0;right:0;display:flex;justify-content:center;gap:8px;z-index:10">
                        @foreach($slideImages as $i => $img)
                        <button type="button" @click.stop="current = {{ $i }}"
                            :style="current === {{ $i }} ? 'width:22px;background:#fff' : 'width:8px;background:rgba(255,255,255,.5)'"
                            style="height:8px;border-radius:999px;border:none;cursor:pointer;transition:all .3s">
                        </button>
                        @endforeach
                    </div>
                    {{-- Zoom hint --}}
                    <div style="position:absolute;top:12px;right:12px;background:rgba(0,0,0,.5);color:#fff;font-size:11px;padding:3px 10px;border-radius:999px;pointer-events:none">
                        🔍 Click to zoom
                    </div>
                    @endif
                </div>

                {{-- Thumbnail strip --}}
                @if(count($images) > 1)
                <div style="display:flex;gap:8px;margin-top:10px;overflow-x:auto;padding-bottom:4px">
                    @foreach($slideImages as $i => $img)
                    <button type="button" @click="current = {{ $i }}"
                        :style="current === {{ $i }}
                            ? 'flex-shrink:0;width:72px;height:72px;border-radius:8px;overflow:hidden;border:none;cursor:pointer;padding:0;transition:all .2s;outline:2px solid #0077b6;outline-offset:2px;opacity:1'
                            : 'flex-shrink:0;width:72px;height:72px;border-radius:8px;overflow:hidden;border:none;cursor:pointer;padding:0;transition:all .2s;opacity:.45'">
                        <img src="{{ $img->image_path }}" alt="Slide {{ $i + 1 }}"
                            style="width:100%;height:100%;object-fit:cover;display:block">
                    </button>
                    @endforeach
                </div>
                @endif

                {{-- Lightbox --}}
                <div x-show="lightbox"
                    x-cloak
                    x-transition:enter="transition-opacity duration-200"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="transition-opacity duration-150"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    style="position:fixed;inset:0;z-index:9999;background:rgba(0,0,0,.92);display:flex;align-items:center;justify-content:center;padding:16px"
                    @click.self="lightbox = false">

                    <button type="button" @click="lightbox = false"
                        style="position:absolute;top:16px;right:16px;background:rgba(255,255,255,.15);color:#fff;border:none;border-radius:50%;width:40px;height:40px;font-size:18px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                        ✕
                    </button>

                    <div style="position:absolute;top:16px;left:50%;transform:translateX(-50%);color:rgba(255,255,255,.6);font-size:13px">
                        <span x-text="lightboxIndex + 1"></span> / {{ count($images) }}
                    </div>

                    <img :src="images[lightboxIndex]" alt="{{ $post->title }}"
                        style="max-width:100%;max-height:85vh;object-fit:contain;border-radius:8px;box-shadow:0 25px 60px rgba(0,0,0,.5)">

                    @if(count($images) > 1)
                    <button type="button" @click="lbPrev()"
                        style="position:absolute;left:16px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.15);color:#fff;border:none;border-radius:50%;width:48px;height:48px;font-size:28px;cursor:pointer;display:flex;align-items:center;justify-content:center">
                        &#8249;
                    </button>
                    <button type="button" @click="lbNext()"
                        style="position:absolute;right:16px;top:50%;transform:translateY(-50%);background:rgba(255,255,255,.15);color:#fff;border:none;border-radius:50%;width:48px;height:48px;font-size:28px;cursor:pointer;display:flex;align-items:center;justify-content:center">
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
