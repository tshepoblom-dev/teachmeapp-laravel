<?php
namespace App\Models;
use App\Enums\DocumentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KycDocument extends Model
{
    protected $fillable = [
        'kyc_application_id','user_id','document_type','file_path',
        'file_hash','mime_type','file_size_kb','status','verified_at','rejection_reason',
    ];
    protected function casts(): array
    {
        return ['verified_at' => 'datetime', 'document_type' => DocumentType::class];
    }
    public function kycApplication(): BelongsTo { return $this->belongsTo(KycApplication::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}
