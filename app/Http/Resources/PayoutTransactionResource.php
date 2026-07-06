<?php

namespace App\Http\Resources;

use App\Models\PayoutTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PayoutTransaction */
class PayoutTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'amount'         => (float) $this->amount,
            'status'         => $this->status,
            'reference'      => $this->reference,
            'failure_reason' => $this->failure_reason,
            'created_at'     => $this->created_at->toIso8601String(),
            'processed_at'   => $this->processed_at?->toIso8601String(),
            'account'        => $this->whenLoaded('payoutAccount', fn () => "{$this->payoutAccount->bank_name} ({$this->payoutAccount->account_type})", '—'),
        ];
    }
}
