<?php

namespace App\Transformers;

use App\RentOrder;

class RentOrderTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(RentOrder $order)
    {
        return [
            'id' => $order->id,
            'start_date' => $order->start_date,
            'end_date' => $order->start_date,
            'extend_date' => $order->start_date
        ];
    }
}
