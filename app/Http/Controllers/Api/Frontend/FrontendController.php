<?php

namespace App\Http\Controllers\Api\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\StoryResource;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function allCategories(){

        return CategoryResource::collection(Category::all());
    }
    public function latestStories(Request $request){
        $pageSize = $request->input('size', 20);
        return StoryResource::collection(Story::with(['authors', 'categories', 'tags'])->latest()->paginate($pageSize));
    }

    public function categoryStories(Request $request,$category){

        $pageSize = $request->input('size', 20);
        $category = Category::where('name', $category)->first();

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $stories = $category->stories()->with('authors', 'tags','categories')->orderBy('id', 'desc')->paginate($pageSize); 

        return StoryResource::collection($stories);
    }
    public function storyDetails(Story $story){

        return response()->json([
            'message'   => 'Story retrieved successfully',
            'story'     => new StoryResource($story->load('authors', 'tags', 'categories')),
        ], 200);
    }

    public function previewStory(Story $story){
        $story_image = json_decode($story->meta);

        $data = '<div
        style="
                max-width: 820px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px;
                background-color: #F2F4F7;
                border-radius: 5px; 
                "
            >
            <h2 style="font-size: 1.5rem; font-family: system-ui">
                <a
                style="text-decoration: none; color: #101828;"
                href="https://bangladeshfirst.com/story/detials/'.$story->id.'"
                  target="_blank"
                  >
                  '.$story->title.'
                  </a>
                  </h2>
                  <img
                  style="width: 200px; border-radius: 5px;"
                  src="https://images.bangladeshfirst.com/resize?width=200&height=112&format=webp&quality=85&path='.$story_image->featured_image.'"
                  alt="placeholder-img"
                  />
                  </div>';
                  
        return $data;          
    }

}
