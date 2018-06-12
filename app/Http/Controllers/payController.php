<?php

namespace App\Http\Controllers;
use App\Traits\PaymentTrait;

class payController extends Controller
{
    use PaymentTrait;

    public function test()
    {
        $this->chargeAmount(1000, 201406010001);
        dd('stop here');
    }
}
