<?php

namespace App\Transformers;

use App\Car;

class CarTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(Car $car)
    {
        return [
            'year' => $car->year,
            'name' => $car->brand.' '.$car->series_model
        ];
    }
}
