<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MediaLibraryImage;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MediaLibraryController extends Controller
{
    public function uploadImage(Request $request,ImageUploadService $imageUploadService){
        $imagePath = $imageUploadService->upload($request->file('image'));
        MediaLibraryImage::create([
            'title'       => $request->title,
            'url'         => $imagePath,
            'meta'        => json_encode($request->meta),
            'status'      => $request->status,
            'created_by'  => Auth::user()->id
        ]);
        return response()->json(['url' => $imagePath], 201);
    }

    public function mediaImageList(Request $request){
        $mediaImages = MediaLibraryImage::query();
        if(!empty($request->title)){
            $mediaImages->where('title','like','%'.$request->title.'%');
        }
        if(!empty($request->sort)){
            $mediaImages->orderBy('id',$request->sort);
        }
        $mediaImages = $mediaImages->paginate(10);

        return response()->json(['media_images' => $mediaImages], 201);
    }
}