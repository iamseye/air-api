<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellCarEquipment extends Model
{
    //
    public function equipment()
    {
        return $this->belongsTo('App\Equipment');
    }
}
