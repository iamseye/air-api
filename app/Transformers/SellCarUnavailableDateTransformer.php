<?php

namespace App\Transformers;

use App\CarUnavailableDate;

class SellCarUnavailableDateTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(CarUnavailableDate $carUnavailableDate)
    {
        return [
            'from' => $carUnavailableDate->from,
            'to' => $carUnavailableDate->to
        ];
    }
}
