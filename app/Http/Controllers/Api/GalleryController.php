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
        $posts        = OldStory::all();

        DB::transaction(function() use($posts,$imageUploadService) {
            foreach ($posts as $post) {
                $story = new Story();
                $story->title = $post->title;
                $story->content = $post->content;
                $story->meta = [
                    'headline' => $post->brief,
                    'featured_image' => $post->featuredPhotoUrl,
                    'featured_image_caption' => $post->feature_image_caption
                ];
                $story->created_at = $post->created_at;
                $story->updated_at = $post->updated_at;
                $story->save();
            
                if (!empty($post->category_id)) {
                    $get_cat = OldCategory::find($post->category_id);
                    $category = Category::firstOrCreate(['name' => $get_cat->name]);
                    $story->categories()->attach($category->id);
                }
            
                if (!empty($post->author)) {
                    $author = Author::firstOrCreate(['name' => $post->author]);
                    $story->authors()->attach($author->id);
                }
            }
            
        },5);

    }
}
