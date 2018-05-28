<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExtendRentOrder extends Model
{
    public function rentOrder()
    {
        return $this->belongsTo('App\RentOrder');
    }
}
