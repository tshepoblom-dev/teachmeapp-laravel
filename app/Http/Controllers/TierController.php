<?php

namespace App\Http\Controllers;

use App\Http\Resources\TierResource;
use App\Services\TierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TierController extends Controller
{
    public function __construct(
        private readonly TierService $tierService,
    ) {}

    // =========================================================================
    // GET /api/tiers
    // Public listing of all active tiers.
    // Used by Flutter discovery screen and tutor profile badges.
    // =========================================================================

    public function index(): AnonymousResourceCollection
    {
        return TierResource::collection($this->tierService->allActive());
    }

    // =========================================================================
    // GET /api/tiers/{tier}
    // Public single tier detail.
    // =========================================================================

    public function show(\App\Models\TutorTier $tier): JsonResponse
    {
        if (! $tier->is_active) {
            return $this->error('Tier not found.', 404);
        }

        return $this->success(new TierResource($tier));
    }

    // =========================================================================
    // GET /api/tutor/tier/progress
    // Returns the authenticated tutor's tier progress toward the next level.
    // =========================================================================

    public function myProgress(Request $request): JsonResponse
    {
        if ($request->user()->role->value !== 'tutor') {
            return $this->error('Only tutors have tier progress.', 403);
        }

        $progress = $this->tierService->progressForTutor($request->user());

        return $this->success([
            'current_tier' => $progress['current_tier']
                ? new TierResource($progress['current_tier'])
                : null,
            'next_tier' => $progress['next_tier']
                ? new TierResource($progress['next_tier'])
                : null,
            'sessions_completed'  => $progress['sessions_completed'],
            'sessions_needed'     => $progress['sessions_needed'],
            'sessions_until_next' => $progress['sessions_until_next'],
            'progress_percent'    => $progress['progress_percent'],
            'is_highest_tier'     => $progress['is_highest_tier'],
        ]);
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function success(mixed $data, string $message = 'OK', int $status = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    private function error(string $message, int $status = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data'    => null,
        ], $status);
    }
}