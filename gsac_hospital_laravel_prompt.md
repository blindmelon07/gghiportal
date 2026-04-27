# GSAC General Hospital — Laravel 13 + Livewire Full-Stack Build Prompt

---

## CONTEXT

You are building a complete, production-ready hospital website for **GSAC General Hospital**.
The stack is:
- **Laravel 13** (already installed and fresh)
- **Livewire 3** (full-page & nested components)
- **Tailwind CSS v3** (utility-first, responsive)
- **Alpine.js** (for lightweight JS interactions)
- **SQLite or MySQL** (developer's choice — use `.env`)

The project has **two main areas**:
1. **Public Frontend** — a polished landing page with hospital branding, services, images, and a blog/post feed
2. **Admin Panel** — a secure backend dashboard to manage posts, hero images, services, and general site information

Implement and test **every feature** as you build it.

---

## PHASE 1 — DEPENDENCIES & INITIAL SETUP

Run the following commands in order from the Laravel project root:

```bash
composer require livewire/livewire
composer require spatie/laravel-medialibrary
npm install -D tailwindcss postcss autoprefixer @tailwindcss/typography @tailwindcss/forms
npx tailwindcss init -p
npm install alpinejs
```

Configure **tailwind.config.js**:

```js
/** @type {import('tailwindcss').Config} */
export default {
  content: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './app/Livewire/**/*.php',
  ],
  theme: {
    extend: {
      colors: {
        brand: {
          50:  '#e6f4f9',
          100: '#b3dcee',
          500: '#0077b6',
          600: '#005f92',
          700: '#004e7a',
          900: '#002f4d',
        },
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        display: ['"Playfair Display"', 'serif'],
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
    require('@tailwindcss/forms'),
  ],
}
```

Add Google Fonts to `resources/views/layouts/app.blade.php`:

```html
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
```

---

## PHASE 2 — DATABASE & MODELS

### 2.1 Migrations

Create and run the following migrations:

#### `hospital_infos` table
```
id, key (string, unique), value (text), created_at, updated_at
```
Seeds: name, tagline, address, phone, email, emergency_phone, about_text, logo_path, favicon_path

#### `services` table
```
id, title, slug, icon (string — SVG or emoji), description (text),
image_path (nullable), is_featured (boolean, default true),
sort_order (int, default 0), is_active (boolean, default true),
created_at, updated_at
```

#### `hero_slides` table
```
id, title, subtitle, button_text, button_url, image_path,
is_active (boolean), sort_order (int), created_at, updated_at
```

#### `posts` table
```
id, title, slug (unique), excerpt (text nullable), body (longtext),
cover_image_path (nullable), category (string nullable),
author_name (string), is_published (boolean, default false),
published_at (datetime nullable), created_at, updated_at
```

#### `gallery_images` table
```
id, caption, image_path, alt_text, section (string — e.g. 'facility', 'team', 'events'),
sort_order (int), is_active (boolean), created_at, updated_at
```

#### `admins` table (separate from users)
```
id, name, email (unique), password, remember_token, created_at, updated_at
```

Run: `php artisan migrate`

### 2.2 Models

Create Eloquent models for all tables above with `$fillable` and appropriate casts:

- `HospitalInfo` — static helper: `HospitalInfo::get('key', 'default')`
- `Service` — scope: `scopeActive`, `scopeFeatured`, ordered by `sort_order`
- `HeroSlide` — scope: `scopeActive`, ordered by `sort_order`
- `Post` — scope: `scopePublished`, mutator for `slug` (auto-generate from title if empty)
- `GalleryImage` — scope: `scopeActive`, grouped by section
- `Admin` — extends `Authenticatable`, uses `admin` guard

### 2.3 Seeders

Create `DatabaseSeeder` that seeds:
- 3–5 hero slides (use Lorem Picsum URLs as placeholder images: `https://picsum.photos/seed/{word}/1600/900`)
- 8 sample services (Cardiology, Orthopedics, Pediatrics, Emergency Care, Neurology, Oncology, Maternity, Radiology) with Heroicon SVG icons
- 3 sample published blog posts
- 10 gallery images across `facility`, `team`, `events` sections
- Default `HospitalInfo` key-value pairs
- One default admin: `admin@gsac.ph` / `password`

Run: `php artisan db:seed`

---

## PHASE 3 — AUTHENTICATION (Admin Guard)

### 3.1 Guard Setup

In `config/auth.php` add:

```php
'guards' => [
    'admin' => [
        'driver'   => 'session',
        'provider' => 'admins',
    ],
],
'providers' => [
    'admins' => [
        'driver' => 'eloquent',
        'model'  => App\Models\Admin::class,
    ],
],
```

### 3.2 Admin Login Page

- Route: `GET /admin/login`, `POST /admin/login`, `POST /admin/logout`
- Livewire component: `Admin\Auth\Login`
- Blade layout: `resources/views/layouts/admin-guest.blade.php` — centered card with GSAC logo
- Validate: email + password, throttle to 5 attempts per minute
- On success: redirect to `/admin/dashboard`
- Middleware: create `EnsureAdminAuthenticated` — redirect to `/admin/login` if unauthenticated

### 3.3 Protect Admin Routes

Wrap all `/admin/*` routes (except login) in:

```php
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    // ... all admin routes
});
```

---

## PHASE 4 — FRONTEND LANDING PAGE

### 4.1 Layout

Create `resources/views/layouts/public.blade.php` with:

- **Sticky top navbar**: GSAC logo left, nav links (Home, Services, About, Blog, Contact), emergency phone number (red pill badge), "Book Appointment" CTA button (brand blue)
- **Mobile hamburger menu** using Alpine.js `x-data / x-show / x-transition`
- **Footer**: 4-column grid — About blurb, Quick Links, Services list, Contact Info + Google Maps embed placeholder; copyright bar

### 4.2 Hero Section (Livewire Component)

Component: `App\Livewire\Frontend\HeroSlider`

- Auto-advancing image carousel (5s interval) using Alpine.js
- Each slide: full-width background image, dark overlay, centered title + subtitle + CTA button
- Dots navigation at bottom
- Lazy-load images using `loading="lazy"` on non-first slides
- Pull slides from `HeroSlide::scopeActive()->ordered()->get()`

### 4.3 Services Section

Component: `App\Livewire\Frontend\ServicesGrid`

- Section header: "Our Medical Services" with subtitle
- Responsive grid: 2 cols mobile → 4 cols desktop
- Each card: service icon (SVG, 48px, brand color), title, short description (truncated to 2 lines), "Learn More" link
- Filter tabs: "All Services" + category filter (if categories added)
- Pull from `Service::active()->featured()->ordered()->get()`

### 4.4 About Section

- Static Blade partial: `resources/views/frontend/partials/about.blade.php`
- Two-column layout: left = image (hospital photo), right = headline + `HospitalInfo::get('about_text')` + 4 stat boxes (Beds, Doctors, Years, Patients)
- Stats animated with Alpine.js counter on scroll

### 4.5 Latest Posts / News Section

Component: `App\Livewire\Frontend\LatestPosts`

- 3-column card grid (latest 3 published posts)
- Card: cover image, category badge, title, excerpt (truncated), author + date, "Read More" link
- Skeleton loader shown while loading

### 4.6 Gallery Section

Component: `App\Livewire\Frontend\GallerySection`

- Masonry or grid layout showing active gallery images
- Tab filter by section: Facility | Team | Events
- Lightbox on click using Alpine.js (no external library required — build a simple `x-data` modal overlay)

### 4.7 Contact / CTA Section

- Full-width section with brand gradient background
- Left: hospital address, phone, emergency line, email, working hours
- Right: simple Livewire contact form (name, email, phone, message, subject)
  - Form: `App\Livewire\Frontend\ContactForm`
  - Validation rules, success flash message (no email sending required — just store to a `contact_messages` table)
  - Add `contact_messages` migration: `id, name, email, phone, subject, message, is_read (bool), created_at`

### 4.8 Single Post Page

- Route: `GET /blog/{slug}`
- Livewire full-page component: `App\Livewire\Frontend\PostShow`
- Layout: featured image (full-width), title, author/date/category meta, article body rendered with `@prose` Tailwind Typography
- Sidebar: recent posts, service links

### 4.9 Blog Index Page

- Route: `GET /blog`
- Livewire full-page component: `App\Livewire\Frontend\PostIndex`
- Search input (real-time, debounce 300ms)
- Category filter
- Pagination (6 posts per page using Livewire paginator)

---

## PHASE 5 — ADMIN PANEL

### 5.1 Admin Layout

`resources/views/layouts/admin.blade.php`:

- **Sidebar**: GSAC Admin logo, nav links with Heroicons — Dashboard, Posts, Services, Hero Slides, Gallery, Site Info, Contact Messages, Logout
- **Topbar**: page title (slot), admin name + avatar initials
- **Content area**: `{{ $slot }}`
- Responsive: sidebar collapses on mobile with Alpine.js toggle
- Active link highlighting based on current route

### 5.2 Admin Dashboard

Component: `App\Livewire\Admin\Dashboard`

Stat cards row:
- Total Posts, Published Posts, Total Services, Unread Messages, Gallery Images, Hero Slides

Recent activity:
- Latest 5 posts table (title, status, date, edit/view links)
- Latest 5 unread contact messages (name, subject, date, mark-read button)

### 5.3 Posts Management (Full CRUD)

**Index** — `App\Livewire\Admin\Posts\PostIndex`:
- Table: cover image thumbnail, title, category, status badge (published/draft), date, actions (Edit, Delete, Toggle Publish)
- Search input (real-time, debounce)
- Filter by status: All | Published | Draft
- Sort by: Newest, Oldest, Title A-Z
- Bulk delete with checkbox selection
- Pagination (15 per page)
- Inline toggle publish/unpublish without page reload

**Create/Edit** — `App\Livewire\Admin\Posts\PostForm`:
- Fields: Title (auto-generates slug), Slug (editable), Category (select or free input), Author Name, Excerpt, Body (use a `<textarea>` with basic Markdown note — or integrate a JS rich text editor like EasyMDE via CDN), Published toggle (switches `published_at`), Cover Image upload
- Cover image preview before save
- Image stored in `storage/app/public/posts/` with `Storage::disk('public')->put()`
- Success notification (flash message in session)

**Delete**: SweetAlert-style confirm dialog using Alpine.js (no external lib) before actual deletion; delete image file from storage too.

### 5.4 Services Management (Full CRUD)

**Index** — `App\Livewire\Admin\Services\ServiceIndex`:
- Drag-to-reorder rows (use Alpine.js `@dragstart/@dragover/@drop`) that saves `sort_order` via Livewire
- Toggle active/featured inline
- Table with thumbnail, title, active badge, featured badge, actions

**Create/Edit** — `App\Livewire\Admin\Services\ServiceForm`:
- Fields: Title (auto-slug), Icon (text input for SVG code or emoji), Description, Image upload, Is Featured, Is Active, Sort Order

### 5.5 Hero Slides Management (Full CRUD)

Component pattern same as services. Additional fields: Title, Subtitle, Button Text, Button URL, Image upload, Active toggle, Sort Order. Show live preview of slide in form.

### 5.6 Gallery Management

**Index** — `App\Livewire\Admin\Gallery\GalleryIndex`:
- Upload multiple images at once (loop through `$this->images` array)
- Grid layout of image cards with caption, section badge, delete button
- Filter by section tab
- Edit caption/alt text inline (click-to-edit with Alpine.js)

### 5.7 Site Information Editor

Component: `App\Livewire\Admin\SiteInfo\SiteInfoEditor`

- Form with all `hospital_infos` key-value pairs grouped in sections:
  - **General**: Name, Tagline, About Text (textarea)
  - **Contact**: Address, Phone, Emergency Phone, Email
  - **Branding**: Logo upload preview, Favicon upload preview
- Save all at once — loop through keys and `updateOrCreate`
- Flash success toast on save

### 5.8 Contact Messages

Component: `App\Livewire\Admin\ContactMessages\MessageIndex`:
- Table: sender name, email, subject, date, read status badge
- Click row to expand and read full message inline (Alpine.js x-show)
- Auto-mark as read when expanded
- Delete message button
- Filter: All | Unread | Read

---

## PHASE 6 — FILE STORAGE & IMAGE HANDLING

```bash
php artisan storage:link
```

Create helper method in a `ImageUploadTrait` (used by all Livewire admin components):

```php
protected function uploadImage($file, string $folder): string
{
    $path = $file->store("public/{$folder}");
    return Storage::url($path); // returns /storage/{folder}/filename.ext
}

protected function deleteImage(?string $path): void
{
    if ($path) {
        $relativePath = str_replace('/storage/', 'public/', $path);
        Storage::delete($relativePath);
    }
}
```

All image fields in models store the **public URL** (`/storage/folder/file.jpg`).

---

## PHASE 7 — ROUTES

```php
// routes/web.php

// --- PUBLIC ---
Route::get('/', App\Livewire\Frontend\HomePage::class)->name('home');
Route::get('/blog', App\Livewire\Frontend\PostIndex::class)->name('blog.index');
Route::get('/blog/{slug}', App\Livewire\Frontend\PostShow::class)->name('blog.show');
Route::get('/services', App\Livewire\Frontend\ServicesPage::class)->name('services');

// --- ADMIN AUTH ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', App\Livewire\Admin\Auth\Login::class)->name('login');
    Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
});

// --- ADMIN PANEL ---
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', App\Livewire\Admin\Dashboard::class)->name('dashboard');

    Route::get('posts', App\Livewire\Admin\Posts\PostIndex::class)->name('posts.index');
    Route::get('posts/create', App\Livewire\Admin\Posts\PostForm::class)->name('posts.create');
    Route::get('posts/{post}/edit', App\Livewire\Admin\Posts\PostForm::class)->name('posts.edit');

    Route::get('services', App\Livewire\Admin\Services\ServiceIndex::class)->name('services.index');
    Route::get('services/create', App\Livewire\Admin\Services\ServiceForm::class)->name('services.create');
    Route::get('services/{service}/edit', App\Livewire\Admin\Services\ServiceForm::class)->name('services.edit');

    Route::get('hero-slides', App\Livewire\Admin\HeroSlides\HeroSlideIndex::class)->name('hero-slides.index');
    Route::get('hero-slides/create', App\Livewire\Admin\HeroSlides\HeroSlideForm::class)->name('hero-slides.create');
    Route::get('hero-slides/{slide}/edit', App\Livewire\Admin\HeroSlides\HeroSlideForm::class)->name('hero-slides.edit');

    Route::get('gallery', App\Livewire\Admin\Gallery\GalleryIndex::class)->name('gallery.index');
    Route::get('site-info', App\Livewire\Admin\SiteInfo\SiteInfoEditor::class)->name('site-info');
    Route::get('messages', App\Livewire\Admin\ContactMessages\MessageIndex::class)->name('messages.index');
});
```

---

## PHASE 8 — TESTING

After building each feature, write and run the following tests using **Pest PHP** (install: `composer require pestphp/pest pestphp/pest-plugin-livewire --dev` then `php artisan pest:install`).

### Test File Structure

```
tests/
├── Feature/
│   ├── Frontend/
│   │   ├── HomePageTest.php
│   │   ├── BlogTest.php
│   │   ├── ContactFormTest.php
│   ├── Admin/
│   │   ├── AuthTest.php
│   │   ├── PostCrudTest.php
│   │   ├── ServiceCrudTest.php
│   │   ├── GalleryTest.php
│   │   ├── SiteInfoTest.php
│   │   ├── HeroSlideTest.php
│   │   └── MessagesTest.php
```

### Tests to Implement

#### `HomePageTest.php`
```php
it('loads the homepage successfully', fn() =>
    get(route('home'))->assertOk()->assertSeeLivewire('frontend.hero-slider')
);
it('shows services section', fn() =>
    get(route('home'))->assertSeeLivewire('frontend.services-grid')
);
it('shows latest posts section', fn() =>
    get(route('home'))->assertSeeLivewire('frontend.latest-posts')
);
```

#### `BlogTest.php`
```php
it('shows blog index', fn() => get(route('blog.index'))->assertOk());
it('shows a published post', function () {
    $post = Post::factory()->published()->create();
    get(route('blog.show', $post->slug))->assertOk()->assertSee($post->title);
});
it('returns 404 for unpublished post', function () {
    $post = Post::factory()->draft()->create();
    get(route('blog.show', $post->slug))->assertNotFound();
});
it('can search posts', function () {
    $post = Post::factory()->published()->create(['title' => 'Heart Surgery Tips']);
    Livewire::test(\App\Livewire\Frontend\PostIndex::class)
        ->set('search', 'Heart')
        ->assertSee('Heart Surgery Tips');
});
```

#### `ContactFormTest.php`
```php
it('submits contact form successfully', function () {
    Livewire::test(\App\Livewire\Frontend\ContactForm::class)
        ->set('name', 'Juan dela Cruz')
        ->set('email', 'juan@example.com')
        ->set('subject', 'Appointment')
        ->set('message', 'I would like to book an appointment.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSee('Thank you');
    expect(\App\Models\ContactMessage::count())->toBe(1);
});
it('validates required fields', function () {
    Livewire::test(\App\Livewire\Frontend\ContactForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'message']);
});
```

#### `AuthTest.php`
```php
it('shows admin login page', fn() => get(route('admin.login'))->assertOk());
it('redirects unauthenticated admin to login', fn() =>
    get(route('admin.dashboard'))->assertRedirect(route('admin.login'))
);
it('logs in with valid credentials', function () {
    $admin = Admin::factory()->create();
    Livewire::test(\App\Livewire\Admin\Auth\Login::class)
        ->set('email', $admin->email)
        ->set('password', 'password')
        ->call('authenticate')
        ->assertRedirect(route('admin.dashboard'));
});
it('rejects invalid credentials', function () {
    Livewire::test(\App\Livewire\Admin\Auth\Login::class)
        ->set('email', 'wrong@test.com')
        ->set('password', 'wrongpass')
        ->call('authenticate')
        ->assertHasErrors(['email']);
});
```

#### `PostCrudTest.php`
```php
beforeEach(fn() => actingAs(Admin::factory()->create(), 'admin'));

it('lists posts', fn() => get(route('admin.posts.index'))->assertOk());
it('creates a post', function () {
    Livewire::test(\App\Livewire\Admin\Posts\PostForm::class)
        ->set('title', 'New Health Article')
        ->set('author_name', 'Dr. Santos')
        ->set('body', 'Article body content here.')
        ->call('save')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.posts.index'));
    expect(Post::where('title', 'New Health Article')->exists())->toBeTrue();
});
it('validates post creation', function () {
    Livewire::test(\App\Livewire\Admin\Posts\PostForm::class)
        ->call('save')
        ->assertHasErrors(['title', 'body', 'author_name']);
});
it('edits a post', function () {
    $post = Post::factory()->create();
    Livewire::test(\App\Livewire\Admin\Posts\PostForm::class, ['post' => $post])
        ->set('title', 'Updated Title')
        ->call('save')
        ->assertHasNoErrors();
    expect($post->fresh()->title)->toBe('Updated Title');
});
it('deletes a post', function () {
    $post = Post::factory()->create();
    Livewire::test(\App\Livewire\Admin\Posts\PostIndex::class)
        ->call('delete', $post->id)
        ->assertHasNoErrors();
    expect(Post::find($post->id))->toBeNull();
});
it('toggles post publish status', function () {
    $post = Post::factory()->draft()->create();
    Livewire::test(\App\Livewire\Admin\Posts\PostIndex::class)
        ->call('togglePublish', $post->id);
    expect($post->fresh()->is_published)->toBeTrue();
});
```

#### `ServiceCrudTest.php`
```php
beforeEach(fn() => actingAs(Admin::factory()->create(), 'admin'));

it('creates a service', function () {
    Livewire::test(\App\Livewire\Admin\Services\ServiceForm::class)
        ->set('title', 'Cardiology')
        ->set('description', 'Heart care specialists.')
        ->call('save')
        ->assertHasNoErrors();
    expect(Service::where('title', 'Cardiology')->exists())->toBeTrue();
});
it('toggles service active status', function () {
    $service = Service::factory()->create(['is_active' => true]);
    Livewire::test(\App\Livewire\Admin\Services\ServiceIndex::class)
        ->call('toggleActive', $service->id);
    expect($service->fresh()->is_active)->toBeFalse();
});
```

#### `SiteInfoTest.php`
```php
it('saves site information', function () {
    actingAs(Admin::factory()->create(), 'admin');
    Livewire::test(\App\Livewire\Admin\SiteInfo\SiteInfoEditor::class)
        ->set('info.name', 'GSAC General Hospital')
        ->set('info.phone', '+63 054 123 4567')
        ->call('save')
        ->assertHasNoErrors()
        ->assertSee('Saved');
    expect(HospitalInfo::get('name'))->toBe('GSAC General Hospital');
});
```

#### `MessagesTest.php`
```php
it('marks message as read when opened', function () {
    actingAs(Admin::factory()->create(), 'admin');
    $msg = ContactMessage::factory()->unread()->create();
    Livewire::test(\App\Livewire\Admin\ContactMessages\MessageIndex::class)
        ->call('markRead', $msg->id);
    expect($msg->fresh()->is_read)->toBeTrue();
});
```

### Model Factories

Create factories for all models:
- `AdminFactory` — name, email, hashed `password`
- `PostFactory` — states: `published()`, `draft()`
- `ServiceFactory`
- `ContactMessageFactory` — states: `unread()`, `read()`

### Run All Tests

```bash
php artisan test
# or with Pest:
./vendor/bin/pest --coverage
```

All tests must pass before the project is considered complete.

---

## PHASE 9 — DESIGN SPECS (Tailwind CSS)

### Color Palette
- **Primary Blue**: `brand-500` (#0077b6) — buttons, links, badges
- **Dark Navy**: `brand-900` (#002f4d) — navbar, footer, headings
- **Accent Red**: `red-600` — emergency badge, alerts
- **Neutral**: `gray-50` background, `gray-800` body text

### Typography
- **Display font** (`font-display`): Playfair Display — section headings
- **Body font** (`font-sans`): Inter — all body text, nav, UI

### UI Patterns
- Buttons: `bg-brand-500 hover:bg-brand-600 text-white font-semibold px-6 py-3 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md`
- Cards: `bg-white rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow`
- Inputs: `border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-500 focus:border-transparent`
- Section spacing: `py-20 px-4 md:px-8 max-w-7xl mx-auto`

### Accessibility
- All images must have descriptive `alt` text
- Buttons must have `:focus-visible` ring
- Color contrast minimum AA (4.5:1)
- Landmark regions: `<header>`, `<main>`, `<footer>`, `<nav>`, `<section>`

---

## PHASE 10 — FINAL CHECKLIST

Before marking complete, verify:

- [ ] `php artisan serve` starts without errors
- [ ] `npm run dev` (Vite) compiles Tailwind without errors
- [ ] Homepage loads with real seeded data (no placeholder errors)
- [ ] Hero slider auto-advances
- [ ] Services grid displays all 8 services
- [ ] Blog index paginates and search works
- [ ] Single blog post renders full content
- [ ] Contact form saves to DB and shows success message
- [ ] Gallery lightbox opens and closes
- [ ] Admin login rejects wrong credentials
- [ ] Admin login accepts correct credentials and redirects
- [ ] Admin dashboard shows real stats
- [ ] Post CRUD: create / edit / delete / toggle publish all work
- [ ] Service CRUD: create / edit / delete / toggle active / reorder all work
- [ ] Hero slide CRUD: create / edit / delete / toggle active all work
- [ ] Gallery: multi-upload, caption edit, section filter, delete all work
- [ ] Site Info: all fields save and reflect on frontend
- [ ] Contact messages: list, expand, mark-read, delete all work
- [ ] `php artisan test` — **all tests green**
- [ ] No N+1 query issues (use `->with([...])` eager loading everywhere)
- [ ] `storage:link` is done — uploaded images display correctly
- [ ] Mobile responsive on 375px viewport

---

## NOTES FOR THE AI / DEVELOPER

- Build **one phase at a time** and test before moving to the next.
- Always use `wire:loading` spinners on buttons and tables.
- Use `$this->dispatch('notify', message: '...', type: 'success')` + a global Livewire event listener for toast notifications in the admin panel.
- Use `#[Validate]` attributes (Livewire 3 style) for form validation in Livewire components.
- For image uploads in Livewire use `WithFileUploads` trait and `TemporaryUploadedFile`.
- Store slugs using `Str::slug($this->title)` and ensure uniqueness.
- All admin Livewire components should use `layout('layouts.admin')` attribute.
- All frontend full-page Livewire components use `layout('layouts.public')`.
- Keep Blade files clean — extract repeating UI (cards, badges) to `resources/views/components/` Blade components.
- Do not use JavaScript frameworks other than Alpine.js (no Vue, React, jQuery).

---

*End of Prompt — GSAC General Hospital Website Build*
