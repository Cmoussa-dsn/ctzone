<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    
    public function index()
    {
        return view('contact.index');
    }
    
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'problem' => 'required|string',
        ]);
        
        
        $contact = Contact::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'problem' => $validated['problem'],
            'user_id' => Auth::id(),
        ]);
        
        
        Mail::to('charbelmoussa13@gmail.com')->send(new ContactFormMail(
            $validated['name'],
            $validated['email'],
            'New Repair Request',
            $validated['problem'],
            [],
            $validated['phone']
        ));
        
        return redirect()->route('contact.success');
    }
    
   
    public function success()
    {
        return view('contact.success');
    }
    
    
    public function adminIndex()
    {
        // Temporarily disable admin check for debugging
        // if (!Auth::user() || Auth::user()->role_id != 1) {
        //     return redirect()->route('home')->with('error', 'Unauthorized access');
        // }
        
        $contacts = Contact::orderBy('created_at', 'desc')->paginate(15);
        
        
        if ($contacts->count() == 0) {
            
            $totalCount = Contact::count();
            return view('admin.contacts.index', compact('contacts'))
                ->with('debug_message', "No contacts found in paginated result. Total contacts in database: $totalCount");
        }
        
        return view('admin.contacts.index', compact('contacts'));
    }
    
    
    public function adminShow(Contact $contact)
    {
       
        if (!Auth::user() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }
        
        return view('admin.contacts.show', compact('contact'));
    }
    
    
    public function adminUpdateStatus(Request $request, Contact $contact)
    {
        // Check if user is admin
        if (!Auth::user() || Auth::user()->role_id != 1) {
            return redirect()->route('home')->with('error', 'Unauthorized access');
        }
        
        $validated = $request->validate([
            'status' => 'required|in:pending,in-progress,resolved',
        ]);
        
        $contact->update([
            'status' => $validated['status'],
        ]);
        
        return redirect()->route('admin.contacts.show', $contact)->with('success', 'Status updated successfully');
    }
    
    /**
     * Legacy email sender method
     */
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg|max:5120', 
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