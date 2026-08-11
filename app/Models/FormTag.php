<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class FormTag extends Model
{
    protected $fillable = ['name', 'slug'];

    public function forms(): BelongsToMany
    {
        return $this->belongsToMany(GovForm::class, 'form_tag_relations', 'form_tag_id', 'gov_form_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
