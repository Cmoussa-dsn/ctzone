<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $email;
    public $subject;
    public $messageContent;
    public $attachmentPaths;
    public $phone;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $subject, $messageContent, $attachmentPaths = [], $phone = null)
    {
        $this->name = $name;
        $this->email = $email;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
        $this->attachmentPaths = $attachmentPaths;
        $this->phone = $phone;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        $mail = $this->subject($this->subject)
                    ->view('emails.contact-form');
                    
        // Add attachments if any
        foreach ($this->attachmentPaths as $path) {
            if (Storage::disk('public')->exists($path)) {
                $mail->attach(Storage::disk('public')->path($path));
            }
        }
                    
        return $mail;
    }
} 