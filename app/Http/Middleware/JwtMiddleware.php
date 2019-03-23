<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $this->handleAuthToken($request->header('Authorization'));

        if (!is_string($token)) {
            //Uh oh, something went wrong, we have an error response
            return $token;
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.'
            ], 400);
        }
        $user = User::find($credentials->sub);
        $request->auth = $user;
        return $next($request);
    }

    private function handleAuthToken ($authHeader) {
        if ($authHeader == null) {
            return response()->json([
                'error' => 'Auth header missing.'
            ], 400);
        }

        $authParts = explode(' ', $authHeader);

        $tokenType = $authParts[0];
        $token = $authParts[1];

        if ($tokenType !== 'Bearer') {
            return response()->json([
                'error' => 'Bearer authorization required.'
            ], 400);
        }

        return $token;

    }
}
