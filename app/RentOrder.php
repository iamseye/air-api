<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RentOrder extends Model
{
    public function sellCar()
    {
        return $this->belongsTo('App\SellCar');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function extendRentOrders()
    {
        return $this->hasMany('App\ExtendRentOrder');
    }

    public function review()
    {
        return $this->hasOne('App\Review');
    }
}
