<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeaturedStories extends Model
{
    use HasFactory;
    protected $fillable = ['category_id','story_ids'];

    protected $casts = [
        'story_ids' => 'array'
    ];
}
