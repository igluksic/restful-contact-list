<?php
namespace App\ContactList\Api;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class BaseApiCalls
{
    protected $client;

    const BEARER_PREFIX = 'Bearer ';
    const LOGIN_ROUTE = 'auth.login'; //These can be also added to config, but unneccesary fiddling for this example

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Login user API request
     *
     * @param $email
     * @param $password
     * @return mixed|string
     */

    public function loginUser($email, $password)
    {
        try {
            $response = $this->client->request(
                'POST',
                route(BaseApiCalls::LOGIN_ROUTE),
                [   'headers' => ['Content-Type' => 'application/x-www-form-urlencoded'],
                    'form_params' => [
                        'email' => $email,
                        'password' => $password,
                    ]
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

    protected function getAuthenticationHeaders()
    {
        $token = session('token');

        return [
            'Authorization' => BaseApiCalls::getBearerToken($token),
            'Accept' => 'application/json'
        ];
    }

    /**
     * Bearer token generator factory method
     *
     * @param $token
     * @return string
     */

    protected static function getBearerToken ($token)
    {
        return BaseApiCalls::BEARER_PREFIX . $token;
    }

}