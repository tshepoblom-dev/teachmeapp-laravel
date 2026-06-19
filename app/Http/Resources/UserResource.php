<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'name'                 => $this->name,
            'email'                => $this->email,
            'role'                 => $this->role->value,
            'account_status'       => $this->account_status->value,
            'email_verified'       => ! is_null($this->email_verified_at),
            'profile_photo_url'    => $this->profile_photo_path
                ? asset('storage/' . $this->profile_photo_path)
                : null,
            'last_login_at'        => $this->last_login_at?->toIso8601String(),
            'created_at'           => $this->created_at->toIso8601String(),

            // Sideload profile when loaded
            'profile' => $this->whenLoaded('profile', fn () =>
                new ProfileResource($this->profile)
            ),

            // Wallet summary when loaded
            'wallet' => $this->whenLoaded('wallet', fn () => [
                'balance'         => (float) $this->wallet->balance,
                'escrow_balance'  => (float) $this->wallet->escrow_balance,
                'currency'        => $this->wallet->currency,
            ]),
        ];
    }
}
