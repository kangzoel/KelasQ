<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserSubject extends Model
{
    public $table = 'user_subject';
    public $timestamps = false;
    public $guarded = [];
}
