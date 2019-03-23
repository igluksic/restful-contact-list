<?php

namespace App\ContactList;
use App\ContactList\Api\PhoneApiCalls;
use App\Http\Controllers\AuthController;

class Phone
{
    protected $request;
    protected $apiCalls;
    protected $contactId;

    public function __construct($request, $contactId)
    {
        $this->request = $request;
        $this->contactId = $contactId;
        $this->apiCalls = new PhoneApiCalls(); //Api communication factory class
    }

    /**
     * Post action controller for user interface; adding phone numbers to contact
     *
     * @param $contactId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function addPhoneNumbers ()
    {
        if (session('token')) {
            $this->user = AuthController::getUserFromToken(session('token'));
        }

        if (is_null($this->user)) {
            return view('loginpage');
        }

        $phoneIds = $this->request->input('phone_id');
        $phoneNumbers = $this->request->input('phone_number');
        $labels = $this->request->input('label');

        for($i = 0; $i<count($phoneNumbers); $i++) {
            if ($phoneNumbers[$i] == '') {
                continue;
            }
            if ($phoneIds[$i] == 0) { // new phone number
                $this->apiCalls->addPhoneNumber($this->contactId, $phoneNumbers[$i], $labels[$i]);
            } else {
                $this->apiCalls->editPhoneNumber($phoneIds[$i], $phoneNumbers[$i], $labels[$i]);
            }
        }
    }

    /**
     * Get action controller for user interface; deleting a phone number under contact
     *
     * @param $contactId
     * @param $phoneId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */

    public function deletePhoneNumber ($phoneId)
    {
        return $this->apiCalls->deletePhoneNumber($phoneId);
    }

}