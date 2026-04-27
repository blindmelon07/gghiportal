<div>
    <div class="text-center mb-12">
        <h2 class="text-3xl md:text-4xl font-bold text-brand-900 mb-3" style="font-family:'Playfair Display',serif">Our Medical Services</h2>
        <p class="text-gray-500 max-w-xl mx-auto">Comprehensive healthcare services delivered by specialists dedicated to your well-being.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach($services as $service)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow p-5 text-center group">
            <div class="w-12 h-12 text-brand-500 mx-auto mb-4">
                {!! $service->icon !!}
            </div>
            <h3 class="font-semibold text-gray-800 mb-2 text-sm md:text-base">{{ $service->title }}</h3>
            <p class="text-gray-500 text-xs md:text-sm leading-relaxed line-clamp-2">{{ $service->description }}</p>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-10">
        <a href="{{ route('services') }}" class="bg-brand-500 hover:bg-brand-600 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 shadow-sm text-sm inline-block">
            View All Services
        </a>
    </div>
</div>
