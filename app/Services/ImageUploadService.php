<?php

namespace App\Services;

class ImageUploadService{

    protected $storageDisk;
    protected $storagePath;

    public function __construct()
    {
        $this->storageDisk = config('filesystems.default');
    }

    public function upload($imageFile)
    {

        $filename = uniqid() . '_' . time() . '.' . $imageFile->getClientOriginalExtension();

        $filePath = 'mediaImages';

        $imageFile->storeAs($filePath, $filename, $this->storageDisk);

        return $filePath . '/' . $filename;
    }

}