<?php

namespace App\Http\Resources;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin PaymentMethod */
class PaymentMethodResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'code'                 => $this->code,
            'name'                 => $this->name,
            'description'          => $this->description,
            'logo_url'             => $this->logo_url,
            'is_active'            => $this->is_active,
            'is_default'           => $this->is_default,
            'payment_flow'         => $this->payment_flow?->value,
            'supported_currencies' => $this->supported_currencies,
            'min_amount'           => $this->min_amount,
            'max_amount'           => $this->max_amount,
            'settlement_days'      => $this->settlement_days,
            'display_order'        => $this->display_order,
            // config_schema only exposed to admin
            'config_schema'        => $this->when(
                $request->user()?->role->value === 'admin',
                $this->config_schema
            ),
        ];
    }
}
