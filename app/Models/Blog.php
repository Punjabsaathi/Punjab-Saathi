<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Blog extends Model
{
    protected $fillable = [
        'title', 'slug', 'excerpt', 'content',
        'featured_image', 'image_alt',
        'meta_title', 'meta_description', 'canonical_url', 'focus_keyword',
        'status', 'is_featured', 'published_at', 'reading_time',
        'author_id', 'category_id',
        'tags', 'schema_faq', 'allow_comments', 'views',
    ];

    protected $casts = [
        'is_featured'    => 'boolean',
        'allow_comments' => 'boolean',
        'published_at'   => 'datetime',
        'tags'           => 'array',
        'schema_faq'     => 'array',
    ];

    protected static function booted(): void
    {
        static::creating(function (Blog $blog) {
            $blog->slug         ??= Str::slug($blog->title);
            $blog->reading_time ??= (int) ceil(str_word_count(strip_tags($blog->content)) / 200);
        });

        static::updating(function (Blog $blog) {
            if ($blog->isDirty('content')) {
                $blog->reading_time = (int) ceil(str_word_count(strip_tags($blog->content)) / 200);
            }
        });
    }

    public function scopePublished(Builder $q): Builder
    {
        return $q->where('status', 'published')
                 ->where(fn ($q) => $q->whereNull('published_at')->orWhere('published_at', '<=', now()));
    }

    public function scopeFeatured(Builder $q): Builder
    {
        return $q->where('is_featured', true);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->title;
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description ?: $this->excerpt ?: Str::limit(strip_tags($this->content), 160);
    }

    public function incrementViews(): void
    {
        $this->increment('views');
    }
}
