<div class="bg-gradient-to-br from-brand-900 to-brand-700 py-20 px-4 md:px-8">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            {{-- Contact Info --}}
            <div class="text-white">
                <p class="text-blue-300 text-sm font-semibold uppercase tracking-widest mb-3">Contact Us</p>
                <h2 class="text-3xl md:text-4xl font-bold mb-6" style="font-family:'Playfair Display',serif">Get In Touch</h2>
                <div class="space-y-4 text-gray-200">
                    <div class="flex items-start gap-3">
                        <span class="text-xl mt-0.5">📍</span>
                        <span>Purok 5 Brgy. Road, Balogo, Sorsogon</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl">📞</span>
                        <a href="tel:+639703117315" class="hover:text-white">+63 970 311 7315</a>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl">🚨</span>
                        <span class="text-red-300 font-semibold">Emergency: +63 970 311 7315 (24/7)</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✉️</span>
                        <a href="mailto:gghi@gsac.coop" class="hover:text-white">gghi@gsac.coop</a>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="text-xl mt-0.5">🕐</span>
                        <div>
                            <p class="font-semibold text-white">Working Hours</p>
                            <p class="text-sm">Emergency: 24/7</p>
                            <p class="text-sm">OPD: Monday – Saturday, 8:00 AM – 5:00 PM</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Contact Form --}}
            <div class="bg-white rounded-2xl p-6 shadow-xl">
                @if($submitted)
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Thank you for your message!</h3>
                    <p class="text-gray-500 text-sm mb-4">We will get back to you within 24 hours.</p>
                    <button wire:click="$set('submitted', false)" class="text-brand-500 text-sm font-medium hover:underline">Send another message</button>
                </div>
                @else
                <h3 class="text-lg font-bold text-gray-800 mb-5">Send Us a Message</h3>
                <form wire:submit="submit" novalidate>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Full Name *</label>
                            <input type="text" wire:model="name"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('name') border-red-400 @enderror">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Email *</label>
                            <input type="email" wire:model="email"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 focus:border-transparent @error('email') border-red-400 @enderror">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Phone</label>
                            <input type="tel" wire:model="phone"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Subject</label>
                            <input type="text" wire:model="subject"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500">
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Message *</label>
                        <textarea wire:model="message" rows="4"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-brand-500 @error('message') border-red-400 @enderror"
                            placeholder="How can we help you?"></textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit"
                        class="w-full bg-brand-500 hover:bg-brand-600 text-white font-semibold py-3 rounded-xl text-sm transition-all duration-200 flex items-center justify-center gap-2 focus-visible:ring-2 focus-visible:ring-brand-400">
                        <span wire:loading.remove>Send Message</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Sending...
                        </span>
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
