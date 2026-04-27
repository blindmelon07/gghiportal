<div>
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.hero-slides.create') }}"
            class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-4 py-2 rounded-xl text-sm transition-all">
            + New Slide
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($slides as $slide)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="relative">
                <img src="{{ $slide->image_path }}" alt="{{ $slide->title }}" class="w-full h-36 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                <div class="absolute bottom-2 left-3 right-3">
                    <p class="text-white text-sm font-semibold truncate">{{ $slide->title }}</p>
                    <p class="text-gray-300 text-xs truncate">{{ $slide->subtitle }}</p>
                </div>
            </div>
            <div class="p-3 flex items-center justify-between">
                <div class="flex gap-2 items-center">
                    <button wire:click="toggleActive({{ $slide->id }})"
                        class="{{ $slide->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs px-2 py-1 rounded-full">
                        {{ $slide->is_active ? 'Active' : 'Inactive' }}
                    </button>
                    <span class="text-xs text-gray-400">Order: {{ $slide->sort_order }}</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.hero-slides.edit', $slide) }}" class="text-brand-500 text-xs font-medium">Edit</a>
                    <button wire:click="confirmDelete({{ $slide->id }})" class="text-red-400 text-xs font-medium">Delete</button>
                </div>
            </div>
        </div>
        @empty
        <p class="text-gray-400 col-span-3 text-center py-8">No hero slides yet.</p>
        @endforelse
    </div>

    @if($confirmDelete)
    <div class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl">
            <h3 class="font-bold text-gray-800 mb-2">Delete Slide?</h3>
            <p class="text-sm text-gray-500 mb-6">The image will be permanently removed.</p>
            <div class="flex gap-3 justify-end">
                <button wire:click="$set('confirmDelete', false)" class="px-4 py-2 text-sm text-gray-600">Cancel</button>
                <button wire:click="delete()" class="px-4 py-2 bg-red-500 text-white text-sm font-semibold rounded-xl">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
