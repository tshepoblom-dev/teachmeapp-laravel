<?php

namespace App\Http\Resources;

use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PaymentTransaction */
class PaymentTransactionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                     => $this->id,
            'amount'                 => $this->amount,
            'currency'               => $this->currency,
            'status'                 => $this->status->value,
            'payment_method'         => new PaymentMethodResource($this->whenLoaded('paymentMethod')),
            'gateway_transaction_id' => $this->gateway_transaction_id,
            'gateway_status'         => $this->gateway_status,
            'booking_id'             => $this->booking_id,
            'completed_at'           => $this->completed_at?->toISOString(),
            'refunded_at'            => $this->refunded_at?->toISOString(),
            'refund_amount'          => $this->refund_amount,
            'created_at'             => $this->created_at->toISOString(),
            // metadata exposed to admins only
            'metadata'               => $this->when(
                $request->user()?->role->value === 'admin',
                $this->metadata
            ),
        ];
    }
}
