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
        return CategoryResource::collection(Category::paginate(10));
    }

    
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'meta' => $request->meta,
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
            'meta' => $request->meta,
        ]);

        return response()->json([
            'message' => 'User Profile updated successfully',
            'data'    => $data
        ], 200);
    }

  
    public function destroy(Category $category)
    {
        $category->delete();
    
        return response()->json([
            'message' => 'Category deleted successfully',
            'data'    => null,
        ], 200);
    }
}
