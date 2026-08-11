<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobAnswerKey extends Model {
    protected $table = 'gov_job_answer_keys';
    protected $fillable = ['job_id','title','release_date','objection_end_date','download_link','objection_details','is_published'];
    protected $casts = ['release_date'=>'date','objection_end_date'=>'date','is_published'=>'boolean'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }
}