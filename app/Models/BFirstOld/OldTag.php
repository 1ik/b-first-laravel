<?php

namespace App\Models\BFirstOld;

use App\Models\BFirstOld\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class OldTag extends BaseModel
{
    use HasFactory;
    protected $fillable = ['name','slug'];
    protected $table = "tags";
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
