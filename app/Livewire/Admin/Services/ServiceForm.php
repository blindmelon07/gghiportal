<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class ServiceForm extends Component
{
    use WithFileUploads, ImageUploadTrait;

    public ?Service $service = null;

    #[Validate('required|min:2|max:255')]
    public string $title = '';
    public string $slug = '';
    public string $icon = '';
    #[Validate('required|min:10')]
    public string $description = '';
    public bool $is_featured = true;
    public bool $is_active = true;
    public int $sort_order = 0;
    public $image;
    public ?string $existingImage = null;

    public function mount(?Service $service = null): void
    {
        if ($service && $service->exists) {
            $this->service     = $service;
            $this->title       = $service->title;
            $this->slug        = $service->slug;
            $this->icon        = $service->icon ?? '';
            $this->description = $service->description;
            $this->is_featured = $service->is_featured;
            $this->is_active   = $service->is_active;
            $this->sort_order  = $service->sort_order;
            $this->existingImage = $service->image_path;
        }
    }

    public function updatedTitle(): void
    {
        if (! $this->service?->exists) {
            $this->slug = Str::slug($this->title);
        }
    }

    public function save()
    {
        $this->validate();
        $data = [
            'title'       => $this->title,
            'slug'        => $this->slug ?: Str::slug($this->title),
            'icon'        => $this->icon,
            'description' => $this->description,
            'is_featured' => $this->is_featured,
            'is_active'   => $this->is_active,
            'sort_order'  => $this->sort_order,
        ];

        if ($this->image) {
            if ($this->existingImage) {
                $this->deleteImage($this->existingImage);
            }
            $data['image_path'] = $this->uploadImage($this->image, 'services');
        }

        if ($this->service?->exists) {
            $this->service->update($data);
        } else {
            Service::create($data);
        }

        session()->flash('success', 'Service saved.');
        return redirect()->route('admin.services.index');
    }

    public function render()
    {
        return view('livewire.admin.services.service-form', [
            'pageTitle' => $this->service?->exists ? 'Edit Service' : 'Create Service',
        ])->title($this->service?->exists ? 'Edit Service' : 'Create Service');
    }
}
