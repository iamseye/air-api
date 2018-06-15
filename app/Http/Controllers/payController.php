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
        $this->payByCreditCard(1000, 201406010001);
    }

    public function paymentResult(Request $request)
    {
        $result = $request->all();


        if (isset($result['Status']) && $result['Status'] === 'SUCCESS') {


        } else {
            return redirect(env('HOME_PAGE'), 302, 'Payment API Error!');
        }
    }
}
