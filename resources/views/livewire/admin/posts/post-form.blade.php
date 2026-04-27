<div>
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.posts.index') }}" class="text-gray-400 hover:text-gray-600 text-sm">Posts</a>
        <span class="text-gray-300">/</span>
        <span class="text-sm text-gray-700">{{ $pageTitle }}</span>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <form wire:submit="save" class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live="title"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('title') border-red-400 @enderror">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" wire:model="slug"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-brand-500">
                </div>
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <input type="text" wire:model="category" placeholder="e.g. Health Tips"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Author <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="author_name"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 @error('author_name') border-red-400 @enderror">
                        @error('author_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Excerpt</label>
                    <textarea wire:model="excerpt" rows="2"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Body <span class="text-red-500">*</span>
                        <span class="text-gray-400 font-normal">(Markdown supported)</span>
                    </label>
                    <textarea wire:model="body" rows="14"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-brand-500 @error('body') border-red-400 @enderror"></textarea>
                    @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Publish Settings</h3>
                <div class="flex items-center gap-3 mb-4">
                    <input type="checkbox" id="is_published" wire:model="is_published"
                        class="rounded border-gray-300 text-brand-500 w-4 h-4">
                    <label for="is_published" class="text-sm text-gray-700">Published</label>
                </div>
                <button type="submit"
                    class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2">
                    <span wire:loading.remove>Save Post</span>
                    <span wire:loading class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                        Saving...
                    </span>
                </button>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Cover Image</h3>
                @if($existingImage && ! $cover_image)
                    <img src="{{ $existingImage }}" alt="Cover" class="w-full h-32 object-cover rounded-lg mb-3">
                @endif
                @if($cover_image)
                    <img src="{{ $cover_image->temporaryUrl() }}" alt="Preview" class="w-full h-32 object-cover rounded-lg mb-3">
                @endif
                <input type="file" wire:model="cover_image" accept="image/*"
                    class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-3 hover:border-brand-400 transition-colors cursor-pointer">
                <div wire:loading wire:target="cover_image" class="text-xs text-gray-400 mt-1">Uploading...</div>
            </div>
        </div>
    </form>
</div>
