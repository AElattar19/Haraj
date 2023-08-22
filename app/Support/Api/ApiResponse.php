<?php

namespace App\Support\Api;

trait ApiResponse
{
    public static function apiResponse(
        $code,
        $message,
        $body = [],
        $strings = null,
        $info = 'from response action'
    ): \Illuminate\Http\JsonResponse {

        return response()->json([
            'code'    => $code,
            'status'  => $code === 200,
            'message' => $message,
            'body'    => $body,
            'strings' => $strings,
            'info'    => $info,
        ], $code);
    }
}
