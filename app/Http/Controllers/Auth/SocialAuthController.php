<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\SocialAccount;
use App\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller
{
    use ResponseTrait;

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialiteUser = Socialite::with($provider)->user();
        } catch (\Exception $e) {
            $this->returnError('SOCIAL_LOGIN_ERROR');
        }

        $user = $this->findOrCreateUser($provider, $socialiteUser);

        // TODO: true for remember user

        // check email & phone number, if both has > login, if not > pass false ask input > login again
        $this->loginUser($user);

        return response()->json([
            'success' => true,
            'data' => $user->toArray(),
        ]);
    }

    public function findOrCreateUser($provider, $socialiteUser)
    {
        if ($user = $this->findUserBySocialId($provider, $socialiteUser->getId())) {
            return $user;
        }

        if ($user = $this->findUserByEmail($provider, $socialiteUser->getEmail())) {
            $this->addSocialAccount($provider, $user, $socialiteUser);

            return $user;
        }

        $user = User::create([
            'name' => $socialiteUser->getName(),
            'email' => $socialiteUser->getEmail()
        ]);

        $this->addSocialAccount($provider, $user, $socialiteUser);

        return $user;
    }

    public function findUserBySocialId($provider, $id)
    {
        $socialAccount = SocialAccount::where('provider', $provider)
            ->where('provider_id', $id)
            ->first();

        return $socialAccount ? $socialAccount->user : false;
    }

    public function findUserByEmail($provider, $email)
    {
        return !$email ? null : User::where('email', $email)->first();
    }

    public function addSocialAccount($provider, $user, $socialiteUser)
    {
        SocialAccount::create([
            'user_id' => $user->id,
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
        ]);
    }

    public function loginUser($user)
    {
        $user->generateToken();
    }
}
