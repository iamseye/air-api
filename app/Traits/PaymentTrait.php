<?php

namespace App\Traits;

trait PaymentTrait
{
    public function payByCreditCard($chargeAmount, $orderNo)
    {
        $merchantId = env('PAYMENT_MERCHANT_ID');
        $paymentApi = env('PAYMENT_FIRST_TIME_API');
        $hashKey = env('PAYMENT_HASH_KEY');
        $hashIv = env('PAYMENT_HASH_IV');
        $tradingDate = '2018/06/17 14:35:06'; //date('Y/m/d H:i:s');
        $redirectUrl = env('PAYMENT_RESULT_REDIRECT');

        $orderNp = 'R'.sprintf('%05d', '1'.time());
        //check value for payment api
        $passingData = [
            'MerchantID' => $merchantId,
            'MerchantTradeNo' => $orderNp,
            'MerchantTradeDate' => $tradingDate,
            'PaymentType' => 'aio',
            'TotalAmount' => $chargeAmount,
            'TradeDesc' => 'testefer',
            'ItemName' => '1qaz2wsx',
            'ReturnURL' => $redirectUrl,
            'ChoosePayment' => 'Credit',
            'EncryptType' => 1
        ];

        ksort($passingData);

        $str = '';
        foreach ($passingData as $key => $parameter) {
            $str .= '&'.$key.'='.$parameter;
        }

        $checkValueString = 'HashKey='.$hashKey.$str.'&HashIV='.$hashIv;
        $checkValueString = strtolower(urlencode($checkValueString));
        $checkMacValue = strtoupper(hash('sha256', $checkValueString));

        array_push($passingData, $checkMacValue);
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
}