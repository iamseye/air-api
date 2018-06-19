<?php

namespace App\Http\Controllers;

use App\Traits\PaymentTrait;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class payController extends Controller
{
    use PaymentTrait, ResponseTrait;

    public function test()
    {
        $this->payByCreditCard(1000, 'efwef4cf4cf43');
    }

    public function paymentResult(Request $request)
    {
        $result = $request->all();

        dd($result);

        if (isset($result['RtnCode']) && $result['RtnCode'] === 1) {
            $responseResut = json_decode($result['Status']);
            $responseResut['TokenValue'];

        } else {
            return redirect(env('HOME_PAGE'), 302, 'Payment API Error!');
        }
    }
}
