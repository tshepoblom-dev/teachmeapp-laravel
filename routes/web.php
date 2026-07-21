<?php

use App\Http\Controllers\Admin\BroadcastNotificationController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\AuthWebController;
use App\Http\Controllers\Admin\BookingWebController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FinancialReportController;
use App\Http\Controllers\Admin\AdminKycWebController;
use App\Http\Controllers\Admin\GatewayWebController;
use App\Http\Controllers\Admin\PayoutWebController;
use App\Http\Controllers\Admin\ReportWebController;
use App\Http\Controllers\Admin\SessionMonitorController;
use App\Http\Controllers\Admin\SettingsWebController;
use App\Http\Controllers\Admin\TierWebController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Broadcast;
use App\Http\Controllers\Tutor\TutorDashboardController;
use App\Http\Controllers\Tutor\TutorAvailabilityController;
use App\Http\Controllers\Tutor\TutorBookingController;
use App\Http\Controllers\Tutor\TutorSessionController;
use App\Http\Controllers\Student\StudentProfileController;
use App\Http\Controllers\Tutor\TutorWalletController;
use App\Http\Controllers\Tutor\TutorProfileController;
use App\Http\Controllers\Tutor\TutorKycController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentDiscoverController;
use App\Http\Controllers\Student\StudentBookingController;
use App\Http\Controllers\Student\StudentWalletController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\Admin\AdminReviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\NotificationPreferenceController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Legal\LegalController;
use App\Http\Controllers\Legal\ConsentController;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\SubjectController;

// Note: Broadcast::routes() is already registered above with ['web','auth'] middleware.

// =============================================================================
// ROOT
// =============================================================================

// Landing pages (no auth required)
Route::get('/', fn () => inertia('Home'))->name('home');
Route::get('/how-it-works', fn () => inertia('HowItWorks'))->name('how-it-works');
Route::get('/pricing', fn () => inertia('Pricing'))->name('pricing');
// =============================================================================
// AUTH (guest only)
// =============================================================================

Route::get('/login',    [AuthWebController::class, 'showLogin'])   ->name('login');
Route::post('/login',   [AuthWebController::class, 'login'])       ->name('login.post');
Route::get('/register', [AuthWebController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthWebController::class, 'register'])    ->name('register.post');

Route::get('/forgot-password',        [AuthWebController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password',       [AuthWebController::class, 'sendResetLink'])     ->name('password.email');
Route::get('/reset-password/{token}', [AuthWebController::class, 'showResetPassword']) ->name('password.reset');
Route::post('/reset-password',        [AuthWebController::class, 'resetPassword'])     ->name('password.update');
// ── Legal — always public ─────────────────────────────────────────────────
Route::get('/legal/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/legal/terms',   [LegalController::class, 'terms'])  ->name('legal.terms');

// ── Consent gate — authenticated users who haven't accepted yet ───────────
Route::middleware('auth')->group(function () {
    Route::get('/consent',  [ConsentController::class, 'show']) ->name('consent.show');
    Route::post('/consent', [ConsentController::class, 'store'])->name('consent.store');

    Route::get('/email/verify', [AuthWebController::class, 'verificationNotice'])
        ->name('verification.notice');

    Route::post('/logout', [AuthWebController::class, 'logout'])
        ->name('logout');
    Route::post('/sessions/{session}/chat', [ChatController::class, 'store'])->middleware(['auth:sanctum', 'check.account.status'])->name('sessions.chat.send');

});


// Signed link that lands from the user's inbox
Route::get('/email/verify/{id}/{hash}', [AuthWebController::class, 'verificationVerify'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

// Re-send the verification email
Route::post('/email/verification-notification', [AuthWebController::class, 'verificationResend'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// =============================================================================
// ADMIN WEB PANEL
// =============================================================================

Route::middleware(['auth', 'verified', 'check.account.status', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/',                   [UserManagementController::class, 'index'])   ->name('index');
            Route::get('/{user}',             [UserManagementController::class, 'show'])    ->name('show');
            Route::post('/{user}/suspend',         [UserManagementController::class, 'suspend'])              ->name('suspend');
            Route::post('/{user}/ban',             [UserManagementController::class, 'ban'])                 ->name('ban');
            Route::post('/{user}/activate',        [UserManagementController::class, 'activate'])            ->name('activate');
            Route::post('/{user}/update-password', [UserManagementController::class, 'updatePassword'])      ->name('update-password');
            Route::post('/{user}/send-reset-link', [UserManagementController::class, 'sendPasswordResetLink'])->name('send-reset-link');
            Route::delete('/{user}',                [UserManagementController::class, 'destroy'])                ->name('destroy');
        });
    // Institutions
        Route::prefix('institutions')->name('institutions.')->group(function () {
            Route::get('/',                  [InstitutionController::class, 'index'])  ->name('index');
            Route::post('/',                 [InstitutionController::class, 'store'])  ->name('store');
            Route::put('/{institution}',     [InstitutionController::class, 'update']) ->name('update');
            Route::delete('/{institution}',  [InstitutionController::class, 'destroy'])->name('destroy');
        });

        // Subjects
        Route::prefix('subjects')->name('subjects.')->group(function () {
            Route::get('/',             [SubjectController::class, 'index'])  ->name('index');
            Route::post('/',            [SubjectController::class, 'store'])  ->name('store');
            Route::put('/{subject}',    [SubjectController::class, 'update']) ->name('update');
            Route::delete('/{subject}', [SubjectController::class, 'destroy'])->name('destroy');
        });

        // KYC
        Route::prefix('kyc')->name('kyc.')->group(function () {
            Route::get('/',                        [AdminKycWebController::class, 'index'])   ->name('index');
            Route::get('/{application}',           [AdminKycWebController::class, 'show'])    ->name('show');
            Route::post('/{application}/approve',  [AdminKycWebController::class, 'approve']) ->name('approve');
            Route::post('/{application}/reject',   [AdminKycWebController::class, 'reject'])  ->name('reject');
        });

        // Sessions
        Route::prefix('sessions')->name('sessions.')->group(function () {
            Route::get('/',                   [SessionMonitorController::class, 'index'])    ->name('index');
            Route::post('/{session}/force-end',[SessionMonitorController::class, 'forceEnd'])->name('force-end');
        });

        // Payouts
        Route::get('/payouts',                              [PayoutWebController::class, 'index'])          ->name('payouts.index');
        Route::post('/payouts/{payout}/processing',         [PayoutWebController::class, 'markProcessing']) ->name('payouts.processing');
        Route::post('/payouts/{payout}/complete',           [PayoutWebController::class, 'markCompleted'])  ->name('payouts.complete');
        Route::post('/payouts/{payout}/fail',               [PayoutWebController::class, 'markFailed'])     ->name('payouts.fail');
        Route::post('/payout-accounts/{account}/verify',    [PayoutWebController::class, 'verifyAccount'])  ->name('payout-accounts.verify');
        Route::post('/payout-accounts/{account}/unverify',  [PayoutWebController::class, 'unverifyAccount'])->name('payout-accounts.unverify');

        // Gateways
        Route::prefix('gateways')->name('gateways.')->group(function () {
            Route::get('/',                    [GatewayWebController::class, 'index'])    ->name('index');
            Route::get('/{method}',            [GatewayWebController::class, 'show'])    ->name('show');
            Route::post('/{method}/configure', [GatewayWebController::class, 'configure'])->name('configure');
            Route::post('/{method}/toggle',    [GatewayWebController::class, 'toggle'])  ->name('toggle');
        });

        // Tiers
        Route::prefix('tiers')->name('tiers.')->group(function () {
            Route::get('/',              [TierWebController::class, 'index'])  ->name('index');
            Route::get('/create',        [TierWebController::class, 'create']) ->name('create');
            Route::post('/',             [TierWebController::class, 'store'])  ->name('store');
            Route::get('/{tier}/edit',   [TierWebController::class, 'edit'])   ->name('edit');
            Route::put('/{tier}',        [TierWebController::class, 'update']) ->name('update');
            Route::delete('/{tier}',     [TierWebController::class, 'destroy'])->name('destroy');
            Route::post('/{tier}/toggle',[TierWebController::class, 'toggle']) ->name('toggle');
        });

        // Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/',        [SettingsWebController::class, 'index']) ->name('index');
            Route::post('/update', [SettingsWebController::class, 'update'])->name('update');
        });

        // Bookings
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/',                            [BookingWebController::class, 'index'])        ->name('index');
            Route::get('/{booking}',                   [BookingWebController::class, 'show'])         ->name('show');
            Route::post('/{booking}/cancel',           [BookingWebController::class, 'cancel'])       ->name('cancel');
            Route::post('/{booking}/resolve-dispute',  [BookingWebController::class, 'resolveDispute'])->name('resolve-dispute');
        });

        // Financials
        Route::get('/financials', [FinancialReportController::class, 'index'])->name('financials.index');

        // Audit Logs
        Route::get('/audit', [AuditLogController::class, 'index'])->name('audit.index');

        // ── Broadcast Notifications ──────────────────────────────────────────
        Route::prefix('notifications')->name('notifications.')->group(function () {
            Route::get('/broadcast',              [BroadcastNotificationController::class, 'index'])       ->name('broadcast');
            Route::post('/broadcast',             [BroadcastNotificationController::class, 'send'])        ->name('broadcast.send');
            Route::get('/broadcast/search-users', [BroadcastNotificationController::class, 'searchUsers']) ->name('broadcast.search-users');
        });

        // Reviews moderation
        Route::get('/reviews',                      [AdminReviewController::class, 'index'])  ->name('reviews.index');
        Route::patch('/reviews/{review}/hide',      [AdminReviewController::class, 'hide'])   ->name('reviews.hide');
        Route::patch('/reviews/{review}/restore',   [AdminReviewController::class, 'restore'])->name('reviews.restore');
        Route::delete('/reviews/{review}',          [AdminReviewController::class, 'destroy'])->name('reviews.destroy');

        Route::get('/reports',                         [ReportWebController::class, 'index'])          ->name('reports.index');
        Route::patch('/reports/{report}/under-review', [ReportWebController::class, 'markUnderReview'])->name('reports.under-review');
        Route::post('/reports/{report}/warn',          [ReportWebController::class, 'warn'])           ->name('reports.warn');
        Route::post('/reports/{report}/suspend',       [ReportWebController::class, 'suspend'])        ->name('reports.suspend');
        Route::post('/reports/{report}/dismiss',       [ReportWebController::class, 'dismiss'])        ->name('reports.dismiss');
    });

    // =============================================================================
// TUTOR WEB PANEL
// =============================================================================

Route::middleware(['auth', 'verified', 'check.account.status', 'role:tutor'])
    ->prefix('tutor')
    ->name('tutor.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [TutorDashboardController::class, 'index'])->name('dashboard');

        // Profile
        Route::get('/profile',        [TutorProfileController::class, 'edit'])  ->name('profile.edit');
        Route::post('/profile',       [TutorProfileController::class, 'update'])->name('profile.update');
        // Inside the tutor middleware group (after the existing profile routes):
        Route::post('/profile/avatar', [TutorProfileController::class, 'uploadAvatar'])->name('profile.avatar');

      // Availability — full CRUD
        Route::get('/availability',                  [TutorAvailabilityController::class, 'index'])      ->name('availability.index');
        Route::post('/availability',                 [TutorAvailabilityController::class, 'store'])      ->name('availability.store');
        Route::post('/availability/bulk',            [TutorAvailabilityController::class, 'bulkStore'])  ->name('availability.bulk');
        Route::post('/availability/replace',         [TutorAvailabilityController::class, 'replaceAll']) ->name('availability.replace');
        Route::put('/availability/{slot}',           [TutorAvailabilityController::class, 'update'])     ->name('availability.update');
        Route::patch('/availability/{slot}/toggle',  [TutorAvailabilityController::class, 'toggle'])     ->name('availability.toggle');
        Route::delete('/availability/{slot}',        [TutorAvailabilityController::class, 'destroy'])    ->name('availability.destroy');
        // Bookings
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/',                        [TutorBookingController::class, 'index'])  ->name('index');
            Route::get('/requests',                [TutorBookingController::class, 'requests'])->name('requests');
            Route::get('/{booking}',               [TutorBookingController::class, 'show'])   ->name('show');
            Route::post('/{booking}/accept',       [TutorBookingController::class, 'accept']) ->name('accept');
            Route::post('/{booking}/decline',      [TutorBookingController::class, 'decline'])->name('decline');
            Route::post('/{booking}/cancel',       [TutorBookingController::class, 'cancel']) ->name('cancel');
        });

        // Sessions
        Route::prefix('sessions')->name('sessions.')->group(function () {
            Route::get('/{session}',       [TutorSessionController::class, 'show'])  ->name('show');
            Route::post('/{session}/start',[TutorSessionController::class, 'start']) ->name('start');
            Route::post('/{session}/end',  [TutorSessionController::class, 'end'])   ->name('end');
        });
        // Wallet & payouts
        Route::get('/wallet',                             [TutorWalletController::class, 'index'])            ->name('wallet.index');
        Route::get('/wallet/payouts',                     [TutorWalletController::class, 'payouts'])          ->name('wallet.payouts');
        Route::post('/wallet/payout/request',             [TutorWalletController::class, 'requestPayout'])    ->name('wallet.payout.request');
        Route::post('/wallet/payout/{payout}/cancel',     [TutorWalletController::class, 'cancelPayout'])     ->name('wallet.payout.cancel');
        Route::post('/wallet/accounts',                   [TutorWalletController::class, 'savePayoutAccount'])->name('wallet.payout-account.store');
        Route::post('/wallet/accounts/{account}/default', [TutorWalletController::class, 'setDefaultAccount'])->name('wallet.payout-account.default');
        Route::delete('/wallet/accounts/{account}',       [TutorWalletController::class, 'deletePayoutAccount'])->name('wallet.payout-account.delete');
        // KYC
        Route::prefix('kyc')->name('kyc.')->group(function () {
            Route::get('/',                      [TutorKycController::class, 'index'])         ->name('index');
            Route::post('/apply',                [TutorKycController::class, 'apply'])         ->name('apply');
            Route::post('/documents',            [TutorKycController::class, 'upload'])        ->name('upload');
            Route::delete('/documents/{document}',[TutorKycController::class, 'deleteDocument'])->name('document.destroy');
        });
    });

// =============================================================================
// STUDENT WEB PANEL
// =============================================================================

Route::middleware(['auth', 'verified', 'check.account.status', 'role:student'])
    ->prefix('student')
    ->name('student.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

        // Discover tutors
        Route::get('/discover',      [StudentDiscoverController::class, 'index'])  ->name('discover');
        Route::get('/tutors/{user}', [StudentDiscoverController::class, 'profile'])->name('tutor.profile');
        // Institutions 
        Route::get('/institutions',  [InstitutionController::class, 'index'])  ->name('institutions.index');
       
        // Subjects
        Route::get('/subjects',      [SubjectController::class, 'index'])  ->name('subjects.index');
        // Bookings
        Route::prefix('bookings')->name('bookings.')->group(function () {
            Route::get('/',                   [StudentBookingController::class, 'index'])  ->name('index');
            Route::get('/create/{user}',      [StudentBookingController::class, 'create']) ->name('create');
            Route::post('/',                  [StudentBookingController::class, 'store'])  ->name('store');
            Route::get('/{booking}',          [StudentBookingController::class, 'show'])   ->name('show');
            Route::post('/{booking}/cancel',  [StudentBookingController::class, 'cancel']) ->name('cancel');
            // Student bookings — keep all existing routes, replace review line:
            Route::post('/{booking}/review', [ReviewController::class, 'store'])->name('review');
        });

        // Session attendance (join via browser)
        Route::get('/sessions/{session}',      [StudentBookingController::class, 'joinSession'])->name('session.join');
        Route::post('/sessions/{session}/end', [StudentBookingController::class, 'endSession']) ->name('session.end');
       
        // Wallet
        Route::prefix('wallet')->name('wallet.')->group(function () {
            Route::get('/',         [StudentWalletController::class, 'index'])  ->name('index');
            Route::post('/deposit', [StudentWalletController::class, 'deposit'])->name('deposit');
        });

        Route::get('/wallet/gateway-redirect', [StudentWalletController::class, 'gatewayRedirect'])
        ->name('wallet.gateway-redirect'); // keep same middleware as your other student routes

        // Inside the student middleware group:
        Route::get('/guardians',                 [GuardianController::class, 'index'])  ->name('guardians.index');
        Route::post('/guardians',                [GuardianController::class, 'store'])  ->name('guardians.store');
        Route::patch('/guardians/{guardian}',    [GuardianController::class, 'update']) ->name('guardians.update');
        Route::delete('/guardians/{guardian}',   [GuardianController::class, 'destroy'])->name('guardians.destroy');

        Route::get('/profile',         [StudentProfileController::class, 'edit'])         ->name('profile.edit');
        Route::post('/profile',        [StudentProfileController::class, 'update'])       ->name('profile.update');
        Route::post('/profile/avatar', [StudentProfileController::class, 'uploadAvatar']) ->name('profile.avatar');
    });



    Route::middleware(['auth', 'verified', 'check.account.status'])->group(function () {
        Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
        Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download')->middleware('signed');

        Route::get('/tutors/{tutor}/reviews', [ReviewController::class, 'tutorReviews'])->name('tutors.reviews');
        Route::post('/sessions/{session}/report', [ReportController::class, 'store'])->name('sessions.report');
        // Inside shared auth middleware (all roles):
        Route::get('/settings/notifications',          [NotificationPreferenceController::class, 'index'])      ->name('settings.notifications.index');
        Route::patch('/settings/notifications/{type}', [NotificationPreferenceController::class, 'update'])     ->name('settings.notifications.update');
        Route::post('/settings/notifications/bulk',    [NotificationPreferenceController::class, 'bulkUpdate']) ->name('settings.notifications.bulk');
        Route::delete('/settings/notifications',       [NotificationPreferenceController::class, 'reset'])      ->name('settings.notifications.reset');

        // In-app notification bell actions
        Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])    ->name('notifications.read');
        Route::post('/notifications/read-all',  [\App\Http\Controllers\NotificationController::class, 'markAllRead']) ->name('notifications.read-all');
    });