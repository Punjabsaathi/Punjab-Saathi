<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GovUpdate extends Model
{
    protected $fillable = [
        'title', 'slug', 'short_description', 'content',
        'category_id', 'related_service_id',
        'featured_image', 'image_alt', 'is_important',
        'status', 'published_at',
        'meta_title', 'meta_description', 'meta_keywords', 'canonical_url',
        'og_title', 'og_description', 'og_image', 'views',
    ];

    protected $casts = [
        'is_important' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::creating(function (GovUpdate $update) {
            $update->slug ??= Str::slug($update->title);
        });
    }

    // ── Scopes ──────────────────────────────────────────
    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published')
            ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeImportant(Builder $q): Builder
    {
        return $q->where('is_important', true);
    }

    // ── Relationships ─────────────────────────────────────
    public function category(): BelongsTo
    {
        return $this->belongsTo(GovUpdateCategory::class, 'category_id');
    }

    public function relatedService(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'related_service_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }

    public function getIsNewAttribute(): bool
    {
        $date = $this->published_at ?: $this->created_at;
        return $date && $date->diffInDays(now()) <= 7;
    }

    // ── SEO ────────────────────────────────────────────────
    // `canonical_url` is also a real nullable column (admin override) —
    // read the raw attribute directly to avoid recursing into this
    // same accessor, and fall back to the real route when unset.
    public function getCanonicalUrlAttribute(): string
    {
        return $this->attributes['canonical_url'] ?? route('gov-updates.show', $this->slug);
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        return $this->featured_image ? Storage::disk('public')->url($this->featured_image) : null;
    }

    public function getOgImageUrlAttribute(): ?string
    {
        if ($this->og_image) {
            return Storage::disk('public')->url($this->og_image);
        }
        return $this->featured_image_url;
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: "{$this->title} | Punjab Saathi";
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description ?: $this->short_description ?: Str::limit(strip_tags($this->content), 160);
    }

    public function getOgTitleDisplayAttribute(): string
    {
        return $this->og_title ?: $this->seo_title;
    }

    public function getOgDescriptionDisplayAttribute(): string
    {
        return $this->og_description ?: $this->seo_description;
    }

    // Article schema — a general, always-safe type for update/announcement
    // summaries. Deliberately not NewsArticle: this is a private platform
    // summarising government announcements, not a news publisher, and the
    // content isn't original reporting.
    public function toArticleSchema(): array
    {
        return [
            '@context'      => 'https://schema.org',
            '@type'         => 'Article',
            'headline'      => $this->title,
            'description'   => $this->seo_description,
            'datePublished' => ($this->published_at ?: $this->created_at)->toIso8601String(),
            'dateModified'  => $this->updated_at->toIso8601String(),
            'image'         => $this->featured_image_url,
            'author'        => ['@type' => 'Organization', 'name' => 'Punjab Saathi'],
            'publisher'     => ['@type' => 'Organization', 'name' => 'Punjab Saathi', 'url' => url('/')],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id'   => $this->canonical_url,
            ],
        ];
    }

    public function toBreadcrumbSchema(): array
    {
        $items = [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Government Updates', 'item' => route('gov-updates.index')],
        ];

        if ($this->category) {
            $items[] = ['@type' => 'ListItem', 'position' => 3, 'name' => $this->category->name, 'item' => route('gov-updates.category', $this->category->slug)];
        }

        $items[] = ['@type' => 'ListItem', 'position' => count($items) + 1, 'name' => $this->title, 'item' => $this->canonical_url];

        return [
            '@context'         => 'https://schema.org',
            '@type'            => 'BreadcrumbList',
            'itemListElement'  => $items,
        ];
    }
}
