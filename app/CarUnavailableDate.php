<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarUnavailableDate extends Model
{
    public function sellCar()
    {
        return $this->belongsTo('App\SellCar');
    }
}
