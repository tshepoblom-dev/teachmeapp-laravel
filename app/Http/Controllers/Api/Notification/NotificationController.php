<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    use ApiResponse;

    // ── GET /api/notifications ────────────────────────────────────────────────

    public function index(Request $request): JsonResponse
    {
        $notifications = $request->user()->notifications()->orderByDesc('created_at')->paginate(20);

        return $this->success(NotificationResource::collection($notifications)->response()->getData(true));
    }

    // ── POST /api/notifications/{id}/read ─────────────────────────────────────

    public function markRead(Request $request, string $id): JsonResponse
    {
        $request->user()->notifications()->findOrFail($id)->markAsRead();

        return $this->success(message: 'Notification marked as read.');
    }

    // ── POST /api/notifications/read-all ──────────────────────────────────────

    public function markAllRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications()->update(['read_at' => now()]);

        return $this->success(message: 'All notifications marked as read.');
    }
}
