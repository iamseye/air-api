<?php

namespace App\Http\Controllers;

use App\SellCar;
use App\Car;
use App\Http\Requests\SearchSellCarRequest;
use App\Transformers\SellCarTransformer;
use App\Traits\ShareFunctionTrait;
use http\Env\Request;

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
            if ($request->brand) {
                $query->where('brand', '=', $request->brand);
            }

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
            if ($request->price && $request->price[0]) {
                $query->where('rent_price', '>=', $request->price[0]);
            }

            if ($request->price && $request->price[1]) {
                $query->where('rent_price', '<=', $request->price[1]);
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

    public function getBrandOptions(\Illuminate\Http\Request $request)
    {
        if ($request->brand && $request->series && $request->series_model) {
            $yearArray = [];
            $year = Car::distinct()
                ->where('brand', '=', $request->brand)
                ->where('series', '=', $request->series)
                ->where('series_model', '=', $request->series_model)
                ->get(['year']);

            foreach ($year as $y) {
                array_push($yearArray, $y->year);
            }

            return response()->json([
                'data' => [
                    'year' => $yearArray
                ]
            ]);
        }

        if ($request->brand && $request->series) {
            $seriesModelArray = [];
            $seriesModel = Car::distinct()
                ->where('brand', '=', $request->brand)
                ->where('series', '=', $request->series)
                ->get(['series_model']);

            foreach ($seriesModel as $s) {
                array_push($seriesModelArray, $s->series_model);
            }

            return response()->json([
                'data' => [
                    'series_model' => $seriesModelArray
                ]
            ]);
        }

        if ($request->brand) {
            $seriesArray = [];
            $series = Car::distinct()->where('brand', '=', $request->brand)->get(['series']);

            foreach ($series as $s) {
                array_push($seriesArray, $s->series);
            }

            return response()->json([
                'data' => [
                    'series' => $seriesArray,
                ]
            ]);
        }
    }
}

