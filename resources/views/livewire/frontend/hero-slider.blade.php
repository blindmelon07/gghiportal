<section
    x-data="{
        current: 0,
        slides: {{ $slides->count() }},
        autoPlay() {
            setInterval(() => {
                this.current = (this.current + 1) % this.slides;
            }, 5000);
        }
    }"
    x-init="autoPlay()"
    class="relative w-full h-[85vh] min-h-[500px] overflow-hidden"
    aria-label="Hospital hero slideshow">

    @foreach($slides as $i => $slide)
    <div
        x-show="current === {{ $i }}"
        x-transition:enter="transition-opacity duration-700"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity duration-700"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute inset-0">
        <img
            src="{{ $slide->image_path }}"
            alt="{{ $slide->title }}"
            class="w-full h-full object-cover"
            {{ $i > 0 ? 'loading=lazy' : '' }}>
        <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/50 to-black/60"></div>
        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4 md:px-8">
            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold text-white mb-4 max-w-3xl leading-tight" style="font-family:'Playfair Display',serif">
                {{ $slide->title }}
            </h1>
            @if($slide->subtitle)
            <p class="text-gray-200 text-lg md:text-xl mb-8 max-w-xl">{{ $slide->subtitle }}</p>
            @endif
            @if($slide->button_text && $slide->button_url)
            <a href="{{ $slide->button_url }}"
                class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-8 py-3 rounded-xl text-base transition-all duration-200 shadow-lg hover:shadow-xl focus-visible:ring-2 focus-visible:ring-white">
                {{ $slide->button_text }}
            </a>
            @endif
        </div>
    </div>
    @endforeach

    {{-- Dots --}}
    @if($slides->count() > 1)
    <div class="absolute bottom-6 left-0 right-0 flex justify-center gap-2" role="tablist" aria-label="Slide controls">
        @foreach($slides as $i => $slide)
        <button
            x-on:click="current = {{ $i }}"
            :class="current === {{ $i }} ? 'bg-white w-6' : 'bg-white/50 w-2'"
            class="h-2 rounded-full transition-all duration-300 focus-visible:ring-2 focus-visible:ring-white"
            role="tab"
            :aria-selected="current === {{ $i }}"
            aria-label="Go to slide {{ $i + 1 }}">
        </button>
        @endforeach
    </div>
    @endif
</section>
