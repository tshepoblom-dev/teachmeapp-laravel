<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'booking_id'  => $this->booking_id,
            'rating'      => $this->rating,
            'comment'     => $this->comment,
            'tags'        => $this->tags ?? [],
            'is_visible'  => $this->is_visible,
            'reviewed_at' => $this->reviewed_at?->toIso8601String(),
            'reviewer'    => $this->whenLoaded('reviewer', fn () => [
                'id'   => $this->reviewer->id,
                'name' => $this->reviewer->name,
            ]),
        ];
    }
}