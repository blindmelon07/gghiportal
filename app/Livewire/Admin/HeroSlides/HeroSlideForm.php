<?php

namespace App\Livewire\Admin\HeroSlides;

use App\Models\HeroSlide;
use App\Traits\ImageUploadTrait;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class HeroSlideForm extends Component
{
    use WithFileUploads, ImageUploadTrait;

    public ?HeroSlide $slide = null;

    #[Validate('required|min:3|max:255')]
    public string $title = '';
    public string $subtitle = '';
    public string $button_text = '';
    public string $button_url = '';
    public bool $is_active = true;
    public int $sort_order = 0;
    public $image;
    public ?string $existingImage = null;

    public function mount(?HeroSlide $slide = null): void
    {
        if ($slide && $slide->exists) {
            $this->slide       = $slide;
            $this->title       = $slide->title;
            $this->subtitle    = $slide->subtitle ?? '';
            $this->button_text = $slide->button_text ?? '';
            $this->button_url  = $slide->button_url ?? '';
            $this->is_active   = $slide->is_active;
            $this->sort_order  = $slide->sort_order;
            $this->existingImage = $slide->image_path;
        }
    }

    public function save()
    {
        $this->validate();
        $rules = [];
        if (! $this->slide?->exists) {
            $rules['image'] = 'required|image|max:4096';
        } else {
            $rules['image'] = 'nullable|image|max:4096';
        }
        $this->validate($rules);

        $data = [
            'title'       => $this->title,
            'subtitle'    => $this->subtitle,
            'button_text' => $this->button_text,
            'button_url'  => $this->button_url,
            'is_active'   => $this->is_active,
            'sort_order'  => $this->sort_order,
        ];

        if ($this->image) {
            if ($this->existingImage) {
                $this->deleteImage($this->existingImage);
            }
            $data['image_path'] = $this->uploadImage($this->image, 'hero-slides');
        } elseif ($this->existingImage) {
            $data['image_path'] = $this->existingImage;
        }

        if ($this->slide?->exists) {
            $this->slide->update($data);
        } else {
            HeroSlide::create($data);
        }

        session()->flash('success', 'Slide saved.');
        return redirect()->route('admin.hero-slides.index');
    }

    public function render()
    {
        return view('livewire.admin.hero-slides.hero-slide-form', [
            'pageTitle' => $this->slide?->exists ? 'Edit Slide' : 'Create Slide',
        ])->title($this->slide?->exists ? 'Edit Slide' : 'Create Slide');
    }
}
