<?php

namespace App\Console\Commands;

use App\Models\Author;
use App\Models\BFirstOld\OldCategory;
use App\Models\BFirstOld\OldStory;
use App\Models\Category;
use App\Models\Story;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OldCmsDataInsert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:old-cms-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'We have old cms, we insert old data by this command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $posts = OldStory::all();

        DB::transaction(function() use($posts) {
            foreach ($posts as $post) {
                $story = new Story();
                $story->title = $post->title;
                $story->content = $post->content;
                $story->meta = [
                    'headline' => $post->brief,
                    'featured_image' => $post->featuredPhotoUrl,
                    'featured_image_caption' => $post->feature_image_caption
                ];
                $story->created_at = $post->created_at;
                $story->updated_at = $post->updated_at;
                $story->save();
            
                if (!empty($post->category_id)) {
                    $get_cat = OldCategory::find($post->category_id);
                    $category = Category::firstOrCreate(['name' => $get_cat->name]);
                    $story->categories()->attach($category->id);
                }
            
                if (!empty($post->author)) {
                    $author = Author::firstOrCreate(['name' => $post->author]);
                    $story->authors()->attach($author->id);
                }
            }
            
        },5);
    }
}
