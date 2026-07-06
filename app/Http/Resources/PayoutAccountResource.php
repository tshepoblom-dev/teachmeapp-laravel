<?php

namespace App\Http\Resources;

use App\Models\PayoutAccount;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PayoutAccount */
class PayoutAccountResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'account_type' => $this->account_type,
            'holder_name'  => $this->account_holder_name,
            'bank_name'    => $this->bank_name,
            'branch_code'  => $this->branch_code,
            'is_default'   => $this->is_default,
            'is_verified'  => $this->is_verified,
            'verified_at'  => $this->verified_at?->toDateString(),
        ];
    }
}
