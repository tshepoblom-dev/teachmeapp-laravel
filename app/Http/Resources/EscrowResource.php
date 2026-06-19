<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EscrowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'booking_id' => $this->booking_id,
            'status'     => $this->status->value,

            'amounts' => [
                'gross'             => (float) $this->amount,
                'commission_rate'   => $this->commission_rate_snapshot
                    ? (float) $this->commission_rate_snapshot . '%'
                    : null,
                'commission_amount' => $this->commission_amount
                    ? (float) $this->commission_amount
                    : null,
                'net_to_tutor'      => $this->net_to_tutor
                    ? (float) $this->net_to_tutor
                    : null,
                'currency'          => 'ZAR',
            ],

            'timeline' => [
                'held_at'     => $this->held_at?->toIso8601String(),
                'released_at' => $this->released_at?->toIso8601String(),
                'refunded_at' => $this->refunded_at?->toIso8601String(),
            ],

            'release_reason' => $this->release_reason,

            'wallets' => $this->when(
                $request->user()?->role->value === 'admin',
                fn () => [
                    'student_wallet_id' => $this->student_wallet_id,
                    'tutor_wallet_id'   => $this->tutor_wallet_id,
                ]
            ),
        ];
    }
}