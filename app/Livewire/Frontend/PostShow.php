<?php

namespace App\Livewire\Frontend;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class PostShow extends Component
{
    public Post $post;

    public function mount(string $slug): void
    {
        $this->post = Post::published()->where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.frontend.post-show', [
            'recentPosts' => Post::published()->where('id', '!=', $this->post->id)->latest('published_at')->limit(4)->get(),
        ])->title($this->post->title . ' — GSAC Hospital');
    }
}
