<?php

namespace App;

use App\Notifications\VerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'password', 'gender', 'birth', 'address', 'address_city', 'address_area', 'ID_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function generateToken()
    {
        $this->api_token = str_random(60);
        $this->save();

        return $this->api_token;
    }

    public function emailVerified()
    {
        return $this->verification()->is_email_verified;
    }

    public function sendVerificationEmail()
    {
        $this->notify(new VerifyEmail($this));
    }

    public function verification()
    {
        return $this->hasOne('App\UserVerification');
    }

    public function emailVerifyToken()
    {
        return $this->hasOne('App\EmailVerifyToken', 'email', 'email');
    }

    public function phoneVerifyCode()
    {
        return $this->hasOne('App\PhoneVerifyCode', 'mobile', 'mobile');
    }

    public function points()
    {
        return $this->hasMany('App\Point');
    }
}
