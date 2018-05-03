<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class EmailVerifyToken extends Model
{

    protected $fillable = [
        'is_used'
    ];

    public function generateVerifyToken(User $user)
    {
        $this->user_id = $user->id;
        $this->token = str_random(60);
        $this->save();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
