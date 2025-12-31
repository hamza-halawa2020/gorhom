<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function success($data = null, $message = 'Success', $code = 200): JsonResponse
    {
        if (is_string($message)) {
            $message = [
                'ar' => $message,
                'en' => $message
            ];
        }

        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => $message,
        ], $code);
    }

    protected function error($message = 'Error', $code = 400, $data = null): JsonResponse
    {
        if (is_string($message)) {
            $message = [
                'ar' => $message,
                'en' => $message
            ];
        }

        return response()->json([
            'data' => $data,
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    protected function successBilingual($data = null, $messageAr = 'نجح', $messageEn = 'Success', $code = 200): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => 'success',
            'message' => [
                'ar' => $messageAr,
                'en' => $messageEn
            ],
        ], $code);
    }

    protected function errorBilingual($messageAr = 'خطأ', $messageEn = 'Error', $code = 400, $data = null): JsonResponse
    {
        return response()->json([
            'data' => $data,
            'status' => 'error',
            'message' => [
                'ar' => $messageAr,
                'en' => $messageEn
            ],
        ], $code);
    }
}
