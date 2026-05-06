<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image;
use Spatie\Image\Enums\Fit;

trait ImageUploadTrait
{
    protected function uploadImage($file, string $folder): string
    {
        $path = $file->store($folder, 'public');
        $fullPath = Storage::disk('public')->path($path);

        try {
            Image::load($fullPath)
                ->fit(Fit::Max, 1920, 1920)
                ->quality(82)
                ->save($fullPath);
        } catch (\Throwable) {
            // Keep original if resize fails (e.g. HEIC without Imagick support)
        }

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
