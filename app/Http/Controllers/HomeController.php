<?php

namespace App\Http\Controllers;
use App\ContactList\Api\ContactApiCalls;
use App\ContactList\UIFactory;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    protected $user = null;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * UI - root element
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function home()
    {
        if (!$this->request->auth) {
            return view('loginpage');
        }

        $UIFactory = new UIFactory((new ContactApiCalls())->getContacts());

        return view('homepage',
            ['user' => $this->request->auth, 'contacts' => $UIFactory->getAllResults(), 'favourites' => $UIFactory->getFavourites(), 'searchData' => $UIFactory->getSearchHelperString()]
        )->with('message', $UIFactory::processFlashMessage());
    }

    /**
     * UI - new contact screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function newContact()
    {
        if (!$this->request->auth) {
            return view('loginpage');
        }

        return view('contacts.new', ['user' => $this->request->auth]);
    }

    /**
     * UI - edit contact screen
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */

    public function editContact($id)
    {
        if (!$this->request->auth) {
            return view('loginpage');
        }

        $contact = (new ContactApiCalls())->getContact($id);
        if (!isset($contact['id'])) {
            return redirect(route('homepage'));
        }

        return view('contacts.edit', ['user' => $this->request->auth, 'contact' => $contact]);
    }

    /**
     * UI - contact showing read only
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */

    public function viewContact($id)
    {
        if (!$this->request->auth) {
            return view('loginpage');
        }

        $contact = (new ContactApiCalls())->getContact($id);

        if (!isset($contact['id'])) {
            return redirect(route('homepage'));
        }

        return view('contacts.show', ['user' => $this->request->auth, 'contact' => $contact]);
    }

}