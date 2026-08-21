<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovUpdateCategory extends Model
{
    protected $fillable = [
        'name', 'slug', 'icon', 'color', 'description', 'sort_order', 'is_active',
        'meta_title', 'meta_description',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function updates(): HasMany
    {
        return $this->hasMany(GovUpdate::class, 'category_id')->where('status', 'published');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getCanonicalUrlAttribute(): string
    {
        return route('gov-updates.category', $this->slug);
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: "{$this->name} — Government Updates " . now()->year . ' | Punjab Saathi';
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description
            ?: "Latest {$this->name} government updates and announcements — explained clearly, in one place, by Punjab Saathi.";
    }

    public function toBreadcrumbSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Government Updates', 'item' => route('gov-updates.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $this->name, 'item' => $this->canonical_url],
            ],
        ];
    }
}
