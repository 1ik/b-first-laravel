<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoryStoreRequest;
use App\Http\Resources\StoryResource;
use App\Models\Author;
use App\Models\Category;
use App\Models\Story;
use App\Models\Tag;
use App\Services\StoryService;
use Illuminate\Http\Request;


class StoryController extends Controller
{
   
    public function index(Request $request)
    {

        $query = Story::query();

        if ($request->has('category_id')) {
            $category_id = $request->input('category_id');
            $query->whereHas('categories', function ($query) use ($category_id) {
                $query->where('category_id', $category_id);
            });
        }

        if ($request->has('latest')) {
            $query->latest();
        }

        $stories = $query->with(['authors', 'categories', 'tags'])->paginate(10);

        return StoryResource::collection($stories);
    }

 
    public function store(StoryStoreRequest $request, StoryService $storyService)
    {
        $storyService->store($request->validated());

        return response()->json(['message' => 'Story created successfully', 'data' => true], 201);
    }

   
    public function show(Story $story)
    {
        return response()->json([
            'message'   => 'Story retrieved successfully',
            'story'     => new StoryResource($story->load('authors', 'tags', 'categories')),
        ], 200);
    }


    public function update(StoryStoreRequest $request, Story $story, StoryService $storyService)
    {
        $storyService->update($story,$request->validated());
        return response()->json([
            'message' => 'Story updated successfully',
            'data'    => true
        ], 200);
    }


    public function destroy(Story $story)
    {
        $story->update([
            'deleted_at' => now()
        ]);

        return response()->json([
            'message' => 'Story deleted successfully',
            'data'    => null,
        ], 200);
    }
}
