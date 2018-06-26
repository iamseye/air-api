<?php

namespace App\Http\Controllers;

use App\Transformers\AreaTransformer;
use App\VehicleBrand;
use App\VehicleType;
use App\Area;
use App\Transformers\VehicleBrandTransformer;
use App\Transformers\VehicleTypeTransformer;

class InitialController extends Controller
{
    public function getInitialInfo()
    {

        $vehicleBrand = VehicleBrand::all();
        $vehicleType = VehicleType::all();
        $area = Area::all();

        return response()->json([
            'data' => [
                'vehicleBrand' => fractal()->collection($vehicleBrand)->transformWith(new VehicleBrandTransformer())->toArray(),
                'vehicleType' => fractal()->collection($vehicleType)->transformWith(new VehicleTypeTransformer())->toArray(),
                'area' => fractal()->collection($area)->transformWith(new AreaTransformer())->toArray(),
             ]
        ]);
    }

}
