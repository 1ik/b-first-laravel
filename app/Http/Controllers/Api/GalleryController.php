<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
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

    public function oldDataUpload(ImageUploadService $imageUploadService){
        $old_category = OldCategory::all();
        $posts        = OldStory::all();

        // DB::transaction(function() use($posts,$imageUploadService) {
               
        // },5);

        foreach($posts as $post){

            if($post->featuredPhotoUrl != null)
            {
                $url = 'https://bfirst.sgp1.cdn.digitaloceanspaces.com/'.$post->featuredPhotoUrl;
                $fileContent = file_get_contents($url);
                if ($fileContent !== false) {
                    $fileName = uniqid() . '.' . pathinfo($url, PATHINFO_EXTENSION);
                    $fileLocation = 'mediaImages' . '/' . $fileName;
                    Storage::disk('do_spaces')->put($fileLocation, $fileContent, 'public');
                }
                MediaLibraryImage::create([
                    'url'         => $post->featuredPhotoUrl?$fileLocation:null,
                    'created_by'  => Auth::user()->id
                ]);
       
            }
            $story = new Story();
            $story->title =  $post->title;
            $story->content = $post->content;
            $story->meta = $post->featuredPhotoUrl ? ['featured_image' =>  $fileLocation] : null;
            $story->save();
            $story->categories()->attach($post->category_id);
            
        }
    }
}
