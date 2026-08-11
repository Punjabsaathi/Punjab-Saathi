<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobUpdate extends Model {
    protected $table = 'gov_job_updates';
    protected $fillable = ['job_id','title','description','update_date','type'];
    protected $casts = ['update_date'=>'date'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }
}