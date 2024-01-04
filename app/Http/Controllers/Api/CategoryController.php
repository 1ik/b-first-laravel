<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
 
    public function index()
    {
        $categories = Category::paginate(10); 

        return response()->json([
            'message' => 'Successfully retrieved categories',
            'data'    => CategoryResource::collection($categories),
        ], 200);
    }

    
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'meta' => json_encode($request->meta),
        ]);
        return response()->json(['message' => 'Category created successfully', 'data' => $category], 201);
    }

   
    public function show(Category $category)
    {
        return response()->json([
            'message' => 'Category retrieved successfully',
            'data'    => new CategoryResource($category),
        ], 200);
    }

 
    public function update(CategoryUpdateRequest $request,Category $category)
    {
        $data = $category->update([
            'name' => $request->name,
            'meta' => json_encode($request->meta),
        ]);

        return response()->json([
            'message' => 'User Profile updated successfully',
            'data'    => $data
        ], 200);
    }

  
    public function destroy(string $id)
    {
        //
    }
}
