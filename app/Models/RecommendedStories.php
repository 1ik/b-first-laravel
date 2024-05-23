<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedStories extends Model
{
    use HasFactory;

    protected $fillable = ['story_ids'];

    protected $casts = [
        'story_ids' => 'array',
    ];
}
