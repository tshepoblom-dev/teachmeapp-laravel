<?php

namespace App\Http\Controllers;

use App\Events\ChatMessageSent;
use App\Http\Requests\SendChatMessageRequest;
use App\Http\Resources\ChatMessageResource;
use App\Models\ChatMessage;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

class ChatController extends Controller
{
    // =========================================================================
    // GET /api/sessions/{session}/chat
    // List all chat messages for a session, paginated oldest-first.
    // =========================================================================

    public function index(Request $request, Session $session): AnonymousResourceCollection
    {
        $this->authorizeParticipant($request->user(), $session);

        $messages = ChatMessage::where('session_id', $session->id)
            ->with('sender')
            ->oldest()
            ->paginate($request->integer('per_page', 50));

        return ChatMessageResource::collection($messages);
    }

    // =========================================================================
    // POST /api/sessions/{session}/chat
    // Send a chat message inside an active session.
    // =========================================================================

    public function store(SendChatMessageRequest $request, Session $session): JsonResponse
    {
        $this->authorizeParticipant($request->user(), $session);

        // Guard: only active sessions accept messages
        if (! in_array($session->status->value, ['active', 'in_progress'])) {
            return $this->error(
                'Messages can only be sent during an active session.',
                422
            );
        }

        try {
            $message = ChatMessage::create([
                'session_id'        => $session->id,
                'sender_id'         => $request->user()->id,
                'message'           => $request->validated('message') ?? '',
                'attachments'       => $request->validated('attachments'),
                'is_system_message' => false,
                'delivered_at'      => now(),
            ]);

            $message->load('sender');

            // Broadcast to both session participants in real-time
            ChatMessageSent::dispatch($message);

            return $this->success(
                data: new ChatMessageResource($message),
                message: 'Message sent.',
                status: 201,
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/sessions/{session}/chat/read
    // Mark all unread messages in the session as read for this user.
    // =========================================================================

    public function markRead(Request $request, Session $session): JsonResponse
    {
        $this->authorizeParticipant($request->user(), $session);

        $updated = ChatMessage::where('session_id', $session->id)
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return $this->success(
            data: ['messages_marked_read' => $updated],
            message: "{$updated} message(s) marked as read.",
        );
    }

    // =========================================================================
    // GET /api/sessions/{session}/chat/unread-count
    // Return the count of unread messages for the requesting user.
    // Used by mobile app for badge counts.
    // =========================================================================

    public function unreadCount(Request $request, Session $session): JsonResponse
    {
        $this->authorizeParticipant($request->user(), $session);

        $count = ChatMessage::where('session_id', $session->id)
            ->where('sender_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->count();

        return $this->success(['unread_count' => $count]);
    }

    // =========================================================================
    // SYSTEM MESSAGE HELPER (called internally — not exposed as HTTP endpoint)
    // Creates a system-generated message in a session (e.g. "Session started").
    // =========================================================================

    public static function systemMessage(Session $session, string $text): ChatMessage
    {
        return ChatMessage::create([
            'session_id'        => $session->id,
            'sender_id'         => null,
            'message'           => $text,
            'attachments'       => null,
            'is_system_message' => true,
            'delivered_at'      => now(),
        ]);
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function authorizeParticipant(\App\Models\User $user, Session $session): void
    {
        $session->loadMissing('booking');

        $allowed = $user->role->value === 'admin'
            || $user->id === $session->booking->student_id
            || $user->id === $session->booking->tutor_id;

        if (! $allowed) {
            abort(403, 'You do not have access to this session chat.');
        }
    }

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