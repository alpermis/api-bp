<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\ApiResponse;

class CheckAuthenticatedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('X-Authenticated-UserId')) {
            return ApiResponse::error('Student ID is required.', 'INVALID_STUDENT_ID', 400);
        }

        return $next($request);
    }
}
