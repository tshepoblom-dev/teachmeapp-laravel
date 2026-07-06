<?php

namespace App\Http\Controllers\Api\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Services\InvoiceService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    use ApiResponse;

    public function __construct(private readonly InvoiceService $invoiceService) {}

    // ── GET /api/invoices/{invoice} ───────────────────────────────────────────

    public function show(Request $request, Invoice $invoice): JsonResponse
    {
        $this->authorise($request, $invoice);

        return $this->success([
            'url'        => $this->invoiceService->signedDownloadUrl($invoice, 'api.invoices.download'),
            'expires_in' => 7200,
        ]);
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    private function authorise(Request $request, Invoice $invoice): void
    {
        $user = $request->user();

        abort_unless(
            $user && in_array($user->id, [$invoice->student_id, $invoice->tutor_id], true),
            403,
            'You do not have permission to access this invoice.'
        );
    }
}
