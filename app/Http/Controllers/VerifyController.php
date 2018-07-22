<?php

namespace App\Http\Controllers;

use App\EmailVerifyToken;
use App\User;
use App\PhoneVerifyCode;
use App\Traits\ResponseTrait;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VerifyController extends Controller
{
    use ResponseTrait;

    public function verifyEmail($token)
    {
        try {
            $emailToken = EmailVerifyToken::where('token', $token)->firstOrFail();
        } catch (\Exception $e) {
            return $this->returnError('TOKEN_NOT_EXIST');
        }

        if ($emailToken->is_used) {
            return $this->returnError('TOKEN_USED');
        }

        $emailToken->is_used = true;
        $emailToken->save();

        $userVerification = $emailToken->user->verification;
        $userVerification->is_email_verified = true;
        $userVerification->save();

        return redirect(url(env('HOME_PAGE')));
    }

    public function sendVerificationEmail(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->firstOrFail();
        } catch (\Exception $e) {
            return $this->returnError('EMAIL_NOT_REGISTERED');
        }

        if ($user->verification->is_email_verified) {
            return $this->returnError('EMAIL_IS_VERIFIED');
        }

        $emailVerifyToken= new EmailVerifyToken();
        $emailVerifyToken->generateVerifyToken($request->email);

        try {
            $user->sendVerificationEmail();
            return $this->returnSuccess('EMAIL_SENT');

        } catch (\Exception $e) {
            return $this->returnError('SEND_EMAIL_FAILED');
        }
    }

    public function sendMobileVerificationCode(Request $request)
    {
        $userMobile = $request->mobile;

        $mobile = User::where('mobile', $request->mobile)->first();
        if ($mobile) {
            return $this->returnError('此手機號碼已註冊，請重新輸入！');
        }

        try {
            User::findOrFail($request->user_id)
                ->update(['mobile' => $userMobile]);
        } catch (\Exception $e) {
            return $this->returnError('USER_NOT_FOUND');
        }

        $phoneVerifyCode= new PhoneVerifyCode();
        $phoneVerifyCode = $phoneVerifyCode->generateVerifyCode($userMobile);

        try {
            $client = new Client();
            $client->get('http://api.every8d.com/API21/HTTP/sendSMS.ashx', [
                'form_params' => [
                    'UID' => env('SEND_TEXT_SERVER_USERID'),
                    'PWD' => env('SEND_TEXT_SERVER_PASSWORD'),
                    'MSG' => '感謝您使用AirCnC平台，您的驗證碼為：' . $phoneVerifyCode,
                    'DEST' => $userMobile
                ]
            ]);

            return $this->returnSuccess('MOBILE_VERIFY_CODE_SENT');

        } catch (\Exception $e) {
            return $this->returnError('SEND_VERIFY_CODE_API_FAILED');
        }
    }

    public function verifyMobile(Request $request)
    {
        $verifyCode = PhoneVerifyCode::where('mobile', $request->mobile)
            ->where('code', $request->code)->first();

        if (is_null($verifyCode)) {
            return $this->returnError('驗證碼錯誤');
        }

        if ($verifyCode->is_used) {
            return $this->returnError('驗證碼重複使用');
        }

        if (new \DateTime($verifyCode->expired_at) > date('Y-m-d H:i:s')) {
            return $this->returnError('驗證碼已過期');
        }

        $verifyCode->update(['is_used' => true]);
        $verifyCode->user()
            ->update(['is_phone_verified' => true]);

        return $this->returnSuccess('MOBILE_VERIFIED');
    }
}
