<?php

namespace App\Services;

use App\Models\Profile;
use App\Models\TutorTier;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class TierService
{
    private const CACHE_KEY = 'tutor_tiers:active';
    private const CACHE_TTL = 300; // 5 minutes

    // =========================================================================
    // PUBLIC LISTING
    // Used by discovery UI and Flutter app — cached.
    // =========================================================================

    public function allActive(): Collection
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return TutorTier::where('is_active', true)
                ->orderBy('display_order')
                ->get();
        });
    }

    // =========================================================================
    // CREATE
    // Validates threshold uniqueness and display order before creating.
    // =========================================================================

    public function create(array $data): TutorTier
    {
        return DB::transaction(function () use ($data) {

            $this->assertUniqueThreshold(
                threshold: (int) $data['sessions_threshold'],
                excludeId: null,
            );

            $this->assertUniqueDisplayOrder(
                order: (int) $data['display_order'],
                excludeId: null,
            );

            $tier = TutorTier::create([
                'name'                       => $data['name'],
                'slug'                       => Str::slug($data['name']),
                'sessions_threshold'         => (int) $data['sessions_threshold'],
                'commission_rate'            => (float) $data['commission_rate'],
                'bonus_rate_above_threshold' => isset($data['bonus_rate_above_threshold'])
                    ? (float) $data['bonus_rate_above_threshold']
                    : null,
                'theme_colour_primary'       => $data['theme_colour_primary'],
                'theme_colour_secondary'     => $data['theme_colour_secondary'],
                'badge_icon_url'             => $data['badge_icon_url'] ?? null,
                'features'                   => $data['features'] ?? null,
                'is_active'                  => $data['is_active'] ?? true,
                'display_order'              => (int) $data['display_order'],
            ]);

            $this->flushCache();

            Log::info('TutorTier created', [
                'tier_id'   => $tier->id,
                'name'      => $tier->name,
                'threshold' => $tier->sessions_threshold,
            ]);

            return $tier;
        });
    }

    // =========================================================================
    // UPDATE
    // =========================================================================

    public function update(TutorTier $tier, array $data): TutorTier
    {
        return DB::transaction(function () use ($tier, $data) {

            if (isset($data['sessions_threshold'])) {
                $this->assertUniqueThreshold(
                    threshold: (int) $data['sessions_threshold'],
                    excludeId: $tier->id,
                );
            }

            if (isset($data['display_order'])) {
                $this->assertUniqueDisplayOrder(
                    order: (int) $data['display_order'],
                    excludeId: $tier->id,
                );
            }

            // Regenerate slug if name changed
            if (isset($data['name']) && $data['name'] !== $tier->name) {
                $data['slug'] = Str::slug($data['name']);
            }

            // Cast numeric fields
            if (isset($data['commission_rate'])) {
                $data['commission_rate'] = (float) $data['commission_rate'];
            }

            if (isset($data['sessions_threshold'])) {
                $data['sessions_threshold'] = (int) $data['sessions_threshold'];
            }

            $tier->update($data);

            $this->flushCache();

            Log::info('TutorTier updated', [
                'tier_id' => $tier->id,
                'changes' => array_keys($data),
            ]);

            return $tier->fresh();
        });
    }

    // =========================================================================
    // DELETE
    // Cannot delete a tier that has tutors currently assigned to it.
    // =========================================================================

    public function delete(TutorTier $tier): void
    {
        $assignedCount = Profile::where('tutor_tier_id', $tier->id)->count();

        if ($assignedCount > 0) {
            throw new RuntimeException(
                "Cannot delete this tier — {$assignedCount} tutor(s) are currently assigned to it. " .
                'Reassign or promote those tutors first.'
            );
        }

        $tier->delete();

        $this->flushCache();

        Log::info('TutorTier deleted', ['tier_id' => $tier->id, 'name' => $tier->name]);
    }

    // =========================================================================
    // TOGGLE ACTIVE
    // Disabling a tier does not remove assigned tutors — they keep their tier
    // but it is hidden from public listing.
    // =========================================================================

    public function toggleActive(TutorTier $tier): TutorTier
    {
        $tier->update(['is_active' => ! $tier->is_active]);

        $this->flushCache();

        Log::info('TutorTier toggled', [
            'tier_id'   => $tier->id,
            'is_active' => $tier->is_active,
        ]);

        return $tier->fresh();
    }

    // =========================================================================
    // MANUALLY ASSIGN TIER
    // Admin overrides the automatic tier assignment for a specific tutor.
    // =========================================================================

    public function assignToTutor(TutorTier $tier, User $tutor, User $admin): Profile
    {
        if ($tutor->role->value !== 'tutor') {
            throw new RuntimeException('Tier assignment is only applicable to tutors.');
        }

        $profile = $tutor->profile;

        if (! $profile) {
            throw new RuntimeException('Tutor profile not found.');
        }

        $previousTierId = $profile->tutor_tier_id;

        $profile->update([
            'tutor_tier_id'    => $tier->id,
            'tier_assigned_at' => now(),
        ]);

        Log::info('TutorTier manually assigned', [
            'tier_id'        => $tier->id,
            'tutor_id'       => $tutor->id,
            'admin_id'       => $admin->id,
            'previous_tier'  => $previousTierId,
        ]);

        return $profile->fresh(['tutorTier']);
    }

    // =========================================================================
    // COMMISSION PREVIEW
    // Given a gross amount, returns the commission breakdown for every tier.
    // Used by the admin tier configuration UI.
    // =========================================================================

    public function commissionPreview(float $grossAmount): array
    {
        return TutorTier::where('is_active', true)
            ->orderBy('display_order')
            ->get()
            ->map(function (TutorTier $tier) use ($grossAmount) {
                $commissionAmount = round($grossAmount * ($tier->commission_rate / 100), 2);
                $netToTutor       = round($grossAmount - $commissionAmount, 2);

                return [
                    'tier_id'          => $tier->id,
                    'tier_name'        => $tier->name,
                    'commission_rate'  => (float) $tier->commission_rate,
                    'gross_amount'     => $grossAmount,
                    'commission_amount'=> $commissionAmount,
                    'net_to_tutor'     => $netToTutor,
                ];
            })
            ->toArray();
    }

    // =========================================================================
    // PROGRESS — how far a tutor is toward the next tier
    // Used by the tutor dashboard tier progress bar.
    // =========================================================================

    public function progressForTutor(User $tutor): array
    {
        $profile      = $tutor->profile;
        $sessionCount = (int) ($profile?->total_sessions_hosted ?? 0);
        $currentTier  = $profile?->tutorTier;

        // Get all active tiers ordered by threshold ascending
        $tiers = TutorTier::where('is_active', true)
            ->orderBy('sessions_threshold')
            ->get();

        // Find the next tier above the current one
        $nextTier = $tiers->first(function (TutorTier $tier) use ($sessionCount) {
            return $tier->sessions_threshold > $sessionCount;
        });

        if (! $nextTier) {
            // Already at the highest tier
            return [
                'current_tier'          => $currentTier,
                'next_tier'             => null,
                'sessions_completed'    => $sessionCount,
                'sessions_needed'       => 0,
                'sessions_until_next'   => 0,
                'progress_percent'      => 100,
                'is_highest_tier'       => true,
            ];
        }

        // Progress from the current tier's threshold (or 0 if no current tier)
        $fromThreshold = $currentTier?->sessions_threshold ?? 0;
        $toThreshold   = $nextTier->sessions_threshold;
        $range         = $toThreshold - $fromThreshold;
        $progress      = $sessionCount - $fromThreshold;
        $percent       = $range > 0
            ? min(100, round(($progress / $range) * 100, 1))
            : 0;

        return [
            'current_tier'        => $currentTier,
            'next_tier'           => $nextTier,
            'sessions_completed'  => $sessionCount,
            'sessions_needed'     => $toThreshold,
            'sessions_until_next' => max(0, $toThreshold - $sessionCount),
            'progress_percent'    => $percent,
            'is_highest_tier'     => false,
        ];
    }

    // =========================================================================
    // RE-EVALUATE ALL TUTORS
    // Admin utility — re-runs tier evaluation for every tutor.
    // Dispatches EvaluateTutorTier job for each tutor rather than doing it inline.
    // =========================================================================

    public function reEvaluateAll(): int
    {
        $tutors = User::where('role', 'tutor')
            ->whereHas('profile')
            ->pluck('id');

        foreach ($tutors as $tutorId) {
            \App\Jobs\EvaluateTutorTier::dispatch($tutorId)
                ->onQueue('default');
        }

        Log::info('TierService: re-evaluation dispatched for all tutors', [
            'count' => $tutors->count(),
        ]);

        return $tutors->count();
    }

    // =========================================================================
    // STATS — summary for admin dashboard
    // =========================================================================

    public function stats(): array
    {
        $tiers = TutorTier::withCount([
            'profiles as tutor_count',
        ])
        ->orderBy('display_order')
        ->get();

        return $tiers->map(fn (TutorTier $tier) => [
            'id'                  => $tier->id,
            'name'                => $tier->name,
            'slug'                => $tier->slug,
            'commission_rate'     => (float) $tier->commission_rate,
            'sessions_threshold'  => $tier->sessions_threshold,
            'tutor_count'         => $tier->tutor_count,
            'is_active'           => $tier->is_active,
        ])->toArray();
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function assertUniqueThreshold(int $threshold, ?int $excludeId): void
    {
        $exists = TutorTier::where('sessions_threshold', $threshold)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();

        if ($exists) {
            throw new RuntimeException(
                "A tier with a threshold of {$threshold} sessions already exists. " .
                'Each tier must have a unique session threshold.'
            );
        }
    }

    private function assertUniqueDisplayOrder(int $order, ?int $excludeId): void
    {
        $exists = TutorTier::where('display_order', $order)
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->exists();

        if ($exists) {
            throw new RuntimeException(
                "Display order {$order} is already taken by another tier."
            );
        }
    }

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}