<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Notifications\ResetPassword;
use App\User;
use App\Traits\ResponseTrait;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, ResponseTrait;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getResetToken(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        if ($request->wantsJson()) {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                return response()->json([
                    'message' => 'cant find the user',
                ]);
            }

            return$this->broker()->createToken($user);
        }
    }

    public function sendResetPasswordEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        if ($request->wantsJson()) {
            $user = User::where('email', $request->input('email'))->first();
            if (!$user) {
                $this->returnError('USER_NOT_EXIST');
            }

            $token = $this->broker()->createToken($user);

            try {
                $user->notify(new ResetPassword($user));
                return response()->json([
                    'message' => 'Email sent',
                ]);
            } catch (\Exception $exception) {
                $this->returnError('SEND_EMAIL_FAILED');
            }

        }
    }
}
