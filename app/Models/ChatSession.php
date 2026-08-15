<?php

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
