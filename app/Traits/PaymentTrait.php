<?php

namespace App\Traits;

use App\User;
use App\RentOrder;

trait PaymentTrait
{
    //TODO: test function
    public function payByBindCreditCard($chargeAmount, $orderNo, $userId, $tokenValue)
    {
        $merchantId = env('PAYMENT_MERCHANT_ID');
        $paymentApi = env('PAYMENT__BINDCARD_API');

        $email = User::findOrFail($userId)->email;

        $postData = [
            'TimeStamp' => time(),
            'MerchantOrderNo' => $orderNo,
            'Version' =>'1.0',
            'Amt' => $chargeAmount,
            'ProdDesc' => '體驗車輛訂單',
            'PayerEmail' => $email,
            'TokenValue' => $tokenValue,
            'TokenTerm' => $email,
            'TokenSwitch' => 'on'
        ];

        $postDataEncrypt = $this->createPostDataEncrypt($postData);

        $passingData = [
            'MerchantID_' => $merchantId,
            'PostData_' => $postDataEncrypt,
            'Pos_' => 'JSON'
        ];

        var_dump($passingData);

        $response = $this->callPostApi($paymentApi, $passingData);
        $result = json_decode($response);

        if ($result->Status !== 'SUCCESS') {
            return 'Payment API calling error!';
        }

        $responseResult = json_decode($result->Result);
        $orderNo = $responseResult->MerchantOrderNo;
        $rentOrder = RentOrder::where('order_no', $orderNo)->get();
        $rentOrder->status = 'BOOKED';
    }

    public function payByFirstCreditCard($chargeAmount, $orderNo, $userId)
    {
        $merchantId = env('PAYMENT_MERCHANT_ID');
        $paymentApi = env('PAYMENT_API');
        $returnUrlToFrontEnd = env('PAYMENT_RESULT_FRONTEND_URL');
        $notifyUrlToBackEnd = env('PAYMENT_RESULT_BACKEND_URL');

        $email = User::findOrFail($userId)->email;

        $passingData = [
            'MerchantID' => $merchantId,
            'TimeStamp' => time(),
            'MerchantOrderNo' => $orderNo,
            'Version' =>'1.1',
            'Amt' => $chargeAmount
        ];

        $passingData['CheckValue'] = $this->createCheckValue($passingData);

        $passingData = array_merge($passingData, [
            'RespondType' => 'JSON',
            'ItemDesc' => '體驗車輛訂單',
            'Email' => $email,
            'LoginType' => 0,
            'CREDITAGREEMENT' => 1,
            'ReturnURL' => $returnUrlToFrontEnd,
            'NotifyURL' => $notifyUrlToBackEnd,
            'TokenTerm' => $email
        ]);

        var_dump($passingData);

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

        return $result;
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

    public function createPostDataEncrypt($dataArray)
    {
        $hashKey = env('PAYMENT_HASH_KEY');
        $hashIv = env('PAYMENT_HASH_IV');

        $postDataStr = http_build_query($dataArray);

        //Testing data
//        $hashKey = '12345678901234567890123456789012';
//        $hashIv = '1234567890123456';
//        $postDataStr = 'abcdefghijklmnopqrstuvwxyzABCDEF';

        $len = strlen($postDataStr);
        $pad = 32 - ($len % 32);
        $postDataStr .= str_repeat(chr($pad), $pad);

        $value = trim(bin2hex(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $hashKey,
            $postDataStr, MCRYPT_MODE_CBC, $hashIv)));

        return $value;
    }
}
