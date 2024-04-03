<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


class Tag extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $fillable = ['name','slug','deleted_at'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(Story::class,'tag_story');
    }
}
