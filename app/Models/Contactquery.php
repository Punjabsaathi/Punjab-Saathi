<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactQuery extends Model
{
    use HasFactory;

    protected $table = 'contact_queries';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'subject',
        'message',
        'language',
        'status',
        'ip_address',
        'user_agent',
        'replied_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
    ];

    /* ── Scopes ────────────────────────────────── */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }

    /* ── Helpers ───────────────────────────────── */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'new'         => '<span class="badge bg-warning text-dark">New</span>',
            'in_progress' => '<span class="badge bg-info text-white">In Progress</span>',
            'resolved'    => '<span class="badge bg-success">Resolved</span>',
            default       => '',
        };
    }

    public function getSubjectLabelAttribute(): string
    {
        return match ($this->subject) {
            'application_status' => 'Application Status',
            'document_help'      => 'Document Assistance',
            'service_info'       => 'Service Information',
            'fees_payment'       => 'Fees & Payment',
            'complaint'          => 'Complaint / Feedback',
            'other'              => 'Other',
            default              => ucfirst(str_replace('_', ' ', $this->subject)),
        };
    }
}