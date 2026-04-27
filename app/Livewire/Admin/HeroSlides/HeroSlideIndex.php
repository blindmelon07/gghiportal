<?php

namespace App\Livewire\Admin\HeroSlides;

use App\Models\HeroSlide;
use App\Traits\ImageUploadTrait;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Hero Slides'])]
class HeroSlideIndex extends Component
{
    use ImageUploadTrait;

    public ?int $deleteId = null;
    public bool $confirmDelete = false;

    public function toggleActive(int $id): void
    {
        $slide = HeroSlide::findOrFail($id);
        $slide->update(['is_active' => ! $slide->is_active]);
        $this->dispatch('notify', message: 'Slide updated.', type: 'success');
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->confirmDelete = true;
    }

    public function delete(): void
    {
        $slide = HeroSlide::findOrFail($this->deleteId);
        $this->deleteImage($slide->image_path);
        $slide->delete();
        $this->confirmDelete = false;
        $this->dispatch('notify', message: 'Slide deleted.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.hero-slides.hero-slide-index', [
            'slides' => HeroSlide::orderBy('sort_order')->get(),
        ]);
    }
}
