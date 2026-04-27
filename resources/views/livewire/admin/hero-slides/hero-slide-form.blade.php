<div>
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.hero-slides.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">Hero Slides</a>
        <span class="text-gray-300">/</span>
        <span class="text-sm text-gray-700">{{ $pageTitle }}</span>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" wire:model="title"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 @error('title') border-red-400 @enderror">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Subtitle</label>
                <input type="text" wire:model="subtitle"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button Text</label>
                    <input type="text" wire:model="button_text" placeholder="e.g. Our Services"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Button URL</label>
                    <input type="text" wire:model="button_url" placeholder="e.g. /services"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
            </div>

            {{-- Live Preview --}}
            @if($existingImage || $image)
            <div class="relative rounded-xl overflow-hidden mt-4">
                <img src="{{ $image ? $image->temporaryUrl() : $existingImage }}" alt="Preview" class="w-full h-44 object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent flex flex-col items-center justify-center text-center p-4">
                    <p class="text-white font-bold text-lg">{{ $title ?: 'Slide Title' }}</p>
                    <p class="text-gray-300 text-sm mt-1">{{ $subtitle ?: 'Subtitle goes here' }}</p>
                    @if($button_text)
                    <span class="mt-3 bg-brand-500 text-white text-xs px-4 py-1.5 rounded-full">{{ $button_text }}</span>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Settings</h3>
                <div class="mb-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-brand-500">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" wire:model="sort_order"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <button type="submit" class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 rounded-xl text-sm">
                    <span wire:loading.remove>Save Slide</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Slide Image</h3>
                @if($existingImage && ! $image)
                    <img src="{{ $existingImage }}" alt="Current" class="w-full h-24 object-cover rounded-lg mb-3">
                @endif
                @if($image)
                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-full h-24 object-cover rounded-lg mb-3">
                @endif
                <input type="file" wire:model="image" accept="image/*"
                    class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-3">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>
    </form>
</div>
