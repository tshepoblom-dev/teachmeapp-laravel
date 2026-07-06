<?php

use App\Http\Controllers\Api\Admin\GatewayConfigController;
use App\Http\Controllers\Api\Auth\EmailVerificationController;
use App\Http\Controllers\Api\Invoice\InvoiceController as ApiInvoiceController;
use App\Http\Controllers\Api\Notification\NotificationController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\PasswordResetController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Payment\PaymentController;
use App\Http\Controllers\Api\Payment\WebhookController;
use App\Http\Controllers\Api\Payout\PayoutController;
use App\Http\Controllers\Api\Reference\ReferenceDataController;
use App\Http\Controllers\Api\Report\ReportController as ApiReportController;
use App\Http\Controllers\Api\Review\ReviewController as ApiReviewController;
use App\Http\Controllers\Api\Tutor\AvailabilityController as ApiTutorAvailabilityController;
use App\Http\Controllers\Api\Tutor\DiscoverController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\Wallet\WalletController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\AdminKycController;
use App\Http\Controllers\TierController;
use App\Http\Controllers\AdminTierController;
use App\Http\Controllers\Tutor\TutorAvailabilityController;
use App\Http\Controllers\FcmTokenController;

// ── Public auth ───────────────────────────────────────────────────────────
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('register', RegisterController::class)->name('register');
    Route::post('login', LoginController::class)->name('login');
    Route::post('forgot-password', [PasswordResetController::class, 'sendLink']);
    Route::post('reset-password', [PasswordResetController::class, 'reset']);
});

// ── Webhook — no auth, always 200 ─────────────────────────────────────────
Route::post('payment/webhook/{gateway}', [WebhookController::class, 'handle'])->name('payment.webhook');
Route::get('payment/callback/{gateway}', [PaymentController::class, 'callback'])->name('payment.callback');

// Public — no auth required
Route::get('/tiers', [TierController::class, 'index']);
Route::get('/tiers/{tier}', [TierController::class, 'show']);

// ── Authenticated ─────────────────────────────────────────────────────────
Route::middleware(['auth:sanctum', 'check.account.status'])->group(function () {

    Route::post('auth/logout', LogoutController::class)->name('auth.logout');

    Route::post('fcm-token',    [FcmTokenController::class, 'store']);
    Route::delete('fcm-token',  [FcmTokenController::class, 'destroy']);

    // Mobile parity: notifications list + mark read
    Route::get('notifications', [NotificationController::class, 'index']);
    Route::post('notifications/{id}/read', [NotificationController::class, 'markRead']);
    Route::post('notifications/read-all', [NotificationController::class, 'markAllRead']);

    // Mobile parity: reference data (institutions/subjects dropdowns)
    Route::get('institutions', [ReferenceDataController::class, 'institutions']);
    Route::get('subjects', [ReferenceDataController::class, 'subjects']);

    Route::prefix('email')->name('email.')->group(function () {
        Route::get('verify/status', [EmailVerificationController::class, 'status'])->name('status');
        Route::post('verification-notification', [EmailVerificationController::class, 'send'])->middleware('throttle:6,1')->name('send');
        Route::get('verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->middleware(['signed', 'throttle:6,1'])->name('verify');
    });

    Route::get('user', [ProfileController::class, 'me'])->name('user.me');
    Route::put('user/profile', [ProfileController::class, 'update'])->name('user.profile.update');
    Route::post('user/profile/avatar', [ProfileController::class, 'avatar'])->name('user.profile.avatar');
    Route::put('user/password', [ProfileController::class, 'changePassword'])->name('user.password.change');

    // Phase 3 — Payments
    Route::prefix('payment')->name('payment.')->group(function () {
        Route::get('methods', [PaymentController::class, 'methods'])->name('methods');
        Route::post('deposit', [PaymentController::class, 'deposit'])->name('deposit');
        Route::post('booking/{booking}', [PaymentController::class, 'payBooking'])->name('booking.pay');
        Route::get('transactions', [PaymentController::class, 'transactions'])->name('transactions');
    });

    // Phase 3 — Admin gateway config
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::prefix('payment/gateways')->name('payment.gateways.')->group(function () {
            Route::get('/',                 [GatewayConfigController::class, 'index'])     ->name('index');
            Route::get('{code}',            [GatewayConfigController::class, 'show'])      ->name('show');
            Route::post('{code}/configure', [GatewayConfigController::class, 'configure']) ->name('configure');
            Route::post('{code}/toggle',    [GatewayConfigController::class, 'toggle'])    ->name('toggle');
            Route::post('{code}/test',      [GatewayConfigController::class, 'test'])      ->name('test');
        });
    });


     // -------------------------------------------------------------------------
    // Shared — all authenticated users
    // -------------------------------------------------------------------------

    // List bookings (students see own, tutors see own, admins see all)
    Route::get('/bookings', [BookingController::class, 'index']);

    // View single booking (parties involved + admin only)
    Route::get('/bookings/{booking}', [BookingController::class, 'show']);

    // Upcoming confirmed bookings for dashboard widgets
    Route::get('/bookings/upcoming/list', [BookingController::class, 'upcoming']);

    // Cancel a booking (student, tutor, or admin — BookingService enforces permissions)
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);

    // -------------------------------------------------------------------------
    // Mobile parity: Wallet — shared by students and tutors
    // -------------------------------------------------------------------------

    Route::get('/wallet', [WalletController::class, 'index']);
    Route::get('/wallet/transactions', [WalletController::class, 'transactions']);

    // -------------------------------------------------------------------------
    // Mobile parity: Payout accounts & payouts — student and tutor
    // -------------------------------------------------------------------------

    Route::middleware('role:student,tutor')->group(function () {
        Route::get('/payout/accounts', [PayoutController::class, 'accounts']);
        Route::post('/payout/accounts', [PayoutController::class, 'storeAccount']);
        Route::post('/payout/accounts/{account}/default', [PayoutController::class, 'setDefaultAccount']);
        Route::delete('/payout/accounts/{account}', [PayoutController::class, 'deleteAccount']);
        Route::get('/payout/transactions', [PayoutController::class, 'transactions']);
        Route::post('/payout/request', [PayoutController::class, 'requestPayout']);
        Route::post('/payout/{payout}/cancel', [PayoutController::class, 'cancelPayout']);
    });

    // -------------------------------------------------------------------------
    // Student only
    // -------------------------------------------------------------------------

    Route::middleware('role:student')->group(function () {
        // Create a new booking request
        Route::post('/bookings', [BookingController::class, 'store']);

        // Mobile parity: submit a review for a completed booking
        Route::post('/bookings/{booking}/review', [ApiReviewController::class, 'store']);
    });

    // -------------------------------------------------------------------------
    // Tutor only
    // -------------------------------------------------------------------------

    Route::middleware('role:tutor')->group(function () {
        // List pending booking requests awaiting tutor response
        Route::get('/tutor/bookings/requests', [BookingController::class, 'pendingRequests']);

        // Accept a pending booking (triggers escrow hold)
        Route::post('/bookings/{booking}/accept', [BookingController::class, 'accept']);

        // Decline a pending booking
        Route::post('/bookings/{booking}/decline', [BookingController::class, 'decline']);

        // -------------------------------------------------------------------------
        // Mobile parity: Tutor availability CRUD
        // -------------------------------------------------------------------------

        Route::prefix('tutor/availability')->group(function () {
            Route::get('/', [ApiTutorAvailabilityController::class, 'index']);
            Route::post('/', [ApiTutorAvailabilityController::class, 'store']);
            Route::post('/bulk', [ApiTutorAvailabilityController::class, 'bulkStore']);
            Route::post('/replace', [ApiTutorAvailabilityController::class, 'replaceAll']);
            Route::put('/{slot}', [ApiTutorAvailabilityController::class, 'update']);
            Route::patch('/{slot}/toggle', [ApiTutorAvailabilityController::class, 'toggle']);
            Route::delete('/{slot}', [ApiTutorAvailabilityController::class, 'destroy']);
        });
    });

    // -------------------------------------------------------------------------
    // Public availability — no role restriction, but must be authenticated
    // -------------------------------------------------------------------------

    // Check tutor availability for a date range (used on booking UI)
    // Tutor availability — public read (student booking picker)
Route::get('/tutors/{tutorId}/availability', [TutorAvailabilityController::class, 'publicSlots']);
  // Tutor tier progress
    Route::get('/tutor/tier/progress', [TierController::class, 'myProgress']);

    // -------------------------------------------------------------------------
    // Mobile parity: Tutor discovery (student-facing browse/search)
    // -------------------------------------------------------------------------

    Route::get('/tutors', [DiscoverController::class, 'index']);
    Route::get('/tutors/{tutor}/reviews', [ApiReviewController::class, 'tutorReviews']);
    Route::get('/tutors/{user}', [DiscoverController::class, 'show']);

    // -------------------------------------------------------------------------
    // Admin only
    // -------------------------------------------------------------------------

    Route::middleware('role:admin')->group(function () {
        // Resolve a disputed booking — release to tutor or refund to student
        Route::post('/admin/bookings/{booking}/dispute', [BookingController::class, 'resolveDispute']);
         // Summary stats for dashboard
        Route::get('/admin/kyc/stats', [AdminKycController::class, 'stats']);

        // List all applications with filters
        Route::get('/admin/kyc/applications', [AdminKycController::class, 'index']);

        // View single application with signed document URLs
        Route::get('/admin/kyc/applications/{application}', [AdminKycController::class, 'show']);

        // Flag application as under review
        Route::post('/admin/kyc/applications/{application}/flag', [AdminKycController::class, 'flag']);

        // Approve application
        Route::post('/admin/kyc/applications/{application}/approve', [AdminKycController::class, 'approve']);

        // Reject application
        Route::post('/admin/kyc/applications/{application}/reject', [AdminKycController::class, 'reject']);

        // Refresh signed URL for a specific document
        Route::get('/admin/kyc/documents/{document}/url', [AdminKycController::class, 'documentUrl']);
      // Stats overview
        Route::get('/admin/tiers/stats', [AdminTierController::class, 'stats']);

        // Commission preview calculator
        Route::get('/admin/tiers/commission-preview', [AdminTierController::class, 'commissionPreview']);

        // Re-evaluate all tutors
        Route::post('/admin/tiers/re-evaluate', [AdminTierController::class, 'reEvaluate']);

        // CRUD
        Route::get('/admin/tiers', [AdminTierController::class, 'index']);
        Route::post('/admin/tiers', [AdminTierController::class, 'store']);
        Route::get('/admin/tiers/{tier}', [AdminTierController::class, 'show']);
        Route::put('/admin/tiers/{tier}', [AdminTierController::class, 'update']);
        Route::delete('/admin/tiers/{tier}', [AdminTierController::class, 'destroy']);

        // Actions
        Route::post('/admin/tiers/{tier}/toggle', [AdminTierController::class, 'toggle']);
        Route::post('/admin/tiers/{tier}/assign', [AdminTierController::class, 'assign']);
   
    });

      // -------------------------------------------------------------------------
    // Session — core lifecycle
    // -------------------------------------------------------------------------

    // View session details
    Route::get('/sessions/{session}', [SessionController::class, 'show']);

    // Get session via booking (convenience for booking detail screen)
    Route::get('/bookings/{booking}/session', [SessionController::class, 'showByBooking']);

    // Mobile parity: invoice signed-URL lookup + download
    Route::get('/invoices/{invoice}', [ApiInvoiceController::class, 'show']);
    Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])
        ->middleware('signed')->name('api.invoices.download');

    // Join session — returns Agora token + channel info
    Route::post('/sessions/{session}/join', [SessionController::class, 'join']);

    // Refresh Agora token (called when token is ~5 min from expiry)
    Route::post('/sessions/{session}/token/refresh', [SessionController::class, 'refreshToken']);

    // Keepalive ping — client sends every 30s while in session
    Route::post('/sessions/{session}/keepalive', [SessionController::class, 'keepalive']);

    // -------------------------------------------------------------------------
    // Session — tutor only actions
    // -------------------------------------------------------------------------

    Route::middleware('role:tutor')->group(function () {
        // Tutor starts session — booking moves to in_progress
        Route::post('/sessions/{session}/start', [SessionController::class, 'start']);
    });

    // -------------------------------------------------------------------------
    // Session — either party can end
    // -------------------------------------------------------------------------

    // End session — triggers escrow release
    Route::post('/sessions/{session}/end', [SessionController::class, 'end']);

    // Mobile parity: submit an in-session incident report
    Route::post('/sessions/{session}/report', [ApiReportController::class, 'store']);

    // -------------------------------------------------------------------------
    // Chat
    // -------------------------------------------------------------------------

    // List messages (paginated, oldest first)
    Route::get('/sessions/{session}/chat', [ChatController::class, 'index']);

    // Send a message
    Route::post('/sessions/{session}/chat', [ChatController::class, 'store']);

    // Mark all messages as read
    Route::post('/sessions/{session}/chat/read', [ChatController::class, 'markRead']);

    // Get unread message count (for badge)
    Route::get('/sessions/{session}/chat/unread', [ChatController::class, 'unreadCount']);

    // -------------------------------------------------------------------------
    // Polls
    // -------------------------------------------------------------------------

    // List all polls in session
    Route::get('/sessions/{session}/polls', [PollController::class, 'index']);

    // Create a new poll
    Route::post('/sessions/{session}/polls', [PollController::class, 'store']);

    // View single poll with results
    Route::get('/sessions/{session}/polls/{poll}', [PollController::class, 'show']);

    // Submit a poll response
    Route::post('/sessions/{session}/polls/{poll}/respond', [PollController::class, 'respond']);

    // Close a poll (creator or admin)
    Route::post('/sessions/{session}/polls/{poll}/close', [PollController::class, 'close']);

     // Check current KYC status and missing documents
    Route::get('/kyc/status', [KycController::class, 'status']);

    // Start a new KYC application
    Route::post('/kyc/apply', [KycController::class, 'apply']);

    // Upload a document to active application
    Route::post('/kyc/documents', [KycController::class, 'uploadDocument']);

    // Delete a document from a pending application
    Route::delete('/kyc/documents/{document}', [KycController::class, 'deleteDocument']);

    // -------------------------------------------------------------------------
    // Admin facing
    // -------------------------------------------------------------------------

});
