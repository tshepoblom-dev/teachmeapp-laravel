<?php

namespace App\Http\Controllers\Api\Tutor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tutor\BulkAvailabilitySlotsRequest;
use App\Http\Requests\Tutor\StoreAvailabilitySlotRequest;
use App\Http\Resources\AvailabilitySlotResource;
use App\Models\TutorAvailabilitySlot;
use App\Services\AvailabilityService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;

class AvailabilityController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly AvailabilityService $availabilityService) {}

    // ── GET /api/tutor/availability ───────────────────────────────────────────

    public function index(Request $request): JsonResponse
    {
        $slots = $this->availabilityService->slotsForTutor($request->user()->id);

        return $this->success(AvailabilitySlotResource::collection($slots));
    }

    // ── POST /api/tutor/availability ──────────────────────────────────────────

    public function store(StoreAvailabilitySlotRequest $request): JsonResponse
    {
        try {
            $slot = $this->availabilityService->create($request->user(), $request->validated());
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new AvailabilitySlotResource($slot), 'Availability slot added.', 201);
    }

    // ── POST /api/tutor/availability/bulk ─────────────────────────────────────

    public function bulkStore(BulkAvailabilitySlotsRequest $request): JsonResponse
    {
        $result = $this->availabilityService->bulkCreate($request->user(), $request->input('slots'));

        return $this->success($result, "{$result['created']} slot(s) added.");
    }

    // ── POST /api/tutor/availability/replace ──────────────────────────────────

    public function replaceAll(BulkAvailabilitySlotsRequest $request): JsonResponse
    {
        $result = $this->availabilityService->replaceAll($request->user(), $request->input('slots'));

        return $this->success($result, "Schedule replaced: {$result['created']} slot(s) saved.");
    }

    // ── PUT /api/tutor/availability/{slot} ────────────────────────────────────

    public function update(StoreAvailabilitySlotRequest $request, TutorAvailabilitySlot $slot): JsonResponse
    {
        abort_unless($slot->tutor_id === $request->user()->id, 403);

        try {
            $slot = $this->availabilityService->update($slot, $request->validated());
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 422);
        }

        return $this->success(new AvailabilitySlotResource($slot), 'Slot updated.');
    }

    // ── PATCH /api/tutor/availability/{slot}/toggle ───────────────────────────

    public function toggle(Request $request, TutorAvailabilitySlot $slot): JsonResponse
    {
        abort_unless($slot->tutor_id === $request->user()->id, 403);

        $slot = $this->availabilityService->toggle($slot);
        $label = $slot->is_active ? 'activated' : 'deactivated';

        return $this->success(new AvailabilitySlotResource($slot), "Slot {$label}.");
    }

    // ── DELETE /api/tutor/availability/{slot} ─────────────────────────────────

    public function destroy(Request $request, TutorAvailabilitySlot $slot): JsonResponse
    {
        abort_unless($slot->tutor_id === $request->user()->id, 403);

        $this->availabilityService->delete($slot);

        return $this->success(message: 'Slot removed.');
    }
}
