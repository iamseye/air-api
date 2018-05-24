<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentOrder extends Model
{
    public function sellCar()
    {
        return $this->belongsTo('App\SellCar');
    }
}
