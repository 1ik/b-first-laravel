<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
 
    public function index(Request $request)
    {
        $category = Category::query();
        if(!empty($request->name)){
            $category->where('name','like','%'.$request->name.'%');
        }

        return CategoryResource::collection($category->orderBy('id', 'desc')->paginate(10));
    }

    
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            'name' => $request->name,
            'meta' => $request->meta,
            'created_by' => Auth::user()->id,
            'color_code' => $request->color_code
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
            'color_code' => $request->color_code
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
