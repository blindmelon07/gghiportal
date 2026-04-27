<div>
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.services.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">Services</a>
        <span class="text-gray-300">/</span>
        <span class="text-sm text-gray-700">{{ $pageTitle }}</span>
    </div>

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                <input type="text" wire:model.live="title"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 @error('title') border-red-400 @enderror">
                @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                <input type="text" wire:model="slug"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-brand-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Icon (SVG code or emoji)</label>
                <textarea wire:model="icon" rows="3"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-brand-500"
                    placeholder="Paste SVG code or emoji like 🏥"></textarea>
                @if($icon)
                <div class="mt-2 w-10 h-10 text-brand-500">{!! $icon !!}</div>
                @endif
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-red-500">*</span></label>
                <textarea wire:model="description" rows="4"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 @error('description') border-red-400 @enderror"></textarea>
                @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Settings</h3>
                <div class="space-y-3 mb-4">
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_active" class="rounded border-gray-300 text-brand-500">
                        <span class="text-sm text-gray-700">Active</span>
                    </label>
                    <label class="flex items-center gap-3">
                        <input type="checkbox" wire:model="is_featured" class="rounded border-gray-300 text-brand-500">
                        <span class="text-sm text-gray-700">Featured on homepage</span>
                    </label>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                    <input type="number" wire:model="sort_order"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <button type="submit"
                    class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 rounded-xl text-sm transition-all duration-200">
                    <span wire:loading.remove>Save Service</span>
                    <span wire:loading>Saving...</span>
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Service Image</h3>
                @if($existingImage && ! $image)
                    <img src="{{ $existingImage }}" alt="Service" class="w-full h-28 object-cover rounded-lg mb-3">
                @endif
                @if($image)
                    <img src="{{ $image->temporaryUrl() }}" alt="Preview" class="w-full h-28 object-cover rounded-lg mb-3">
                @endif
                <input type="file" wire:model="image" accept="image/*"
                    class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-3 hover:border-brand-400 transition-colors cursor-pointer">
            </div>
        </div>
    </form>
</div>
