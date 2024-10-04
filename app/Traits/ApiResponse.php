<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

trait ApiResponse
{
    public function successResponse(string $msg, JsonResource|array|null $data = null, $statusCode = 200): JsonResponse
    {

        if ($data === null) {
            return response()->json([
                'message' => $msg,
                'code' => $statusCode,
            ]);
        }

        return response()->json(
            [
                'message' => $msg,
                'data' => $data,
                'code' => $statusCode,
            ],
            status: $statusCode
        );
    }

    public function clientErrorResponse(string $msg, $statusCode = 400): JsonResponse
    {
        return response()->json(
            [
                'message' => $msg,
                'code' => $statusCode,
            ],
            status: $statusCode
        );
    }

    public function serverErrorResponse(string $msg, $statusCode = 500): JsonResponse
    {
        return response()->json(
            [
                'message' => $msg,
                'code' => $statusCode,
            ],
            status: $statusCode
        );
    }

    public function notFoundResponse(string $msg = 'Does not exist', $statusCode = 404): JsonResponse
    {
        return response()->json(
            [
                'message' => $msg,
                'code' => $statusCode,
            ],
            status: $statusCode
        );
    }
}
