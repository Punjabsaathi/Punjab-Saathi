<?php

namespace App\Models;

// ─────────────────────────────────────────────────────────
// Save as: app/Models/GovJob.php
// ─────────────────────────────────────────────────────────

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovJob extends Model
{
    protected $table = 'gov_jobs';

    protected $fillable = [
        'category_id', 'title', 'slug', 'department', 'ad_number', 'location',
        'total_posts', 'short_description', 'description', 'qualification',
        'age_min', 'age_max', 'age_relaxation', 'experience_required',
        'salary_pay_scale', 'publish_date', 'apply_start', 'apply_end', 'exam_date',
        'application_mode', 'official_website', 'application_fee', 'selection_process',
        'application_steps', 'required_documents', 'exam_pattern', 'syllabus',
        'notification_link', 'apply_link', 'syllabus_link', 'correction_form_link',
        'merit_list_link', 'cutoff_link', 'previous_papers_link',
        'status', 'is_featured', 'is_published', 'schema_enabled',
        'meta_title', 'meta_description', 'meta_keywords', 'og_image', 'views',
        'employment_type', 'hiring_organization_name', 'hiring_organization_url',
        'salary_min', 'salary_max', 'salary_currency',
    ];

    protected $casts = [
        'apply_start'        => 'date',
        'apply_end'          => 'date',
        'exam_date'          => 'date',
        'publish_date'       => 'date',
        'application_fee'    => 'array',
        'selection_process'  => 'array',
        'application_steps'  => 'array',
        'required_documents' => 'array',
        'exam_pattern'       => 'array',
        'syllabus'           => 'array',
        'is_featured'        => 'boolean',
        'is_published'       => 'boolean',
        'schema_enabled'     => 'boolean',
        'salary_min'         => 'integer',
        'salary_max'         => 'integer',
    ];

    // ── Scopes ──────────────────────────────────────────
    public function scopePublished($query)      { return $query->where('is_published', true); }
    public function scopeActive($query)         { return $query->where('status', 'active'); }
    public function scopeFeatured($query)       { return $query->where('is_featured', true); }
    public function scopeByCategory($query, $slug) {
        return $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }
    // Punjab-specific postings first, then everything else (e.g. national
    // bank/PSU drives) — ties broken by the caller's own ->orderBy() calls,
    // since MySQL keeps prior ORDER BY columns as tie-breakers.
    public function scopePunjabFirst($query) {
        return $query->orderByRaw("CASE WHEN location LIKE '%Punjab%' THEN 0 ELSE 1 END");
    }

    // ── Relationships ────────────────────────────────────
    public function category(): BelongsTo    { return $this->belongsTo(GovJobCategory::class, 'category_id'); }
    public function admitCards(): HasMany    { return $this->hasMany(GovJobAdmitCard::class, 'job_id')->where('is_published', true)->orderByDesc('created_at'); }
    public function answerKeys(): HasMany    { return $this->hasMany(GovJobAnswerKey::class, 'job_id')->where('is_published', true)->orderByDesc('created_at'); }
    public function results(): HasMany       { return $this->hasMany(GovJobResult::class, 'job_id')->where('is_published', true)->orderByDesc('created_at'); }
    public function documents(): HasMany     { return $this->hasMany(GovJobDocument::class, 'job_id')->where('is_published', true)->orderBy('sort_order'); }
    public function faqs(): HasMany          { return $this->hasMany(GovJobFaq::class, 'job_id')->orderBy('sort_order'); }
    public function updates(): HasMany       { return $this->hasMany(GovJobUpdate::class, 'job_id')->orderByDesc('update_date'); }

    // ── SEO ────────────────────────────────────────────────
    public function getCanonicalUrlAttribute(): string
    {
        return url("/jobs/{$this->slug}");
    }

    public function getOgImageUrlAttribute(): ?string
    {
        return $this->og_image ? \Illuminate\Support\Facades\Storage::disk('public')->url($this->og_image) : null;
    }

    // JobPosting schema — the single biggest missing piece for this section:
    // without it the page is not eligible for Google's dedicated Jobs search
    // feature at all. Returns null (not emitted) when the admin has turned
    // schema off for this job, or when the minimum fields Google requires
    // (title, description, a posting date) aren't there yet.
    public function toJobPostingSchema(): ?array
    {
        if (! $this->schema_enabled) {
            return null;
        }

        $description = $this->description ?: $this->short_description;
        $datePosted  = $this->publish_date ?: $this->created_at;

        if (! $this->title || ! $description || ! $datePosted) {
            return null;
        }

        $schema = [
            '@context'         => 'https://schema.org',
            '@type'            => 'JobPosting',
            'title'            => $this->title,
            'description'      => $description,
            'datePosted'       => $datePosted->toDateString(),
            'employmentType'   => $this->employment_type ?: 'FULL_TIME',
            'hiringOrganization' => array_filter([
                '@type' => 'Organization',
                'name'  => $this->hiring_organization_name ?: $this->department,
                'sameAs' => $this->hiring_organization_url ?: $this->official_website,
            ]),
            'jobLocation' => [
                '@type'   => 'Place',
                'address' => [
                    '@type'           => 'PostalAddress',
                    'addressLocality' => $this->location ?: 'Punjab',
                    'addressRegion'   => 'Punjab',
                    'addressCountry'  => 'IN',
                ],
            ],
            // Punjab Saathi is an information/assistance platform, never the
            // employer — directApply must not be asserted for postings we
            // don't control the application pipeline for.
            'directApply' => false,
        ];

        if ($this->apply_end) {
            $schema['validThrough'] = $this->apply_end->copy()->endOfDay()->toIso8601String();
        }

        if ($this->ad_number) {
            $schema['identifier'] = [
                '@type' => 'PropertyValue',
                'name'  => $this->department,
                'value' => $this->ad_number,
            ];
        }

        if ($this->total_posts) {
            $schema['totalJobOpenings'] = $this->total_posts;
        }

        if ($this->salary_min || $this->salary_max) {
            $schema['baseSalary'] = [
                '@type'    => 'MonetaryAmount',
                'currency' => $this->salary_currency ?: 'INR',
                'value'    => array_filter([
                    '@type'    => 'QuantitativeValue',
                    'minValue' => $this->salary_min,
                    'maxValue' => $this->salary_max,
                    'unitText' => 'MONTH',
                ]),
            ];
        }

        return $schema;
    }

    public function toBreadcrumbSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type'    => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => url('/')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => 'Job Saathi', 'item' => route('jobs.index')],
                ['@type' => 'ListItem', 'position' => 3, 'name' => $this->category->name, 'item' => route('jobs.category', $this->category->slug)],
                ['@type' => 'ListItem', 'position' => 4, 'name' => $this->title, 'item' => $this->canonical_url],
            ],
        ];
    }

    public function toFaqSchema(): ?array
    {
        if (! $this->schema_enabled || $this->faqs->isEmpty()) {
            return null;
        }

        return [
            '@context' => 'https://schema.org',
            '@type'    => 'FAQPage',
            'mainEntity' => $this->faqs->map(fn ($faq) => [
                '@type' => 'Question',
                'name'  => $faq->question,
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text'  => $faq->answer,
                ],
            ])->all(),
        ];
    }

    // ── Accessors ────────────────────────────────────────
    public function getIsNewAttribute(): bool
    {
        return $this->created_at && $this->created_at->diffInDays(now()) <= 10;
    }
    public function getIsUrgentAttribute(): bool
    {
        return $this->apply_end && $this->apply_end->isFuture() && $this->apply_end->diffInDays(now(), true) <= 7;
    }
    public function getStatusBadgeAttribute(): array
    {
        return match($this->status) {
            'active'   => ['label' => 'Active',    'class' => 'badge-active'],
            'upcoming' => ['label' => 'Upcoming',  'class' => 'badge-upcoming'],
            default    => ['label' => 'Expired',   'class' => 'badge-expired'],
        };
    }
}
