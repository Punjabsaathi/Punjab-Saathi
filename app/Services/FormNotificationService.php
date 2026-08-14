<?php

namespace App\Services;

use App\Mail\FormSubmissionAdminAlert;
use App\Mail\FormSubmissionUserConfirmation;
use App\Support\FormSubmissionData;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class FormNotificationService
{
    /**
     * Send the user confirmation (if we have an email) and the admin alert
     * for a form submission. Never throws — a mail/queue failure must never
     * break the caller's existing request/response flow.
     */
    public static function send(FormSubmissionData $data): void
    {
        if ($data->recipientEmail) {
            try {
                Mail::to($data->recipientEmail)->queue(new FormSubmissionUserConfirmation($data));
            } catch (Throwable $e) {
                Log::error('Failed to queue user confirmation email', [
                    'form_type' => $data->formType,
                    'email'     => $data->recipientEmail,
                    'error'     => $e->getMessage(),
                ]);
            }
        }

        $admins = config('site.admin_notification_emails', []);

        if (! empty($admins)) {
            try {
                Mail::to($admins)->queue(new FormSubmissionAdminAlert($data));
            } catch (Throwable $e) {
                Log::error('Failed to queue admin alert email', [
                    'form_type' => $data->formType,
                    'admins'    => $admins,
                    'error'     => $e->getMessage(),
                ]);
            }
        }
    }
}
