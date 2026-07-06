<?php

namespace App\Http\Resources;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Report */
class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'session_id'   => $this->session_id,
            'booking_id'   => $this->booking_id,
            'reporter_id'  => $this->reporter_id,
            'reported_id'  => $this->reported_id,
            'reason'       => $this->reason,
            'description'  => $this->description,
            'action_taken' => $this->action_taken,
            'status'       => $this->status,
            'created_at'   => $this->created_at->toIso8601String(),
        ];
    }
}
