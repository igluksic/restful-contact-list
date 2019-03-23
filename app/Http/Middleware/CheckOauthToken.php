<?php

namespace App\Http\Middleware;

use Closure;
use App\Http\Controllers\AuthController;

class CheckOauthToken
{
    public function handle($request, Closure $next, $guard = null)
    {
        if ($request->session()->has('token')) {
            $user = AuthController::getUserFromToken($request->session()->get('token'));
        } else {
            $user = null;
        }

        $request->auth = $user;
        return $next($request);
    }
}
