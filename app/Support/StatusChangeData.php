<?php

namespace App\Support;

final class StatusChangeData
{
    public function __construct(
        public string $formType,
        public ?string $referenceNo,
        public string $previousStatusLabel,
        public string $newStatusLabel,
        public ?string $note,
        public ?string $recipientName,
        public ?string $recipientEmail,
        public ?string $recipientPhone,
    ) {
    }
}
