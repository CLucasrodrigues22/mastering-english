<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ListingsHelper
{
    public static function saveImage(UploadedFile $image, string $directory): string
    {
        // Define o caminho completo para salvar a imagem
        $path = $image->store($directory, 'public');

        // Retorna o caminho para uso posterior
        return Storage::url($path);
    }

    public static function prepareTags(string $tags): string
    {
        return implode(',', array_unique(array_filter(array_map('trim', explode(',', $tags)))));
    }
}
