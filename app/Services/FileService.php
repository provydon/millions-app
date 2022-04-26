<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileService
{

    public static function storeFile($file, $folder, $cloud = false, $base64 = false, $filename = null, $filtype = null)
    {
        if ($base64 && $filename) {
            $file = base64_decode($file);
            $name = $filtype ? $folder . "/$filename." . $filtype : $folder . "/" . $filename;

            if ($cloud) {
                Storage::disk('s3')->put($name, $file);
            }else{
                Storage::disk('public')->put($name, $file);
            }
        }

        if ($cloud) {
            $path = $base64 && isset($name) ? $name : $file->store($folder, 's3');
        } else {
            $path = $base64 && isset($name) ? $name : Storage::disk('public')->put($folder, $file);
        }

        return $path;
    }

    public static function deleteFile($path, $cloud = false)
    {
        if ($cloud) {
            Storage::cloud()->delete($path);
        } else {
            Storage::delete($path);
        }

        return;
    }
}

return new FileService;
