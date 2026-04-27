<?php

use App\Models\Admin;
use Livewire\Livewire;

it('shows admin login page', function () {
    $this->get(route('admin.login'))->assertOk();
});

it('redirects unauthenticated admin to login', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('admin.login'));
});

it('logs in with valid credentials', function () {
    $admin = Admin::factory()->create();
    Livewire::test(\App\Livewire\Admin\Auth\Login::class)
        ->set('email', $admin->email)
        ->set('password', 'password')
        ->call('authenticate')
        ->assertRedirect(route('admin.dashboard'));
});

it('rejects invalid credentials', function () {
    Livewire::test(\App\Livewire\Admin\Auth\Login::class)
        ->set('email', 'wrong@test.com')
        ->set('password', 'wrongpass')
        ->call('authenticate')
        ->assertHasErrors(['email']);
});
