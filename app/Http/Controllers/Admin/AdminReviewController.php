<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KycApplication;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class AdminReviewController extends Controller
{
    public function __construct(private readonly ReviewService $reviewService) {}

    // ─── Index ────────────────────────────────────────────────────────────────

    public function index(Request $request): Response
    {
        $reviews = Review::with([
            'reviewer:id,name,email',
            'reviewee:id,name,email',
            'booking:id,subject,scheduled_at',
        ])
        ->when($request->visibility, function ($q) use ($request) {
            match ($request->visibility) {
                'hidden'  => $q->where('is_visible', false),
                'visible' => $q->where('is_visible', true),
                default   => null,
            };
        })
        ->when($request->rating, fn ($q) => $q->where('rating', $request->rating))
        ->when($request->search, fn ($q) => $q->whereHas(
            'reviewer', fn ($u) => $u->where('name', 'like', "%{$request->search}%")
        ))
        ->orderByDesc('created_at')
        ->paginate(25)
        ->withQueryString()
        ->through(fn ($r) => [
            'id'          => $r->id,
            'rating'      => $r->rating,
            'comment'     => $r->comment,
            'tags'        => $r->tags ?? [],
            'is_visible'  => $r->is_visible,
            'reviewer'    => $r->reviewer?->name,
            'reviewer_email' => $r->reviewer?->email,
            'reviewee'    => $r->reviewee?->name,
            'reviewee_email' => $r->reviewee?->email,
            'subject'     => $r->booking?->subject,
            'booking_id'  => $r->booking_id,
            'reviewed_at' => $r->reviewed_at?->toDateString(),
            'created_at'  => $r->created_at->toDateString(),
        ]);

        $stats = [
            'total'   => Review::count(),
            'visible' => Review::where('is_visible', true)->count(),
            'hidden'  => Review::where('is_visible', false)->count(),
            'avg'     => round((float) Review::where('is_visible', true)->avg('rating'), 2),
        ];

        return Inertia::render('Admin/Reviews/Index', [
            'reviews'    => $reviews,
            'stats'      => $stats,
            'filters'    => $request->only(['visibility', 'rating', 'search']),
            'pendingKyc' => KycApplication::where('status', 'pending')->count(),
        ]);
    }

    // ─── Moderation actions ───────────────────────────────────────────────────

    public function hide(Request $request, Review $review): RedirectResponse
    {
        try {
            $this->reviewService->hide($review, $request->user());
            return back()->with('success', "Review #{$review->id} hidden. Tutor rating recalculated.");
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function restore(Request $request, Review $review): RedirectResponse
    {
        try {
            $this->reviewService->restore($review, $request->user());
            return back()->with('success', "Review #{$review->id} restored. Tutor rating recalculated.");
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Request $request, Review $review): RedirectResponse
    {
        try {
            $this->reviewService->delete($review, $request->user());
            return back()->with('success', "Review #{$review->id} permanently deleted.");
        } catch (RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}