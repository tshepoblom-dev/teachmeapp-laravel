<?php

namespace App\Http\Controllers\Api\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\SubmitReportRequest;
use App\Http\Resources\ReportResource;
use App\Models\Session;
use App\Services\ReportService;
use App\Services\SessionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class ReportController extends Controller
{
    use ApiResponse;

    public function __construct(
        private readonly ReportService $reportService,
        private readonly SessionService $sessionService,
    ) {}

    // ── POST /api/sessions/{session}/report ───────────────────────────────────

    public function store(SubmitReportRequest $request, Session $session): JsonResponse
    {
        $data = $request->validated();

        try {
            $report = $this->reportService->submit($request->user(), $session, $data);
        } catch (RuntimeException $e) {
            return $this->error($e->getMessage(), 403);
        }

        if ($data['action_taken'] === 'end_session') {
            if (in_array($session->status->value, ['waiting', 'active', 'in_progress'], true)) {
                $this->sessionService->end(
                    session: $session,
                    endedBy: $request->user(),
                    reason: 'Ended by participant after submitting a report.',
                );
            }

            return $this->success(new ReportResource($report), 'Report submitted and session ended. Our team will review it shortly.', 201);
        }

        return $this->success(new ReportResource($report), 'Report submitted. Our team will review it shortly.', 201);
    }
}
