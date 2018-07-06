<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SellCarExamination extends Model
{
    public function examination()
    {
        return $this->belongsTo('App\Examination');
    }
}
