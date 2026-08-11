<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobDocument extends Model {
    protected $table = 'gov_job_documents';
    protected $fillable = ['job_id','title','type','file_url','file_size','sort_order','is_published'];
    protected $casts = ['is_published'=>'boolean'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }
}