<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellCar extends Model
{
    public function rentOrders()
    {
        return $this->hasMany('App\RentOrder');
    }

    public function unavailableDates()
    {
        return $this->hasMany('App\CarUnavailableDate');
    }
}
