<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = ['booking_id','reviewer_id','reviewee_id','rating','comment','tags','is_visible','reviewed_at'];
    protected function casts(): array
    {
        return ['tags' => 'array', 'is_visible' => 'boolean', 'reviewed_at' => 'datetime'];
    }
    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewer_id'); }
    public function reviewee(): BelongsTo { return $this->belongsTo(User::class, 'reviewee_id'); }
}
