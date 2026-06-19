<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\TutorAvailabilitySlot;
use App\Services\AvailabilityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class TutorAvailabilityController extends Controller
{
    public function __construct(private readonly AvailabilityService $availabilityService) {}

    // ─── READ ─────────────────────────────────────────────────────────────────

    public function index(Request $request): Response
    {
        $slots = $this->availabilityService
            ->slotsForTutor($request->user()->id)
            ->map(fn ($s) => $this->formatSlot($s));

        return Inertia::render('Tutor/Availability/Index', [
            'slots' => $slots,
            'days'  => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        ]);
    }

    // ─── CREATE ───────────────────────────────────────────────────────────────

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        try {
            $this->availabilityService->create($request->user(), $data);
            return back()->with('success', 'Availability slot added.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Bulk-create multiple slots at once (e.g. paste a weekly template).
     * POST /tutor/availability/bulk
     */
    public function bulkStore(Request $request): RedirectResponse
    {
        $request->validate([
            'slots'                   => ['required', 'array', 'min:1', 'max:50'],
            'slots.*.day_of_week'     => ['required', 'integer', 'min:0', 'max:6'],
            'slots.*.start_time'      => ['required', 'date_format:H:i'],
            'slots.*.end_time'        => ['required', 'date_format:H:i', 'after:slots.*.start_time'],
            'slots.*.is_recurring'    => ['boolean'],
            'slots.*.valid_from'      => ['nullable', 'date'],
            'slots.*.valid_until'     => ['nullable', 'date'],
        ]);

        $result = $this->availabilityService->bulkCreate($request->user(), $request->slots);

        $message = "{$result['created']} slot(s) added.";
        if ($result['skipped'] > 0) {
            $message .= " {$result['skipped']} skipped (overlap).";
        }

        return back()->with('success', $message);
    }

    /**
     * Replace all slots with a fresh schedule.
     * POST /tutor/availability/replace
     */
    public function replaceAll(Request $request): RedirectResponse
    {
        $request->validate([
            'slots'                   => ['required', 'array', 'min:1', 'max:50'],
            'slots.*.day_of_week'     => ['required', 'integer', 'min:0', 'max:6'],
            'slots.*.start_time'      => ['required', 'date_format:H:i'],
            'slots.*.end_time'        => ['required', 'date_format:H:i'],
            'slots.*.is_recurring'    => ['boolean'],
            'slots.*.valid_from'      => ['nullable', 'date'],
            'slots.*.valid_until'     => ['nullable', 'date'],
        ]);

        $result = $this->availabilityService->replaceAll($request->user(), $request->slots);

        return back()->with('success', "Schedule replaced: {$result['created']} slot(s) saved.");
    }

    // ─── UPDATE ───────────────────────────────────────────────────────────────

    public function update(Request $request, TutorAvailabilitySlot $slot): RedirectResponse
    {
        abort_unless($slot->tutor_id === $request->user()->id, 403);

        $data = $request->validate($this->rules());

        try {
            $this->availabilityService->update($slot, $data);
            return back()->with('success', 'Slot updated.');
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Toggle a slot active/inactive without deleting it.
     * PATCH /tutor/availability/{slot}/toggle
     */
    public function toggle(Request $request, TutorAvailabilitySlot $slot): RedirectResponse
    {
        abort_unless($slot->tutor_id === $request->user()->id, 403);

        $updated = $this->availabilityService->toggle($slot);

        $label = $updated->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Slot {$label}.");
    }

    // ─── DELETE ───────────────────────────────────────────────────────────────

    public function destroy(Request $request, TutorAvailabilitySlot $slot): RedirectResponse
    {
        abort_unless($slot->tutor_id === $request->user()->id, 403);

        $this->availabilityService->delete($slot);

        return back()->with('success', 'Slot removed.');
    }

    // ─── Public API (used by booking UI) ─────────────────────────────────────

    /**
     * Returns a tutor's active slots for a date range.
     * Used by the student-side booking picker.
     * GET /api/tutors/{tutorId}/availability?from=YYYY-MM-DD&to=YYYY-MM-DD
     */
    public function publicSlots(Request $request, int $tutorId): JsonResponse
    {
        $request->validate([
            'from' => ['nullable', 'date'],
            'to'   => ['nullable', 'date', 'after_or_equal:from'],
        ]);

        $slots = $this->availabilityService
            ->slotsForTutor($tutorId)
            ->where('is_active', true)
            ->when($request->from, fn ($c) => $c->filter(
                fn ($s) => ! $s->valid_until || $s->valid_until->gte($request->from)
            ))
            ->when($request->to, fn ($c) => $c->filter(
                fn ($s) => ! $s->valid_from || $s->valid_from->lte($request->to)
            ))
            ->map(fn ($s) => $this->formatSlot($s))
            ->values();

        return response()->json(['data' => $slots]);
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function rules(): array
    {
        return [
            'day_of_week'  => ['required', 'integer', 'min:0', 'max:6'],
            'start_time'   => ['required', 'date_format:H:i'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'is_recurring' => ['boolean'],
            'valid_from'   => ['nullable', 'date'],
            'valid_until'  => ['nullable', 'date', 'after_or_equal:valid_from'],
        ];
    }

    private function formatSlot(TutorAvailabilitySlot $s): array
    {
        return [
            'id'           => $s->id,
            'day_of_week'  => $s->day_of_week,
            'start_time'   => substr($s->start_time, 0, 5),
            'end_time'     => substr($s->end_time, 0, 5),
            'is_recurring' => $s->is_recurring,
            'is_active'    => $s->is_active,
            'valid_from'   => $s->valid_from?->toDateString(),
            'valid_until'  => $s->valid_until?->toDateString(),
        ];
    }
}