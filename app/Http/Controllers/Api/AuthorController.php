<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $author = Author::query();
        if(!empty($request->name)){
            $author->where('name','like','%'.$request->name.'%');
        }
        return AuthorResource::collection($author->orderBy('id', 'desc')->paginate(10));
    }

    
    public function store(AuthorRequest $request)
    {
        $author = Author::create([
            'name' => $request->name,
            'meta' => $request->meta,
            'created_by' => Auth::user()->id
        ]);
        return response()->json(['message' => 'Author created successfully', 'data' => $author], 201);
    }

   
    public function show(Author $author)
    {
        return response()->json([
            'message' => 'Author retrieved successfully',
            'data'    => new AuthorResource($author),
        ], 200);
    }

 
    public function update(AuthorRequest $request, Author $author)
    {
        $data = $author->update([
            'name' => $request->name,
            'meta' => $request->meta,
        ]);

        return response()->json([
            'message' => 'Author updated successfully',
            'data'    => $data
        ], 200);
    }

    public function destroy(Author $author)
    {
        $author->delete();
    
        return response()->json([
            'message' => 'Author deleted successfully',
            'data'    => null,
        ], 200);
    }
}
