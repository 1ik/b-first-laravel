<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\Category;
use App\Models\Story;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DeleteOldTrashItems extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete-old-trash-items';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete 30days old story items from the trash';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = Carbon::now()->subDays(30);
        $storyId    = Story::onlyTrashed()->where('deleted_at', '<=', $thresholdDate)->pluck('id');
        $categoryId = Category::onlyTrashed()->where('deleted_at', '<=', $thresholdDate)->pluck('id');
        $authorId   = Author::onlyTrashed()->where('deleted_at', '<=', $thresholdDate)->pluck('id');
        $tagId      = Tag::onlyTrashed()->where('deleted_at', '<=', $thresholdDate)->pluck('id');

        if ($storyId->isNotEmpty()) {
            DB::transaction(function () use ($storyId) {
                DB::table('author_story')->whereIn('story_id', $storyId)->delete();
                DB::table('category_story')->whereIn('story_id', $storyId)->delete();
                DB::table('tag_story')->whereIn('story_id', $storyId)->delete();
        
                Story::whereIn('id', $storyId)->forceDelete();
            });
            Log::info("Stories and related pivot table data permanently deleted");   
        }
        if($categoryId->isNotEmpty()){
            DB::transaction(function() use($categoryId) {
                DB::table('category_story')->whereIn('category_id', $categoryId)->delete();
                Category::whereIn('id', $categoryId)->forceDelete();
            },5);
            Log::info("Category and related pivot table data permanently deleted");
        }
        if($authorId->isNotEmpty()){
            DB::transaction(function() use($authorId) {
                DB::table('author_story')->whereIn('author_id', $authorId)->delete();
                Author::whereIn('id', $authorId)->forceDelete();
            },5);
            Log::info("Author and related pivot table data permanently deleted");
        }
        if($tagId->isNotEmpty()){
            DB::transaction(function() use($tagId) {
                DB::table('tag_story')->whereIn('tag_id', $tagId)->delete();
                Tag::whereIn('id', $tagId)->forceDelete();
            },5);
            Log::info("Tag and related pivot table data permanently deleted");
        }
    }
}
