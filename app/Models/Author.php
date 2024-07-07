<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Author extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name', 'meta', 'deleted_at', 'created_by', 'updated_by'];

    public function setMetaAttribute($value)
    {
        $this->attributes['meta'] = json_encode($value);
    }

    public function stories(): BelongsToMany
    {
        return $this->belongsToMany(Story::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
