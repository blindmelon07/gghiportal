<div>
    <div class="flex justify-end mb-6">
        <a href="{{ route('admin.services.create') }}"
            class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-4 py-2 rounded-xl text-sm transition-all duration-200 shadow-sm">
            + New Service
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Icon</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Title</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Active</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Featured</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Order</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($services as $service)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="w-8 h-8 text-brand-500">{!! $service->icon !!}</div>
                    </td>
                    <td class="px-4 py-3 font-medium text-gray-800">{{ $service->title }}</td>
                    <td class="px-4 py-3">
                        <button wire:click="toggleActive({{ $service->id }})"
                            class="{{ $service->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} text-xs px-2 py-1 rounded-full hover:opacity-80 transition-opacity">
                            {{ $service->is_active ? 'Active' : 'Inactive' }}
                        </button>
                    </td>
                    <td class="px-4 py-3">
                        <button wire:click="toggleFeatured({{ $service->id }})"
                            class="{{ $service->is_featured ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-500' }} text-xs px-2 py-1 rounded-full hover:opacity-80">
                            {{ $service->is_featured ? 'Featured' : 'Normal' }}
                        </button>
                    </td>
                    <td class="px-4 py-3 text-gray-400">{{ $service->sort_order }}</td>
                    <td class="px-4 py-3">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.services.edit', $service) }}" class="text-brand-500 hover:text-brand-700 text-xs font-medium">Edit</a>
                            <button wire:click="confirmDelete({{ $service->id }})" class="text-red-400 hover:text-red-600 text-xs font-medium">Delete</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-gray-400">No services found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($confirmDelete)
    <div class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-xl">
            <h3 class="font-bold text-gray-800 mb-2">Delete Service?</h3>
            <p class="text-sm text-gray-500 mb-6">This cannot be undone.</p>
            <div class="flex gap-3 justify-end">
                <button wire:click="$set('confirmDelete', false)" class="px-4 py-2 text-sm font-medium text-gray-600">Cancel</button>
                <button wire:click="delete()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white text-sm font-semibold rounded-xl">Delete</button>
            </div>
        </div>
    </div>
    @endif
</div>
