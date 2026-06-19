<?php

namespace App\Services;

use App\Models\NotificationPreference;
use App\Models\User;
use Illuminate\Support\Collection;

/**
 * NotificationPreferenceService
 *
 * Provides a per-user, per-type channel preference store.
 * Notification classes call resolveChannels() in their via() method
 * to respect both user preferences and platform-level channel toggles.
 *
 * Supported channels : 'database', 'mail', 'fcm'
 * Broadcast/Pusher   : delivered automatically via NotificationObserver
 *                      whenever a 'database' notification is written.
 * Supported types    : see TYPES constant below.
 *
 * ─── Platform-level channel toggle (.env) ────────────────────────────────────
 * Set NOTIFICATION_CHANNELS in .env to a comma-separated list of channels that
 * are enabled platform-wide.  Per-user preferences are then intersected with
 * this list, so an admin can switch off FCM or mail globally without touching
 * user records.
 *
 *   NOTIFICATION_CHANNELS=database,mail,fcm   ← all three on  (default)
 *   NOTIFICATION_CHANNELS=database,mail       ← FCM off globally
 *   NOTIFICATION_CHANNELS=database            ← only in-app bell
 *
 * 'database' is always kept regardless of the env value so the in-app bell
 * continues to function.
 * ─────────────────────────────────────────────────────────────────────────────
 */
class NotificationPreferenceService
{
    /** All notification types the system can produce. */
    public const TYPES = [
        'booking_accepted'  => 'Booking accepted',
        'booking_cancelled' => 'Booking cancelled',
        'booking_declined'  => 'Booking declined',
        'booking_request'   => 'New booking request',
        'booking_completed' => 'Session completed',
        'session_started'   => 'Session started',
        'session_ended'     => 'Session ended',
        'kyc_approved'      => 'KYC approved',
        'kyc_rejected'      => 'KYC rejected',
        'tier_upgraded'     => 'Tutor tier upgraded',
        'payout_completed'  => 'Payout completed',
        'payout_failed'     => 'Payout failed',
        'review_received'   => 'New review received',
        'report_resolved'   => 'Report resolved',
    ];

    /** Channels available to users. */
    public const AVAILABLE_CHANNELS = ['database', 'mail', 'fcm'];

    /**
     * Default channels for each type when no preference row exists.
     * FCM is included so new users get push notifications out of the box.
     * The platform-level gate (resolveEnabledChannels) will still strip 'fcm'
     * if NOTIFICATION_CHANNELS does not include it.
     */
    public const DEFAULTS = [
        'booking_accepted'  => ['database', 'mail', 'fcm'],
        'booking_cancelled' => ['database', 'mail', 'fcm'],
        'booking_declined'  => ['database', 'mail', 'fcm'],
        'booking_request'   => ['database', 'fcm'],
        'booking_completed' => ['database', 'mail', 'fcm'],
        'session_started'   => ['database', 'fcm'],
        'session_ended'     => ['database', 'fcm'],
        'kyc_approved'      => ['database', 'mail', 'fcm'],
        'kyc_rejected'      => ['database', 'mail', 'fcm'],
        'tier_upgraded'     => ['database', 'mail', 'fcm'],
        'payout_completed'  => ['database', 'mail', 'fcm'],
        'payout_failed'     => ['database', 'mail', 'fcm'],
        'review_received'   => ['database', 'fcm'],
        'report_resolved'   => ['database', 'mail', 'fcm'],
    ];

    // ─── Read ─────────────────────────────────────────────────────────────────

    /**
     * Resolve which channels to use for a given user + notification type.
     *
     * Resolution order:
     *  1. User has a stored preference   → use it (gated by platform channels)
     *  2. No stored preference           → use DEFAULTS (gated by platform channels)
     *  3. User disabled this type        → ['database'] only (bell still works)
     *
     * @return string[]
     */
    public function resolveChannels(User $user, string $type): array
    {
        $pref = NotificationPreference::where('user_id', $user->id)
            ->where('notification_type', $type)
            ->first();

        if (! $pref) {
            // No stored preference — use system default, gated by platform
            $channels = self::DEFAULTS[$type] ?? ['database'];
            return $this->gatePlatformChannels($channels);
        }

        if (! $pref->enabled) {
            // User disabled this notification entirely; still write to DB for the bell icon
            return ['database'];
        }

        $channels = $pref->channels ?: ['database'];
        return $this->gatePlatformChannels($channels);
    }

    /**
     * Return all preferences for a user, filling in defaults for missing types.
     *
     * @return Collection<int, array{type,label,channels,enabled}>
     */
    public function allForUser(User $user): Collection
    {
        $stored = NotificationPreference::where('user_id', $user->id)
            ->get()
            ->keyBy('notification_type');

        return collect(self::TYPES)->map(function (string $label, string $type) use ($stored) {
            $pref = $stored->get($type);
            return [
                'type'     => $type,
                'label'    => $label,
                'channels' => $pref?->channels ?? (self::DEFAULTS[$type] ?? ['database']),
                'enabled'  => $pref?->enabled  ?? true,
            ];
        })->values();
    }

    /**
     * The channels that are enabled at the platform level.
     * Reads NOTIFICATION_CHANNELS from the environment.
     * 'database' is always present regardless of the env value.
     *
     * @return string[]
     */
    public function platformEnabledChannels(): array
    {
        $raw = env('NOTIFICATION_CHANNELS', 'database,mail,fcm');

        $channels = array_map('trim', explode(',', $raw));
        $channels = array_intersect($channels, self::AVAILABLE_CHANNELS);

        // 'database' is non-negotiable — the bell must always work.
        if (! in_array('database', $channels, true)) {
            $channels[] = 'database';
        }

        return array_values(array_unique($channels));
    }

    // ─── Write ────────────────────────────────────────────────────────────────

    /**
     * Upsert a single preference row.
     *
     * @param  string[]  $channels
     */
    public function set(User $user, string $type, array $channels, bool $enabled): NotificationPreference
    {
        $this->assertValidType($type);
        $channels = $this->sanitiseChannels($channels);

        return NotificationPreference::updateOrCreate(
            ['user_id' => $user->id, 'notification_type' => $type],
            ['channels' => $channels, 'enabled' => $enabled],
        );
    }

    /**
     * Bulk-update all preferences for a user in one request.
     *
     * @param  array<int, array{type: string, channels: string[], enabled: bool}>  $preferences
     */
    public function bulkSet(User $user, array $preferences): void
    {
        foreach ($preferences as $pref) {
            if (! isset(self::TYPES[$pref['type']])) {
                continue; // Skip unknown types silently
            }
            $this->set(
                $user,
                $pref['type'],
                $pref['channels'] ?? ['database'],
                $pref['enabled']  ?? true,
            );
        }
    }

    /**
     * Reset all preferences for a user to system defaults.
     */
    public function resetToDefaults(User $user): void
    {
        NotificationPreference::where('user_id', $user->id)->delete();
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    /**
     * Intersect the given channels with platform-enabled channels.
     * 'database' is always retained.
     *
     * @param  string[]  $channels
     * @return string[]
     */
    private function gatePlatformChannels(array $channels): array
    {
        $enabled = $this->platformEnabledChannels();
        $gated   = array_values(array_intersect($channels, $enabled));

        // Guarantee database is always present
        if (! in_array('database', $gated, true)) {
            $gated[] = 'database';
        }

        return $gated;
    }

    private function assertValidType(string $type): void
    {
        if (! isset(self::TYPES[$type])) {
            throw new \InvalidArgumentException("Unknown notification type: {$type}");
        }
    }

    private function sanitiseChannels(array $channels): array
    {
        $valid = array_intersect($channels, self::AVAILABLE_CHANNELS);
        // Always include database so the in-app bell always works
        if (! in_array('database', $valid, true)) {
            $valid[] = 'database';
        }
        return array_values(array_unique($valid));
    }
}
