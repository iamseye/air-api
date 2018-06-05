<?php

namespace App\Transformers;

use App\CarCenter;

class CarCenterTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(CarCenter $carCenter)
    {
        return [
            'name' => $carCenter->name,
            'area' => $carCenter->area,
            'address' => $carCenter->address,
        ];
    }
}
