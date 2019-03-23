<?php
namespace App\ContactList\Api;

use GuzzleHttp\Exception\GuzzleException;

class PhoneApiCalls extends BaseApiCalls
{

    const ADD_PHONE_POST_ROUTE = 'phone.post';
    const EDIT_PHONE_PUT_ROUTE = 'phone.put';
    const PHONE_DELETE_ROUTE = 'phone.delete';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add phone number to contact API request
     *
     * @param $contactId
     * @param $phoneNumber
     * @param $label
     * @return mixed|string
     */

    public function addPhoneNumber($contactId, $phoneNumber, $label)
    {
        try {
            $response = $this->client->request(
                'POST',
                route(PhoneApiCalls::ADD_PHONE_POST_ROUTE, $contactId),
                [   'headers' => $this->getAuthenticationHeaders(),
                    'form_params' => [
                        'phone_number' => $phoneNumber,
                        'label' => $label
                    ]
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

    /**
     * Edit a phone number API request
     *
     * @param $phoneId
     * @param $phoneNumber
     * @param $label
     * @return mixed|string
     */

    public function editPhoneNumber($phoneId, $phoneNumber, $label)
    {
        try {
            $response = $this->client->request(
                'PUT',
                route(PhoneApiCalls::EDIT_PHONE_PUT_ROUTE, $phoneId),
                [   'headers' => $this->getAuthenticationHeaders(),
                    'form_params' => [
                        'phone_number' => $phoneNumber,
                        'label' => $label
                    ]
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

    /**
     * Delete a phone number API request
     *
     * @param $phoneId
     * @return mixed|string
     */

    public function deletePhoneNumber ($phoneId)
    {
        try {
            $response = $this->client->request(
                'DELETE',
                route(PhoneApiCalls::PHONE_DELETE_ROUTE, $phoneId),
                [   'headers' => $this->getAuthenticationHeaders()
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

}