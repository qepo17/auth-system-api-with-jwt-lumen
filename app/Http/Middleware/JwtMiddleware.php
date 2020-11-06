<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JWTMiddleware
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        $header = $request->header('Grant-Type');

        // Unauthorized response if token not there
        if (!$token) {
            return response([
                'code' => 401,
                'error' => 'Token tidak ada'
            ], 401);
        }

        // refresh token
        if ($header === 'refresh_token') {
            try {
                $credentials = JWT::decode($token, env('APP_KEY'), ['HS256']);

                $payload = [
                    'iat' => time(), // Time when JWT was issued.
                    'exp' => time() + 60 * 60, // Expiration time (1 hour)
                    'username' => $credentials->username,
                ];

                $jwt = JWT::encode($payload, env('APP_KEY'));

                return ['code' => 200, 'message' => 'Token succesfully refreshed', 'access_token' => $jwt];
            } catch (ExpiredException $e) {
                return response([
                    'code' => 400,
                    'error' => 'Token sudah kadaluarsa'
                ], 400);
            }
        }

        // cek header
        if ($header != 'access_token') {
            // Unauthorized response if token not there
            return response([
                'code' => 401,
                'error' => 'Tidak valid'
            ], 401);
        }

        try {
            $credentials = JWT::decode($token, env('APP_KEY'), ['HS256']);
        } catch (ExpiredException $e) {
            return response([
                'code' => 400,
                'error' => 'Token sudah kadaluarsa'
            ], 400);
        } catch (\Exception $e) {
            return response([
                'code' => 400,
                'error' => 'Token tidak valid'
            ], 400);
        }

        $request->request->add(['auth' => ['username' => $credentials->username]]);
        return $next($request);
    }
}
