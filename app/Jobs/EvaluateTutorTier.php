<?php

namespace App\Jobs;

use App\Models\Profile;
use App\Models\TutorTier;
use App\Notifications\TutorTierUpgradedNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EvaluateTutorTier implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries   = 3;
    public int $backoff = 30;

    public function __construct(
        private readonly int $tutorId,
    ) {}

    public function handle(): void
    {
        DB::transaction(function () {

            // Lock the profile row for this evaluation
            $profile = Profile::where('user_id', $this->tutorId)
                ->lockForUpdate()
                ->first();

            if (! $profile) {
                Log::warning('TierEvaluation: profile not found', ['tutor_id' => $this->tutorId]);
                return;
            }

            $sessionCount = (int) $profile->total_sessions_hosted;

            // Load all active tiers ordered by threshold descending
            // so we match the highest tier the tutor qualifies for
            $tiers = TutorTier::where('is_active', true)
                ->orderByDesc('sessions_threshold')
                ->get();

            $qualifiedTier = null;

            foreach ($tiers as $tier) {
                if ($sessionCount >= $tier->sessions_threshold) {
                    $qualifiedTier = $tier;
                    break; // Highest qualifying tier found
                }
            }

            if (! $qualifiedTier) {
                Log::info('TierEvaluation: no tier qualified yet', [
                    'tutor_id'      => $this->tutorId,
                    'session_count' => $sessionCount,
                ]);
                return;
            }

            // No change if already on this tier
            if ($profile->tutor_tier_id === $qualifiedTier->id) {
                Log::info('TierEvaluation: tier unchanged', [
                    'tutor_id' => $this->tutorId,
                    'tier'     => $qualifiedTier->name,
                ]);
                return;
            }

            $previousTierId = $profile->tutor_tier_id;

            $profile->update([
                'tutor_tier_id'    => $qualifiedTier->id,
                'tier_assigned_at' => now(),
            ]);

            Log::info('TierEvaluation: tier upgraded', [
                'tutor_id'       => $this->tutorId,
                'previous_tier'  => $previousTierId,
                'new_tier'       => $qualifiedTier->name,
                'session_count'  => $sessionCount,
            ]);

            // Notify the tutor of their promotion
            $tutor = $profile->user;
            if ($tutor) {
                try {
                    $tutor->notify(new TutorTierUpgradedNotification($qualifiedTier));
                } catch (\Throwable $e) {
                    // Notification failure must never roll back the tier update
                    Log::error('TierUpgraded notification failed', [
                        'tutor_id' => $this->tutorId,
                        'error'    => $e->getMessage(),
                    ]);
                }
            }
        });
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('EvaluateTutorTier job failed permanently', [
            'tutor_id' => $this->tutorId,
            'error'    => $exception->getMessage(),
        ]);
    }
}