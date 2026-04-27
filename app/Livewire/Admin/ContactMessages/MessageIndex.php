<?php

namespace App\Livewire\Admin\ContactMessages;

use App\Models\ContactMessage;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Contact Messages'])]
class MessageIndex extends Component
{
    public string $filter = 'all';
    public ?int $expandedId = null;

    public function expand(int $id): void
    {
        $this->expandedId = $this->expandedId === $id ? null : $id;
        $this->markRead($id);
    }

    public function markRead(int $id): void
    {
        ContactMessage::findOrFail($id)->update(['is_read' => true]);
    }

    public function delete(int $id): void
    {
        ContactMessage::findOrFail($id)->delete();
        if ($this->expandedId === $id) {
            $this->expandedId = null;
        }
        $this->dispatch('notify', message: 'Message deleted.', type: 'success');
    }

    public function render()
    {
        $query = ContactMessage::latest();
        if ($this->filter === 'unread') {
            $query->where('is_read', false);
        } elseif ($this->filter === 'read') {
            $query->where('is_read', true);
        }
        return view('livewire.admin.contact-messages.message-index', [
            'messages' => $query->get(),
        ]);
    }
}
