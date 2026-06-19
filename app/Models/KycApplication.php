<?php
namespace App\Models;
use App\Enums\KycStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KycApplication extends Model
{
    protected $fillable = [
        'user_id','application_type','status','submitted_at',
        'reviewed_at','reviewed_by','rejection_reason','admin_notes','resubmission_count',
    ];
    protected function casts(): array
    {
        return ['submitted_at' => 'datetime', 'reviewed_at' => 'datetime', 'status' => KycStatus::class];
    }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewed_by'); }
    public function documents(): HasMany { return $this->hasMany(KycDocument::class); }
}
