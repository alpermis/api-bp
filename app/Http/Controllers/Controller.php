<?php

namespace App\Http\Controllers;

use App\Support\ApiResponse;
use Illuminate\Http\JsonResponse;

abstract class Controller
{
    /**
     * Return a success JSON response.
     *
     * @param  mixed  $data
     * @param  int  $status
     * @return JsonResponse
     */
    protected function success(mixed $data = null, int $status = 200): JsonResponse
    {
        return ApiResponse::success($data, $status);
    }

    /**
     * Return an error JSON response.
     *
     * @param  string  $message
     * @param  string|null  $code
     * @param  int  $status
     * @param  mixed  $details
     * @return JsonResponse
     */
    protected function error(string $message, ?string $code = null, int $status = 400, mixed $details = null): JsonResponse
    {
        return ApiResponse::error($message, $code, $status, $details);
    }
}
