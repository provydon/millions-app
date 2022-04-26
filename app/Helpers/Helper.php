<?php

namespace App\Helpers;

class Helper
{

    public static function apiRes($message, $data = [], $status = true, $code = 200)
    {
        $resObj = [
            "success" => $status,
            "message" => $message,
            "data" => $data,
        ];

        return response()->json($resObj, $code);
    }
}
