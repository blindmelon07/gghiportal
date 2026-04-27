<?php

namespace App\Livewire\Frontend;

use App\Models\Service;
use Livewire\Component;

class ServicesGrid extends Component
{
    public function render()
    {
        return view('livewire.frontend.services-grid', [
            'services' => Service::active()->featured()->ordered()->get(),
        ]);
    }
}
