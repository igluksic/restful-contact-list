<?php
namespace App\ContactList\Api;

use GuzzleHttp\Exception\GuzzleException;

class ContactApiCalls extends BaseApiCalls
{

    const CONTACT_LIST_ROUTE = 'contact.list';
    const NEW_CONTACT_POST_ROUTE = 'post.contact';
    const EDIT_CONTACT_PUT_ROUTE = 'put.contact';
    const SHOW_CONTACT_ROUTE = 'contact.show';
    const CONTACT_DELETE_ROUTE = 'delete.contact';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get contact list API request
     *
     * @return mixed|string
     */

    public function getContacts()
    {
        try {
            $response = $this->client->request(
                'GET',
                route(ContactApiCalls::CONTACT_LIST_ROUTE),
                ['headers' => $this->getAuthenticationHeaders()]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

    /**
     * Create new contact API request
     *
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $profile_image
     * @param $favourite
     * @return mixed|string
     */

    public function newContact($first_name, $last_name, $email, $image, $favourite)
    {
        try {
            $response = $this->client->request(
                'POST',
                route(ContactApiCalls::NEW_CONTACT_POST_ROUTE),
                [   'headers' => $this->getAuthenticationHeaders(),
                    'form_params' => [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'profile_photo' => $image,
                        'favourite' => $favourite
                    ]
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

    /**
     * Edit contact API request
     *
     * @param $id
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $profile_image
     * @param $favourite
     * @return mixed|string
     */

    public function editContact($id, $first_name, $last_name, $email, $image, $favourite)
    {
        try {
            $response = $this->client->request(
                'PUT',
                route(ContactApiCalls::EDIT_CONTACT_PUT_ROUTE, $id),
                [   'headers' => $this->getAuthenticationHeaders(),
                    'form_params' => [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'email' => $email,
                        'profile_photo' => $image,
                        'favourite' => $favourite
                    ]
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

    /**
     * Get a single contact API request
     *
     * @param $id
     * @return mixed|string
     */

    public function getContact($id)
    {
        try {
            $response = $this->client->request(
                'GET',
                route(ContactApiCalls::SHOW_CONTACT_ROUTE, $id),
                ['headers' => $this->getAuthenticationHeaders()
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }

    /**
     * Delete a contact API request
     *
     * @param $contactId
     * @return mixed|string
     */

    public function deleteContact($contactId)
    {
        try {
            $response = $this->client->request(
                'DELETE',
                route(ContactApiCalls::CONTACT_DELETE_ROUTE, $contactId),
                [   'headers' => $this->getAuthenticationHeaders()
                ]
            )->getBody()->getContents();

            return json_decode($response, true);

        } catch (GuzzleException $e) {
            return 'Error occured!!! '  . $e->getTraceAsString();
        }
    }
}