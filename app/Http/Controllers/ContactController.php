<?php

namespace App\Http\Controllers;

use App\Models\contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = contact::query()->paginate(10);

        return view('backend.contact.index', compact('contacts'));
    }
    public function show($id)
    {

        $contact = contact::query()->where('id', $id)->get()->first();
        return view('backend.contact.show', compact('contact'));
    }
    public function destroy($id)
    {
        $contact = new Contact;
        $contact = $contact->where('id', $id)->First();
        $contact->delete();
        return redirect('/admin/contact')->with('success', 'Your data has been deleted');
    }
}
