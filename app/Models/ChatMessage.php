<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    public $timestamps = false;
    protected $fillable = ['session_id','sender_id','message','attachments','is_system_message','delivered_at','read_at','created_at'];
    protected function casts(): array
    {
        return ['attachments' => 'array', 'is_system_message' => 'boolean', 'delivered_at' => 'datetime', 'read_at' => 'datetime', 'created_at' => 'datetime'];
    }
    public function session(): BelongsTo { return $this->belongsTo(Session::class); }
    public function sender(): BelongsTo { return $this->belongsTo(User::class, 'sender_id'); }
}
