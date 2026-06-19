<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = ['booking_id','student_id','tutor_id','invoice_number','amount','vat_amount','total_amount','status','pdf_url','paid_at'];
    protected function casts(): array { return ['amount' => 'decimal:2', 'vat_amount' => 'decimal:2', 'total_amount' => 'decimal:2', 'paid_at' => 'datetime']; }
    public function booking(): BelongsTo { return $this->belongsTo(Booking::class); }
    public function student(): BelongsTo { return $this->belongsTo(User::class, 'student_id'); }
    public function tutor(): BelongsTo { return $this->belongsTo(User::class, 'tutor_id'); }
}
