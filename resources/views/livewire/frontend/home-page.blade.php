<div>
    {{-- Hero --}}
    <livewire:frontend.hero-slider />

    {{-- Services --}}
    <section id="services" class="py-20 px-4 md:px-8 max-w-7xl mx-auto">
        <livewire:frontend.services-grid />
    </section>

    {{-- About --}}
    @include('frontend.partials.about')

    {{-- Latest Posts --}}
    <section class="py-20 px-4 md:px-8 max-w-7xl mx-auto">
        <livewire:frontend.latest-posts />
    </section>

    {{-- Gallery --}}
    <section class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <livewire:frontend.gallery-section />
        </div>
    </section>

    {{-- Contact --}}
    <section id="contact" class="py-20">
        <livewire:frontend.contact-form />
    </section>
</div>
