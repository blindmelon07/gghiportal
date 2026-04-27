<?php

namespace App\Livewire\Frontend;

use App\Models\HeroSlide;
use Livewire\Component;

class HeroSlider extends Component
{
    public function render()
    {
        return view('livewire.frontend.hero-slider', [
            'slides' => HeroSlide::active()->ordered()->get(),
        ]);
    }
}
