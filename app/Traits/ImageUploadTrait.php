<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    protected function uploadImage($file, string $folder): string
    {
        $path = $file->store($folder, 'public');
        return Storage::disk('public')->url($path);
    }

    protected function deleteImage(?string $path): void
    {
        if ($path) {
            $relativePath = ltrim(parse_url($path, PHP_URL_PATH), '/');
            $relativePath = preg_replace('#^storage/#', '', $relativePath);
            Storage::disk('public')->delete($relativePath);
        }
    }
}
