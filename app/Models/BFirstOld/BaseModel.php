<?php

namespace App\Models\BFirstOld;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    protected $connection = 'mysql'; //mysql_intercity_periphery, default => mysql

    public function __construct() {
        $this->connection = config('database.b_first_old');
    }
}