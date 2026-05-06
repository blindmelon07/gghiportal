<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use App\Traits\ImageUploadTrait;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin', ['title' => 'Posts'])]
class PostIndex extends Component
{
    use WithPagination, ImageUploadTrait;

    public string $search = '';
    public string $status = '';
    public string $sort = 'newest';
    public array $selected = [];
    public bool $showDeleteModal = false;
    public ?int $deleteId = null;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatus(): void { $this->resetPage(); }

    public function togglePublish(int $id): void
    {
        $post = Post::findOrFail($id);
        $post->is_published = ! $post->is_published;
        $post->published_at = $post->is_published ? now() : null;
        $post->save();
        $this->dispatch('notify', message: 'Post status updated.', type: 'success');
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(?int $id = null): void
    {
        $id = $id ?? $this->deleteId;
        $post = Post::findOrFail($id);
        $this->deleteImage($post->cover_image_path);
        $post->delete();
        $this->showDeleteModal = false;
        $this->deleteId = null;
        $this->dispatch('notify', message: 'Post deleted.', type: 'success');
    }

    public function bulkDelete(): void
    {
        $posts = Post::whereIn('id', $this->selected)->get();
        $count = $posts->count();
        foreach ($posts as $post) {
            $this->deleteImage($post->cover_image_path);
            $post->delete();
        }
        $this->selected = [];
        $this->dispatch('notify', message: $count . ' posts deleted.', type: 'success');
    }

    public function render()
    {
        $query = Post::query()
            ->when($this->search, fn($q) => $q->where('title', 'like', "%{$this->search}%"))
            ->when($this->status === 'published', fn($q) => $q->where('is_published', true))
            ->when($this->status === 'draft', fn($q) => $q->where('is_published', false));

        $query = match($this->sort) {
            'oldest' => $query->oldest(),
            'title'  => $query->orderBy('title'),
            default  => $query->latest(),
        };

        return view('livewire.admin.posts.post-index', [
            'posts' => $query->paginate(15),
        ]);
    }
}
