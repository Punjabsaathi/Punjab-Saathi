<?php

namespace App\Models;

use App\Support\StatusChangeData;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'service',
        'message',
        'status',
    ];

    public function toStatusChangeData(string $previousStatus): StatusChangeData
    {
        return new StatusChangeData(
            formType: 'Service Inquiry (Request Quote)',
            referenceNo: null,
            previousStatusLabel: ucwords(str_replace('_', ' ', $previousStatus)),
            newStatusLabel: ucwords(str_replace('_', ' ', $this->status)),
            note: null,
            recipientName: trim($this->first_name . ' ' . $this->last_name),
            recipientEmail: $this->email,
            recipientPhone: $this->phone,
        );
    }
}