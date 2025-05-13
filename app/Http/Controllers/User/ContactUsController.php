<?php

namespace App\Http\Controllers\User;
use App\Models\ContactUs;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactUsController extends Controller
{
    public function index() {
        return view('userside.contact_us');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Store the contact us message in the database
        ContactUs::create($request->all());

        return redirect()->back()->with('success', 'Your message has been sent successfully!');
    }
}
