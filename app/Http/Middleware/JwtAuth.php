<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();
        Log::info(__FILE__.' Line:'.__LINE__, ['bearerToken' => $token]);

        if (!$token) {
            Log::warning('JWT token missing', [
                'ip'   => $request->ip(),
                'path' => $request->path(),
            ]);

            return response()->json([
                'success' => false,
                'data'    => null,
                'error'   => [
                    'code'    => 'TOKEN_MISSING',
                    'message' => 'Token not provided',
                ],
            ], 401);
        }

        try {
            //@todo remove logs later.

            //jwtTokenDecoded = JWT::decode($token, new Key(config('api.jwt_secret'), 'HS256'));

            list($headersB64, $payloadB64, $sig) = explode('.', $token);
            $jwtTokenDecoded = json_decode(base64_decode($payloadB64));

            Log::info(__FILE__.' Line:'.__LINE__, ['decodedJwtTokenDecoded' => $jwtTokenDecoded]);

            if (!$jwtTokenDecoded->sub) {
                throw new Exception('Invalid JWT token. Student ID not found.', 200);
            }

            $request->attributes->set('jwtTokenDecoded', $jwtTokenDecoded);

        } catch (\Throwable $e) {

            Log::warning('Invalid or expired JWT token', [
                'ip'      => $request->ip(),
                'path'    => $request->path(),
                'message' => $e->getMessage(),
            ]);

            $errorMsg = ($e->getCode() == 200) ? $e->getMessage() : 'Invalid or expired token';

            return response()->json([
                'success' => false,
                'data'    => null,
                'error'   => [
                    'code'    => 'TOKEN_INVALID',
                    'message' => $errorMsg,
                ],
            ], 401);
        }

        return $next($request);
    }
}
