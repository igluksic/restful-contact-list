<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactApiController extends ApiController
{

    protected $validateRules;

    public function __construct()
    {
        $this->validateRules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:contacts'
        ];

    }

    /**
     * Get contacts index api call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function index(Request $request)
    {
        $userId = $request->auth->id;

        return response()->json(
            Contact::where('user_id', $userId)
                ->with('phones')
                ->get()
        );
    }

    /**
     * Show a sigle contact API call
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function show(Request $request, $id)
    {
        $userId = $request->auth->id;
        return response()->json(Contact::where('user_id', $userId)->where('id', $id)->with('phones')->first());
    }

    /**
     * Add new contact API call
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request, $id = null)
    {
        $userId = $request->auth->id;

        $request->validate($this->validateRules);

        ($request->has('favourite')) ? $favourite = $request->input('favourite') : $favourite = 0;
        ($request->has('profile_photo')) ? $photo = $request->input('profile_photo') : $photo = '';

        $contact = Contact::create([
                'user_id' => $userId,
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'profile_photo' => $photo,
                'favourite' => $favourite
            ]
        );

        return response()->json($contact, 201, [
            'Location' => route('contact.show',
                ['id', $contact->id])
        ]);
    }

    /**
     * Update existing contact API call
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, $id)
    {
        $userId = $request->auth->id;
        $this->validateRules['email'] = "required|email|unique:contacts,email,$id,id"; //Own email must be allowed

        $request->validate($this->validateRules);

        $contact = Contact::where('user_id', $userId)->where('id', $id)->first();

        ($request->has('favourite')) ? $favourite = $request->input('favourite') : $favourite = 0;
        ($request->has('profile_photo')) ? $photo = $request->input('profile_photo') : $photo = '';

        $updateFields = [
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'favourite' => $favourite
        ];

        if ($photo != '') {
            $updateFields['profile_photo'] = $photo;
        }

        $contact->update($updateFields);

        return response()->json($contact, 201, [
            'Location' => route('contact.show',
                ['id', $contact->id])
        ]);
    }

    /**
     * Delete a contact API call
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */

    public function destroy(Request $request, $id)
    {
        $userId = $request->auth->id;
        Contact::where('user_id', $userId)->where('id', $id)->delete();
        return response(null, 204);
    }


}