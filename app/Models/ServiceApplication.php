<?php

namespace App\Models;

use App\Support\StatusChangeData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceApplication extends Model
{
    protected $fillable = [
        'service_id', 'reference_no', 'name', 'phone', 'email',
        'address', 'message', 'document_paths', 'status',
        'admin_notes', 'ip_address',
    ];

    protected $casts = [
        'document_paths' => 'array',
        'admin_notes'    => 'array', // ← change from string to array

    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    // Generate unique reference number
    public static function generateReference(): string
    {
        do {
            $ref = 'PSK-' . date('Y') . '-' . strtoupper(substr(uniqid(), -6));
        } while (static::where('reference_no', $ref)->exists());

        return $ref;
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'    => '<span class="badge badge-warning">Pending</span>',
            'in_review'  => '<span class="badge badge-info">In Review</span>',
            'processing' => '<span class="badge badge-primary">Processing</span>',
            'completed'  => '<span class="badge badge-success">Completed</span>',
            'rejected'   => '<span class="badge badge-danger">Rejected</span>',
            default      => '<span class="badge badge-secondary">Unknown</span>',
        };
    }
        public function trackingHistory()
    {
        return $this->hasMany(ApplicationTrackingHistory::class)->latest();
    }

    public function toStatusChangeData(string $previousStatus): StatusChangeData
    {
        $note = null;
        $notes = $this->admin_notes ?? [];

        if (! empty($notes)) {
            $lastEntry = end($notes);

            if (($lastEntry['status'] ?? null) === $this->status) {
                $note = $lastEntry['note'] ?? null;
            }
        }

        return new StatusChangeData(
            formType: 'Service Application' . ($this->service?->title ? ' — ' . $this->service->title : ''),
            referenceNo: $this->reference_no,
            previousStatusLabel: ucwords(str_replace('_', ' ', $previousStatus)),
            newStatusLabel: ucwords(str_replace('_', ' ', $this->status)),
            note: $note,
            recipientName: $this->name,
            recipientEmail: $this->email,
            recipientPhone: $this->phone,
        );
    }
}