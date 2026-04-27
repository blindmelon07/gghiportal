<?php

use App\Models\ContactMessage;
use Livewire\Livewire;

it('submits contact form successfully', function () {
    Livewire::test(\App\Livewire\Frontend\ContactForm::class)
        ->set('name', 'Juan dela Cruz')
        ->set('email', 'juan@example.com')
        ->set('subject', 'Appointment')
        ->set('message', 'I would like to book an appointment.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSee('Thank you');
    expect(ContactMessage::count())->toBe(1);
});

it('validates required fields', function () {
    Livewire::test(\App\Livewire\Frontend\ContactForm::class)
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'message']);
});
