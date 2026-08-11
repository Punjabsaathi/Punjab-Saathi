<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobResult extends Model {
    protected $table = 'gov_job_results';
    protected $fillable = ['job_id','title','result_date','download_link','merit_list_link','cutoff_marks','scorecard_link','notes','is_published'];
    protected $casts = ['result_date'=>'date','is_published'=>'boolean'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }
}