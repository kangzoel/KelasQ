<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public $timestamps = false;

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }
}
