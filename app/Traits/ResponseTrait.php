<?php

namespace App\Traits;

trait ResponseTrait
{
    public function returnError($errorMessage)
    {
        return response()->json([
            'status' => 'error',
            'message' => $errorMessage
        ]);
    }

    public function returnSuccess($message)
    {
        return response()->json([
            'status' => 'ok',
            'message' => $message
        ]);
    }
}