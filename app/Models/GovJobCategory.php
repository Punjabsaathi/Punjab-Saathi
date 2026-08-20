<?php

namespace App\Models;

// Save as: app/Models/GovJobCategory.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovJobCategory extends Model
{
    protected $table = 'gov_job_categories';

    protected $fillable = [
        'name', 'slug', 'icon', 'description', 'sort_order', 'is_active',
        'meta_title', 'meta_description',
    ];

    protected $casts = ['is_active' => 'boolean'];

    public function jobs(): HasMany
    {
        return $this->hasMany(GovJob::class, 'category_id')->where('is_published', true);
    }
    public function activeJobs(): HasMany
    {
        return $this->hasMany(GovJob::class, 'category_id')->where('is_published', true)->where('status', 'active');
    }

    // ── SEO ────────────────────────────────────────────────
    public function getCanonicalUrlAttribute(): string
    {
        return route('jobs.category', $this->slug);
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: "{$this->name} " . now()->year . ' — Latest Vacancies & Notifications | Punjab Saathi';
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description
            ?: "Latest {$this->name} job vacancies in Punjab — eligibility, important dates, and apply links. Updated regularly by Punjab Saathi.";
    }

    public function toBreadcrumbSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Job Saathi', 'item' => route('jobs.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $this->name, 'item' => $this->canonical_url],
            ],
        ];
    }
}
