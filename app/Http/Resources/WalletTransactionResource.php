<?php

namespace App\Http\Resources;

use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin WalletTransaction */
class WalletTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'type'          => $this->type->value,
            'direction'     => $this->direction,
            'amount'        => (float) $this->amount,
            'balance_after' => (float) $this->balance_after,
            'description'   => $this->description,
            'reference'     => $this->reference,
            'created_at'    => $this->created_at->toIso8601String(),
        ];
    }
}
