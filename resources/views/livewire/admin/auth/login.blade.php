<div class="bg-white rounded-2xl shadow-xl p-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6 text-center">Sign in to Admin</h2>

    <form wire:submit="authenticate" novalidate>
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input
                type="email"
                id="email"
                wire:model="email"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('email') border-red-400 @enderror"
                autocomplete="email"
                autofocus>
            @error('email')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input
                type="password"
                id="password"
                wire:model="password"
                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('password') border-red-400 @enderror"
                autocomplete="current-password">
            @error('password')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center mb-6">
            <input type="checkbox" id="remember" wire:model="remember" class="rounded border-gray-300 text-brand-500">
            <label for="remember" class="ml-2 text-sm text-gray-600">Remember me</label>
        </div>

        <button
            type="submit"
            class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-2.5 px-4 rounded-xl transition-all duration-200 flex items-center justify-center gap-2 focus-visible:ring-2 focus-visible:ring-brand-400">
            <span wire:loading.remove>Sign In</span>
            <span wire:loading>
                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
            </span>
        </button>
    </form>
</div>
