<?php

namespace App\Http\Controllers;

use App\Insurance;
use App\PromoCode;
use App\RentOrder;
use App\RentInvoice;
use App\SellCar;
use App\Http\Requests\StoreRentOrderRequest;
use App\Http\Requests\GetPaymentDetailRequest;
use App\Traits\ResponseTrait;
use App\Transformers\RentOrderTransformer;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Transformers\PaymentDetailTransformer;

class RentOrderController extends Controller
{
    use ResponseTrait;

    public function store(StoreRentOrderRequest $request)
    {
        $startDate = Carbon::createFromTimestamp($request->start_date);
        $endDate = Carbon::createFromTimestamp($request->end_date);
        $rentDays = $startDate->diffInDays($endDate);

        if ($startDate < Carbon::now()) {
            return $this->returnError('體驗開始日期已過!');
        }

        $startDate = $startDate->toDateTimeString();
        $endDate = $endDate->toDateTimeString();

        if (!$this->isCarAvailable($request->sell_car_id, $startDate, $endDate)) {
            return $this->returnError('體驗日期不在車子可以的範圍內');
        }

        $sellCar = SellCar::findOrFail($request->sell_car_id);
        $rentPrice = $sellCar->rent_price;

        $order = new RentOrder();
        $order->pickup_price = 0;
        $order->promo_code_discount = 0;

        if ($request->promo_code !=null) {
            if (!$this->isPromoCodeValid($request->promo_code)) {
                return $this->returnError('此優惠代碼無效或已超過使用次數');
            }
            $order->promo_code_discount = $this->getPromoCodeDiscount($rentPrice, $request->promo_code);
        }

        if ($request->pickup_home_address !== null) {
            $distance = $this->getKmDistance($request->pickup_home_address, $sellCar->carCenter->address);

            if ($distance == 'GOOGLE_API_ERROR') {
                $this->returnError('輸入地址格式錯誤');
            }

            $order->pickup_home_address = $request->pickup_home_address;
            $order->pickup_price = $this->getPickUpPrice($rentPrice, $distance);
        }

        $order->user_id = $request->user_id;
        $order->sell_car_id = $request->sell_car_id;
        $order->start_date = $request->start_date;
        $order->end_date = $request->end_date;
        $order->rent_days = $rentDays;
        $order->insurance_price = $request->buy_insurance ? $this->getInsurancePrice($rentPrice, $rentDays) : 0;
        $order->long_rent_discount = $this->getLongRentDiscount($rentPrice, $rentDays);
        $order->emergency_fee = $this->getEmergencyFee($rentPrice, $startDate);
        $order->total_price = $this->getTotalPrice(
            $rentPrice,
            $rentDays,
            $order->insurance_price,
            $order->emergency_fee,
            $order->promo_code_discount + $order->long_rent_discount
        );
        $order->save();

        return fractal()
            ->item($order)
            ->transformWith(new RentOrderTransformer())
            ->toArray();
    }

    /**
     * @param $carId
     * @param DateTimeString $startDate
     * @param DateTimeString $endDate
     * @return bool
     */
    public function isCarAvailable($carId, $startDate, $endDate)
    {
        $car = SellCar::findOrFail($carId);

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

    public function isPromoCodeValid($promoCode)
    {
        $promoCode = PromoCode::where('code', '=', $promoCode)
            ->where('expired_at', '>=', Carbon::now())
            ->where('remain_use_times', '>', 0)
            ->first();

        if ($promoCode) {
            return true;
        }

        return false;
    }


    public function getPaymentDetail(GetPaymentDetailRequest $request)
    {
        $startDate = Carbon::createFromTimestamp($request->start_date);
        $endDate = Carbon::createFromTimestamp($request->end_date);
        $rentDays = $startDate->diffInDays($endDate);

        if ($startDate < Carbon::now()) {
            return $this->returnError('體驗開始日期已過!');
        }

        $startDate = $startDate->toDateTimeString();
        $endDate = $endDate->toDateTimeString();

        if (!$this->isCarAvailable($request->sell_car_id, $startDate, $endDate)) {
            return $this->returnError('體驗日期不在車子可以的範圍內');
        }

        $sellCar = SellCar::findOrFail($request->sell_car_id);
        $rentPrice = $sellCar->rent_price;

        $paymentDetail=  new \stdClass();
        $paymentDetail->pickup_price = 0;
        $paymentDetail->promo_code_discount = 0;

        if ($request->promo_code !=null) {
            if (!$this->isPromoCodeValid($request->promo_code)) {
                return $this->returnError('此優惠代碼無效或已超過使用次數');
            }
            $paymentDetail->promo_code_discount = $this->getPromoCodeDiscount($rentPrice, $request->promo_code);
        }

        if ($request->pickup_home_address !== null) {
            $distance = $this->getKmDistance($request->pickup_home_address, $sellCar->carCenter->address);

            if ($distance === 'GOOGLE_API_ERROR') {
                return $this->returnError('輸入地址格式錯誤');
            }

            $paymentDetail->pickup_place = $request->pickup_home_address;
            $paymentDetail->pickup_price = $this->getPickUpPrice($rentPrice, $distance);
        } else {
            $paymentDetail->pickup_place = $sellCar->carCenter->address;
        }

        $paymentDetail->car_year = $sellCar->car->year;
        $paymentDetail->car_name = $sellCar->car->brand . ' ' . $sellCar->car->series_model;
        $paymentDetail->start_date = $request->start_date;
        $paymentDetail->end_date = $request->end_date;
        $paymentDetail->rent_days = $rentDays;
        $paymentDetail->insurance_price = $this->getInsurancePrice($rentPrice, $rentDays);
        $paymentDetail->emergency_fee = $this->getEmergencyFee($rentPrice, $startDate);
        $paymentDetail->long_rent_discount = $this->getLongRentDiscount($rentPrice, $rentDays);
        $paymentDetail->rent_price = $rentPrice;
        $paymentDetail->total_price = $this->getTotalPrice(
            $rentPrice,
            $rentDays,
            $paymentDetail->insurance_price,
            $paymentDetail->emergency_fee,
            $paymentDetail->promo_code_discount + $paymentDetail->long_rent_discount
        );

        return fractal()
            ->item($paymentDetail)
            ->transformWith(new PaymentDetailTransformer())
            ->toArray();
    }

    public function getTotalPrice($rentPrice, $rentDays, $insurancePrice, $emergencyFee, $totalDiscount)
    {
        return $rentPrice * $rentDays + $insurancePrice + $emergencyFee - $totalDiscount;
    }

    public function getLongRentDiscount($rentPrice, $rentDays)
    {
        if ($rentDays >=5 && $rentDays < 30) {
            return $rentPrice * $rentDays * 0.1;
        } elseif ($rentDays >= 30) {
            return $rentPrice * $rentDays * 0.5;
        }

        return 0;
    }

    public function getPromoCodeDiscount($rentPrice, $promoCode)
    {
        $promoCode = PromoCode::where('code', '=', $promoCode)
            ->where('expired_at', '>=', Carbon::now())
            ->where('remain_use_times', '>', 0)
            ->first();

        $promoCode->remain_use_times -= 1;
        $promoCode->save();

        if ($promoCode->amount !== 0) {
            return $promoCode->amount;
        } else {
            return $rentPrice * $promoCode->percentage/100;
        }
    }

    public function getEmergencyFee($rentPrice, $startDate)
    {
        $maxDays = 3;
        $emergencyDays =  $maxDays - Carbon::now()->diffInDays($startDate);

        if ($emergencyDays > 3) {
            $emergencyDays = 3;
        }

        if ($emergencyDays < 0) {
            $emergencyDays = 0;
        }

        return $rentPrice * 0.15 * $emergencyDays;
    }

    public function getInsurancePrice($rent_price, $rent_days)
    {
        return $rent_price * $rent_days * 0.1;
    }

    public function getPickUpPrice($rent_price, $distance)
    {
        return intval($rent_price * $distance * 0.025);
    }

    public function getKmDistance($origin, $destination)
    {
        try {
            $client = new Client();
            $response = $client->get('https://maps.googleapis.com/maps/api/distancematrix/json', [
                'query' => [
                    'origins' => $origin,
                    'destinations' => $destination,
                    'key' => env('GOOGLE_API_KEY')
                ]
            ]);

            $responseData = json_decode($response->getBody()->getContents());
            return intval($responseData->rows[0]->elements[0]->distance->value/1000);

        } catch (\Exception $exception) {
            var_dump($exception);
            return 'GOOGLE_API_ERROR';
        }
    }
}
