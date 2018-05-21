<?php

namespace App\Transformers;

use App\User;

class UserTransformer extends \League\Fractal\TransformerAbstract
{

    protected $availableIncludes = [
        'user_verification'
    ];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    public function includeUserVerification(User $user)
    {
        return $this->item($user->verification, new UserVerificationTransformer());
    }
}
