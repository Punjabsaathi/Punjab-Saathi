<?php
namespace App\Models;
use App\Support\StatusChangeData;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GovJobFormRequest extends Model {
    protected $table = 'gov_job_form_requests';
    protected $fillable = ['job_id','name','phone','email','job_name','service_type','message','status'];
    public function job(): BelongsTo { return $this->belongsTo(GovJob::class, 'job_id'); }

    public function toStatusChangeData(string $previousStatus): StatusChangeData
    {
        return new StatusChangeData(
            formType: 'Job Form Help Request',
            referenceNo: null,
            previousStatusLabel: ucwords(str_replace('_', ' ', $previousStatus)),
            newStatusLabel: ucwords(str_replace('_', ' ', $this->status)),
            note: null,
            recipientName: $this->name,
            recipientEmail: $this->email,
            recipientPhone: $this->phone,
        );
    }
}