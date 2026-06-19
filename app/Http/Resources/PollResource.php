<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PollResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user         = $request->user();
        $hasResponded = false;
        $myResponse   = null;

        // Check if the requesting user has already responded
        if ($user && $this->relationLoaded('responses')) {
            $myPollResponse = $this->responses
                ->firstWhere('user_id', $user->id);

            $hasResponded = $myPollResponse !== null;
            $myResponse   = $myPollResponse?->response;
        }

        return [
            'id'         => $this->id,
            'session_id' => $this->session_id,
            'question'   => $this->question,
            'options'    => $this->options,
            'status'     => $this->status,

            'created_by' => $this->whenLoaded('creator', fn () => [
                'id'   => $this->creator->id,
                'name' => $this->creator->name,
                'role' => $this->creator->role->value,
            ]),

            // Whether the requesting user has voted
            'has_responded' => $hasResponded,
            'my_response'   => $myResponse,

            // Aggregated results — only shown when poll is closed
            // or to admins/tutors while active (so tutor can see live results)
            'results' => $this->when(
                $this->status === 'closed' ||
                in_array($user?->role->value, ['admin', 'tutor'], true),
                fn () => $this->buildResults()
            ),

            // Total response count — always visible
            'response_count' => $this->when(
                $this->relationLoaded('responses'),
                fn () => $this->responses->count()
            ),

            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }

    /**
     * Aggregate poll responses into a results summary.
     * Returns option => count and option => percentage.
     * Anonymous — individual user choices are never exposed.
     */
    private function buildResults(): array
    {
        if (! $this->relationLoaded('responses')) {
            // Return pre-computed results if stored on the model
            return $this->results ?? [];
        }

        $responses = $this->responses;
        $total     = $responses->count();

        if ($total === 0) {
            return collect($this->options)->mapWithKeys(fn ($option) => [
                $option => ['count' => 0, 'percentage' => 0],
            ])->toArray();
        }

        // Flatten all selected options from all responses
        $allSelections = $responses->flatMap(fn ($r) => (array) $r->response);

        return collect($this->options)->mapWithKeys(function ($option) use ($allSelections, $total) {
            $count = $allSelections->filter(fn ($s) => $s === $option)->count();

            return [
                $option => [
                    'count'      => $count,
                    'percentage' => round(($count / $total) * 100, 1),
                ],
            ];
        })->toArray();
    }
}