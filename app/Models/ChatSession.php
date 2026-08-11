<?php

// ============================================================
// App\Models\ChatSession
// ============================================================

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatSession extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id', 'session_token', 'language', 'user_ip', 'user_agent', 'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function messages(): HasMany
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    public function touch($attribute = null, $value = null): bool
    {
        if ($attribute === 'expires_at') {
            $this->expires_at = $value;
            return $this->save();
        }
        return parent::touch($attribute);
    }
}

// ============================================================
// App\Models\ChatMessage
// ============================================================

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id', 'role', 'content', 'language', 'intent',
        'tokens_used', 'latency_ms', 'was_cached', 'similarity_score',
    ];

    protected $casts = [
        'was_cached' => 'boolean',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ChatSession::class, 'session_id');
    }

    public function scopeUser($query)
    {
        return $query->where('role', 'user');
    }

    public function scopeAssistant($query)
    {
        return $query->where('role', 'assistant');
    }
}

// ============================================================
// App\Models\KnowledgeChunk
// ============================================================

class KnowledgeChunk extends Model
{
    protected $fillable = [
        'source_type', 'source_id', 'chunk_index', 'content', 'title',
        'content_hi', 'content_pa', 'metadata', 'is_active', 'embedded_at',
    ];

    protected $casts = [
        'metadata'    => 'array',
        'is_active'   => 'boolean',
        'embedded_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('source_type', $type);
    }

    public function markEmbedded(): void
    {
        $this->update(['embedded_at' => now()]);
    }
}

// ============================================================
// App\Models\Application  (your existing model — extend as needed)
// ============================================================

class Application extends Model
{
    protected $fillable = [
        'reference_number', 'service_id', 'applicant_name',
        'applicant_phone', 'status', 'applied_at', 'completed_at',
    ];

    protected $casts = [
        'applied_at'    => 'datetime',
        'completed_at'  => 'datetime',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Service::class);
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(ApplicationStatusLog::class);
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending'             => 'Pending',
            'under_review'        => 'Under Review',
            'approved'            => 'Approved',
            'rejected'            => 'Rejected',
            'documents_required'  => 'Documents Required',
            default               => ucfirst($this->status),
        };
    }
}