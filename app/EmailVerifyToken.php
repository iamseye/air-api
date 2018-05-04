<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailVerifyToken extends Model
{

    protected $fillable = [
        'is_used'
    ];

    public function generateVerifyToken($email)
    {
        $this->email = $email;
        $this->token = str_random(60);
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'email', 'email');
    }
}
