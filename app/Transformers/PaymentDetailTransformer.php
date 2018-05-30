<?php

namespace App\Transformers;

class PaymentDetailTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform($paymentDetail)
    {
        return [
            'car_year' => $paymentDetail->car_year,
            'car_name' => $paymentDetail->car_name,
            'start_date' => $paymentDetail->start_date,
            'end_date' => $paymentDetail->end_date,
            'pickup_place' => $paymentDetail->pickup_place,
            'pickup_price' => $paymentDetail->pickup_price,
            'rent_days' => $paymentDetail->rent_days,
            'insurance_price' => $paymentDetail->insurance_price,
            'emergency_fee' => $paymentDetail->emergency_fee,
            'promo_code_discount' => $paymentDetail->promo_code_discount,
            'long_rent_discount' => $paymentDetail->long_rent_discount,
            'rent_price' => $paymentDetail->rent_price,
            'total_price' => $paymentDetail->total_price
        ];
    }
}
