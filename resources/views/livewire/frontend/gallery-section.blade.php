<div x-data="{ lightbox: null }">
    <div class="text-center mb-10">
        <p class="text-brand-500 text-sm font-semibold uppercase tracking-widest mb-2">Gallery</p>
        <h2 class="text-3xl md:text-4xl font-bold text-brand-900" style="font-family:'Playfair Display',serif">Our Facilities & Team</h2>
    </div>

    {{-- Tabs --}}
    <div class="flex justify-center gap-2 mb-8">
        @foreach(['all' => 'All', 'facility' => 'Facility', 'team' => 'Team', 'events' => 'Events'] as $val => $label)
        <button wire:click="$set('activeSection', '{{ $val }}')"
            class="{{ $activeSection === $val ? 'bg-brand-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }} px-4 py-2 rounded-full text-sm font-medium border border-gray-200 transition-colors focus-visible:ring-2 focus-visible:ring-brand-500">
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- Image Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
        @forelse($images as $img)
        <div
            @click="lightbox = { src: '{{ $img->image_path }}', alt: '{{ addslashes($img->alt_text ?: $img->caption) }}' }"
            class="relative h-40 md:h-48 overflow-hidden rounded-xl cursor-pointer group">
            <img src="{{ $img->image_path }}" alt="{{ $img->alt_text ?: $img->caption }}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                <svg class="w-8 h-8 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                </svg>
            </div>
            @if($img->caption)
            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                <p class="text-white text-xs truncate">{{ $img->caption }}</p>
            </div>
            @endif
        </div>
        @empty
        <p class="col-span-4 text-center text-gray-400 py-8">No gallery images available.</p>
        @endforelse
    </div>

    {{-- Lightbox --}}
    <div
        x-show="lightbox"
        x-cloak
        x-transition
        @click.self="lightbox = null"
        @keydown.escape.window="lightbox = null"
        class="fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4"
        role="dialog"
        aria-modal="true"
        :aria-label="lightbox?.alt">
        <button @click="lightbox = null" class="absolute top-4 right-4 text-white hover:text-gray-300 focus-visible:ring-2 focus-visible:ring-white rounded" aria-label="Close lightbox">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img x-show="lightbox" :src="lightbox?.src" :alt="lightbox?.alt" class="max-w-full max-h-[90vh] rounded-xl shadow-2xl">
    </div>
</div>
