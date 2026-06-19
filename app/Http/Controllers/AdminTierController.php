<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignTierRequest;
use App\Http\Requests\CreateTierRequest;
use App\Http\Requests\UpdateTierRequest;
use App\Http\Resources\TierResource;
use App\Models\TutorTier;
use App\Models\User;
use App\Services\TierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class AdminTierController extends Controller
{
    public function __construct(
        private readonly TierService $tierService,
    ) {}

    // =========================================================================
    // GET /api/admin/tiers
    // List all tiers (including inactive) with tutor counts.
    // =========================================================================

    public function index(): AnonymousResourceCollection
    {
        $tiers = TutorTier::withCount(['profiles as profiles_count'])
            ->orderBy('display_order')
            ->get();

        return TierResource::collection($tiers);
    }

    // =========================================================================
    // GET /api/admin/tiers/{tier}
    // Single tier detail with tutor count.
    // =========================================================================

    public function show(TutorTier $tier): JsonResponse
    {
        $tier->loadCount(['profiles as profiles_count']);

        return $this->success(new TierResource($tier));
    }

    // =========================================================================
    // POST /api/admin/tiers
    // Create a new tier.
    // =========================================================================

    public function store(CreateTierRequest $request): JsonResponse
    {
        try {
            $tier = $this->tierService->create($request->validated());

            return $this->success(
                data: new TierResource($tier),
                message: "Tier '{$tier->name}' created successfully.",
                status: 201,
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // PUT /api/admin/tiers/{tier}
    // Update an existing tier.
    // =========================================================================

    public function update(UpdateTierRequest $request, TutorTier $tier): JsonResponse
    {
        try {
            $tier = $this->tierService->update($tier, $request->validated());

            return $this->success(
                data: new TierResource($tier),
                message: "Tier '{$tier->name}' updated successfully.",
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // DELETE /api/admin/tiers/{tier}
    // Delete a tier — blocked if tutors are assigned.
    // =========================================================================

    public function destroy(TutorTier $tier): JsonResponse
    {
        try {
            $this->tierService->delete($tier);

            return $this->success(
                data: null,
                message: "Tier '{$tier->name}' deleted.",
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/admin/tiers/{tier}/toggle
    // Enable or disable a tier.
    // =========================================================================

    public function toggle(TutorTier $tier): JsonResponse
    {
        $tier = $this->tierService->toggleActive($tier);

        $state = $tier->is_active ? 'enabled' : 'disabled';

        return $this->success(
            data: new TierResource($tier),
            message: "Tier '{$tier->name}' {$state}.",
        );
    }

    // =========================================================================
    // POST /api/admin/tiers/{tier}/assign
    // Manually assign a tier to a specific tutor.
    // =========================================================================

    public function assign(AssignTierRequest $request, TutorTier $tier): JsonResponse
    {
        $tutor = User::findOrFail($request->validated('tutor_id'));

        try {
            $profile = $this->tierService->assignToTutor(
                tier: $tier,
                tutor: $tutor,
                admin: $request->user(),
            );

            return $this->success(
                data: [
                    'tutor_id'         => $tutor->id,
                    'tutor_name'       => $tutor->name,
                    'tier'             => new TierResource($tier),
                    'tier_assigned_at' => $profile->tier_assigned_at?->toIso8601String(),
                ],
                message: "{$tutor->name} has been assigned to the {$tier->name} tier.",
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // GET /api/admin/tiers/stats
    // Summary of tutor counts per tier for admin dashboard.
    // =========================================================================

    public function stats(): JsonResponse
    {
        return $this->success(
            data: $this->tierService->stats(),
        );
    }

    // =========================================================================
    // GET /api/admin/tiers/commission-preview
    // Preview commission breakdown across all tiers for a given gross amount.
    // Used by admin configuration UI.
    // =========================================================================

    public function commissionPreview(Request $request): JsonResponse
    {
        $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        return $this->success(
            data: $this->tierService->commissionPreview(
                (float) $request->input('amount')
            ),
        );
    }

    // =========================================================================
    // POST /api/admin/tiers/re-evaluate
    // Re-run tier evaluation for all tutors.
    // Dispatches a job per tutor — does not block the response.
    // =========================================================================

    public function reEvaluate(): JsonResponse
    {
        $count = $this->tierService->reEvaluateAll();

        return $this->success(
            data: ['tutors_queued' => $count],
            message: "Tier evaluation queued for {$count} tutor(s). Results will apply within minutes.",
        );
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