<?php

namespace App\ContactList;
use App\ContactList\Api\ContactApiCalls;
use App\ApiHelpers\ImageProcessor;
use App\ContactList\Phone;

class Contact
{
    protected $request;
    protected $apiCalls;

    public function __construct($request)
    {
        $this->request = $request;
        $this->apiCalls = new ContactApiCalls(); //Api communication factory class
    }

    public function addNew()
    {
        if ($this->request->hasFile('profile_photo')) {
            $image = (new ImageProcessor($this->request->file('profile_photo')))->getImageBase64();
        } else {
            $image = '';
        }

        $newContact = $this->apiCalls->newContact($this->request->input('first_name'), $this->request->input('last_name'), $this->request->input('email'), $image, $this->request->input('favourite', 0));

        // Contact added successfully
        if (isset($newContact['id'])) {
            (new Phone($this->request, $newContact['id']))->addPhoneNumbers();
        }

        return $newContact;
    }

    public function editExisting($id)
    {
        if ($this->request->hasFile('profile_photo')) {
            $image = (new ImageProcessor($this->request->file('profile_photo')))->getImageBase64();
        } else {
            $image = '';
        }

        $contactEdited = $this->apiCalls->editContact($id, $this->request->input('first_name'), $this->request->input('last_name'), $this->request->input('email'), $image, $this->request->input('favourite', 0));

        if (isset ($contactEdited['id'])) {
            (new Phone($this->request, $contactEdited['id']))->addPhoneNumbers();
            return $contactEdited;
        } else {
            return 0;
        }
    }

    public function delete($id)
    {
        return $this->apiCalls->deleteContact($id);
    }

}