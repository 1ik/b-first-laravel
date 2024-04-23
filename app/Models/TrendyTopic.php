<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrendyTopic extends Model
{
    use HasFactory;

    protected $fillable = ['tag_ids'];

    protected $casts = [
        'tag_ids' => 'array'
    ];
}
