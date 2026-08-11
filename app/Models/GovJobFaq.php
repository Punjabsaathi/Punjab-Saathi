<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobFaq extends Model {
    protected $table = 'gov_job_faqs';
    protected $fillable = ['job_id','question','answer','sort_order'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }
}