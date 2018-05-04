<?php

namespace App\Traits;

trait ResponseTrait
{
    public function returnError($errorMessage)
    {
        return response()->json([
            'status' => 'error',
            'messages' => $errorMessage
        ]);
    }
}