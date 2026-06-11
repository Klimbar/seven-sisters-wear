<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Mail::to(config('mail.contact.to'))->send(new ContactMessage(
            name: $validated['name'],
            email: $validated['email'],
            mailSubject: $validated['subject'],
            body: $validated['message'],
        ));

        return back()->with('success', 'Your message has been sent successfully.');
    }
}
