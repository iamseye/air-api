<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PaymentController extends Controller
{
    public function placeOrder()
    {
        var_dump('test');
        // test $merchantId = 'MS32769423';
        $merchantId = 'MS330229460';
        $mer_array = array(
            'MerchantID' => 'MS330229460', 'TimeStamp' => '1400137200', 'MerchantOrderNo'=>'20140601000', 'Version' =>'1.1',
            'Amt' => '1000',
        );
        ksort($mer_array);
        $check_merstr = http_build_query($mer_array);


       // test $CheckValue_str = 'HashKey=eWFh3qRYZ359eawzj472RXbpiZnGKkzA&' . $check_merstr . '&HashIV=FHZqROP4COX9Hozy';
        $CheckValue_str = 'HashKey=5eeK3Etb4YdFbtYUnb8xOjixcOXeiLN9&' . $check_merstr . '&HashIV=WpmWjJ0BfsLmQalD';
        $CheckValue = strtoupper(hash("sha256", $CheckValue_str));
dd($CheckValue);
        $client = new Client();
        $response = $client->post('https://ccore.spgateway.com/MPG/mpg_gateway', [
            'json' => [
                'MerchantID' => $merchantId,
                'RespondType' => 'JSON',
                'CheckValue' => $CheckValue,
                'TimeStamp' => '1400137200',
                'Version' => '1.1',
                'MerchantOrderNo' => '20140601000',
                'Amt' => 1000,
                'ItemDesc' => 'testetset',
                'Email' => 'iamseye@gmail.com',
                'LoginType' => 0,
                'CREDITAGREEMENT' => 1,
                'OrderComment' => 'tetetse',
                'TokenTerm' => 'test123'
            ]
        ]);


        $body = $response->getBody();

    }


}
