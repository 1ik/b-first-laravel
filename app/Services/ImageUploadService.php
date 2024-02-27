<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageUploadService{

    protected $storageDisk;
    protected $storagePath;

    public function __construct()
    {
        $this->storageDisk = config('filesystems.default');
    }

    public function upload($imageFile)
    {
        $dateDir = date('Y-M-d');
        $filename = $dateDir.'_'.uniqid() . '_' . time() . '.' . $imageFile->getClientOriginalExtension();
        $fileLocation = 'mediaImages' . '/' . $filename;
        Storage::disk('do_spaces')->put($fileLocation, file_get_contents($imageFile), 'public');

        return $fileLocation;
    }

}