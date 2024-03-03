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

        $stories = $category->stories()->with('authors', 'tags','categories')->paginate($pageSize); 

        return StoryResource::collection($stories);
    }
    public function storyDetails(Story $story){

        return response()->json([
            'message'   => 'Story retrieved successfully',
            'story'     => new StoryResource($story->load('authors', 'tags', 'categories')),
        ], 200);
    }

}