<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;


class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::latest()->get(); // fetch all messages
        return view('superadmin.contacts', compact('contacts'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Store
        Contact::create($request->only(['name', 'email', 'subject', 'message']));

        // Response
        return response()->json(['success' => 'Message sent successfully!']);
    }
}
