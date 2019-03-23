<?php

namespace App\Http\Controllers;
use App\ContactList\Contact;
use App\ContactList\Phone;

use App\ContactList\UIFactory;
use Illuminate\Http\Request;

class UIController extends Controller
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    protected $apiCalls;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Post action controller for user interface; new contact
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function new()
    {
        $newContact = (new Contact($this->request))->addNew();

        return redirect(route('homepage'))->with('fwdMessage', ['result' => $newContact, 'action' => 'newContact']);
    }

    /**
     * Post action controller for user interface; editing an existing contact
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function edit($id)
    {
        $editedContact = (new Contact($this->request))->editExisting($id);

        return redirect(route('homepage'))->with('fwdMessage', ['result' => $editedContact, 'action' => 'editContact']);

    }

    /**
     * Get action controller for user interface; deleting a contact
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function delete($id)
    {
        $deleted = (new Contact($this->request))->delete($id);

        return redirect(route('homepage'))->with('fwdMessage', ['result' => $deleted, 'action' => 'deleteContact']);
    }

    /**
     * Get action controller for user interface; deleting a phone number under contact
     *
     * @param $contactId
     * @param $phoneId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */

    public function deletePhoneNumber ($contactId, $phoneId)
    {
        $deleted = (new Phone($this->request, $contactId))->deletePhoneNumber($phoneId);
        //TODO: maybe implement reporting to edit form as well?

        return redirect(route('contact.edit', $contactId));
    }



}