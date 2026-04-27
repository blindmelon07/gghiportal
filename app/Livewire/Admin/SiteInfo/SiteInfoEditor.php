<?php

namespace App\Livewire\Admin\SiteInfo;

use App\Models\HospitalInfo;
use App\Traits\ImageUploadTrait;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('layouts.admin', ['title' => 'Site Information'])]
class SiteInfoEditor extends Component
{
    use WithFileUploads, ImageUploadTrait;

    public array $info = [];
    public $logo;
    public $favicon;

    public function mount(): void
    {
        $keys = ['name','tagline','about_text','address','phone','emergency_phone','email','working_hours','logo_path','favicon_path'];
        foreach ($keys as $key) {
            $this->info[$key] = HospitalInfo::get($key, '');
        }
    }

    public function save(): void
    {
        if ($this->logo) {
            $this->validate(['logo' => 'image|max:2048']);
            $this->info['logo_path'] = $this->uploadImage($this->logo, 'branding');
        }
        if ($this->favicon) {
            $this->validate(['favicon' => 'image|max:512']);
            $this->info['favicon_path'] = $this->uploadImage($this->favicon, 'branding');
        }

        foreach ($this->info as $key => $value) {
            HospitalInfo::set($key, $value);
        }

        $this->dispatch('notify', message: 'Site information saved.', type: 'success');
    }

    public function render()
    {
        return view('livewire.admin.site-info.site-info-editor');
    }
}
