<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PollResponse extends Model
{
    public $timestamps = false;
    protected $fillable = ['poll_id','user_id','response','responded_at'];
    protected function casts(): array { return ['response' => 'array', 'responded_at' => 'datetime']; }
    public function poll(): BelongsTo { return $this->belongsTo(SessionPoll::class, 'poll_id'); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
