<?php

namespace App\Transformers;

use App\Car;

class CarTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Car $car)
    {
        return [
            'year' => $car->year,
            'brand' => $car->brand,
            'brand_ch' => $car->brand_ch,
            'series' => $car->series,
            'series_model' => $car->series_model,
            'vehicle_type' => $car->vehicle_type,
        ];
    }
}
