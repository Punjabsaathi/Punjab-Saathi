<?php

namespace App\Mail;

use App\Support\FormSubmissionData;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class FormSubmissionAdminAlert extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public FormSubmissionData $data)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "New {$this->data->formType} submission — " . config('site.name') . ' Admin',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin-alert',
            with: ['data' => $this->data],
        );
    }
}
