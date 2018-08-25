<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    public function wallets()
    {
        return $this->hasMany('App\Wallet');
    }
}
