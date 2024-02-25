<?php

namespace App\Models\BFirstOld;

use App\Models\BFirstOld\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OldAuthor extends BaseModel
{
    use HasFactory;
    protected $fillable = ['name'];
}
