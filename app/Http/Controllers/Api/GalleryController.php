<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\BFirstOld\OldCategory;
use App\Models\BFirstOld\OldStory;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GalleryController extends Controller
{
    public  function imageUpload(Request $request){
        return $request->all();
    }

    public function oldDataUpload(){
        $old_category = OldCategory::all();
        $posts        = OldStory::all();
        dd($posts);
        DB::transaction(function() use($old_category,$posts) {
            DB::statement('ALTER TABLE categories MODIFY id INT');
            foreach($old_category as $key=>$category_data){
                if($key == 5){
                    Category::create([
                        'id' => 6,
                        'name' => $category_data->name,
                    ]);
                }else{
                    Category::create([
                        'id' => $key + 1,
                        'name' => $category_data->name,
                    ]);
                }
            }
            DB::statement('ALTER TABLE categories MODIFY id INT AUTO_INCREMENT');
            // foreach($posts as $post){
            //     $story = new Story();
            //     $story->title =  $post->title;
            //     $story->content =  $post->content;
            //     $story->save();
            //     $story->categories()->attach($post->category_id);
            // }
        },5);
    }
}
