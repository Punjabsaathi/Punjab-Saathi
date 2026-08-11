<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobFormRequest extends Model {
    protected $table = 'gov_job_form_requests';
    protected $fillable = ['job_id','name','phone','email','job_name','service_type','message','status'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }
}