<?php

namespace App\Http\Controllers;

use App\RentOrder;
use App\Traits\PaymentTrait;
use App\Traits\ResponseTrait;
use App\UserPaymnetCards;
use Illuminate\Http\Request;

class payController extends Controller
{
    use PaymentTrait, ResponseTrait;

    public function test()
    {
        $this->payByCreditCard(1000, 'efwef4cf4cf43', 1);
    }

    public function paymentResult(Request $request)
    {
        $result = json_decode($request->get('JSONData'));
        dd($result);

        // TODO: check response and test
        if (isset($result['Status']) && $result['Status'] === 'SUCCESS') {
            $responseResult = json_decode($result->Result);
            $orderNo = $responseResult->MerchantOrderNo;
            $rentOrder = RentOrder::where('order_no', $orderNo)->get();
            $rentOrder->status = 'BOOKED';
            $rentOrder->save();

            $paymentCard = new UserPaymnetCards();
            $paymentCard->user_id = $rentOrder->user->id;
            $paymentCard->bank_name = $responseResult->EscrowBank;
            $paymentCard->card_no_first_6 = $responseResult->Card6No;
            $paymentCard->card_no_last_4 = $responseResult->Card4No;
            $paymentCard->card_expired_date = $responseResult->Exp;
            $paymentCard->token_value = $responseResult->TokenValue;
            $paymentCard->token_expired_date = $responseResult->TokenLife;
            $paymentCard->save();

        } else {
            //TODO: change to error page in frontend
            return redirect(env('HOME_PAGE'), 302);
        }
    }
}
