<?php

namespace App\Traits;

trait ResponseTrait
{
    public function returnError($errorMessage)
    {
        return response()->json([
            'errors' => [
                'title' => $errorMessage
            ]
        ]);
    }

    public function returnSuccess($message)
    {
        return response()->json([
            'message' => $message
        ]);
    }
}