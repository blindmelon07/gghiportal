<?php

namespace App\Livewire\Admin;

use App\Models\ContactMessage;
use App\Models\GalleryImage;
use App\Models\HeroSlide;
use App\Models\Post;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Dashboard'])]
class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalPosts'      => Post::count(),
            'publishedPosts'  => Post::where('is_published', true)->count(),
            'totalServices'   => Service::count(),
            'unreadMessages'  => ContactMessage::where('is_read', false)->count(),
            'galleryImages'   => GalleryImage::count(),
            'heroSlides'      => HeroSlide::count(),
            'recentPosts'     => Post::latest()->limit(5)->get(),
            'recentMessages'  => ContactMessage::where('is_read', false)->latest()->limit(5)->get(),
        ]);
    }
}
