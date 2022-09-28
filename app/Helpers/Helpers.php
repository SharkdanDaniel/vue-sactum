<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('getImageBase64')) {
    function getImageBase64($media_type, $path)
    {
        $data = base64_encode(Storage::get($path));
        return "data:$media_type;base64,$data";
    }
}
