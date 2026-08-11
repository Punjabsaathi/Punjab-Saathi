<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormFaq extends Model
{
    protected $fillable = ['gov_form_id', 'question', 'answer', 'sort_order'];

    protected $casts = ['sort_order' => 'integer'];

    public function form(): BelongsTo
    {
        return $this->belongsTo(GovForm::class, 'gov_form_id');
    }
}
