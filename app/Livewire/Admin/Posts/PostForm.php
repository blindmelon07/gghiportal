<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Post;
use App\Models\PostImage;
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

    public string $post_type = 'article';
    public string $video_url = '';

    #[Validate('required|min:3|max:255')]
    public string $title = '';
    public string $slug = '';
    public string $category = '';
    #[Validate('required|min:3|max:255')]
    public string $author_name = '';
    public string $excerpt = '';
    public string $body = '';
    public bool $is_published = false;
    public $cover_image;
    public ?string $existingImage = null;
    public array $newImages = [];

    public function mount(?Post $post = null): void
    {
        if ($post && $post->exists) {
            $this->post          = $post;
            $this->post_type     = $post->post_type ?? 'article';
            $this->video_url     = $post->video_url ?? '';
            $this->title         = $post->title;
            $this->slug          = $post->slug;
            $this->category      = $post->category ?? '';
            $this->author_name   = $post->author_name;
            $this->excerpt       = $post->excerpt ?? '';
            $this->body          = $post->body;
            $this->is_published  = $post->is_published;
            $this->existingImage = $post->cover_image_path;
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->post?->exists) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function removeNewImage(int $index): void
    {
        array_splice($this->newImages, $index, 1);
    }

    public function deleteSlideImage(int $id): void
    {
        $img = PostImage::findOrFail($id);
        $this->deleteImage($img->image_path);
        $img->delete();
    }

    public function save()
    {
        $rules = [
            'title'       => 'required|min:3|max:255',
            'author_name' => 'required|min:3|max:255',
            'post_type'   => 'required|in:article,video',
        ];

        if ($this->post_type === 'article') {
            $rules['body'] = 'required|min:10';
        }

        if ($this->post_type === 'video') {
            $rules['video_url'] = 'required|url';
        }

        $this->validate($rules);

        if ($this->cover_image) {
            $this->validate(['cover_image' => 'file|mimes:jpg,jpeg,png,gif,webp,svg,heic,heif|max:10240']);
        }

        if (!empty($this->newImages)) {
            $this->validate(['newImages.*' => 'file|mimes:jpg,jpeg,png,gif,webp,svg,heic,heif|max:10240']);
        }

        $data = [
            'post_type'    => $this->post_type,
            'video_url'    => $this->post_type === 'video' ? $this->video_url : null,
            'title'        => $this->title,
            'slug'         => $this->slug ?: Str::slug($this->title),
            'category'     => $this->category,
            'author_name'  => $this->author_name,
            'excerpt'      => $this->excerpt,
            'body'         => $this->body,
            'is_published' => $this->is_published,
            'published_at' => $this->is_published ? ($this->post?->published_at ?? now()) : null,
        ];

        if ($this->cover_image) {
            if ($this->existingImage) {
                $this->deleteImage($this->existingImage);
            }
            $data['cover_image_path'] = $this->uploadImage($this->cover_image, 'posts');
        }

        if ($this->post?->exists) {
            $this->post->update($data);
            $post = $this->post;
        } else {
            $post = Post::create($data);
        }

        foreach ($this->newImages as $img) {
            $post->images()->create([
                'image_path' => $this->uploadImage($img, 'posts'),
                'sort_order' => $post->images()->count(),
            ]);
        }

        session()->flash('success', 'Post saved successfully.');
        return redirect()->route('admin.posts.index');
    }

    public function render()
    {
        return view('livewire.admin.posts.post-form', [
            'pageTitle'   => $this->post?->exists ? 'Edit Post' : 'Create Post',
            'slideImages' => $this->post?->images()->get() ?? collect(),
        ])->title($this->post?->exists ? 'Edit Post' : 'Create Post');
    }
}
