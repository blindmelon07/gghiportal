<?php

namespace App\Livewire\Frontend;

use App\Models\ContactMessage;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ContactForm extends Component
{
    #[Validate('required|min:2|max:255')]
    public string $name = '';

    #[Validate('required|email|max:255')]
    public string $email = '';

    public string $phone = '';
    public string $subject = '';

    #[Validate('required|min:10')]
    public string $message = '';

    public bool $submitted = false;

    public function submit()
    {
        $this->validate();

        ContactMessage::create([
            'name'    => $this->name,
            'email'   => $this->email,
            'phone'   => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
        ]);

        $this->submitted = true;
        $this->reset(['name', 'email', 'phone', 'subject', 'message']);
    }

    public function render()
    {
        return view('livewire.frontend.contact-form');
    }
}
