<?php

namespace App\Traits;

trait PaymentTrait
{
    public function payByCreditCard($chargeAmount, $orderNo)
    {
        $merchantId = env('PAYMENT_MERCHANT_ID');
        $paymentApi = env('PAYMENT_API');
        $returnUrlToFrontEnd = env('PAYMENT_RESULT_FRONTEND_URL');
        $notifyUrlToBackEnd = env('PAYMENT_RESULT_BACKEND_URL');
        
        $orderNo = 'R'.sprintf('%05d', '1'.time());

        $passingData = [
            'MerchantID' => $merchantId,
            'TimeStamp' => time(),
            'MerchantOrderNo' => $orderNo,
            'Version' =>'1.2',
            'Amt' => $chargeAmount
        ];

        $passingData['CheckValue'] = $this->createCheckValue($passingData);

        $passingData = array_merge($passingData, [
            'RespondType' => 'JSON',
            'ItemDesc' => '體驗車輛訂單',
            'Email' => 'iamseye@gmail.com',
            'LoginType' => 0,
            'CREDITAGREEMENT' => 1,
            'ReturnURL' => $returnUrlToFrontEnd,
            'NotifyURL' => $notifyUrlToBackEnd,
            'TokenTerm' => 'testesfrf'.$orderNo
        ]);


        $this->callPostApi($paymentApi, $passingData);
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

    public function createCheckValue($dataArray)
    {
        $hashKey = env('PAYMENT_HASH_KEY');
        $hashIv = env('PAYMENT_HASH_IV');

        ksort($dataArray);
        $checkStr = http_build_query($dataArray);
        $checkValueStr = 'HashKey='.$hashKey.'&'.$checkStr.'&HashIV='.$hashIv;
        return strtoupper(hash('sha256', $checkValueStr));
    }
}