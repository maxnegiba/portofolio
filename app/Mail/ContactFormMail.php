<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Datele primite din formular

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        // 4. Setăm subiectul emailului din câmpul 'subject' al formularului
        return new Envelope(
            subject: $this->data['subject'], 
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        // 5. Specificăm view-ul pentru email și transmitem datele
        return new Content(
            view: 'emails.contact', // Vom crea acest view
            with: [
                'name' => $this->data['name'],
                'email' => $this->data['email'],
                'messageContent' => $this->data['message'], // Redenumim pentru a evita confuzia cu metoda `message`
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}