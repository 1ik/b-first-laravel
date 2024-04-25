<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActivationEmailNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $userData;

    public function __construct($data)
    {
        $this->userData = $data;
    }

 
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Activation Email Notification',
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'email.emailActivation',
        );
    }

 
    public function attachments(): array
    {
        return [];
    }
}
