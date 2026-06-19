<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePollRequest;
use App\Http\Requests\SubmitPollResponseRequest;
use App\Http\Resources\PollResource;
use App\Models\PollResponse;
use App\Models\Session;
use App\Models\SessionPoll;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Throwable;

class PollController extends Controller
{
    // =========================================================================
    // GET /api/sessions/{session}/polls
    // List all polls for a session.
    // =========================================================================

    public function index(Request $request, Session $session): AnonymousResourceCollection
    {
        $this->authorizeParticipant($request->user(), $session);

        $polls = SessionPoll::where('session_id', $session->id)
            ->with(['creator', 'responses'])
            ->latest()
            ->get();

        return PollResource::collection($polls);
    }

    // =========================================================================
    // POST /api/sessions/{session}/polls
    // Create a new poll during an active session.
    // Both tutors and students can create polls.
    // =========================================================================

    public function store(CreatePollRequest $request, Session $session): JsonResponse
    {
        $this->authorizeParticipant($request->user(), $session);

        if ($session->status->value !== 'active') {
            return $this->error('Polls can only be created during an active session.', 422);
        }

        try {
            $poll = SessionPoll::create([
                'session_id'  => $session->id,
                'question'    => $request->validated('question'),
                'options'     => $request->validated('options'),
                'created_by'  => $request->user()->id,
                'status'      => 'active',
                'results'     => null,
            ]);

            $poll->load(['creator', 'responses']);

            return $this->success(
                data: new PollResource($poll),
                message: 'Poll created.',
                status: 201,
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // GET /api/sessions/{session}/polls/{poll}
    // View a single poll with current results.
    // =========================================================================

    public function show(Request $request, Session $session, SessionPoll $poll): JsonResponse
    {
        $this->authorizeParticipant($request->user(), $session);
        $this->assertPollBelongsToSession($poll, $session);

        $poll->load(['creator', 'responses']);

        return $this->success(new PollResource($poll));
    }

    // =========================================================================
    // POST /api/sessions/{session}/polls/{poll}/respond
    // Submit a response to a poll.
    // Each user can only respond once — subsequent calls update their response.
    // =========================================================================

    public function respond(
        SubmitPollResponseRequest $request,
        Session                   $session,
        SessionPoll               $poll,
    ): JsonResponse {
        $this->authorizeParticipant($request->user(), $session);
        $this->assertPollBelongsToSession($poll, $session);

        if ($poll->status !== 'active') {
            return $this->error('This poll is no longer accepting responses.', 422);
        }

        try {
            DB::transaction(function () use ($request, $poll) {
                PollResponse::updateOrCreate(
                    [
                        'poll_id' => $poll->id,
                        'user_id' => $request->user()->id,
                    ],
                    [
                        'response'     => $request->validated('response'),
                        'responded_at' => now(),
                    ]
                );
            });

            $poll->load(['creator', 'responses']);

            return $this->success(
                data: new PollResource($poll),
                message: 'Response submitted.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // POST /api/sessions/{session}/polls/{poll}/close
    // Close a poll — only the poll creator or an admin can close it.
    // Computes and stores final aggregated results.
    // =========================================================================

    public function close(Request $request, Session $session, SessionPoll $poll): JsonResponse
    {
        $this->authorizeParticipant($request->user(), $session);
        $this->assertPollBelongsToSession($poll, $session);

        $user = $request->user();

        // Only poll creator or admin can close
        $canClose = $user->role->value === 'admin'
            || $user->id === $poll->created_by;

        if (! $canClose) {
            return $this->error('Only the poll creator can close this poll.', 403);
        }

        if ($poll->status === 'closed') {
            return $this->error('This poll is already closed.', 422);
        }

        try {
            DB::transaction(function () use ($poll) {
                $poll->load('responses');

                // Compute and snapshot final results
                $responses = $poll->responses;
                $total     = $responses->count();

                $results = collect($poll->options)->mapWithKeys(function ($option) use ($responses, $total) {
                    $count = $responses
                        ->flatMap(fn ($r) => (array) $r->response)
                        ->filter(fn ($s) => $s === $option)
                        ->count();

                    return [
                        $option => [
                            'count'      => $count,
                            'percentage' => $total > 0
                                ? round(($count / $total) * 100, 1)
                                : 0,
                        ],
                    ];
                })->toArray();

                $poll->update([
                    'status'  => 'closed',
                    'results' => $results,
                ]);
            });

            $poll->load(['creator', 'responses']);

            return $this->success(
                data: new PollResource($poll),
                message: 'Poll closed. Results have been computed.',
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), 422);
        }
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    private function assertPollBelongsToSession(SessionPoll $poll, Session $session): void
    {
        if ($poll->session_id !== $session->id) {
            abort(404, 'Poll not found in this session.');
        }
    }

    private function authorizeParticipant(\App\Models\User $user, Session $session): void
    {
        $session->loadMissing('booking');

        $allowed = $user->role->value === 'admin'
            || $user->id === $session->booking->student_id
            || $user->id === $session->booking->tutor_id;

        if (! $allowed) {
            abort(403, 'You do not have access to this session.');
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