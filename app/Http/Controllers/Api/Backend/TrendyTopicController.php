<?php

namespace App\Http\Controllers\Api\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\TrendyTopicRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Models\TrendyTopic;
use Illuminate\Http\Request;

class TrendyTopicController extends Controller
{
    public function searchTrendyTopic(Request $request){
        $name = $request->name;
        $tags = [];
        if($name){
            $tags = Tag::where('name','like','%'.$name.'%')->orderBy('id','desc')->paginate(10);
        }
 
        return TagResource::collection($tags);
    }

    public function createTrendyTopic(TrendyTopicRequest $request){
        $tag_ids   = $request->validated('tag_ids');  
        $record = TrendyTopic::first();

        if ($record) {
            $record->update(['tag_ids' => $tag_ids]);
            $message = 'Data updated successfully';
            $updatedRecord = TrendyTopic::find($record->id);
        } else {
            $updatedRecord = TrendyTopic::create([ 
                'tag_ids' => $tag_ids,
            ]);
            $message = 'Data inserted successfully';
        }

        return response()->json(['message' => $message, 'data' => $updatedRecord],200);
    }
}
