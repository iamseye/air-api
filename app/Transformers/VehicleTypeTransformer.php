<?php

namespace App\Transformers;

use App\VehicleType;

class VehicleTypeTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(VehicleType $vehicleType)
    {
        return [
            'name' => $vehicleType->name,
        ];
    }
}
