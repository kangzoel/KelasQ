<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserKlass extends Model
{
    public $timestamps = false;
    public $table = 'user_klass';
    public $guarded = [];
}
