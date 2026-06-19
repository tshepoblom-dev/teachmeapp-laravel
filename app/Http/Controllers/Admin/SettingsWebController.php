<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlatformSetting;
use App\Services\PlatformSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingsWebController extends Controller
{
    public function __construct(
        private readonly PlatformSettingsService $settingsService,
    ) {}

    public function index(): Response
    {
        $settings = PlatformSetting::orderBy('group')
            ->orderBy('key')
            ->get()
            ->groupBy('group')
            ->map(fn ($group) => $group->map(fn ($s) => [
                'id'          => $s->id,
                'key'         => $s->key,
                'label'       => $s->label,
                'description' => $s->description,
                'data_type'   => $s->data_type,
                'value'       => $s->is_encrypted ? '••••••••' : $s->value,
                'is_encrypted'=> $s->is_encrypted,
                'is_public'   => $s->is_public,
            ]))
            ->toArray();

        return Inertia::render('Admin/Settings/Index', [
            'settings'   => $settings,
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'group' => ['required', 'string'],
            'key'   => ['required', 'string'],
            'value' => ['required'],
        ]);

        $this->settingsService->set(
            group: $request->group,
            key: $request->key,
            value: $request->value,
            updatedBy: $request->user()->id,
        );

        return back()->with('success', 'Setting updated.');
    }
}