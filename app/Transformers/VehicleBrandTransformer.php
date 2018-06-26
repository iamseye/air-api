<?php

namespace App\Transformers;

use App\VehicleBrand;

class VehicleBrandTransformer extends \League\Fractal\TransformerAbstract
{
    public function transform(VehicleBrand $vehicleBrand)
    {
        return [
            'name' => $vehicleBrand->name,
            'name_ch' => $vehicleBrand->name_ch
        ];
    }
}
