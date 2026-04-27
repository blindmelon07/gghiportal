<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    protected function uploadImage($file, string $folder): string
    {
        $path = $file->store("public/{$folder}");
        return Storage::url($path);
    }

    protected function deleteImage(?string $path): void
    {
        if ($path) {
            $relativePath = str_replace('/storage/', 'public/', $path);
            Storage::delete($relativePath);
        }
    }
}
