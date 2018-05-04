<?php

namespace App\Http\Controllers;

use App\EmailVerifyToken;
use App\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class VerifyController extends Controller
{
    use ResponseTrait;

    public function verifyEmail($token)
    {
        try {
            $emailToken = EmailVerifyToken::where('token', $token)->firstOrFail();
        } catch (\Exception $e) {
            $this->returnError('TOKEN_NOT_EXIST');
        }

        if ($emailToken->is_used) {
            $this->returnError('TOKEN_USED');
        }

        $emailToken->update(['is_used' => true]);
        $emailToken->user()
                    ->update(['is_email_verified' => true]);

        return redirect(url(env('HOME_PAGE')));
    }

    public function sendVerificationEmail(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
        } catch (\Exception $e) {
            $this->returnError('EMAIL_NOT_REGISTERED');
        }

        if ($user->is_email_verified) {
            $this->returnError('EMAIL_IS_VERIFIED');
        }

        $emailVerifyToken= new EmailVerifyToken();
        $emailVerifyToken->generateVerifyToken($request->email);

        try {
            $user->sendVerificationEmail();
        } catch (\Exception $e) {
            $this->returnError('SEND_EMAIL_FAILED');
        }
    }
}
