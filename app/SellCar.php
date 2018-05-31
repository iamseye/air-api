<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\OrderableTrait;

class SellCar extends Model
{
    use OrderableTrait;

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
