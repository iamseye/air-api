<?php

namespace App\Http\Controllers;

use App\Transformers\SellCarTransformer;
use Illuminate\Http\Request;
use App\SellCar;
use App\CarUnavailableDate;
use App\Traits\ResponseTrait;
use App\Http\Requests\StoreCarUnavailableRequest;

class SellCarController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $carsCollection = SellCar::latestFirst()->where('active', 1)->get();

        return fractal()
            ->collection($carsCollection)
            ->parseIncludes(['car'])
            ->transformWith(new SellCarTransformer())
            ->toArray();
    }

    public function show($id)
    {
        $sellCar = SellCar::findOrFail($id);

        return fractal()
            ->item($sellCar)
            ->parseIncludes(['car', 'car_center'])
            ->transformWith(new SellCarTransformer())
            ->toArray();
    }

    public function setCarUnavailable(StoreCarUnavailableRequest $request)
    {
        if (!$this->isCarAvailable($request->sell_car_id, $request->start_date, $request->end_date)) {
            return $this->returnError('已有人預定此日期區間!');
        }

        $carUnavailable = new CarUnavailableDate();

        $carUnavailable->sell_car_id = $request->sell_car_id;
        $carUnavailable->from = date('Y-m-d H:i:s', strtotime($request->start_date . '00:00:00'));
        $carUnavailable->to = date('Y-m-d H:i:s', strtotime($request->end_date . '23:59:59'));
        $carUnavailable->save();

        return fractal()
            ->item($carUnavailable->sellCar)
            ->parseIncludes(['car_unavailable_dates', 'rent_orders'])
            ->transformWith(new SellCarTransformer())
            ->toArray();
    }

    public function isCarAvailable($carId, $startDate, $endDate)
    {
        $car = SellCar::findOrFail($carId);

        $startDate = date('Y-m-d H:i:s', strtotime($startDate));
        $endDate = date('Y-m-d H:i:s', strtotime($endDate));

        if ($startDate < $car->available_from || $endDate > $car->available_to) {
            return false;
        }

        // check whether overlapping other orders
        foreach ($car->rentOrders as $order) {
            if ($startDate <= $order->end_date && $endDate >= $order->start_date) {
                return false;
            }
        }

        return true;
    }
}
