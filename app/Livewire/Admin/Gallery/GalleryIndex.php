<?php

namespace App\Livewire\Admin\Gallery;

use App\Models\GalleryImage;
use App\Traits\ImageUploadTrait;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin', ['title' => 'Gallery'])]
class GalleryIndex extends Component
{
    use WithFileUploads, ImageUploadTrait;

    public string $filterSection = 'all';
    public array $images = [];
    public string $uploadSection = 'facility';
    public ?int $editingId = null;
    public string $editCaption = '';
    public string $editAlt = '';

    public function upload(): void
    {
        $this->validate([
            'images.*' => 'image|max:4096',
        ]);

        foreach ($this->images as $img) {
            GalleryImage::create([
                'image_path' => $this->uploadImage($img, 'gallery'),
                'caption'    => '',
                'alt_text'   => 'Gallery image',
                'section'    => $this->uploadSection,
                'sort_order' => GalleryImage::max('sort_order') + 1,
                'is_active'  => true,
            ]);
        }

        $this->images = [];
        $this->dispatch('notify', message: 'Images uploaded.', type: 'success');
    }

    public function startEdit(int $id): void
    {
        $img = GalleryImage::findOrFail($id);
        $this->editingId  = $id;
        $this->editCaption = $img->caption ?? '';
        $this->editAlt    = $img->alt_text ?? '';
    }

    public function saveEdit(): void
    {
        GalleryImage::findOrFail($this->editingId)->update([
            'caption'  => $this->editCaption,
            'alt_text' => $this->editAlt,
        ]);
        $this->editingId = null;
        $this->dispatch('notify', message: 'Image updated.', type: 'success');
    }

    public function delete(int $id): void
    {
        $img = GalleryImage::findOrFail($id);
        $this->deleteImage($img->image_path);
        $img->delete();
        $this->dispatch('notify', message: 'Image deleted.', type: 'success');
    }

    public function render()
    {
        $query = GalleryImage::orderBy('sort_order');
        if ($this->filterSection !== 'all') {
            $query->where('section', $this->filterSection);
        }
        return view('livewire.admin.gallery.gallery-index', [
            'galleryImages' => $query->get(),
        ]);
    }
}
