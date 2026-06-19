<?php

namespace App\Http\Controllers;

use App\Services\NotificationPreferenceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationPreferenceController extends Controller
{
    public function __construct(
        private readonly NotificationPreferenceService $prefService
    ) {}

    /**
     * Show the preferences page.
     * GET /settings/notifications
     */
    public function index(Request $request): Response
    {
        return Inertia::render('Settings/Notifications', [
            'preferences'        => $this->prefService->allForUser($request->user()),
            'available_channels' => NotificationPreferenceService::AVAILABLE_CHANNELS,
            // Channels actually active platform-wide (driven by NOTIFICATION_CHANNELS in .env)
            // so the UI can grey-out channels the admin has disabled globally.
            'platform_channels'  => $this->prefService->platformEnabledChannels(),
        ]);
    }

    /**
     * Update a single notification type preference.
     * PATCH /settings/notifications/{type}
     */
    public function update(Request $request, string $type): RedirectResponse
    {
        $data = $request->validate([
            'channels'   => ['required', 'array'],
            'channels.*' => ['string', 'in:database,mail,fcm'],
            'enabled'    => ['required', 'boolean'],
        ]);

        try {
            $this->prefService->set($request->user(), $type, $data['channels'], $data['enabled']);
            return back()->with('success', 'Notification preference updated.');
        } catch (\InvalidArgumentException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Bulk-update all preferences in one save.
     * POST /settings/notifications/bulk
     */
    public function bulkUpdate(Request $request): RedirectResponse
    {
        $request->validate([
            'preferences'            => ['required', 'array'],
            'preferences.*.type'     => ['required', 'string'],
            'preferences.*.channels' => ['required', 'array'],
            'preferences.*.enabled'  => ['required', 'boolean'],
        ]);

        $this->prefService->bulkSet($request->user(), $request->preferences);

        return back()->with('success', 'Notification preferences saved.');
    }

    /**
     * Reset all to system defaults.
     * DELETE /settings/notifications
     */
    public function reset(Request $request): RedirectResponse
    {
        $this->prefService->resetToDefaults($request->user());
        return back()->with('success', 'Notification preferences reset to defaults.');
    }
}