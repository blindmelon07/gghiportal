<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <img src="https://picsum.photos/seed/hospital-about/800/600"
                    alt="GSAC General Hospital facility"
                    class="rounded-2xl w-full h-80 object-cover shadow-lg">
            </div>
            <div>
                <p class="text-brand-500 text-sm font-semibold uppercase tracking-widest mb-3">About Us</p>
                <h2 class="text-3xl md:text-4xl font-bold text-brand-900 mb-4 leading-tight" style="font-family:'Playfair Display',serif">
                    {{ \App\Models\HospitalInfo::get('tagline', 'Your Health, Our Priority') }}
                </h2>
                <p class="text-gray-600 leading-relaxed mb-8">
                    {{ \App\Models\HospitalInfo::get('about_text', 'GSAC General Hospital Inc. is committed to providing compassionate and comprehensive healthcare to the people of Sorsogon.') }}
                </p>

                {{-- Stats --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4"
                    x-data="{
                        stats: [
                            { label: 'Beds', value: '{{ \App\Models\HospitalInfo::get('beds', '450') }}', count: 0, target: {{ intval(\App\Models\HospitalInfo::get('beds', '450')) }} },
                            { label: 'Doctors', value: '{{ \App\Models\HospitalInfo::get('doctors', '120') }}', count: 0, target: {{ intval(\App\Models\HospitalInfo::get('doctors', '120')) }} },
                            { label: 'Years', value: '{{ \App\Models\HospitalInfo::get('years', '39') }}+', count: 0, target: {{ intval(\App\Models\HospitalInfo::get('years', '39')) }} },
                            { label: 'Patients', value: '50K+', count: 0, target: 50 },
                        ],
                        animate() {
                            this.stats.forEach(stat => {
                                let start = 0;
                                const increment = Math.ceil(stat.target / 60);
                                const timer = setInterval(() => {
                                    start = Math.min(start + increment, stat.target);
                                    stat.count = start;
                                    if (start >= stat.target) clearInterval(timer);
                                }, 25);
                            });
                        }
                    }"
                    x-intersect="animate()">
                    <template x-for="stat in stats" :key="stat.label">
                        <div class="text-center bg-brand-50 rounded-xl p-4 border border-brand-100">
                            <div class="text-2xl font-bold text-brand-600" x-text="stat.count + (stat.value.includes('+') ? '+' : '')"></div>
                            <div class="text-xs text-gray-500 mt-1" x-text="stat.label"></div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>
