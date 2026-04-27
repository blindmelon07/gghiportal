<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use App\Traits\ImageUploadTrait;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

#[Layout('layouts.admin')]
class PostForm extends Component
{
    use WithFileUploads, ImageUploadTrait;

    public ?Post $post = null;

    #[Validate('required|min:3|max:255')]
    public string $title = '';
    public string $slug = '';
    public string $category = '';
    #[Validate('required|min:3|max:255')]
    public string $author_name = '';
    public string $excerpt = '';
    #[Validate('required|min:10')]
    public string $body = '';
    public bool $is_published = false;
    public $cover_image;
    public ?string $existingImage = null;

    public function mount(?Post $post = null): void
    {
        if ($post && $post->exists) {
            $this->post = $post;
            $this->title        = $post->title;
            $this->slug         = $post->slug;
            $this->category     = $post->category ?? '';
            $this->author_name  = $post->author_name;
            $this->excerpt      = $post->excerpt ?? '';
            $this->body         = $post->body;
            $this->is_published = $post->is_published;
            $this->existingImage = $post->cover_image_path;
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->post?->exists) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'title'       => $this->title,
            'slug'        => $this->slug ?: Str::slug($this->title),
            'category'    => $this->category,
            'author_name' => $this->author_name,
            'excerpt'     => $this->excerpt,
            'body'        => $this->body,
            'is_published'=> $this->is_published,
            'published_at'=> $this->is_published ? ($this->post?->published_at ?? now()) : null,
        ];

        if ($this->cover_image) {
            if ($this->existingImage) {
                $this->deleteImage($this->existingImage);
            }
            $data['cover_image_path'] = $this->uploadImage($this->cover_image, 'posts');
        }

        if ($this->post?->exists) {
            $this->post->update($data);
        } else {
            Post::create($data);
        }

        session()->flash('success', 'Post saved successfully.');
        return redirect()->route('admin.posts.index');
    }

    public function render()
    {
        return view('livewire.admin.posts.post-form', [
            'pageTitle' => $this->post?->exists ? 'Edit Post' : 'Create Post',
        ])->title($this->post?->exists ? 'Edit Post' : 'Create Post');
    }
}
