<?php

use Illuminate\Support\Facades\Route;

// --- PUBLIC FRONTEND ---
Route::get('/', App\Livewire\Frontend\HomePage::class)->name('home');
Route::get('/blog', App\Livewire\Frontend\PostIndex::class)->name('blog.index');
Route::get('/blog/{slug}', App\Livewire\Frontend\PostShow::class)->name('blog.show');
Route::get('/services', App\Livewire\Frontend\ServicesPage::class)->name('services');

// --- ADMIN AUTH ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', App\Livewire\Admin\Auth\Login::class)->name('login');
    Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
});

// --- ADMIN PANEL (protected) ---
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
    Route::get('change-password', App\Livewire\Admin\ChangePassword::class)->name('change-password');
});
