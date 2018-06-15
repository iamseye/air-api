<?php

namespace App\Traits;

trait PaymentTrait
{
    use ShareFunctionTrait;

    public function payByCreditCard($chargeAmount, $orderNo)
    {
        $merchantId = env('PAYMENT_MERCHANT_ID');
        $paymentApi = env('PAYMENT_FIRST_TIME_API');
        $hashKey = env('PAYMENT_HASH_KEY');
        $hashIv = env('PAYMENT_HASH_IV');
        $timestamp = time();
        $redirectUrl = env('PAYMENT_RESULT_REDIRECT');

        //智富通的check value
        $mer_array = [
            'MerchantID' => $merchantId,
            'TimeStamp' => $timestamp,
            'MerchantOrderNo' => $orderNo,
            'Version' => '1.1',
            'Amt' => $chargeAmount,
        ];
        ksort($mer_array);
        $check_merstr = http_build_query($mer_array);
        $CheckValue_str = 'HashKey='.$hashKey.'&'.$check_merstr.'&HashIV='.$hashIv;
        $CheckValue = strtoupper(hash('sha256', $CheckValue_str));

        $data = [
            'MerchantID' => $merchantId,
            'RespondType' => 'JSON',
            'CheckValue' => $CheckValue,
            'TimeStamp' => $timestamp,
            'ReturnURL' => $redirectUrl,
            'Version' => '1.1',
            'MerchantOrderNo' => $orderNo,
            'Amt' => $chargeAmount,
            'ItemDesc' => 'testetset',
            'Email' => 'iamseye@gmail.com',
            'LoginType' => 0,
            'CREDITAGREEMENT' => 1,
            'OrderComment' => 'tetetse',
            'TokenTerm' => 'test123'
        ];

        $this->callPostApi($paymentApi, $data);
    }

}