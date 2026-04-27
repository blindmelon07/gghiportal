<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\GalleryImage;
use App\Models\HeroSlide;
use App\Models\HospitalInfo;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedHospitalInfo();
        $this->seedHeroSlides();
        $this->seedServices();
        $this->seedPosts();
        $this->seedGallery();
        $this->seedAdmin();
    }

    private function seedHospitalInfo(): void
    {
        $infos = [
            'name'            => 'GSAC General Hospital Inc.',
            'tagline'         => 'Your Health, Our Priority',
            'address'         => 'Purok 5 Brgy. Road, Balogo, Sorsogon',
            'phone'           => '+63 970 311 7315',
            'email'           => 'gghi@gsac.coop',
            'emergency_phone' => '+63 970 311 7315',
            'about_text'      => 'GSAC General Hospital Inc. is committed to providing compassionate, comprehensive, and quality healthcare to the people of Sorsogon and the surrounding communities. With a dedicated team of medical professionals and modern facilities, we strive to deliver excellent patient care across a wide range of medical and diagnostic services.',
            'logo_path'       => '/images/gghi-logo.png',
            'favicon_path'    => '',
            'working_hours'   => 'Emergency: 24/7 | OPD: Mon–Sat 8:00 AM – 5:00 PM',
            'beds'            => '100',
            'doctors'         => '50',
            'years'           => '20',
            'patients_yearly' => '20,000+',
        ];
        foreach ($infos as $key => $value) {
            HospitalInfo::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    private function seedHeroSlides(): void
    {
        $slides = [
            [
                'title'       => 'Your Health, Our Priority',
                'subtitle'    => 'Providing comprehensive medical services to Sorsogon and surrounding communities.',
                'button_text' => 'Our Services',
                'button_url'  => '/services',
                'image_path'  => 'https://picsum.photos/seed/hospital1/1600/900',
                'sort_order'  => 1,
            ],
            [
                'title'       => 'Advanced Diagnostic Services',
                'subtitle'    => 'Equipped with modern diagnostic technology — X-ray, Ultrasound, and complete laboratory services.',
                'button_text' => 'Learn More',
                'button_url'  => '/#about',
                'image_path'  => 'https://picsum.photos/seed/medical2/1600/900',
                'sort_order'  => 2,
            ],
            [
                'title'       => 'Compassionate Care for Every Patient',
                'subtitle'    => 'From the ICU to the Neonatal Unit, our specialists are dedicated to your recovery.',
                'button_text' => 'Book Appointment',
                'button_url'  => '/#contact',
                'image_path'  => 'https://picsum.photos/seed/doctors3/1600/900',
                'sort_order'  => 3,
            ],
            [
                'title'       => '24/7 Emergency Medical Services',
                'subtitle'    => 'Round-the-clock emergency and ambulance services when you need us most.',
                'button_text' => 'Contact Us',
                'button_url'  => '/#contact',
                'image_path'  => 'https://picsum.photos/seed/emergency4/1600/900',
                'sort_order'  => 4,
            ],
        ];

        foreach ($slides as $slide) {
            HeroSlide::create(array_merge($slide, ['is_active' => true]));
        }
    }

    private function seedServices(): void
    {
        // SVG icon helpers
        $icons = [
            'dialysis'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714a2.25 2.25 0 001.357 2.059l.842.335c1.018.407 1.585 1.494 1.348 2.563l-.523 2.358a2.25 2.25 0 01-2.19 1.757H8.085a2.25 2.25 0 01-2.19-1.757l-.523-2.358c-.237-1.07.33-2.156 1.348-2.563l.842-.335a2.25 2.25 0 001.357-2.059V3.104"/></svg>',
            'icu'       => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/></svg>',
            'nicu'      => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z"/></svg>',
            'medicine'  => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .405.162.79.449 1.076l1.184 1.184c.39.39.39 1.024 0 1.414l-1.184 1.184A1.5 1.5 0 0013.5 21h-3a1.5 1.5 0 01-1.06-.44l-1.184-1.184a1.5 1.5 0 010-2.121l1.184-1.184A1.5 1.5 0 009.75 15V8.818"/></svg>',
            'lab'       => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M14.25 6.087c0-.355.186-.676.401-.959.221-.29.349-.634.349-1.003 0-1.036-1.007-1.875-2.25-1.875s-2.25.84-2.25 1.875c0 .369.128.713.349 1.003.215.283.401.604.401.959v0a.64.64 0 01-.657.643 48.39 48.39 0 01-4.163-.3c.186 1.613.293 3.25.315 4.907a.656.656 0 01-.658.663v0c-.355 0-.676-.186-.959-.401a1.647 1.647 0 00-1.003-.349c-1.036 0-1.875 1.007-1.875 2.25s.84 2.25 1.875 2.25c.369 0 .713-.128 1.003-.349.283-.215.604-.401.959-.401v0c.31 0 .555.26.532.57a48.039 48.039 0 01-.642 5.056c1.518.19 3.058.309 4.616.354a.64.64 0 00.657-.643v0c0-.355-.186-.676-.401-.959a1.647 1.647 0 01-.349-1.003c0-1.035 1.008-1.875 2.25-1.875 1.243 0 2.25.84 2.25 1.875 0 .369-.128.713-.349 1.003-.215.283-.4.604-.4.959v0c0 .333.277.599.61.58a48.1 48.1 0 005.427-.63 48.05 48.05 0 00.582-4.717.532.532 0 00-.533-.57v0c-.355 0-.676.186-.959.401-.29.221-.634.349-1.003.349-1.035 0-1.875-1.007-1.875-2.25s.84-2.25 1.875-2.25c.37 0 .713.128 1.003.349.283.215.604.401.959.401v0a.656.656 0 00.658-.663 48.422 48.422 0 00-.37-5.36c-1.886.342-3.81.574-5.766.689a.578.578 0 01-.61-.58v0z"/></svg>',
            'dental'    => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
            'obgyne'    => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253M3 12a8.959 8.959 0 01.284-2.253"/></svg>',
            'ortho'     => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>',
            'emergency' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>',
            'surgery'   => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 3.75H6A2.25 2.25 0 003.75 6v1.5M16.5 3.75H18A2.25 2.25 0 0120.25 6v1.5m0 9V18A2.25 2.25 0 0118 20.25h-1.5m-9 0H6A2.25 2.25 0 013.75 18v-1.5M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            'opd'       => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/></svg>',
            'ambulance' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>',
            'ultrasound'=> '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z"/></svg>',
            'xray'      => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776"/></svg>',
            'eent'      => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
            'isolation' => '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>',
            'philhealth'=> '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/></svg>',
            'anesthesia'=> '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
        ];

        $services = [
            // Core Clinical Services
            ['title' => 'Hemodialysis Center',           'icon_key' => 'dialysis',   'description' => 'State-of-the-art hemodialysis services for patients with kidney disease, managed by trained nephrology staff in a comfortable and safe environment.', 'sort_order' => 1],
            ['title' => 'Intensive Care Unit (ICU)',      'icon_key' => 'icu',        'description' => 'Round-the-clock critical care for severely ill patients, staffed by experienced intensivists, nurses, and support personnel using advanced life-support equipment.', 'sort_order' => 2],
            ['title' => 'Neonatal Intensive Care Unit',  'icon_key' => 'nicu',       'description' => 'Specialized care for premature and critically ill newborns, with modern incubators, monitoring systems, and a dedicated neonatology team.', 'sort_order' => 3],
            ['title' => 'Internal Medicine',             'icon_key' => 'medicine',   'description' => 'Comprehensive diagnosis and treatment of adult diseases including diabetes, hypertension, respiratory, and cardiovascular conditions by board-certified internists.', 'sort_order' => 4],
            ['title' => 'Complete Laboratory Services',  'icon_key' => 'lab',        'description' => 'Full-service clinical laboratory offering a wide range of diagnostic tests including blood chemistry, hematology, urinalysis, microbiology, and more.', 'sort_order' => 5],
            ['title' => 'Dental Services',               'icon_key' => 'dental',     'description' => 'General and preventive dentistry services including teeth cleaning, extraction, fillings, and oral health consultations for the entire family.', 'sort_order' => 6],
            ['title' => 'OB-Gyne Services',              'icon_key' => 'obgyne',     'description' => 'Comprehensive obstetrics and gynecology services covering prenatal care, normal and high-risk deliveries, postnatal care, and women\'s health consultations.', 'sort_order' => 7],
            ['title' => 'Orthopedic Services',           'icon_key' => 'ortho',      'description' => 'Expert care for bone, joint, and muscle injuries and conditions — including fractures, dislocations, sports injuries, and musculoskeletal disorders.', 'sort_order' => 8],
            ['title' => 'Emergency Medical Services',    'icon_key' => 'emergency',  'description' => '24/7 emergency care with rapid response teams trained to handle trauma, cardiac events, stroke, and all life-threatening conditions.', 'sort_order' => 9],
            ['title' => 'Surgical Services',             'icon_key' => 'surgery',    'description' => 'General and specialized surgical procedures performed in fully equipped operating theaters by skilled surgeons and a dedicated surgical team.', 'sort_order' => 10],
            // Outpatient & Diagnostic
            ['title' => 'Out-Patient Services',          'icon_key' => 'opd',        'description' => 'Walk-in and scheduled consultations with specialist doctors for diagnosis, treatment, and follow-up care without hospital admission.', 'sort_order' => 11],
            ['title' => 'Ambulance Services',            'icon_key' => 'ambulance',  'description' => 'Fully equipped ambulance for emergency response and patient transport, available 24 hours a day, 7 days a week.', 'sort_order' => 12],
            ['title' => 'Ultrasound Services',           'icon_key' => 'ultrasound', 'description' => 'Advanced ultrasound imaging for obstetric, abdominal, and soft tissue assessments, performed by experienced sonographers and radiologists.', 'sort_order' => 13],
            ['title' => 'X-ray Services',                'icon_key' => 'xray',       'description' => 'Digital X-ray imaging for bone, chest, and soft tissue examination with fast turnaround results for accurate and timely diagnosis.', 'sort_order' => 14],
            ['title' => 'Isolation Facility',            'icon_key' => 'isolation',  'description' => 'Dedicated isolation rooms for patients with infectious or communicable diseases, ensuring the safety of other patients and staff.', 'sort_order' => 15],
            ['title' => 'Pediatric Clinic',              'icon_key' => 'nicu',       'description' => 'Child-friendly outpatient clinic offering well-baby check-ups, vaccinations, growth monitoring, and treatment for common childhood illnesses.', 'sort_order' => 16],
            ['title' => 'Anesthesia Services',           'icon_key' => 'anesthesia', 'description' => 'Expert anesthesia care provided by licensed anesthesiologists for surgical and procedural patients, ensuring safe and comfortable experiences.', 'sort_order' => 17],
            ['title' => 'EENT Services',                 'icon_key' => 'eent',       'description' => 'Ear, Eye, Nose, and Throat consultations and treatment for conditions such as hearing loss, vision problems, sinusitis, and throat disorders.', 'sort_order' => 18],
            ['title' => 'PhilHealth E-Konsulta',         'icon_key' => 'philhealth', 'description' => 'Accredited PhilHealth E-Konsulta service providing free outpatient consultations and basic medicines to eligible PhilHealth members.', 'sort_order' => 19],
        ];

        foreach ($services as $service) {
            $iconKey = $service['icon_key'];
            Service::create([
                'title'       => $service['title'],
                'slug'        => Str::slug($service['title']),
                'icon'        => $icons[$iconKey] ?? $icons['medicine'],
                'description' => $service['description'],
                'sort_order'  => $service['sort_order'],
                'is_featured' => $service['sort_order'] <= 8,
                'is_active'   => true,
            ]);
        }
    }

    private function seedPosts(): void
    {
        $posts = [
            [
                'title'       => 'Understanding Kidney Disease and the Role of Hemodialysis',
                'slug'        => 'understanding-kidney-disease-hemodialysis',
                'excerpt'     => 'Kidney disease affects millions of Filipinos. Learn how hemodialysis works and how GSAC\'s Hemodialysis Center supports patients on their journey to better health.',
                'body'        => "## What is Kidney Disease?\n\nChronic Kidney Disease (CKD) is a progressive condition where the kidneys lose their ability to filter waste and excess fluid from the blood. In the Philippines, CKD is among the top causes of illness and death.\n\n## Common Causes\n\n- **Diabetes** — the leading cause of kidney failure\n- **Hypertension** — high blood pressure damages kidney vessels\n- **Recurrent kidney infections** — if left untreated\n- **Certain medications** — prolonged use of pain relievers\n\n## What is Hemodialysis?\n\nHemodialysis is a life-sustaining treatment that uses a dialysis machine to filter waste, salt, and excess water from the blood when the kidneys can no longer do so effectively.\n\nAt GSAC General Hospital, our **Hemodialysis Center** is equipped with modern dialysis machines operated by trained nurses under the supervision of a nephrologist.\n\n## Early Warning Signs\n\nWatch for these symptoms:\n\n- Swelling in the legs, ankles, or feet\n- Fatigue and weakness\n- Changes in urination frequency or color\n- Nausea or loss of appetite\n- Persistent itching\n\n## Prevention\n\n1. Control blood sugar and blood pressure\n2. Drink adequate water daily\n3. Maintain a healthy weight\n4. Avoid excessive use of NSAIDs (pain relievers)\n5. Get regular kidney function tests\n\nFor consultations, call us at **+63 970 311 7315** or visit GSAC General Hospital Inc., Balogo, Sorsogon.",
                'category'    => 'Health Tips',
                'author_name' => 'GSAC Medical Team',
                'is_published'=> true,
                'published_at'=> now()->subDays(10),
            ],
            [
                'title'       => 'GSAC General Hospital: Expanding Services for the Sorsogon Community',
                'slug'        => 'gsac-hospital-expanding-services-sorsogon',
                'excerpt'     => 'GSAC General Hospital Inc. continues to grow its medical services to better serve the communities of Sorsogon and neighboring provinces.',
                'body'        => "## Committed to the Community\n\nGSAC General Hospital Inc. has been a trusted healthcare provider in Sorsogon, and we continue to expand our capabilities to meet the growing needs of our community.\n\n## Recent Developments\n\nWe are proud to offer:\n\n- **Expanded Hemodialysis Center** with additional dialysis chairs\n- **Upgraded Intensive Care Unit (ICU)** with modern monitoring equipment\n- **Neonatal ICU (NICU)** for our most vulnerable patients — newborns\n- **24/7 Ambulance Services** with trained emergency responders\n- **GSAC Diagnostic at Gubat Sorsogon** — bringing diagnostic services closer to communities\n\n## PhilHealth Accreditation\n\nGSAC General Hospital is a PhilHealth-accredited institution. We also offer the **PhilHealth E-Konsulta** program, providing eligible members with free outpatient consultations and access to basic medicines.\n\n## Room Services Available\n\nWe offer various room types to suit every patient's needs:\n\n- Suite Rooms\n- Semi-Private Rooms\n- Private Rooms\n- Male & Female Wards\n- Surgical Ward\n\n## Contact Us\n\nFor appointments and inquiries:\n\n- **Phone:** +63 970 311 7315\n- **Email:** gghi@gsac.coop\n- **Address:** Purok 5 Brgy. Road, Balogo, Sorsogon",
                'category'    => 'News',
                'author_name' => 'GSAC Communications Team',
                'is_published'=> true,
                'published_at'=> now()->subDays(5),
            ],
            [
                'title'       => 'The Importance of Regular OB-Gyne Check-Ups for Women',
                'slug'        => 'importance-regular-ob-gyne-checkups-women',
                'excerpt'     => 'Regular visits to your OB-Gyne are essential for every woman\'s health. Our specialists at GSAC share what you need to know about maternal and reproductive health.',
                'body'        => "## Why OB-Gyne Check-Ups Matter\n\nRegular obstetrics and gynecology consultations are among the most important health visits a woman can make — at every stage of life, from adolescence through menopause.\n\n## For Pregnant Women\n\nPrenatal care is critical for a safe pregnancy:\n\n- **First trimester:** Confirm pregnancy, blood work, ultrasound\n- **Second trimester:** Anomaly scan, glucose testing\n- **Third trimester:** Birth planning, position check, monitoring\n\nAt GSAC, our OB-Gyne team handles both **normal and high-risk pregnancies** with compassionate, expert care.\n\n## For All Women\n\nRegular check-ups help detect:\n\n- Cervical cancer (Pap smear)\n- Breast conditions\n- Polycystic Ovary Syndrome (PCOS)\n- Fibroids and ovarian cysts\n- Sexually transmitted infections (STIs)\n\n## When to Visit\n\n- Annually for routine wellness checks\n- Immediately if you experience unusual bleeding, pain, or discharge\n- As soon as you suspect pregnancy\n\n## Book an Appointment\n\nOur OB-Gyne clinic is open Monday to Saturday, 8:00 AM – 5:00 PM.\n\nCall **+63 970 311 7315** or visit GSAC General Hospital Inc., Balogo, Sorsogon.",
                'category'    => 'Health Tips',
                'author_name' => 'GSAC Medical Team',
                'is_published'=> true,
                'published_at'=> now()->subDays(2),
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }

    private function seedGallery(): void
    {
        $sections = ['facility', 'team', 'events'];
        $i = 1;
        foreach ($sections as $section) {
            for ($j = 1; $j <= 4; $j++) {
                GalleryImage::create([
                    'caption'    => 'GSAC ' . ucfirst($section) . ' ' . $j,
                    'image_path' => "https://picsum.photos/seed/gsac{$section}{$j}/800/600",
                    'alt_text'   => "GSAC General Hospital Inc. {$section} photo {$j}",
                    'section'    => $section,
                    'sort_order' => $i++,
                    'is_active'  => true,
                ]);
            }
        }
    }

    private function seedAdmin(): void
    {
        Admin::firstOrCreate(
            ['email' => 'admin@gsac.ph'],
            ['name' => 'GSAC Administrator', 'password' => Hash::make('password')]
        );
    }
}
