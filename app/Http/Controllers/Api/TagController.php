<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
 
    public function index(Request $request)
    {
        $tags = Tag::query();
        if(!empty($request->name)){
            $tags->where('name','like','%'.$request->name.'%');
        }

        return TagResource::collection($tags->paginate(10)); 
    }

    
    public function store(TagStoreRequest $request)
    {
        $tag = Tag::create([
            'name' => $request->name
        ]);

        return response()->json(['message' => 'Tag created successfully', 'data' => $tag], 201);
    }

   
    public function show(Tag $tag)
    {
        return response()->json([
            'message' => 'Tag retrieved successfully',
            'data'    => new TagResource($tag),
        ], 200);
    }

 
    public function update(TagUpdateRequest $request, Tag $tag)
    {
        $data = $tag->update([
            'name' => $request->name
        ]);

        return response()->json([
            'message' => 'Tag updated successfully',
            'data'    => $data
        ], 200);
    }

  
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json([
            'message' => 'Tag deleted successfully',
            'data'    => null,
        ], 200);
    }
}
