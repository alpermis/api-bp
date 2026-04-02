<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * Success response
     *
     * @param mixed $data
     * @param int $status
     */
    public static function success(mixed $data = null, int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $data,
            'error'   => null,
        ], $status);
    }

    /**
     * Error response
     *
     * @param string $message
     * @param string|null $code
     * @param int $status
     * @param mixed $details
     */
    public static function error(
        string $message,
        ?string $code = null,
        int $status = 400,
        mixed $details = null
    ): JsonResponse {
        return response()->json([
            'success' => false,
            'data'    => null,
            'error'   => [
                'code'    => $code,
                'message' => $message,
                'details' => $details,
            ],
        ], $status);
    }
}
