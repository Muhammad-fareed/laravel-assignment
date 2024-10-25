<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str; 
class ImageHelper
{
    public static function compressImage($image)
    {

        $img = Image::read($image)->resize(400, 400);
        $randomString = Str::random(10);
        $extension = $image->getClientOriginalExtension();
        $imageName = $randomString . '.' . $extension;
        $path = 'products/' . $imageName;
        Storage::disk('public')->put($path, (string) $img->encode());
        return $path;
    }
}
