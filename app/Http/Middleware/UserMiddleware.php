<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class UserMiddleware
{
    public function handle(Request $request, Closure $next, $guard = null)
    {
        $usernameToken = $request->auth['username'];
        $username = $request->username;

        if ($usernameToken != $username) {
            return response(['code' => 401, 'message' => 'Unauthorized'], 401);
        }

        $request->request->add(['auth' => ['username' => $usernameToken]]);
        return $next($request);
    }
}
