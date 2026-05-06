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

            {{-- Post Type Switcher --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <label class="block text-sm font-semibold text-gray-700 mb-3">Post Type</label>
                <div class="flex gap-3">
                    <label class="flex-1 flex items-center gap-3 border rounded-xl px-4 py-3 cursor-pointer transition-colors {{ $post_type === 'article' ? 'border-brand-500 bg-brand-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" wire:model.live="post_type" value="article" class="text-brand-500">
                        <div>
                            <p class="text-sm font-medium text-gray-800">📝 Article</p>
                            <p class="text-xs text-gray-400">Text content with images</p>
                        </div>
                    </label>
                    <label class="flex-1 flex items-center gap-3 border rounded-xl px-4 py-3 cursor-pointer transition-colors {{ $post_type === 'video' ? 'border-red-500 bg-red-50' : 'border-gray-200 hover:border-gray-300' }}">
                        <input type="radio" wire:model.live="post_type" value="video" class="text-red-500">
                        <div>
                            <p class="text-sm font-medium text-gray-800">🎬 Video</p>
                            <p class="text-xs text-gray-400">YouTube or Vimeo embed</p>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Video URL (only for video posts) --}}
            @if($post_type === 'video')
            <div class="bg-white rounded-xl shadow-sm border border-red-100 p-5">
                <label class="block text-sm font-semibold text-gray-700 mb-1">Video URL <span class="text-red-500">*</span></label>
                <p class="text-xs text-gray-400 mb-3">Paste a YouTube or Vimeo link (e.g. https://youtube.com/watch?v=...)</p>
                <input type="url" wire:model="video_url" placeholder="https://www.youtube.com/watch?v=..."
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-red-400 @error('video_url') border-red-400 @enderror">
                @error('video_url') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror

                @if($video_url)
                <div class="mt-3 text-xs text-gray-400">
                    Preview will appear on the post page after saving.
                </div>
                @endif
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" wire:model.live.debounce.800ms="title"
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
                        Body
                        @if($post_type === 'article') <span class="text-red-500">*</span> @endif
                        <span class="text-gray-400 font-normal">(Markdown supported)</span>
                    </label>
                    <textarea wire:model="body" rows="14"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:ring-2 focus:ring-brand-500 @error('body') border-red-400 @enderror"></textarea>
                    @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Slider Images (article only) --}}
            @if($post_type === 'article')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Slider Images</h3>
                <p class="text-xs text-gray-400 mb-4">These appear as a slideshow on the post page. Upload multiple images.</p>

                {{-- Existing slider images --}}
                @if($slideImages->isNotEmpty())
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                    @foreach($slideImages as $img)
                    <div class="relative group">
                        <img src="{{ $img->image_path }}" class="w-full h-28 object-cover rounded-lg">
                        <button type="button"
                            wire:click="deleteSlideImage({{ $img->id }})"
                            wire:confirm="Remove this slide image?"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            ✕
                        </button>
                    </div>
                    @endforeach
                </div>
                @endif

                @if(count($newImages) > 0)
                <div class="flex items-center gap-2 mb-3 text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg px-3 py-2">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 00-1.414 0L8 12.586 4.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" clip-rule="evenodd"/></svg>
                    {{ count($newImages) }} image(s) ready — click Save Post to upload
                </div>
                @endif

                <div class="relative">
                    <input type="file" wire:model="newImages" multiple
                        accept="image/*,.heic,.heif"
                        class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-3 hover:border-brand-400 transition-colors cursor-pointer">

                    <div wire:loading wire:target="newImages"
                        class="absolute inset-0 bg-white/80 backdrop-blur-sm rounded-lg flex flex-col items-center justify-center gap-2">
                        <svg class="animate-spin w-6 h-6 text-brand-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span class="text-xs font-medium text-brand-600">Uploading images, please wait...</span>
                    </div>
                </div>
                @error('newImages.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            @endif {{-- end article-only slider section --}}
        </div>

        <div class="space-y-5">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <h3 class="text-sm font-semibold text-gray-700 mb-4">Publish Settings</h3>
                <div class="flex items-center gap-3 mb-4">
                    <input type="checkbox" id="is_published" wire:model="is_published"
                        class="rounded border-gray-300 text-brand-500 w-4 h-4">
                    <label for="is_published" class="text-sm text-gray-700">Published</label>
                </div>
                <button type="submit" wire:loading.attr="disabled"
                    class="w-full bg-brand-500 hover:bg-brand-600 disabled:opacity-60 disabled:cursor-not-allowed text-white font-semibold py-2.5 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2">
                    <svg wire:loading class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span wire:loading.remove>Save Post</span>
                    <span wire:loading>Saving & optimizing images...</span>
                </button>
            </div>

            {{-- Cover Image --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5"
                x-data="{ previewUrl: '{{ $existingImage ?? '' }}' }"
                x-on:livewire-upload-finish="previewUrl = previewUrl">
                <h3 class="text-sm font-semibold text-gray-700 mb-1">Cover Image</h3>
                <p class="text-xs text-gray-400 mb-3">Shown in post listings and as the hero image.</p>
                <img x-show="previewUrl" :src="previewUrl" alt="Preview"
                    class="w-full h-32 object-cover rounded-lg mb-3">
                <input type="file" wire:model="cover_image" accept="image/*,.heic,.heif"
                    @change="
                        const file = $event.target.files[0];
                        if (file && file.type.startsWith('image/')) {
                            const reader = new FileReader();
                            reader.onload = e => previewUrl = e.target.result;
                            reader.readAsDataURL(file);
                        }
                    "
                    class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-3 hover:border-brand-400 transition-colors cursor-pointer">
                <div wire:loading wire:target="cover_image" class="text-xs text-gray-400 mt-1">Uploading...</div>
            </div>
        </div>
    </form>
</div>
