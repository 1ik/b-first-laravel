<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaLibraryImage extends Model
{
    use HasFactory;

    protected $fillable = ['title','url','meta','status','created_by'];
}
