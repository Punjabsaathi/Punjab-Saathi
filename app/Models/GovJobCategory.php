<?php

namespace App\Models;

// Save as: app/Models/GovJobCategory.php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GovJobCategory extends Model
{
    protected $table = 'gov_job_categories';

    protected $fillable = ['name', 'slug', 'icon', 'description', 'sort_order', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function jobs(): HasMany
    {
        return $this->hasMany(GovJob::class, 'category_id')->where('is_published', true);
    }
    public function activeJobs(): HasMany
    {
        return $this->hasMany(GovJob::class, 'category_id')->where('is_published', true)->where('status', 'active');
    }
}
