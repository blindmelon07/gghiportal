<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div class="flex gap-3 flex-wrap">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search posts..."
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent w-56">
            <select wire:model.live="status" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                <option value="">All Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
            <select wire:model.live="sort" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                <option value="newest">Newest</option>
                <option value="oldest">Oldest</option>
                <option value="title">Title A-Z</option>
            </select>
        </div>
        <a href="{{ route('admin.posts.create') }}"
            class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-4 py-2 rounded-xl text-sm transition-all duration-200 shadow-sm text-center">
            + New Post
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 w-10">
                        <input type="checkbox" class="rounded border-gray-300">
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Cover</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Title</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($posts as $post)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <input type="checkbox" wire:model="selected" value="{{ $post->id }}" class="rounded border-gray-300">
                    </td>
                    <td class="px-4 py-3">
                        @if($post->cover_image_path)
                            <img src="{{ $post->cover_image_path }}" alt="{{ $post->title }}" class="w-12 h-10 object-cover rounded-lg">
                        @else
                            <div class="w-12 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs">No img</div>
                        @endif
                    </td>
                    <td class="px-4 py-3 max-w-[200px]">
                        <p class="font-medium text-gray-800 truncate">{{ $post->title }}</p>
                        <p class="text-xs text-gray-400">{{ $post->author_name }}</p>
                    </td>
                    <td class="px-4 py-3 text-gray-500">{{ $post->category ?: '—' }}</td>
                    <td class="px-4 py-3">
                        <button wire:click="togglePublish({{ $post->id }})"
                            class="{{ $post->is_published ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-500 hover:bg-gray-200' }} text-xs px-2 py-1 rounded-full transition-colors cursor-pointer"
                            wire:loading.attr="disabled">
                            {{ $post->is_published ? 'Published' : 'Draft' }}
                        </button>
                    </td>
                    <td class="px-4 py-3 text-gray-400 text-xs">{{ $post->created_at->format('M d, Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.posts.edit', $post) }}"
                                class="text-brand-500 hover:text-brand-700 text-xs font-medium">Edit</a>
                            <button wire:click="confirmDelete({{ $post->id }})"
                                class="text-red-400 hover:text-red-600 text-xs font-medium">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-4 py-8 text-center text-gray-400">No posts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="px-4 py-3 border-t border-gray-100">
            {{ $posts->links() }}
        </div>
    </div>

    {{-- Delete Confirm Modal --}}
    @if($confirmDelete)
    <div class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4" x-data>
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl">
            <h3 class="font-bold text-gray-800 mb-2">Delete Post?</h3>
            <p class="text-sm text-gray-500 mb-6">This action cannot be undone. The cover image will also be removed.</p>
            <div class="flex gap-3 justify-end">
                <button wire:click="$set('confirmDelete', false)"
                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800">Cancel</button>
                <button wire:click="delete()"
                    class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl transition-colors">
                    Delete
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
