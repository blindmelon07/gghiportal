<div>
    {{-- Upload Section --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
        <h2 class="text-sm font-semibold text-gray-700 mb-4">Upload Images</h2>
        <div class="flex gap-4 flex-wrap items-end">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Section</label>
                <select wire:model="uploadSection" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                    <option value="facility">Facility</option>
                    <option value="team">Team</option>
                    <option value="events">Events</option>
                </select>
            </div>
            <div class="flex-1 min-w-48">
                <label class="block text-xs font-medium text-gray-600 mb-1">Select Images</label>
                <input type="file" wire:model="images" multiple accept="image/*"
                    class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-2 hover:border-brand-400 transition-colors">
                <div wire:loading wire:target="images" class="text-xs text-gray-400 mt-1">Processing...</div>
            </div>
            <button wire:click="upload"
                class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-4 py-2 rounded-xl text-sm transition-all">
                <span wire:loading.remove wire:target="upload">Upload</span>
                <span wire:loading wire:target="upload">Uploading...</span>
            </button>
        </div>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex gap-2 mb-4">
        @foreach(['all' => 'All', 'facility' => 'Facility', 'team' => 'Team', 'events' => 'Events'] as $val => $label)
        <button wire:click="$set('filterSection', '{{ $val }}')"
            class="{{ $filterSection === $val ? 'bg-brand-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }} px-4 py-1.5 rounded-full text-sm font-medium border border-gray-200 transition-colors">
            {{ $label }}
        </button>
        @endforeach
    </div>

    {{-- Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
        @forelse($galleryImages as $img)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group relative">
            <img src="{{ $img->image_path }}" alt="{{ $img->alt_text }}" class="w-full h-32 object-cover">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>

            @if($editingId === $img->id)
            <div class="p-2 space-y-1">
                <input type="text" wire:model="editCaption" placeholder="Caption"
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs focus:ring-1 focus:ring-brand-500">
                <input type="text" wire:model="editAlt" placeholder="Alt text"
                    class="w-full border border-gray-300 rounded px-2 py-1 text-xs focus:ring-1 focus:ring-brand-500">
                <div class="flex gap-1 justify-end">
                    <button wire:click="saveEdit" class="text-xs bg-brand-500 text-white px-2 py-1 rounded">Save</button>
                    <button wire:click="$set('editingId', null)" class="text-xs text-gray-500 px-2 py-1">Cancel</button>
                </div>
            </div>
            @else
            <div class="p-2">
                <p class="text-xs text-gray-600 truncate">{{ $img->caption ?: 'No caption' }}</p>
                <span class="text-xs bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded">{{ $img->section }}</span>
            </div>
            <div class="flex gap-1 px-2 pb-2">
                <button wire:click="startEdit({{ $img->id }})" class="text-brand-500 text-xs">Edit</button>
                <button wire:click="delete({{ $img->id }})"
                    wire:confirm="Delete this image?"
                    class="text-red-400 text-xs ml-auto">Delete</button>
            </div>
            @endif
        </div>
        @empty
        <p class="col-span-5 text-center text-gray-400 py-8">No gallery images. Upload some above.</p>
        @endforelse
    </div>
</div>
