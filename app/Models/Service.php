<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Builder;

class Service extends Model
{
    protected $fillable = [
        'title', 'slug', 'tag', 'category', 'icon', 'color',
        'short_desc', 'overview', 'processing_time', 'fee_range',
        'fee_note', 'eligibility', 'is_popular', 'is_active',
        'meta_title', 'meta_description', 'meta_keywords',
        'og_image', 'sort_order',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active'  => 'boolean',
    ];

    // ── Relationships ────────────────────────────────────────

    public function documents(): HasMany
    {
        return $this->hasMany(ServiceDocument::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(ServiceFaq::class)->orderBy('sort_order');
    }

    public function applications(): HasMany
    {
        return $this->hasMany(ServiceApplication::class);
    }

    // ── Scopes ───────────────────────────────────────────────

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->where('is_popular', true);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    // ── Accessors ────────────────────────────────────────────

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: "{$this->title} in Punjab | Punjab Seva Kendra";
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: $this->short_desc;
    }

    public function getCanonicalUrlAttribute(): string
    {
        return url("/services/{$this->slug}");
    }

    public function getWhatsappUrlAttribute(): string
    {
        $text = urlencode("Hello, I need help with: {$this->title}");
        return "https://wa.me/91XXXXXXXXXX?text={$text}";
    }

    // ── Route model binding key ──────────────────────────────

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ── Related services (same category, excluding self) ─────

    public function related(int $limit = 3)
    {
        return static::active()
            ->byCategory($this->category)
            ->where('id', '!=', $this->id)
            ->orderBy('sort_order')
            ->limit($limit)
            ->get();
    }
}