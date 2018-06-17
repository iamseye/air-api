<?php

namespace App\Traits;

trait PaymentTrait
{
    public function payByCreditCard($chargeAmount, $orderNo, $userEmail)
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
            'Email' => $userEmail,
            'LoginType' => 0,
            'CREDITAGREEMENT' => 1,
            'OrderComment' => 'tetetse',
            'TokenTerm' => $userEmail
        ];

        $this->callPostApi($paymentApi, $data);
    }

    public function callPostApi($url, $formData)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($formData));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $result = curl_exec($ch);
        if (curl_errno($ch) !== 0) {
            error_log('cURL error when connecting to '.$url.': '.curl_error($ch));
        }
        curl_close($ch);
        print_r($result);
    }
}