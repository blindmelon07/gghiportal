<?php

use App\Models\Admin;
use App\Models\HospitalInfo;
use Livewire\Livewire;

it('saves site information', function () {
    $this->actingAs(Admin::factory()->create(), 'admin');
    Livewire::test(\App\Livewire\Admin\SiteInfo\SiteInfoEditor::class)
        ->set('info.name', 'GSAC General Hospital')
        ->set('info.phone', '+63 054 123 4567')
        ->call('save')
        ->assertHasNoErrors();
    expect(HospitalInfo::get('name'))->toBe('GSAC General Hospital');
});
