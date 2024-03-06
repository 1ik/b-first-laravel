<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeaturedStoryRequest;
use App\Http\Resources\StoryResource;
use App\Models\FeaturedStories;
use App\Models\Story;
use Illuminate\Http\Request;

class FeaturedStoryController extends Controller
{
    public function categoryFeaturedStories($category){
        $featured_stories = FeaturedStories::where('category_id',$category)->first();
        $stories = []; 
        if ($featured_stories) {
            $storyIdsString = implode(',', $featured_stories->story_ids);
            $stories = Story::with(['authors', 'categories', 'tags'])->whereIn('id', $featured_stories->story_ids)->orderByRaw("FIELD(id,$storyIdsString)")->get();
        }

        return StoryResource::collection($stories);
    }

    public function searchStories(Request $request){
        $title = $request->title;
        $stories = [];
        if($title){
            $stories = Story::with(['authors', 'categories', 'tags'])->where('title','like','%'.$request->title.'%')->orderBy('id','desc')->paginate(10);
        }
        return StoryResource::collection($stories);
    }

    public function createFeaturedStory(FeaturedStoryRequest $request){
        $category_id = $request->validated('category_id');
        $story_ids   = $request->validated('story_ids');

        $record = FeaturedStories::where('category_id', $category_id)->first();

        if ($record) {
            
            $record->update(['story_ids' => $story_ids]);
            $message = 'Data updated successfully';
            $updatedRecord = FeaturedStories::find($record->id);

        } else {

            $updatedRecord = FeaturedStories::create([
                'category_id' => $category_id,
                'story_ids' => $story_ids,
            ]);
            $message = 'Data inserted successfully';
        }

        return response()->json(['message' => $message, 'data' => $updatedRecord],200);
    }
}
