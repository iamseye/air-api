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
        $vehicleBrandArray = [];

        foreach ($vehicleBrand as $vehicle) {
            array_push($vehicleBrandArray, $vehicle->name_ch.' '.$vehicle->name);
        }

        $vehicleType = VehicleType::all();
        $vehicleTypeArray = [];

        foreach ($vehicleType as $vehicle) {
            array_push($vehicleTypeArray, $vehicle->name);
        }

        $areas = Area::all();
        $areaArray = [];

        foreach ($areas as $area) {
            array_push($areaArray, $area->name);
        }

        return response()->json([
            'data' => [
                'vehicleBrand' => $vehicleBrandArray,
                'vehicleType' => $vehicleTypeArray,
                'area' => $areaArray
             ]
        ]);
    }

}
