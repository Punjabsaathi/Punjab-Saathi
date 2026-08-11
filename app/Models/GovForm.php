<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class GovForm extends Model
{
    protected $fillable = [
        'category_id', 'subcategory_id', 'title', 'slug',
        'short_description', 'full_description',
        'file_path', 'file_name', 'file_mime', 'file_size', 'thumbnail',
        'download_count', 'is_featured', 'is_popular', 'is_active',
        'sort_order', 'published_date',
        'seo_title', 'meta_description', 'meta_keywords', 'canonical_url', 'og_image',
    ];

    protected $casts = [
        'is_featured'    => 'boolean',
        'is_popular'     => 'boolean',
        'is_active'      => 'boolean',
        'file_size'      => 'integer',
        'download_count' => 'integer',
        'sort_order'     => 'integer',
        'published_date' => 'date',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(FormCategory::class, 'category_id');
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(FormCategory::class, 'subcategory_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(FormTag::class, 'form_tag_relations', 'gov_form_id', 'form_tag_id');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(FormFaq::class, 'gov_form_id')->orderBy('sort_order');
    }

    public function relatedForms(): BelongsToMany
    {
        return $this->belongsToMany(GovForm::class, 'form_related', 'gov_form_id', 'related_form_id');
    }

    public function downloadLogs(): HasMany
    {
        return $this->hasMany(FormDownloadLog::class, 'gov_form_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->where('is_active', true);
    }

    public function scopePopular($query)
    {
        return $query->where('is_popular', true)->where('is_active', true);
    }

    public function scopeSearch($query, string $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('short_description', 'like', "%{$term}%")
              ->orWhere('meta_keywords', 'like', "%{$term}%");
        });
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024)    return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' B';
    }

    public function getDownloadUrlAttribute(): string
    {
        return route('forms.download', $this->slug);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->thumbnail ? Storage::url($this->thumbnail) : null;
    }

    public function getSeoTitleDisplayAttribute(): string
    {
        return $this->seo_title ?: $this->title . ' | Punjab Seva Kendra';
    }
}
