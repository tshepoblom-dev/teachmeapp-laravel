<?php

namespace App\Http\Resources;

use App\Models\TutorAvailabilitySlot;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin TutorAvailabilitySlot */
class AvailabilitySlotResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'day_of_week'  => $this->day_of_week,
            'start_time'   => substr($this->start_time, 0, 5),
            'end_time'     => substr($this->end_time, 0, 5),
            'is_recurring' => $this->is_recurring,
            'is_active'    => $this->is_active,
            'valid_from'   => $this->valid_from?->toDateString(),
            'valid_until'  => $this->valid_until?->toDateString(),
        ];
    }
}
