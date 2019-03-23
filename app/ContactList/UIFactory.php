<?php

namespace App\ContactList;

class UIFactory
{
    protected $apiResults;
    protected $favourites;

    const RESULTS_PER_ROW = 3;
    const SEARCH_STRING_ENTITY_DELIMITER = ':|:|:';

    const RESULT_SUCCESS_DESCRIPTION = 'success';
    const RESULT_ERROR_DESCRIPTION = 'danger'; // so that it matches the frontend class requirement - easy peasy
    const NEW_CONTACT_SUCCESS = 'Contact created successfully';
    const NEW_CONTACT_ERROR = 'Something went wrong while creating contact';
    const EDIT_CONTACT_SUCCESS = 'Contact edited successfully';
    const EDIT_CONTACT_ERROR = 'Something went wrong while editing contact';
    const DELETE_CONTACT_SUCCESS = 'Contact deleted successfully';
    const DELETE_CONTACT_ERROR = 'Something went wrong while deleting contact';

    public function __construct($apiResults)
    {
        $this->apiResults = $apiResults;
    }

    /**
     * Favourite contact list
     *
     * @return array
     */

    public function getFavourites()
    {
        $favouriteList = [];
        foreach ($this->apiResults as $result) {
            if ($result['favourite']) {
                $favouriteList[] = $result;
            }
        }
        return array_chunk($favouriteList, UIFactory::RESULTS_PER_ROW);
    }

    /**
     * All contacts list
     *
     * @return array
     */

    public function getAllResults()
    {
        return array_chunk($this->apiResults, UIFactory::RESULTS_PER_ROW);
    }

    /**
     * Flash message processor
     *
     * @param $action
     * @return array
     */

    public static function processFlashMessage()
    {
        if (!session('fwdMessage')) return [];

        $message = session('fwdMessage');
        $action = $message['action'] ?? 0;
        $result = $message['result'] ?? 0;

        switch ($action) {
            case 'newContact':
                if (isset($result['id'])) {
                    return ['result' => UIFactory::RESULT_SUCCESS_DESCRIPTION, 'message' => UIFactory::NEW_CONTACT_SUCCESS];
                } else {
                    return ['result' => UIFactory::RESULT_ERROR_DESCRIPTION, 'message' => UIFactory::NEW_CONTACT_ERROR];
                }
                break;
            case 'editContact':
                if (isset($result['id'])) {
                    return ['result' => UIFactory::RESULT_SUCCESS_DESCRIPTION, 'message' => UIFactory::EDIT_CONTACT_SUCCESS];
                } else {
                    return ['result' => UIFactory::RESULT_ERROR_DESCRIPTION, 'message' => UIFactory::EDIT_CONTACT_ERROR];
                }
                break;
            case 'deleteContact':
                if (!$result) {
                    return ['result' => UIFactory::RESULT_SUCCESS_DESCRIPTION, 'message' => UIFactory::DELETE_CONTACT_SUCCESS];
                } else {
                    return ['result' => UIFactory::RESULT_ERROR_DESCRIPTION, 'message' => UIFactory::DELETE_CONTACT_ERROR];
                }
                break;
        }

        return [];
    }

    /**
     * Search string generator helper
     *
     * @return string
     */

    public function getSearchHelperString()
    {
        $searchString = '';
        foreach ($this->apiResults as $result) {
            $searchString[] = ['id' => $result['id'], 'first_name' => $result['first_name'], 'last_name'=> $result['last_name'], 'email'=>$result['email'], 'searchString' => UIFactory::processContactData($result)];
        }
        return json_encode($searchString);
    }

    /**
     * Factory method for getSearchHelperString()
     *
     * @param $contact
     * @return string
     */

    private static function processContactData($contact)
    {
        foreach ($contact as $attribute => $value) {
            if ($attribute == 'phones') continue; // Thats an array
            $contact[$attribute] = mb_strtolower($value);
        }
        return implode(self::SEARCH_STRING_ENTITY_DELIMITER, [$contact['first_name'], $contact['last_name'], $contact['email']]);
    }
}