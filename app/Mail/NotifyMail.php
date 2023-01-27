<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotifyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected string $pesan;
    protected string $subjek;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($pesan, $subjek)
    {
        $this->pesan = $pesan;
        $this->subjek = $subjek;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: $this->subjek,
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            view: 'emails.mail',
            with: [
                'pesan' => $this->pesan,
                'subjek' => $this->subjek
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
