<?php

use App\Models\Admin;
use App\Models\Service;
use Livewire\Livewire;

beforeEach(fn () => $this->actingAs(Admin::factory()->create(), 'admin'));

it('creates a service', function () {
    Livewire::test(\App\Livewire\Admin\Services\ServiceForm::class)
        ->set('title', 'Cardiology')
        ->set('description', 'Heart care specialists.')
        ->call('save')
        ->assertHasNoErrors();
    expect(Service::where('title', 'Cardiology')->exists())->toBeTrue();
});

it('toggles service active status', function () {
    $service = Service::factory()->create(['is_active' => true]);
    Livewire::test(\App\Livewire\Admin\Services\ServiceIndex::class)
        ->call('toggleActive', $service->id);
    expect($service->fresh()->is_active)->toBeFalse();
});
