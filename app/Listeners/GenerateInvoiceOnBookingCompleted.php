<?php

namespace App\Listeners;

use App\Events\BookingCompleted;
use App\Services\InvoiceService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Throwable;

class GenerateInvoiceOnBookingCompleted implements ShouldQueue
{
    use InteractsWithQueue;

    public string $queue = 'invoices';

    public function __construct(private readonly InvoiceService $invoiceService) {}

    public function handle(BookingCompleted $event): void
    {
        $invoice = $this->invoiceService->generateForBooking($event->booking);

        Log::info('Invoice generated for completed booking', [
            'booking_id'     => $event->booking->id,
            'invoice_id'     => $invoice->id,
            'invoice_number' => $invoice->invoice_number,
        ]);
    }

    public function failed(BookingCompleted $event, Throwable $e): void
    {
        Log::error('Invoice generation failed', [
            'booking_id' => $event->booking->id,
            'error'      => $e->getMessage(),
        ]);
    }
}