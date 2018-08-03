<?php

namespace App\Http\Controllers;

use App\RentOrder;
use App\SellCar;
use App\User;
use App\Traits\ResponseTrait;
use App\Http\Requests\PayByPrimeRequest;
use GuzzleHttp\Client;

class payController extends Controller
{
    use ResponseTrait;

    public function payByPrime(PayByPrimeRequest $request)
    {
        $order = RentOrder::findOrFail($request->order_id);

        if ($order->status === 'PAID') {
            return $this->returnError('此訂單已付款');
        }

        if ($request->amount !== $order->total_price) {
            return $this->returnError('付款金額不正確');
        }

        $user = User::findOrFail($order->user_id);

        $sellCar = SellCar::findOrFail($order->sell_car_id);

        $details = $sellCar->car->brand . ' ' . $sellCar->car->series . '於' . $order->start_date . '至'
            . $order->end_date . '之體驗費用';

        $client = new Client();
        try {
            $response = $client->post(env('TAPPAY_PRIME_API'), [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-api-key' => env('TAPPAY_X_API_KEY'),
                ],
                'json' => [
                    'prime' => $request->prime,
                    'partner_key' => env('TAPPAY_PARTNER_KEY'),
                    'merchant_id' => env('TAPPAY_MERCHANT_ID'),
                    'details' => $details,
                    'order_number' => $order->order_no,
                    'amount' => $request->amount,
                    'cardholder' => [
                        'phone_number' => $user->mobile,
                        'name' => $user->name,
                        'email' => $user->email,
                        'address' => $user->address,
                        'national_id' => $user->ID_number,
                    ],
                    'remember' => $request->remember,
                ],
                'timeout' => 30
            ]);

            $responseObj = json_decode($response->getBody());

            if ($responseObj->status !== 0) {
                return $this->returnError($responseObj->msg);
            }

            $order->status = 'PAID';
            $order->save();
dd($responseObj);
            return $response->getBody()->getContents();

        } catch (\Exception $e) {
            return $this->returnError('TAPPAY PAI FAILED');
        }
    }
}
