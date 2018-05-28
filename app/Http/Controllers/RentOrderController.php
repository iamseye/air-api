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
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Transformers\PaymentDetailTransformer;

class RentOrderController extends Controller
{
    use ResponseTrait;

    public function store(StoreRentOrderRequest $request)
    {
        if (!$this->isCarAvailable($request->sell_car_id, $request->start_date, $request->end_date)) {
            return $this->returnError('體驗日期不在車子可以的範圍內');
        }

        if ($request->promo_code !=null) {
            if (!$this->isPromoCodeValid($request->promo_code)) {
                return $this->returnError('此優惠代碼無效或已超過使用次數');
            }
        }

        $order = new RentOrder();
        $order->user_id = $request->user_id;
        $order->sell_car_id = $request->sell_car_id;
        $order->is_pickup_at_car_center = $request->is_pickup_at_car_center;
        $order->start_date = date('Y-m-d', strtotime($request->start_date));
        $order->end_date = date('Y-m-d', strtotime($request->end_date));
        $order->pickup_time = date('Y-m-d H:i:s', strtotime($request->start_date.$request->pickup_time));

        $car = SellCar::findOrFail($request->sell_car_id);

        $invoice = new RentInvoice();
        $invoice->rent_price = $car->rent_price;
        $invoice->rent_days = $request->end_date - $request->start_date + 1;
        $invoice->insurance_id = $request->insurance_id;
        $invoice->discount = $this->getRentDiscount($invoice->rent_price, $invoice->rent_days);

        if ($request->promo_code !=null) {
            $invoice->promo_code_amount = $this->getPromoCodeAmount($request->promo_code);
            $invoice->promo_code = $request->promo_code;
        }

        $insurance_price = Insurance::findOrFail($request->insurance_id);
        $invoice->total_amount = ($invoice->rent_price * $invoice->rent_days)
            - $invoice->discount
            - $invoice->promo_code_amount
            - $insurance_price;

        $invoice->save();

        $order->rent_invoice_id = $invoice->id;
        $order->save();

    }

    public function isCarAvailable($carId, $startDate, $endDate)
    {
        $car = SellCar::findOrFail($carId);

        $startDate = date('Y-m-d', strtotime($startDate));
        $endDate = date('Y-m-d', strtotime($endDate));

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
        $sellCar = SellCar::findOrFail($request->sell_car_id);
        $rentPrice = $sellCar->rent_price;

        if ($request->pickup_home_address !== null) {
            $pickUpPlace = $request->pickup_home_address;
            $distance = $this->getKmDistance($request->pickup_home_address, $sellCar->carCenter->address);

            if ($distance == 'GOOGLE_API_ERROR') {
                $this->returnError('輸入地址格式錯誤');
            }

            $pickUpPrice = $this->getPickUpPrice($rentPrice, $distance);
        } else {
            $pickUpPrice = 0;
            $pickUpPlace = $sellCar->carCenter->address;
        }

        $startDate = Carbon::createFromTimestamp($request->start_date);
        $endDate = Carbon::createFromTimestamp($request->end_date);
        $rentDays = $startDate->diffInDays($endDate);

        $insurancePrice = $this->getInsurancePrice($rentPrice, $rentDays);
        $emergencyFee = $this->getEmergencyFee($rentPrice, $startDate);
        $longRentDiscount = $this->getLongRentDiscount($rentPrice, $rentDays);

        $promoCodeDiscount = 0;
        if ($request->promo_code !== null) {
            $promoCodeDiscount = $this->getPromoCodeDiscount($rentPrice, $request->promo_code);
        }

        $paymentDetail=  new \stdClass();
        $paymentDetail->carYear = $sellCar->car->year;
        $paymentDetail->carName = $sellCar->car->brand . ' ' . $sellCar->car->series_model;
        $paymentDetail->startDate = $request->start_date;
        $paymentDetail->endDate = $request->end_date;
        $paymentDetail->pickUpPlace = $pickUpPlace;
        $paymentDetail->rentDays = $rentDays;
        $paymentDetail->insurancePrice = $insurancePrice;
        $paymentDetail->emergencyFee = $emergencyFee;
        $paymentDetail->pickUpPrice = $pickUpPrice;
        $paymentDetail->promoCodeDiscount = $promoCodeDiscount;
        $paymentDetail->longRentDiscount = $longRentDiscount;
        $paymentDetail->rentPrice = $sellCar->rent_price;
        $paymentDetail->totalPrice =
            $this->getTotalPrice($rentPrice, $rentDays, $insurancePrice, $emergencyFee,$longRentDiscount + $promoCodeDiscount);

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
            return 'GOOGLE_API_ERROR';
        }
    }
}
