<?php

namespace App\Http\Controllers;

use App\SellCar;
use App\Http\Requests\SearchSellCarRequest;
use App\Transformers\SellCarTransformer;
use App\Traits\ShareFunctionTrait;

class SearchController extends Controller
{
    use ShareFunctionTrait;

    public function searchSellCar(SearchSellCarRequest $request)
    {
        $areas = $request->area ? $request->area : [];
        $vehicleTypes = $request->vehicle_type ? $request->vehicle_type : [];

        $sellCars = SellCar::whereHas('carCenter', function ($query) use ($areas) {
            foreach ($areas as $key => $area) {
                if ($key == 0) {
                    $query->where('area', '=', $area);
                } else {
                    $query->orWhere('area', '=', $area);
                }
            }
        })->whereHas('car', function ($query) use ($vehicleTypes, $request) {
            if ($request->series) {
                $query->where('series', '=', $request->series);
            }

            if ($request->series_model) {
                $query->where('series_model', '=', $request->series_model);
            }

            if ($request->year) {
                $query->where('year', '=', $request->year);
            }

            foreach ($vehicleTypes as $key => $vehicleType) {
                if ($key == 0) {
                    $query->where('vehicle_type', '=', $vehicleType);
                } else {
                    $query->orWhere('vehicle_type', '=', $vehicleType);
                }
            }
        })->where(function ($query) use ($request) {
            if ($request->min_price) {
                $query->where('rent_price', '>=', $request->min_price);
            }

            if ($request->max_price) {
                $query->where('rent_price', '<=', $request->max_price);
            }

            if ($request->start_date && $request->end_date) {
                $query->whereIn('id', $this->getAvailableCars($request->start_date, $request->end_date));
            }
        })->get();

        return fractal()
            ->collection($sellCars)
            ->parseIncludes(['car', 'car_center'])
            ->transformWith(new SellCarTransformer())
            ->toArray();
    }
}
