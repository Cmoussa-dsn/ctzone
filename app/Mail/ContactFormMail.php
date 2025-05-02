<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $senderName;
    public $senderEmail;
    public $subject;
    public $messageContent;
    public $attachmentPaths;

    public function __construct($name, $email, $subject, $message, $attachments = [])
    {
        $this->senderName = $name;
        $this->senderEmail = $email;
        $this->subject = $subject;
        $this->messageContent = $message;
        $this->attachmentPaths = $attachments;
    }

    public function build()
    {
        $mail = $this->from($this->senderEmail, $this->senderName)
                    ->subject($this->subject)
                    ->view('emails.contact-form')
                    ->with([
                        'name' => $this->senderName,
                        'email' => $this->senderEmail,
                        'messageContent' => $this->messageContent
                    ]);

        foreach ($this->attachmentPaths as $path) {
            $mail->attach(Storage::disk('public')->path($path));
        }

        return $mail;
    }
} 