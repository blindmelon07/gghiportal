<div class="py-16 px-4 md:px-8 max-w-7xl mx-auto">
    <div class="text-center mb-12">
        <h1 class="text-3xl md:text-4xl font-bold text-brand-900 mb-3" style="font-family:'Playfair Display',serif">Medical Services</h1>
        <p class="text-gray-500 max-w-xl mx-auto">Comprehensive healthcare services delivered by our team of specialists.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($services as $service)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow p-6">
            <div class="w-12 h-12 text-brand-500 mb-4">
                {!! $service->icon !!}
            </div>
            <h2 class="text-lg font-bold text-gray-800 mb-3">{{ $service->title }}</h2>
            <p class="text-gray-500 text-sm leading-relaxed">{{ $service->description }}</p>
        </div>
        @endforeach
    </div>
</div>
