<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RecommendedStoryRequest;
use App\Http\Resources\StoryResource;
use App\Models\RecommendedStories;
use App\Models\Story;
use Illuminate\Http\Request;

class RecommendedStoryController extends Controller
{
    public function searchStories(Request $request){
        $title = $request->title;
        $stories = [];
        if($title){
            $stories = Story::with(['authors', 'categories', 'tags'])->where('title','like','%'.$request->title.'%')->orderBy('id','desc')->paginate(10);
        }
        return StoryResource::collection($stories);
    }

    public function createRecommendedStory(RecommendedStoryRequest $request)
    {
        $story_ids = $request->validated('story_ids');

        $record = RecommendedStories::first();

        if ($record) {
            $record->update(['story_ids' => $story_ids]);
            $message = 'Data updated successfully';
            $updatedRecord = RecommendedStories::find($record->id);
        } else {
            $updatedRecord = RecommendedStories::create([
                'story_ids' => $story_ids,
            ]);
            $message = 'Data inserted successfully';
        }

        return response()->json(['message' => $message, 'data' => $updatedRecord], 200);
    }
}
