<?php

namespace App\Livewire\Frontend;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public')]
class HomePage extends Component
{
    public function render()
    {
        return view('livewire.frontend.home-page');
    }
}
