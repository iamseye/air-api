<?php

namespace App\Transformers;

use App\RentOrder;

class RentOrderTransformer extends \League\Fractal\TransformerAbstract
{
    protected $availableIncludes = [
        'sell_car',
    ];

    public function transform(RentOrder $order)
    {
        return [
            'id' => $order->id,
            'start_date' => $order->start_date,
            'end_date' => $order->end_date,
            'pickup_price' => $order->pickup_price,
            'rent_days' => $order->rent_days,
            'insurance_price' => $order->insurance_price,
            'emergency_fee' => $order->emergency_fee,
            'promo_code_discount' => $order->promo_code_discount,
            'long_rent_discount' => $order->long_rent_discount,
            'total_price' => $order->total_price,
            'status' => $order->status
        ];
    }

    public function includeSellCar(RentOrder $order)
    {
        return $this->item($order->sellCar, new SellCarTransformer());
    }
}
