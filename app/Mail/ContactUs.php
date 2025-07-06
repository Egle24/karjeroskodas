<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable, SerializesModels;

    public $fromEmail;
    public $fromName;
    public $subject;
    public $body;

    public function __construct($data)
    {
        $this->recipient = $data['recipient'];
        $this->fromEmail = $data['fromEmail'];
        $this->fromName = $data['fromName'];
        $this->subject = $data['subject'];
        $this->body = $data['body'];
    }

    public function build()
    {
        return $this->from($this->fromEmail, $this->fromName)
            ->to($this->recipient)
            ->view('main.email-template')
            ->subject($this->subject)
            ->replyTo($this->fromEmail, $this->fromName);
    }
}
