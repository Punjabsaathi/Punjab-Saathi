<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CscCenterFaq extends Model
{
    protected $table = 'csc_center_faqs';

    protected $fillable = ['csc_center_id', 'question', 'answer', 'sort_order'];

    public function cscCenter(): BelongsTo
    {
        return $this->belongsTo(CscCenter::class);
    }
}
