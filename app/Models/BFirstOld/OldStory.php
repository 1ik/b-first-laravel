<?php

namespace App\Models\BFirstOld;

use App\Models\Author;
use App\Models\BFirstOld\BaseModel;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class OldStory extends BaseModel
{
    use HasFactory;
    use SoftDeletes;
    protected $table = "posts";
    
    protected $fillable = ['title','meta','content','deleted_at'];

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode($value);
    }

    public function authors(): BelongsToMany
    {
        return $this->belongsToMany(Author::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class,'tag_story');
    }
}
