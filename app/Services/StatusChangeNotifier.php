<?php

namespace App\Services;

use App\Mail\StatusChangeNotification;
use App\Support\StatusChangeData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class StatusChangeNotifier
{
    /**
     * Email the applicant about a status change. Never throws — a mail/queue
     * failure must never break the admin save that triggered it.
     */
    public static function send(StatusChangeData $data): void
    {
        if (! $data->recipientEmail) {
            return;
        }

        try {
            Mail::to($data->recipientEmail)->queue(new StatusChangeNotification($data));
        } catch (Throwable $e) {
            Log::error('Failed to queue status change email', [
                'form_type' => $data->formType,
                'email'     => $data->recipientEmail,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}
