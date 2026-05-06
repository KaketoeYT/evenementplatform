<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QueueInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public $url;
    public $event;

    public function __construct($url, $event)
    {
        $this->url = $url;
        $this->event = $event;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Queue Invitation',
        );
    }

    public function build()
    {
    return $this->subject('Er is een ticket vrijgekomen!')
                ->view('mails.queue_invitation');
    }

    public function content(): Content
    {
        return new Content(
            view: 'mails.queue_invitation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
