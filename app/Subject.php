<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany('App\Comment', 'foreign_key', 'local_key');
    }
}
