<?php

namespace App\Http\Controllers;

use App\RentOrder;
use App\SellCar;
use App\User;
use App\Traits\ResponseTrait;
use App\Http\Requests\PayByPrimeRequest;
use App\UserPayment;
use App\UserRememberCard;
use GuzzleHttp\Client;

class payController extends Controller
{
    use ResponseTrait;

    public function payByPrime(PayByPrimeRequest $request)
    {
        $order = RentOrder::findOrFail($request->order_id);

//        if ($order->status === 'PAID') {
//            return $this->returnError('此訂單已付款');
//        }

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

        } catch (\Exception $e) {
            return $this->returnError('TAPPAY API FAILED');
        }

        return $this->payResult($request->remember, $order->order_no, $order->user_id, $responseObj);
    }

    public function payResult($rememberCard, $orderNo, $userId, $result)
    {
        $userPayment = new UserPayment();
        $userPayment->user_id = $userId;
        $userPayment->status = $result->status;
        $userPayment->msg = $result->msg;
        $userPayment->rec_trade_id =  $result->rec_trade_id;
        $userPayment->bank_transaction_id =  $result->bank_transaction_id;
        $userPayment->auth_code =  $result->auth_code;
        $userPayment->amount =  $result->amount;
        $userPayment->currency =  $result->currency;
        $userPayment->order_number =  $orderNo;
        $userPayment->bin_code =  $result->card_info->bin_code;
        $userPayment->last_four =  $result->card_info->last_four;
        $userPayment->issuer =  $result->card_info->issuer;
        $userPayment->save();

        if ($rememberCard) {
            $userRememberCard = new UserRememberCard();
            $userRememberCard->user_id = $userId;
            $userRememberCard->card_token = $result->card_secret->card_token;
            $userRememberCard->card_key = $result->card_secret->card_key;
            $userRememberCard->bin_code =  $result->card_info->bin_code;
            $userRememberCard->last_four =  $result->card_info->last_four;
            $userRememberCard->issuer =  $result->card_info->issuer;
            $userRememberCard->funding =  $result->card_info->funding;
            $userRememberCard->type =  $result->card_info->type;
            $userRememberCard->expiry_date =  $result->card_info->expiry_date;
            $userRememberCard->save();
        }

        return $this->returnSuccess($orderNo . ' 訂單成立成功');
    }
}
