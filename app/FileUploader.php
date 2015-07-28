<?php

namespace App;

use File;
use Storage;

class FileUploader
{
    public static function store($file)
    {
        $filePath = config('uploads.path') . '/' . $file->getClientOriginalName();
        Storage::put($filePath, File::get($file), 'public');
        return $filePath;
    }
}
