<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class GoogleReview extends Model
{
    protected $fillable = [
        'reviewer_name', 'city', 'rating', 'review_text', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'rating'    => 'integer',
        'is_active' => 'boolean',
    ];

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /** First letter of the name, for the initials avatar (no real photo on file). */
    public function getInitialAttribute(): string
    {
        return mb_strtoupper(mb_substr(trim($this->reviewer_name), 0, 1));
    }

    /** Deterministic color per name, so the same reviewer always gets the same avatar color. */
    public function getAvatarColorAttribute(): string
    {
        $palette = ['#fc5e28', '#0ea5e9', '#059669', '#8b5cf6', '#e11d48', '#0891b2', '#ca8a04'];
        return $palette[crc32($this->reviewer_name) % count($palette)];
    }
}
