<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SessionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user      = $request->user();
        $booking   = $this->whenLoaded('booking');
        $isAdmin   = $user?->role->value === 'admin';
        $isTutor   = $booking && $user?->id === $this->resource->booking?->tutor_id;
        $isStudent = $booking && $user?->id === $this->resource->booking?->student_id;

        return [
            'id'          => $this->id,
            'booking_id'  => $this->booking_id,
            'status'      => $this->status->value,

            // Channel info — returned to both parties on join
            // Not included in general listing responses
            'channel' => $this->when(
                $isAdmin || $isTutor || $isStudent,
                fn () => [
                    'channel_name' => $this->agora_channel_name,
                    'app_id'       => config('agora.app_id'),
                    'uid_student'  => $this->agora_uid_student,
                    'uid_tutor'    => $this->agora_uid_tutor,
                ]
            ),

            // Tokens are NEVER returned in resource responses —
            // they are returned exclusively by the join endpoint
            // to prevent token leakage in listing/show responses

            'timeline' => [
                'scheduled_at' => $this->resource->booking?->scheduled_at?->copy()->setTimezone(config('app.local_timezone'))->toIso8601String(),
                'started_at'   => $this->started_at?->copy()->setTimezone(config('app.local_timezone'))->toIso8601String(),
                'ended_at'     => $this->ended_at?->copy()->setTimezone(config('app.local_timezone'))->toIso8601String(),
                'duration_minutes' => $this->started_at && $this->ended_at
                    ? (int) $this->started_at->diffInMinutes($this->ended_at)
                    : null,
            ],

            'recording' => $this->when(
                $isAdmin || $isTutor,
                fn () => [
                    'enabled'     => (bool) $this->recording_enabled,
                    'url'         => $this->recording_url,
                    'is_available'=> ! empty($this->recording_url),
                ]
            ),

            'early_termination' => $this->when(
                $this->early_termination_reason !== null,
                fn () => [
                    'reason'    => $this->early_termination_reason,
                    'ended_by'  => $this->ended_by,
                ]
            ),

            // Related resources
            'booking' => $this->whenLoaded(
                'booking',
                fn () => new BookingResource($this->booking)
            ),

            'agora_channel' => $this->when(
                $isAdmin,
                fn () => $this->whenLoaded('agoraChannel', fn () => [
                    'id'                     => $this->agoraChannel->id,
                    'is_active'              => $this->agoraChannel->is_active,
                    'last_keepalive_at'      => $this->agoraChannel->last_keepalive_at?->toIso8601String(),
                    'total_duration_seconds' => $this->agoraChannel->total_duration_seconds,
                ])
            ),

            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}