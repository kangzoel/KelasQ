<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Klass extends Model
{
    public $timestamps = false;

    public function admin()
    {
        return $this->hasManyThrough('App\User', 'App\UserKlass', 'klass_id', 'npm', NULL, 'user_npm')->where('role_id', 1);
    }

    public function users()
    {
        return $this->hasManyThrough('App\User', 'App\UserKlass', 'klass_id', 'npm', NULL, 'user_npm')->orderBy('role_id', 'asc');
    }

    public function subjects()
    {
        return $this->hasMany('App\Subject');
    }
}
