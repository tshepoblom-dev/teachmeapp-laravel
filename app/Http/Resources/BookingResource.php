<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $request->user();

        return [
            'id'             => $this->id,
            'status'         => $this->status->value,
            'subject'        => $this->subject,
            'description'    => $this->description,
            'scheduled_at'   => $this->scheduled_at?->copy()->setTimezone(config('app.local_timezone'))->toIso8601String(),
            'duration_minutes' => $this->duration_minutes,
            'ends_at'        => $this->scheduled_at
                ? $this->scheduled_at->copy()->addMinutes($this->duration_minutes)->copy()->setTimezone(config('app.local_timezone'))->toIso8601String()
                : null,

            // Financial snapshot — always show to admin, only show amounts to
            // the parties involved in the booking
            'financials' => $this->when(
                $user && (
                    $user->id === $this->student_id ||
                    $user->id === $this->tutor_id   ||
                    $user->role->value === 'admin'
                ),
                fn () => [
                    'hourly_rate'           => (float) $this->hourly_rate_snapshot,
                    'total_amount'          => (float) $this->total_amount,
                    'platform_fee_percent'  => (float) $this->platform_fee_snapshot,
                    'currency'              => 'ZAR',
                ]
            ),

            // Cancellation info
            'cancellation' => $this->when(
                $this->cancellation_reason || $this->cancelled_by,
                fn () => [
                    'reason'       => $this->cancellation_reason,
                    'cancelled_by' => $this->cancelled_by,
                ]
            ),

            // Rescheduling audit trail
            'rescheduled_from_booking_id' => $this->rescheduled_from_booking_id,

            // Related resources — loaded only when the relationships are eager-loaded
            'student' => $this->whenLoaded('student', fn () => [
                'id'     => $this->student->id,
                'name'   => $this->student->name,
                'avatar' => $this->student->profile_photo_url ?? null,
            ]),

            'tutor' => $this->whenLoaded('tutor', fn () => [
                'id'     => $this->tutor->id,
                'name'   => $this->tutor->name,
                'avatar' => $this->tutor->profile_photo_url ?? null,
                'tier'   => $this->tutor->profile?->tutorTier?->name,
            ]),

            'session' => $this->whenLoaded('session', fn () => new SessionResource($this->session)),

            'escrow' => $this->whenLoaded('escrowTransaction', function () use ($user) {
                // Only admin sees the full escrow breakdown
                if ($user?->role->value === 'admin') {
                    return new EscrowResource($this->escrowTransaction);
                }

                // Students and tutors only see the status
                return [
                    'status' => $this->escrowTransaction?->status?->value,
                ];
            }),

            'payment_method' => $this->whenLoaded('paymentMethod', fn () => [
                'id'   => $this->paymentMethod->id,
                'name' => $this->paymentMethod->name,
                'code' => $this->paymentMethod->code,
            ]),

            'review' => $this->whenLoaded('review', fn () => new ReviewResource($this->review)),

            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}