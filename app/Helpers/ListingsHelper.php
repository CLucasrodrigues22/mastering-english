<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ListingsHelper
{
    public static function saveFile(UploadedFile $image, string $directory): string
    {
        $path = $image->store($directory, 'public');

        return $directory . '/' . basename($path);
    }


    public static function deleteImage(string $imagePath): bool
    {
        if (Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }

        return false;
    }



    public static function prepareTags(string $tags): string
    {
        return implode(',', array_unique(array_filter(array_map('trim', explode(',', $tags)))));
    }
}
