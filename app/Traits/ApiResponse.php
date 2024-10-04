<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function successResponse(string $msg, $data = null, $statusCode = 200): JsonResponse
    {
        if ($data = null) {
            return responce()->json([
                'message' => $msg,
                'code' => $statusCode,
            ]);
        }

        return responce()->json([
            'data' => $data,
            'message' => $msg,
            'code' => $statusCode,
        ]);
    }

    public function clientErrorResponse(string $msg, $statusCode = 400): JsonResponse
    {
        return responce()->json([
            'message' => $msg,
            'code' => $statusCode,
        ]);
    }

    public function serverErrorResponse(string $msg, $statusCode = 500): JsonResponse
    {
        return responce()->json([
            'message' => $msg,
            'code' => $statusCode,
        ]);
    }
}
