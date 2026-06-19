<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SessionPoll extends Model
{
    protected $fillable = ['session_id','question','options','created_by','status','results'];
    protected function casts(): array { return ['options' => 'array', 'results' => 'array']; }
    public function session(): BelongsTo { return $this->belongsTo(Session::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
    public function responses(): HasMany { return $this->hasMany(PollResponse::class, 'poll_id'); }
}
