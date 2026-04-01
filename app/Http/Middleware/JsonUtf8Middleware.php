<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonUtf8Middleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->headers->get('Content-Type') === 'application/json') {
            $response->headers->set('Content-Type', 'application/json; charset=UTF-8');
        }

        return $response;
    }
}
