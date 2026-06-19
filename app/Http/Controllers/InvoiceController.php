<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\InvoiceService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InvoiceController extends Controller
{
    public function __construct(private readonly InvoiceService $invoiceService) {}

    /**
     * Issue a short-lived signed download URL for an invoice.
     * Both student and tutor on the booking may request this.
     */
    public function show(Request $request, Invoice $invoice): \Illuminate\Http\JsonResponse
    {
        $this->authorise($request, $invoice);

        return response()->json([
            'url'        => $this->invoiceService->signedDownloadUrl($invoice),
            'expires_in' => 7200, // seconds
        ]);
    }

    /**
     * Stream the PDF to the browser.
     * Only reachable via a valid signed URL (enforced by route middleware).
     */
    public function download(Request $request, Invoice $invoice): StreamedResponse
    {
        // Signed URL already validated by the `signed` middleware on the route.
        // Still check the user is the student or tutor as a belt-and-braces guard.
        $this->authorise($request, $invoice);

        $content  = $this->invoiceService->pdfContent($invoice);
        $filename = "{$invoice->invoice_number}.pdf";

        return response()->stream(function () use ($content) {
            echo $content;
        }, 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Content-Length'      => strlen($content),
            'Cache-Control'       => 'private, no-store',
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