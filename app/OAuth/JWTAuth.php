<?php

namespace App\OAuth;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class JWTAuth
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Create a new token.
     *
     * @param  \App\Models\User   $user
     * @return string
     */
    protected function jwt(User $user)
    {
        $payload = [
            'iss' => "typecast", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // Passing JWT_SECRET to use for decoding later.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    public function check($password)
    {
        if (Hash::check($password, $this->user->password)) {
            return response()->json([
                'token' => $this->jwt($this->user)
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }
}