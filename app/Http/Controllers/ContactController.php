<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg|max:5120', // 5MB max per file
        ]);

        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('contact-attachments', 'public');
                $attachments[] = $path;
            }
        }

        Mail::to('charbelmoussa13@gmail.com')->send(new ContactFormMail(
            $request->name,
            $request->email,
            $request->subject,
            $request->message,
            $attachments
        ));

        return back()->with('success', 'Thank you for your message. We will get back to you soon!');
    }
} 