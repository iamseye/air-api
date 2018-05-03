<?php

namespace App\Http\Controllers;

use App\EmailVerifyToken;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    public function verifyEmail($token)
    {
        $emailToken = EmailVerifyToken::where('token', $token)->firstOrFail();
        $emailToken->update(['is_used' => true]);

        $emailToken->user()
                    ->update(['is_email_verified' => true]);

        return redirect(url(env('HOME_PAGE')));
    }
}
