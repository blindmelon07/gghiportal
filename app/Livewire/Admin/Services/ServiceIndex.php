<?php

namespace App\Livewire\Admin\Services;

use App\Models\Service;
use App\Traits\ImageUploadTrait;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin', ['title' => 'Services'])]
class ServiceIndex extends Component
{
    use ImageUploadTrait;

    public ?int $deleteId = null;
    public bool $showDeleteModal = false;

    public function toggleActive(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->update(['is_active' => ! $service->is_active]);
        $this->dispatch('notify', message: 'Service status updated.', type: 'success');
    }

    public function toggleFeatured(int $id): void
    {
        $service = Service::findOrFail($id);
        $service->update(['is_featured' => ! $service->is_featured]);
        $this->dispatch('notify', message: 'Service updated.', type: 'success');
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        $service = Service::findOrFail($this->deleteId);
        $this->deleteImage($service->image_path);
        $service->delete();
        $this->showDeleteModal = false;
        $this->dispatch('notify', message: 'Service deleted.', type: 'success');
    }

    public function updateOrder(array $order): void
    {
        foreach ($order as $item) {
            Service::where('id', $item['value'])->update(['sort_order' => $item['order']]);
        }
    }

    public function render()
    {
        return view('livewire.admin.services.service-index', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }
}
