<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'session_id','booking_id','reporter_id','reported_id',
        'reason','description','action_taken','status','admin_notes','resolved_by','resolved_at',
    ];
    protected function casts(): array { return ['resolved_at' => 'datetime']; }
    public function session(): BelongsTo { return $this->belongsTo(Session::class); }
    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function reporter(): BelongsTo { return $this->belongsTo(User::class, 'reporter_id'); }
    public function reported(): BelongsTo { return $this->belongsTo(User::class, 'reported_id'); }
    public function resolvedBy(): BelongsTo { return $this->belongsTo(User::class, 'resolved_by'); }
}
