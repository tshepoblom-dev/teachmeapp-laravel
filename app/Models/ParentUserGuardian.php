<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParentUserGuardian extends Model
{
    protected $fillable = [
        'student_id','guardian_id','relationship','can_book_sessions',
        'can_receive_reports','is_primary_contact','consent_provided_at','consent_proof_ip',
    ];
    protected function casts(): array
    {
        return ['can_book_sessions' => 'boolean', 'can_receive_reports' => 'boolean', 'is_primary_contact' => 'boolean', 'consent_provided_at' => 'datetime'];
    }
    public function student(): BelongsTo { return $this->belongsTo(User::class, 'student_id'); }
    public function guardian(): BelongsTo { return $this->belongsTo(User::class, 'guardian_id'); }
}
