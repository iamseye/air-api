<?php

namespace App\Http\Controllers;

use App\Insurance;
use App\PromoCode;
use App\RentOrder;
use App\RentInvoice;
use App\SellCar;
use App\Http\Requests\StoreRentOrderRequest;
use App\Traits\ResponseTrait;
use Carbon\Carbon;

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

        $invoice = $this->createInvoice($request);

        $order->rent_invoice_id = $invoice->id;

        $order->save();

    }

    public function createInvoice(StoreRentOrderRequest $request)
    {
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

        return $invoice;
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

    public function getPromoCodeAmount($promoCode)
    {
        $promoCode = PromoCode::where('code', '=', $promoCode)
            ->where('expired_at', '>=', Carbon::now())
            ->where('remain_use_times', '>', 0)
            ->first();

        return $promoCode->amount;
    }

    public function getPromoCodePercentage($promoCode)
    {
        $promoCode = PromoCode::where('code', '=', $promoCode)
            ->where('expired_at', '>=', Carbon::now())
            ->where('remain_use_times', '>', 0)
            ->first();

        return $promoCode->percentage;
    }

    public function getRentDiscount($rent_price, $rent_days)
    {
        if ($rent_days >= 30) {
            return $rent_price*0.5;
        }

        return 0;
    }
}
