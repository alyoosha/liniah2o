<?php


namespace App\Http\Controllers\Pages;


use App\Http\Controllers\Controller;
use App\Models\Contact;

class ContactsController extends Controller
{
    public function __invoke()
    {
        $contactsInfo = Contact::all()[0];

        return view('pages.contacts', compact('contactsInfo'));
    }
}
