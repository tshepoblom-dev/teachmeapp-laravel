<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AgoraChannel extends Model
{
    protected $fillable = ['session_id','channel_name','is_active','last_keepalive_at','total_duration_seconds'];
    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'last_keepalive_at' => 'datetime'];
    }
    public function session(): BelongsTo { return $this->belongsTo(Session::class); }
}
