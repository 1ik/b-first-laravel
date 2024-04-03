<?php

namespace App\Http\Controllers\Api\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\StoryResource;
use App\Http\Resources\TagResource;
use App\Models\Author;
use App\Models\Category;
use App\Models\Story;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TrashController extends Controller
{
    public function trashItems($type){
        if($type == 'story')
        {
            $softDeletedStories = Story::with(['authors'])->onlyTrashed()->orderByDesc('deleted_at')->paginate(20);
            $trash_items = StoryResource::collection($softDeletedStories);
        }
        if($type == 'category')
        {
            $softDeletedStories = Category::onlyTrashed()->orderByDesc('deleted_at')->paginate(20);
            $trash_items = CategoryResource::collection($softDeletedStories);
        }
        if($type == 'author')
        {
            $softDeletedStories = Author::onlyTrashed()->orderByDesc('deleted_at')->paginate(20);
            $trash_items = AuthorResource::collection($softDeletedStories);
        }
        if($type == 'tag')
        {
            $softDeletedStories = Tag::onlyTrashed()->orderByDesc('deleted_at')->paginate(20);
            $trash_items = TagResource::collection($softDeletedStories);
        }
        return $trash_items;
    }

    public function restoreTrashItem($type,$id)
    {

        $validTypes = ['story', 'category', 'author', 'tag'];

        if (!in_array($type, $validTypes)) {
            return response()->json(['error' => 'Invalid type'], 400);
        }

        $modelClass = 'App\\Models\\' . ucfirst($type);;

        $model = $modelClass::withTrashed()->find($id);

        if (!$model) {
            return response()->json(['error' => "$type not found"], 404);
        }

        if ($model->trashed()) {
            $model->restore();
            return response()->json(['message' => "$type restored successfully"]);
        }

    }

    public function deleteTrashItem($type,$id)
    {

        if($type == 'story'){
            $story = Story::with(['authors', 'categories', 'tags'])->onlyTrashed()->find($id);
            if ($story) {
                DB::transaction(function() use($story) {
                    $story->authors()->detach();
                    $story->categories()->detach();
                    $story->tags()->detach();
                    $story->forceDelete();
                },5);
                return response()->json(['message' => 'Story permanently deleted']);
            } else {
                return response()->json(['error' => 'Story not found'], 404);
            }
        }
        if($type == 'category'){
            $category = Category::with(['stories'])->onlyTrashed()->find($id);
            if ($category) {
                DB::transaction(function() use($category) {
                    $category->stories()->detach();
                    $category->forceDelete();
                },5);
                return response()->json(['message' => 'category permanently deleted']);
            }
        }
        if($type == 'author'){
            $author = Author::with(['stories'])->onlyTrashed()->find($id);
            if ($author) {
                $author->stories()->detach();
                $author->forceDelete();
                return response()->json(['message' => 'author permanently deleted']);
            }
        }
        if($type == 'tag'){
            $tag = Tag::with(['stories'])->onlyTrashed()->find($id);
            if ($tag) {
                $tag->stories()->detach();
                $tag->forceDelete();
                return response()->json(['message' => 'Tag permanently deleted']);
            }
        }
    }
}
