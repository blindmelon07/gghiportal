<?php

namespace App\Livewire\Frontend;

use App\Models\Post;
use Livewire\Component;

class LatestPosts extends Component
{
    public function render()
    {
        return view('livewire.frontend.latest-posts', [
            'posts' => Post::published()->latest('published_at')->limit(3)->get(),
        ]);
    }
}
