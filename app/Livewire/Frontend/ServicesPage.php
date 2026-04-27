<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.public', ['title' => 'Our Services'])]
class ServicesPage extends Component
{
    public function render()
    {
        return view('livewire.frontend.services-page', [
            'services' => Service::active()->ordered()->get(),
        ]);
    }
}
