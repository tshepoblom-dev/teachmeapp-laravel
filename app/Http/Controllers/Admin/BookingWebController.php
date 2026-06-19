<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\BookingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BookingWebController extends Controller
{
    public function __construct(
        private readonly BookingService $bookingService,
    ) {}

    public function index(Request $request): Response
    { 
        $bookings = Booking::with(['student:id,name', 'tutor:id,name'])
            ->when($request->search, fn ($q) =>
                $q->where('subject', 'like', "%{$request->search}%")
            )
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString()
            ->through(fn ($b) => [
                'id'           => $b->id,
                'status'       => $b->status->value,
                'subject'      => $b->subject,
                'total_amount' => (float) $b->total_amount,
                'scheduled_at' => $b->scheduled_at?->copy()->setTimezone(config('app.local_timezone'))->toIso8601String(),
                'student'      => $b->student?->name,
                'tutor'        => $b->tutor?->name,
                'created_at'   => $b->created_at->toDateString(),
            ]);

        return Inertia::render('Admin/Bookings/Index', [
            'bookings'   => $bookings,
            'filters'    => $request->only(['search', 'status']),
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function show(Booking $booking): Response
    {
        $booking->load([
            'student:id,name,email',
            'tutor:id,name,email',
            'session',
            'escrowTransaction',
            'review',
        ]);

        return Inertia::render('Admin/Bookings/Show', [
            'booking'    => $booking,
            'pendingKyc' => \App\Models\KycApplication::where('status', 'pending')->count(),
        ]);
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        $request->validate(['reason' => ['required', 'string', 'max:500']]);

        try {
            $this->bookingService->cancel($booking, $request->user(), $request->reason);
            return back()->with('success', 'Booking cancelled.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function resolveDispute(Request $request, Booking $booking): RedirectResponse
    {
        $request->validate([
            'action' => ['required', 'in:release,refund'],
            'reason' => ['required', 'string', 'max:1000'],
        ]);

        try {
           /* if ($request->action === 'release') {
                $this->bookingService->complete($booking, "Admin release: {$request->reason}");
                $msg = 'Escrow released to tutor.';
            } else {
                $this->bookingService->cancel($booking, $request->user(), "Admin refund: {$request->reason}");
                $msg = 'Escrow refunded to student.';
            }*/

            $this->bookingService->resolveDispute($booking, $request->user(), $request->action, $request->reason);

            //return back()->with('success', $msg);
            return back()->with('success', 'Dispute resolved.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}