<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryEditHistory extends Model
{
    use HasFactory;
    protected $table = 'story_edit_history';
    
    protected $fillable = ['user_id', 'story_id', 'snapshot'];
}
