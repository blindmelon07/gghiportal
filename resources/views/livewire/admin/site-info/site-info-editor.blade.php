<div>
    <form wire:submit="save" class="space-y-6">
        {{-- General --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3 mb-4">General Information</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Hospital Name</label>
                    <input type="text" wire:model="info.name"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tagline</label>
                    <input type="text" wire:model="info.tagline"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">About Text</label>
                    <textarea wire:model="info.about_text" rows="5"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500"></textarea>
                </div>
            </div>
        </div>

        {{-- Contact --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3 mb-4">Contact Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" wire:model="info.address"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" wire:model="info.phone"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Emergency Phone</label>
                    <input type="text" wire:model="info.emergency_phone"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" wire:model="info.email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Working Hours</label>
                    <input type="text" wire:model="info.working_hours"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-brand-500">
                </div>
            </div>
        </div>

        {{-- Branding --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="text-sm font-semibold text-gray-700 border-b border-gray-100 pb-3 mb-4">Branding</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Logo</label>
                    @if($info['logo_path'])
                        <img src="{{ $info['logo_path'] }}" alt="Logo" class="h-16 mb-2 border border-gray-100 rounded-lg p-1">
                    @endif
                    @if($logo && in_array($logo->getClientOriginalExtension(), ['jpg','jpeg','png','gif','webp','svg']))
                        <img src="{{ $logo->temporaryUrl() }}" alt="Logo preview" class="h-16 mb-2 border border-gray-100 rounded-lg p-1">
                    @endif
                    <input type="file" wire:model="logo" accept="image/*"
                        class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-3">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                    @if($info['favicon_path'])
                        <img src="{{ $info['favicon_path'] }}" alt="Favicon" class="h-10 mb-2 border border-gray-100 rounded p-1">
                    @endif
                    @if($favicon && in_array($favicon->getClientOriginalExtension(), ['jpg','jpeg','png','gif','webp','svg']))
                        <img src="{{ $favicon->temporaryUrl() }}" alt="Favicon preview" class="h-10 mb-2 border border-gray-100 rounded p-1">
                    @elseif($favicon)
                        <p class="text-xs text-gray-500 mb-2">{{ $favicon->getClientOriginalName() }} selected</p>
                    @endif
                    <input type="file" wire:model="favicon" accept="image/*"
                        class="text-sm text-gray-500 w-full border border-dashed border-gray-300 rounded-lg p-3">
                </div>
            </div>
        </div>

        <div class="flex justify-end">
            <button type="submit"
                class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-8 py-2.5 rounded-xl text-sm transition-all duration-200 shadow-sm">
                <span wire:loading.remove>Save All Changes</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </form>
</div>
