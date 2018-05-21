<?php

namespace App\Transformers;

use App\UserVerification;

class UserVerificationTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(UserVerification $verification)
    {
        return [
            'id' => $verification->id,
            'is_email_verified' => $verification->is_email_verified,
            'is_phone_verified' => $verification->is_phone_verified,
            'is_ID_card_verified' => $verification->is_ID_card_verified,
            'is_driver_license_verified' => $verification->is_driver_license_verified,
            'is_photo_verified' => $verification->is_photo_verified,
            'ID_card_photo' => $verification->ID_card_photo,
            'driver_license_photo' => $verification->driver_license_photo,
            'personal_photo' => $verification->personal_photo
        ];
    }
}
