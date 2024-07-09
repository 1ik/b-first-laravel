<?php

namespace App\Services;

use App\Models\Story;
use App\Models\StoryEditHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoryService{

    public function store(array $data): Story{

        return DB::transaction(function() use($data) {
            $data['created_by'] = Auth::user()->id;
            $story = Story::create($data);
            $story->authors()->attach($data['authors']);
            $story->categories()->attach($data['categories']);
            $story->tags()->attach($data['tags']);
            return $story;
        },5);
    }

    public function update(Story $story, array $data)
    {
        
        DB::transaction(function() use($story, $data) {

            $story = tap($story)->update($data);
            StoryEditHistory::create([
                'user_id'  => Auth::user()->id,
                'story_id' => $story->id,
                'snapshot' => json_encode($data),
            ]);
            $story->authors()->sync($data['authors']);
            $story->categories()->sync($data['categories']);
            $story->tags()->sync($data['tags']);

        }, 5);
    }
}