<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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