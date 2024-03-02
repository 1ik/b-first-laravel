<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\BFirstOld\OldCategory;
use App\Models\BFirstOld\OldStory;
use App\Models\Category;
use App\Models\MediaLibraryImage;
use App\Models\Story;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public  function imageUpload(Request $request){
        return $request->all();
    }
}
