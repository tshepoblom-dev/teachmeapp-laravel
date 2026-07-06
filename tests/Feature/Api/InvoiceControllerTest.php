<?php

namespace Tests\Feature\Api;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InvoiceControllerTest extends TestCase
{
    use RefreshDatabase;

    private function makeInvoice(User $student, User $tutor): Invoice
    {
        $booking = Booking::create([
            'student_id' => $student->id,
            'tutor_id' => $tutor->id,
            'subject' => 'Maths',
            'scheduled_at' => now()->subDay(),
            'duration_minutes' => 60,
            'hourly_rate_snapshot' => 100,
            'total_amount' => 100,
            'platform_fee_snapshot' => 10,
            'status' => 'completed',
        ]);

        Storage::fake('private');
        Storage::disk('private')->put('invoices/INV-TEST-1.pdf', '%PDF-1.4 fake content');

        return Invoice::create([
            'booking_id' => $booking->id,
            'student_id' => $student->id,
            'tutor_id' => $tutor->id,
            'invoice_number' => 'INV-TEST-1',
            'amount' => 100,
            'vat_amount' => 15,
            'total_amount' => 115,
            'status' => 'paid',
            'pdf_url' => 'invoices/INV-TEST-1.pdf',
            'paid_at' => now(),
        ]);
    }

    public function test_student_or_tutor_can_get_signed_url(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $invoice = $this->makeInvoice($student, $tutor);

        $response = $this->actingAs($student)->getJson("/api/invoices/{$invoice->id}");

        $response->assertOk();
        $url = $response->json('data.url');
        $this->assertStringContainsString('/api/invoices/', $url);
        $this->assertStringContainsString('signature=', $url);
    }

    public function test_third_party_forbidden(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $outsider = User::factory()->create(['role' => 'student']);
        $invoice = $this->makeInvoice($student, $tutor);

        $this->actingAs($outsider)->getJson("/api/invoices/{$invoice->id}")->assertForbidden();
    }

    public function test_signed_url_download_streams_pdf(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $invoice = $this->makeInvoice($student, $tutor);

        $signedUrl = $this->actingAs($student)->getJson("/api/invoices/{$invoice->id}")->json('data.url');

        $response = $this->actingAs($student)->get($signedUrl);

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    public function test_tampered_signature_rejected(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $tutor = User::factory()->create(['role' => 'tutor']);
        $invoice = $this->makeInvoice($student, $tutor);

        $signedUrl = $this->actingAs($student)->getJson("/api/invoices/{$invoice->id}")->json('data.url');
        $tampered = $signedUrl . '0';

        $this->actingAs($student)->get($tampered)->assertForbidden();
    }
}
