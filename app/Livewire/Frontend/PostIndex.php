<?php

namespace App\Livewire\Frontend;

use App\Models\Post;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.public', ['title' => 'Health Blog'])]
class PostIndex extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $category = '';

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingCategory(): void { $this->resetPage(); }

    public function render()
    {
        $query = Post::published()
            ->when($this->search, fn($q) => $q->where(function($q) {
                $q->where('title', 'like', "%{$this->search}%")
                  ->orWhere('excerpt', 'like', "%{$this->search}%");
            }))
            ->when($this->category, fn($q) => $q->where('category', $this->category))
            ->latest('published_at');

        return view('livewire.frontend.post-index', [
            'posts'      => $query->paginate(6),
            'categories' => Post::published()->whereNotNull('category')->distinct()->pluck('category'),
        ]);
    }
}
