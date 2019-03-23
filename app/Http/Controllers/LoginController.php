<?php

namespace App\Http\Controllers;
use Validator;
use App\Models\User;

use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use App\OAuth\JWTAuth;

use App\ContactList\Api\ContactApiCalls;

class LoginController extends Controller
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    const TOKEN_TYPE = 'Bearer';

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
     * Oauth login user session registration
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function userLogin() {
        $loginUserData = (new ContactApiCalls())->loginUser($this->request->input('email'), $this->request->input('password'));

        if (isset($loginUserData['token'])) {
            session(['token' => $loginUserData['token']]);
        }

        return redirect(route('homepage'));
    }

    /**
     * User logout
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function userLogout() {
        session()->flush();

        return redirect(route('homepage'));
    }

}