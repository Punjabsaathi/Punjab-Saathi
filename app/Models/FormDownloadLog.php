<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormDownloadLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['gov_form_id', 'ip_address', 'user_agent', 'referer', 'downloaded_at'];

    protected $casts = ['downloaded_at' => 'datetime'];

    public function form(): BelongsTo
    {
        return $this->belongsTo(GovForm::class, 'gov_form_id');
    }
}
