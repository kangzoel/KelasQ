<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public $timestamps = false;
    public function klass()
    {
        return $this->belongsTo('App\Klass');
    }
    public function paid_bills()
    {
        return $this->belongsTo('App\PaidBill');
    }
}
