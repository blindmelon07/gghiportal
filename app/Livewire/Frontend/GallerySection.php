<?php

namespace App\Livewire\Frontend;

use App\Models\GalleryImage;
use Livewire\Component;

class GallerySection extends Component
{
    public string $activeSection = 'all';

    public function render()
    {
        $query = GalleryImage::active()->ordered();
        if ($this->activeSection !== 'all') {
            $query->where('section', $this->activeSection);
        }
        return view('livewire.frontend.gallery-section', [
            'images' => $query->get(),
        ]);
    }
}
