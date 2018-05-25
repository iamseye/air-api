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

    public function carCenter()
    {
        return $this->belongsTo('App\CarCenter');
    }

    public function car()
    {
        return $this->belongsTo('App\Car');
    }

}
