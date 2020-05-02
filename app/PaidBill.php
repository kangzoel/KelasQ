<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaidBill extends Model
{
    public $timestamps = false;
    public function bills(){
        return $this->belongsTo('App\Bill');
    }
    public function users(){
        return $this->belongsTo('App\User');
    }
}
