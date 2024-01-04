<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::paginate(10); 

        return response()->json([
            'message' => 'Successfully retrieved authors',
            'data'    => AuthorResource::collection($authors),
        ], 200);
    }

    
    public function store(AuthorRequest $request)
    {
        $author = Author::create([
            'name' => $request->name,
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
