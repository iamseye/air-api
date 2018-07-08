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

    public function reviews()
    {
        return $this->hasMany('App\Review');
    }


    public function sellCarExaminations()
    {
        return $this->hasMany('App\SellCarExamination');
    }

    public function sellCarAccessories()
    {
        return $this->hasMany('App\SellCarAccessory');
    }

    public function sellCarEquipments()
    {
        return $this->hasMany('App\SellCarEquipment');
    }

}
