<?php

namespace App\Traits;

use App\SellCar;
use Carbon\Carbon;

trait ShareFunctionTrait
{
    /***
     * @param $carId
     * @param carbon $startDate
     * @param carbon $endDate
     * @return bool
     */
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

    /***
     * @param timestamp $startDate
     * @param timestamp $endDate
     * @return array
     */

    public function getAvailableCars($startDate, $endDate)
    {
        $sellCars = SellCar::all();
        $availableCars = [];

        $startDate = Carbon::createFromTimestamp($startDate);
        $endDate = Carbon::createFromTimestamp($endDate);

        foreach ($sellCars as $sellCar) {
            if ($this->isCarAvailable($sellCar->id, $startDate, $endDate)) {
                array_push($availableCars, $sellCar->id);
            }
        }

        return $availableCars;
    }

    public function callPostApi($url, $formData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($formData));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
            error_log('cURL error when connecting to '.$url.': '.curl_error($ch));
        }
        curl_close($ch);
        print_r($result);
    }
}