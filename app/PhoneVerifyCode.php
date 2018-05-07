<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhoneVerifyCode extends Model
{
    protected $fillable = [
        'is_used', 'expired_at'
    ];

    public function generateVerifyCode($mobile)
    {
        $this->mobile = $mobile;
        $this->code = str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT);
        $this->expired_at =  date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s').' +3 minutes'));
        $this->save();

        return $this->code;
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'mobile', 'mobile');
    }
}
