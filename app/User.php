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
        'name', 'email', 'password', 'is_email_verified', 'is_phone_verified',
        'is_ID_card_verified', 'is_driver_license_verified', 'is_photo_verified'
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
        return $this->is_email_verified;
    }

    public function sendVerificationEmail()
    {
        $this->notify(new VerifyEmail($this));
    }

    public function emailVerifyToken()
    {
        return $this->hasOne('App\EmailVerifyToken');
    }
}
