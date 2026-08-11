<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormCategory extends Model
{
    protected $fillable = [
        'parent_id', 'name', 'slug', 'icon', 'color', 'description',
        'meta_title', 'meta_description', 'og_image',
        'is_active', 'sort_order', 'forms_count',
    ];

    protected $casts = [
        'is_active'   => 'boolean',
        'sort_order'  => 'integer',
        'forms_count' => 'integer',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(FormCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(FormCategory::class, 'parent_id')->orderBy('sort_order');
    }

    public function forms(): HasMany
    {
        return $this->hasMany(GovForm::class, 'category_id');
    }

    public function subForms(): HasMany
    {
        return $this->hasMany(GovForm::class, 'subcategory_id');
    }

    /** Only top-level categories */
    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }
}
