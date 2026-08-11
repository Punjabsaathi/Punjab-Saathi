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
        'status', 'is_featured', 'is_published',
        'meta_title', 'meta_description', 'meta_keywords', 'views',
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
    ];

    // ── Scopes ──────────────────────────────────────────
    public function scopePublished($query)      { return $query->where('is_published', true); }
    public function scopeActive($query)         { return $query->where('status', 'active'); }
    public function scopeFeatured($query)       { return $query->where('is_featured', true); }
    public function scopeByCategory($query, $slug) {
        return $query->whereHas('category', fn($q) => $q->where('slug', $slug));
    }

    // ── Relationships ────────────────────────────────────
    public function category(): BelongsTo    { return $this->belongsTo(GovJobCategory::class, 'category_id'); }
    public function admitCards(): HasMany    { return $this->hasMany(GovJobAdmitCard::class, 'job_id')->where('is_published', true)->orderByDesc('created_at'); }
    public function answerKeys(): HasMany    { return $this->hasMany(GovJobAnswerKey::class, 'job_id')->where('is_published', true)->orderByDesc('created_at'); }
    public function results(): HasMany       { return $this->hasMany(GovJobResult::class, 'job_id')->where('is_published', true)->orderByDesc('created_at'); }
    public function documents(): HasMany     { return $this->hasMany(GovJobDocument::class, 'job_id')->where('is_published', true)->orderBy('sort_order'); }
    public function faqs(): HasMany          { return $this->hasMany(GovJobFaq::class, 'job_id')->orderBy('sort_order'); }
    public function updates(): HasMany       { return $this->hasMany(GovJobUpdate::class, 'job_id')->orderByDesc('update_date'); }

    // ── Accessors ────────────────────────────────────────
    public function getIsNewAttribute(): bool
    {
        return $this->created_at && $this->created_at->diffInDays(now()) <= 10;
    }
    public function getIsUrgentAttribute(): bool
    {
        return $this->apply_end && $this->apply_end->diffInDays(now(), false) <= 7 && $this->apply_end->isFuture();
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
