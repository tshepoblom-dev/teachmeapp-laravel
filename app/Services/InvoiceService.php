<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use RuntimeException;

/**
 * InvoiceService
 *
 * - Generates a PDF invoice on booking completion
 * - Stores it to the private disk (never publicly accessible)
 * - Issues short-lived signed URLs for authorised downloads
 */
class InvoiceService
{
    private const DISK          = 'private';
    private const VAT_RATE      = 0.15;   // 15% VAT — adjust or make configurable
    private const URL_TTL_HOURS = 2;

    // ─── Generate ─────────────────────────────────────────────────────────────

    /**
     * Generate and store the invoice PDF for a completed booking.
     * Idempotent — returns the existing invoice if one already exists.
     */
    public function generateForBooking(Booking $booking): Invoice
    {
        // Idempotency — one invoice per booking
        if ($existing = Invoice::where('booking_id', $booking->id)->first()) {
            return $existing;
        }

        $booking->loadMissing(['student', 'tutor.profile']);

        $invoiceNumber = $this->nextInvoiceNumber();
        $amount        = (float) $booking->total_amount;
        $vatAmount     = round($amount * self::VAT_RATE, 2);
        $total         = round($amount + $vatAmount, 2);

        // Build PDF
        $pdf = Pdf::loadView('invoices.invoice', [
            'invoiceNumber' => $invoiceNumber,
            'booking'       => $booking,
            'student'       => $booking->student,
            'tutor'         => $booking->tutor,
            'amount'        => $amount,
            'vatAmount'     => $vatAmount,
            'vatRate'       => self::VAT_RATE * 100,
            'total'         => $total,
            // Both values converted to local display timezone (SAST) so that
            // Blade's ->format() calls render the correct local time on the PDF.
            'issuedAt'      => now()->setTimezone(config('app.local_timezone')),
            'scheduledAt'   => $booking->scheduled_at->copy()->setTimezone(config('app.local_timezone')),
        ])->setPaper('a4');

        // Store to private disk
        $path = "invoices/{$invoiceNumber}.pdf";
        Storage::disk(self::DISK)->put($path, $pdf->output());

        $invoice = Invoice::create([
            'booking_id'     => $booking->id,
            'student_id'     => $booking->student_id,
            'tutor_id'       => $booking->tutor_id,
            'invoice_number' => $invoiceNumber,
            'amount'         => $amount,
            'vat_amount'     => $vatAmount,
            'total_amount'   => $total,
            'status'         => 'paid',
            'pdf_path'       => $path,
            'paid_at'        => now(),
        ]);

        Log::info('Invoice generated', [
            'invoice_id'     => $invoice->id,
            'invoice_number' => $invoiceNumber,
            'booking_id'     => $booking->id,
        ]);

        return $invoice;
    }

    // ─── Download ─────────────────────────────────────────────────────────────

    /**
     * Issue a signed URL valid for TTL_HOURS that serves the invoice PDF.
     * The controller validates the signature before streaming the file.
     */
    public function signedDownloadUrl(Invoice $invoice): string
    {
        return URL::signedRoute(
            'invoices.download',
            ['invoice' => $invoice->id],
            now()->addHours(self::URL_TTL_HOURS)
        );
    }

    /**
     * Return the raw PDF content from private storage.
     *
     * @throws RuntimeException if the file is missing from disk.
     */
    public function pdfContent(Invoice $invoice): string
    {
        if (! Storage::disk(self::DISK)->exists($invoice->pdf_path)) {
            throw new RuntimeException("Invoice PDF not found on disk: {$invoice->pdf_path}");
        }

        return Storage::disk(self::DISK)->get($invoice->pdf_path);
    }

    // ─── Void ─────────────────────────────────────────────────────────────────

    /**
     * Void an invoice (e.g. on dispute resolution).
     * File is retained on disk for audit purposes.
     */
    public function void(Invoice $invoice): Invoice
    {
        $invoice->update(['status' => 'void']);

        Log::info('Invoice voided', [
            'invoice_id'     => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
            'booking_id'     => $invoice->booking_id,
        ]);

        return $invoice->fresh();
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function nextInvoiceNumber(): string
    {
        $year = now()->year;
        $last = Invoice::whereYear('created_at', $year)->lockForUpdate()->count();
        $seq  = str_pad($last + 1, 5, '0', STR_PAD_LEFT);
        return "INV-{$year}-{$seq}";
    }
}