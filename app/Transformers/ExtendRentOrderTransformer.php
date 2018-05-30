<?php

namespace App\Transformers;

use App\ExtendRentOrder;

class ExtendRentOrderTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(ExtendRentOrder $order)
    {
        return [
            'id' => $order->id,
            'start_date' => $order->start_date,
            'end_date' => $order->end_date,
            'insurance_price' => $order->insurance_price,
            'rent_days' => $order->rent_days,
            'total_price' => $order->total_price
        ];
    }

}
