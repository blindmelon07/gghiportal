<?php

namespace App\Livewire\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Change Password'])]
class ChangePassword extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function update(): void
    {
        $this->validate([
            'current_password'      => ['required'],
            'password'              => ['required', 'confirmed', Password::min(8)],
            'password_confirmation' => ['required'],
        ]);

        $admin = Auth::guard('admin')->user();

        if (! Hash::check($this->current_password, $admin->password)) {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        $admin->update(['password' => $this->password]);

        $this->reset('current_password', 'password', 'password_confirmation');
        $this->dispatch('notify', message: 'Password changed successfully.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.change-password');
    }
}
