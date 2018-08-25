<?php

namespace App\Transformers;

use App\PromoCode;

class PromoCodeTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(PromoCode $promoCode)
    {
        return [
            'amount' => $promoCode->amount,
            'percentage' => $promoCode->percentage,
            'expired_at' => $promoCode->expired_at,
            'remain_use_times' => $promoCode->remain_use_times,
        ];
    }
}
