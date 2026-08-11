<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobAdmitCard extends Model {
    protected $table = 'gov_job_admit_cards';
    protected $fillable = ['job_id','title','release_date','exam_date','download_link','instructions','is_published'];
    protected $casts = ['release_date'=>'date','exam_date'=>'date','is_published'=>'boolean'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }
}