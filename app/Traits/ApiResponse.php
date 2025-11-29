<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success($data = null, $message = 'Success', $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => $message,
        ], $code);
    }

    protected function error($message = 'Error', $code = 400, $data = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => 'error',
            'message' => $message,
        ], $code);
    }
}
