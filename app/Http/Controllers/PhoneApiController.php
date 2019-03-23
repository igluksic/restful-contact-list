<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;

class PhoneApiController extends ApiController
{

    protected $validateRules;

    public function __construct()
    {
        $this->validateRules = [
            'phone_number' => 'required'
        ];

    }

    /**
     * Show a single phone number API call
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show(Request $request, $id)
    {
        $phone = Phone::where('id', $id)->with('contact');
        if ($this->checkContactOwnership($phone->contact, $request->auth) == 0) {
            return ApiController::errorResponse('Contact not found');
        }

        return response()->json($phone);
    }

    /**
     * Add new phone number to contact API call
     *
     * @param Request $request
     * @param $contactId
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request, $contactId)
    {
        $request->validate($this->validateRules);
        $contact = Contact::find($contactId);

        if (!$contact) {
            return ApiController::errorResponse('Contact not found');
        }

        if ($this->checkContactOwnership($contact, $request->auth) == 0) {
            return ApiController::errorResponse('Contact not found');
        }

        if (PhoneApiController::checkPhoneDuplicate($contactId, $request->input('phone_number'))) {
            return ApiController::errorResponse('Duplicate phone number');
        }

        $phone = Phone::create([
            'contact_id' => $contactId,
            'phone_number' => $request->input('phone_number'),
            'label' => $request->input('label', '')
        ]);

        return response()->json($phone, 201, [
            'Location' => route('phone.show',
                ['id', $phone->id])
        ]);
    }

    /**
     * Update existing number API call
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {
        $request->validate($this->validateRules);

        $phone = Phone::where('id', $id)->with('contact')->first();

        if (!$phone) {
            return ApiController::errorResponse('Phone number not found');
        }

        if ($this->checkContactOwnership($phone->contact, $request->auth) == 0) {
            return ApiController::errorResponse('Contact not found');
        }

        if (PhoneApiController::checkPhoneDuplicate($phone->contact->id, $request->input('phone_number'))) {
            return ApiController::errorResponse('Duplicate phone number');
        }

        $phone->update([
            'phone_number' => $request->input('phone_number'),
            'label' => $request->input('label', '')
        ]);

        return response()->json($phone, 201, [
            'Location' => route('phone.show',
                ['id', $phone->id])
        ]);
    }

    /**
     * Delete a phone number API call
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */

    public function destroy(Request $request, $id)
    {
        $phone = Phone::where('id', $id)->with('contact')->first();

        if (!$phone) {
            return ApiController::errorResponse('Phone number not found');
        }

        if ($this->checkContactOwnership($phone->contact, $request->auth) == 0) {
            return ApiController::errorResponse('Contact not found');
        }

        Phone::where('id', $id)->delete();
        return response(null, 204);
    }

    /**
     * Check duplicate factory
     *
     * @param $contactId
     * @param $phoneNumber
     * @return mixed
     */

    private function checkPhoneDuplicate($contactId, $phoneNumber)
    {
        return Phone::where('contact_id', $contactId)->where('phone_number', $phoneNumber)->count();
    }

}