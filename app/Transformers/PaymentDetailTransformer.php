<?php

namespace App\Transformers;

class PaymentDetailTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform($paymentDetail)
    {
        return [
            'car_year' => $paymentDetail->carYear,
            'car_name' => $paymentDetail->carName,
            'start_date' => $paymentDetail->startDate,
            'end_date' => $paymentDetail->endDate,
            'pickup_place' => $paymentDetail->pickUpPlace,
            'pickup_price' => $paymentDetail->pickUpPrice,
            'rent_days' => $paymentDetail->rentDays,
            'insurance_price' => $paymentDetail->insurancePrice,
            'emergency_fee' => $paymentDetail->emergencyFee,
            'promo_code_discount' => $paymentDetail->promoCodeDiscount,
            'long_rent_discount' => $paymentDetail->longRentDiscount,
            'rent_price' => $paymentDetail->rentPrice,
            'total_price' => $paymentDetail->totalPrice
        ];
    }
}
