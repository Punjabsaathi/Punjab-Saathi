<?php

namespace App\Support;

final class FormSubmissionData
{
    /**
     * @param  array<string, string|null>  $details  Label => value rows shown in the email.
     */
    public function __construct(
        public string $formType,
        public ?string $referenceNo,
        public string $submittedAt,
        public string $statusLabel,
        public string $nextSteps,
        public ?string $recipientName,
        public ?string $recipientEmail,
        public ?string $recipientPhone,
        public array $details = [],
        public ?string $adminUrl = null,
    ) {
    }
}
