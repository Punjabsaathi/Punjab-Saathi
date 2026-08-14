<?php

namespace App\Mail;

use App\Support\StatusChangeData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StatusChangeNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public StatusChangeData $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Update on your {$this->data->formType} — " . config('site.name'),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.status-update',
            with: ['data' => $this->data],
        );
    }
}
