<?php

namespace App\Http\Controllers;

use App\VehicleBrand;
use App\VehicleType;
use App\Area;
use App\SellCar;
use Illuminate\Support\Facades\DB;


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

        $minPrice = DB::table('sell_cars')->min('rent_price');
        $maxPrice = DB::table('sell_cars')->max('rent_price');


        return response()->json([
            'data' => [
                'vehicleBrand' => $vehicleBrandArray,
                'vehicleType' => $vehicleTypeArray,
                'area' => $areaArray,
                'price' => [$minPrice, $maxPrice]
             ]
        ]);
    }

}
