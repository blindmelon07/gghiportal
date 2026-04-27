<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'GSAC General Hospital Inc.' }}</title>
    <meta name="description" content="GSAC General Hospital Inc. — Your Health, Our Priority. Serving Balogo, Sorsogon.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">

{{-- Sticky Navbar --}}
<header class="sticky top-0 z-50 bg-white shadow-md border-b border-gray-100" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="flex items-center justify-between h-18 py-2">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="/images/gghi-logo.png" alt="GSAC General Hospital Inc." class="h-12 w-auto">
            </a>

            <nav class="hidden md:flex items-center gap-6" aria-label="Main navigation">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-600 transition-colors text-sm font-medium">Home</a>
                <a href="{{ route('services') }}" class="text-gray-600 hover:text-brand-600 transition-colors text-sm font-medium">Services</a>
                <a href="{{ route('home') }}#about" class="text-gray-600 hover:text-brand-600 transition-colors text-sm font-medium">About</a>
                <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-brand-600 transition-colors text-sm font-medium">Blog</a>
                <a href="{{ route('home') }}#contact" class="text-gray-600 hover:text-brand-600 transition-colors text-sm font-medium">Contact</a>
                <a href="tel:+639703117315" class="bg-red-600 text-white text-xs font-bold px-3 py-1.5 rounded-full hover:bg-red-700 transition-colors">🚨 +63 970 311 7315</a>
                <a href="{{ route('home') }}#contact" class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-4 py-2 rounded-xl text-sm shadow-sm transition-all duration-200">Book Appointment</a>
            </nav>

            <button @click="open = !open" class="md:hidden text-gray-600 hover:text-brand-600 p-2 focus-visible:ring-2 focus-visible:ring-brand-400 rounded" aria-label="Toggle menu">
                <svg x-show="!open" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="open" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div x-show="open" x-transition x-cloak class="md:hidden py-4 border-t border-gray-100">
            <nav class="flex flex-col gap-3" aria-label="Mobile navigation">
                <a href="{{ route('home') }}" class="text-gray-600 hover:text-brand-600 py-1 text-sm font-medium">Home</a>
                <a href="{{ route('services') }}" class="text-gray-600 hover:text-brand-600 py-1 text-sm font-medium">Services</a>
                <a href="{{ route('home') }}#about" class="text-gray-600 hover:text-brand-600 py-1 text-sm font-medium">About</a>
                <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-brand-600 py-1 text-sm font-medium">Blog</a>
                <a href="{{ route('home') }}#contact" class="text-gray-600 hover:text-brand-600 py-1 text-sm font-medium">Contact</a>
                <a href="tel:+639703117315" class="bg-red-600 text-white text-center font-bold px-4 py-2 rounded-full text-sm">🚨 +63 970 311 7315</a>
                <a href="{{ route('home') }}#contact" class="bg-brand-500 text-white text-center font-semibold px-4 py-2 rounded-xl text-sm">Book Appointment</a>
            </nav>
        </div>
    </div>
</header>

<main>
    {{ $slot }}
</main>

<footer class="bg-brand-900 text-gray-300 pt-16 pb-6">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-10">
            <div>
                <div class="mb-4">
                    <img src="/images/gghi-logo.png" alt="GSAC General Hospital Inc." class="h-12 w-auto">
                </div>
                <p class="text-sm text-gray-400 leading-relaxed">Your Health, Our Priority. Providing compassionate and comprehensive medical care to Sorsogon and surrounding communities.</p>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('home') }}" class="hover:text-blue-300 transition-colors">Home</a></li>
                    <li><a href="{{ route('services') }}" class="hover:text-blue-300 transition-colors">Our Services</a></li>
                    <li><a href="{{ route('home') }}#about" class="hover:text-blue-300 transition-colors">About Us</a></li>
                    <li><a href="{{ route('blog.index') }}" class="hover:text-blue-300 transition-colors">Health Blog</a></li>
                    <li><a href="{{ route('home') }}#contact" class="hover:text-blue-300 transition-colors">Contact Us</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Our Services</h3>
                <ul class="space-y-2 text-sm text-gray-400">
                    <li>Hemodialysis Center</li>
                    <li>Intensive Care Unit</li>
                    <li>Emergency Medical Services</li>
                    <li>OB-Gyne Services</li>
                    <li>Surgical Services</li>
                    <li>Laboratory Services</li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-semibold mb-4">Contact Info</h3>
                <ul class="space-y-2 text-sm">
                    <li class="flex gap-2 items-start"><span>📍</span><span>Purok 5 Brgy. Road, Balogo, Sorsogon</span></li>
                    <li class="flex gap-2"><span>📞</span><a href="tel:+639703117315" class="hover:text-blue-300">+63 970 311 7315</a></li>
                    <li class="flex gap-2"><span>🚨</span><a href="tel:+639703117315" class="text-red-400 hover:text-red-300">Emergency: +63 970 311 7315</a></li>
                    <li class="flex gap-2"><span>✉️</span><a href="mailto:gghi@gsac.coop" class="hover:text-blue-300">gghi@gsac.coop</a></li>
                </ul>
                <div class="mt-3 bg-blue-800 rounded-lg p-3 text-xs text-gray-400">
                    <strong class="text-white block mb-1">Working Hours</strong>
                    Emergency: 24/7 &bull; OPD: Mon–Sat 8AM–5PM
                </div>
            </div>
        </div>
        <div class="mb-8 rounded-xl overflow-hidden bg-blue-800 h-28 flex items-center justify-center text-gray-400 text-sm">
            📍 Purok 5 Brgy. Road, Balogo, Sorsogon
        </div>
        <div class="border-t border-blue-800 pt-6 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} GSAC General Hospital. All rights reserved.
        </div>
    </div>
</footer>

@livewireScripts
</body>
</html>
