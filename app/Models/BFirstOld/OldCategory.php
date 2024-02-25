<?php

namespace App\Models\BFirstOld;

use App\Models\BFirstOld\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class OldCategory extends BaseModel
{
    use HasFactory;

    protected $table = "categories";
    //protected $fillable = ['name','slug','meta'];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }
}
