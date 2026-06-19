<?php

namespace App\Services;

use App\Models\TutorAvailabilitySlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

/**
 * AvailabilityService — single source of truth for tutor slot logic.
 *
 * Used by:
 *  - TutorAvailabilityController  (CRUD)
 *  - BookingService               (availability assertion at booking time)
 */
class AvailabilityService
{
    // ─── Queries ──────────────────────────────────────────────────────────────

    /**
     * All active slots for a tutor, ordered by day then time.
     */
    public function slotsForTutor(int $tutorId): Collection
    {
        return TutorAvailabilitySlot::where('tutor_id', $tutorId)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();
    }

    /**
     * Check whether a tutor has an active slot covering a proposed booking window.
     *
     * Day mapping: Carbon 0 = Sunday … 6 = Saturday
     * Our schema:  0 = Monday … 6 = Sunday  (ISO-week style)
     *
     * @throws RuntimeException when the tutor is not available at the given time.
     */
    public function assertAvailableAt(int $tutorId, Carbon $start, int $durationMinutes): void
    {
       // $end = $start->copy()->addMinutes($durationMinutes);

        // Convert Carbon day-of-week (Sun=0) → ISO (Mon=0)
        $dayOfWeek = ($start->dayOfWeek + 6) % 7;

        $startTime = $start->format('H:i:s');
       // $endTime   = $end->format('H:i:s');

        $covered = TutorAvailabilitySlot::where('tutor_id', $tutorId)
            ->where('day_of_week', $dayOfWeek)
            ->where('is_active', true)
            ->where('start_time', '<=', $startTime)
            ->where('end_time', '>', $startTime)
            ->where(function ($q) use ($start) {
                $q->whereNull('valid_from')
                  ->orWhere('valid_from', '<=', $start->toDateString());
            })
            ->where(function ($q) use ($start) {
                $q->whereNull('valid_until')
                  ->orWhere('valid_until', '>=', $start->toDateString());
            })
            ->exists();

        if (! $covered) {
            Log::warning('AvailabilityService: tutor not available at requested time', ['tutor_id' => $tutorId, 'start' => $start->toIso8601String(), 'duration' => $durationMinutes]);
            throw new RuntimeException(
                'The tutor is not available at the requested time. Please choose a time within their availability.'
            );
        }
    }

    // ─── Mutations ────────────────────────────────────────────────────────────

    /**
     * Create a new availability slot, rejecting overlaps.
     *
     * @param  array{
     *   day_of_week: int,
     *   start_time: string,
     *   end_time: string,
     *   is_recurring?: bool,
     *   valid_from?: string|null,
     *   valid_until?: string|null,
     * } $data
     */
    public function create(User $tutor, array $data): TutorAvailabilitySlot
    {
        Log::info('AvailabilityService: slot created', ['tutor_id' => $tutor->id, 'day' => $data['day_of_week'] ?? null]);
        $this->assertNoOverlap($tutor->id, $data);

        return TutorAvailabilitySlot::create([
            'tutor_id'     => $tutor->id,
            'day_of_week'  => $data['day_of_week'],
            'start_time'   => $data['start_time'],
            'end_time'     => $data['end_time'],
            'is_recurring' => $data['is_recurring'] ?? true,
            'is_active'    => true,
            'valid_from'   => $data['valid_from']  ?? null,
            'valid_until'  => $data['valid_until'] ?? null,
        ]);
    }

    /**
     * Update an existing slot's time/day/date-range.
     * Re-checks overlap, excluding the slot being edited.
     *
     * @param  array{
     *   day_of_week: int,
     *   start_time: string,
     *   end_time: string,
     *   is_recurring?: bool,
     *   valid_from?: string|null,
     *   valid_until?: string|null,
     * } $data
     */
    public function update(TutorAvailabilitySlot $slot, array $data): TutorAvailabilitySlot
    {
        $this->assertNoOverlap($slot->tutor_id, $data, excludeSlotId: $slot->id);

        $slot->update([
            'day_of_week'  => $data['day_of_week'],
            'start_time'   => $data['start_time'],
            'end_time'     => $data['end_time'],
            'is_recurring' => $data['is_recurring'] ?? $slot->is_recurring,
            'valid_from'   => $data['valid_from']  ?? null,
            'valid_until'  => $data['valid_until'] ?? null,
        ]);

        Log::info('AvailabilityService: slot updated', [
            'slot_id'  => $slot->id,
            'tutor_id' => $slot->tutor_id,
            'day'      => $data['day_of_week'],
        ]);

        return $slot->fresh();
    }

    /**
     * Toggle a slot's is_active flag.
     */
    public function toggle(TutorAvailabilitySlot $slot): TutorAvailabilitySlot
    {
        $slot->update(['is_active' => ! $slot->is_active]);

        Log::info('AvailabilityService: slot toggled', [
            'slot_id'   => $slot->id,
            'tutor_id'  => $slot->tutor_id,
            'is_active' => $slot->is_active,
        ]);

        return $slot->fresh();
    }

    /**
     * Delete a slot.
     */
    public function delete(TutorAvailabilitySlot $slot): void
    {
        Log::info('AvailabilityService: slot deleted', ['slot_id' => $slot->id, 'tutor_id' => $slot->tutor_id]);
        $slot->delete();
    }

    /**
     * Bulk-create slots from a weekly template, skipping any that would overlap.
     *
     * Useful when a tutor wants to set a full weekly schedule at once.
     *
     * @param  array<int, array{day_of_week,start_time,end_time,is_recurring?,valid_from?,valid_until?}>  $slots
     * @return array{created: int, skipped: int, errors: string[]}
     */
    public function bulkCreate(User $tutor, array $slots): array
    {
        $created = 0;
        $skipped = 0;
        $errors  = [];

        DB::transaction(function () use ($tutor, $slots, &$created, &$skipped, &$errors) {
            foreach ($slots as $index => $slot) {
                try {
                    $this->assertNoOverlap($tutor->id, $slot);
                    TutorAvailabilitySlot::create([
                        'tutor_id'     => $tutor->id,
                        'day_of_week'  => $slot['day_of_week'],
                        'start_time'   => $slot['start_time'],
                        'end_time'     => $slot['end_time'],
                        'is_recurring' => $slot['is_recurring'] ?? true,
                        'is_active'    => true,
                        'valid_from'   => $slot['valid_from']  ?? null,
                        'valid_until'  => $slot['valid_until'] ?? null,
                    ]);
                    $created++;
                } catch (RuntimeException $e) {
                    $skipped++;
                    $errors[] = "Slot #{$index}: {$e->getMessage()}";
                }
            }
        });

        Log::info('AvailabilityService: bulk create completed', [
            'tutor_id' => $tutor->id,
            'created'  => $created,
            'skipped'  => $skipped,
        ]);

        return compact('created', 'skipped', 'errors');
    }

    /**
     * Delete all slots for a tutor and replace with a fresh set.
     *
     * @param  array<int, array{day_of_week,start_time,end_time,...}>  $slots
     */
    public function replaceAll(User $tutor, array $slots): array
    {
        return DB::transaction(function () use ($tutor, $slots) {
            TutorAvailabilitySlot::where('tutor_id', $tutor->id)->delete();
            return $this->bulkCreate($tutor, $slots);
        });
    }

    // ─── Private helpers ──────────────────────────────────────────────────────

    /**
     * Throw if the proposed slot would overlap any existing active slot on the same day.
     *
     * @param  int|null  $excludeSlotId  Exclude this ID (used during update).
     */
    private function assertNoOverlap(int $tutorId, array $data, ?int $excludeSlotId = null): void
    {
        $query = TutorAvailabilitySlot::where('tutor_id', $tutorId)
            ->where('day_of_week', $data['day_of_week'])
            ->where('is_active', true)
            ->where(function ($q) use ($data) {
                // Overlap condition: new slot intersects existing slot in any way
                $q->whereBetween('start_time', [$data['start_time'], $data['end_time']])
                  ->orWhereBetween('end_time',  [$data['start_time'], $data['end_time']])
                  ->orWhere(function ($q2) use ($data) {
                      $q2->where('start_time', '<=', $data['start_time'])
                         ->where('end_time',   '>=', $data['end_time']);
                  });
            });

        if ($excludeSlotId) {
            $query->where('id', '!=', $excludeSlotId);
        }

        if ($query->exists()) {
            Log::warning('AvailabilityService: slot overlap detected', ['tutor_id' => $tutorId]);
            throw new RuntimeException('This slot overlaps with an existing availability window.');
        }
    }
}