<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellCarAccessory extends Model
{
    public function accessory()
    {
        return $this->belongsTo('App\Accessory');
    }
}
