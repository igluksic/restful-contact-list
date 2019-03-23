<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\User;

abstract class ApiController extends Controller
{
    abstract function show(Request $request, $id);
    abstract function store(Request $request, $id);
    abstract function update(Request $request, $id);
    abstract function destroy(Request $request, $id);

    /**
     * User authorization
     *
     * @param Contact $contact
     * @param User $user
     * @return bool
     */

    protected function checkContactOwnership (Contact $contact, User $user)
    {
        return ($contact->user_id === $user->id);
    }

    /**
     * Error report factory
     *
     * @param $description
     * @return \Illuminate\Http\JsonResponse
     */

    protected static function errorResponse ($description)
    {
        return response()->json(['Error' => $description], 400);
    }
}