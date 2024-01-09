<?php

namespace App\Services;

use App\Models\Story;
use Illuminate\Support\Facades\DB;

class StoryService{

    public function store(array $data){

        DB::transaction(function() use($data) {
            $story = Story::create($data);
            $story->authors()->attach($data['authors']);
            $story->categories()->attach($data['categories']);
            $story->tags()->attach($data['tags']);
        },5);
    }

    public function update(Story $story, array $data)
    {
        DB::transaction(function() use($story, $data) {

            $story = tap($story)->update($data);

            $story->authors()->sync($data['authors']);
            $story->categories()->sync($data['categories']);
            $story->tags()->sync($data['tags']);

        }, 5);
    }
}