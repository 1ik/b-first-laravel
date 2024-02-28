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

    public function oldDataUpload(ImageUploadService $imageUploadService){
        $old_category = OldCategory::all();
        $posts        = OldStory::all();

        DB::transaction(function() use($posts,$imageUploadService) {
            foreach($posts as $post){
                $story = new Story();
                $story->title =  $post->title;
                $story->content = $post->content;
                $story->meta = ['headline'=>$post->brief,'featured_image'=>$post->featuredPhotoUrl,'featured_image_caption'=>$post->feature_image_caption];
                $story->created_at = $post->created_at;
                $story->updated_at = $post->updated_at;
                $story->save();
                $story->categories()->attach($post->category_id);
                if (!empty($post->author)) {
                    $author = Author::firstOrCreate(['name' => $post->author]);
                    if ($author->wasRecentlyCreated) {
                        $story->authors()->attach($author->id);
                    } else {
                        $story->authors()->attach($author->id);
                    }
                }
            }   
        },5);

    }
}
