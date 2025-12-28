<?php

namespace App\Mail;

use App\Models\Rappel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RappelEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $rappel;
    public function __construct(Rappel $rappel)
    {
        $this->rappel = $rappel;
    }
    public function build()
    {
        return $this->subject('Rappel: ' . ucfirst($this->rappel->type) . ' pour votre véhicule')
                    ->view('emails.rappel');
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Rappel Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
