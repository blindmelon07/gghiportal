<?php

use App\Models\Admin;
use App\Models\ContactMessage;
use Livewire\Livewire;

it('marks message as read when opened', function () {
    $this->actingAs(Admin::factory()->create(), 'admin');
    $msg = ContactMessage::factory()->unread()->create();
    Livewire::test(\App\Livewire\Admin\ContactMessages\MessageIndex::class)
        ->call('markRead', $msg->id);
    expect($msg->fresh()->is_read)->toBeTrue();
});
