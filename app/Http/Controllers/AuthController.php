<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\User;

use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use App\OAuth\JWTAuth;
use Firebase\JWT\JWT;


class AuthController extends Controller
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param  \App\User   $user
     * @return mixed
     */
    public function auth() {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);

        // Find the user by email
        $user = User::where('email', $this->request->input('email'))->first();

        if (!$user) {
            // Not the most elegant way, but it works for now until we flesh out Response.php
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }
        // Verify the password and generate the token
        return (new JWTAuth($user))->check($this->request->input('password'));

    }

    /**
     * Authentication user from token, demo Oauth solution
     *
     * @param $token
     * @return null
     */

    public static function getUserFromToken($token)
    {
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
            return User::find($credentials->sub);
        } catch(ExpiredException $e) {
            return null;
        }
    }

}