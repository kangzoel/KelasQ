<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function klass()
    {
        return $this->belongsTo('App\Klass');
    }
}
