<?php

namespace App\Providers;

use App\Events\BookingAccepted;
use App\Events\BookingCancelled;
use App\Events\BookingCompleted;
use App\Events\BookingDeclined;
use App\Events\KycApproved;
use App\Events\KycRejected;
use App\Events\PayoutCompleted;
use App\Events\PayoutFailed;
use App\Events\ReportResolved;
use App\Events\ReviewReceived;
use App\Events\SessionEnded;
use App\Events\SessionStarted;
use App\Listeners\DispatchTierEvaluation;
use App\Listeners\GenerateInvoiceOnBookingCompleted;
use App\Listeners\SendBookingAcceptedNotification;
use App\Listeners\SendBookingCancelledNotification;
use App\Listeners\SendBookingCompletedNotification;
use App\Listeners\SendKycDecisionNotification;
use App\Listeners\SendPayoutCompletedNotification;
use App\Listeners\SendPayoutFailedNotification;
use App\Listeners\SendReportResolvedNotification;
use App\Listeners\SendReviewReceivedNotification;
use App\Listeners\SendSessionEndedNotification;
use App\Listeners\SendSessionStartedNotification;
use App\Listeners\SendBookingDeclinedNotification;
use App\Listeners\WriteBookingAuditLog;
use App\Listeners\WriteKycAuditLog;
use App\Listeners\WriteSessionAuditLog;
use App\Listeners\WriteSessionSystemMessages;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        BookingAccepted::class => [
            SendBookingAcceptedNotification::class,
        ],
        BookingCancelled::class => [
            SendBookingCancelledNotification::class,
        ],
        BookingDeclined::class => [
            SendBookingDeclinedNotification::class,
        ],
        BookingCompleted::class => [
            SendBookingCompletedNotification::class,
            DispatchTierEvaluation::class,
            GenerateInvoiceOnBookingCompleted::class,
        ],
        SessionStarted::class => [
            SendSessionStartedNotification::class,
        ],
        SessionEnded::class => [
            SendSessionEndedNotification::class,
        ],
        ReviewReceived::class => [
            SendReviewReceivedNotification::class,
        ],
        ReportResolved::class => [
            SendReportResolvedNotification::class,
        ],
        PayoutCompleted::class => [
            SendPayoutCompletedNotification::class,
        ],
        PayoutFailed::class => [
            SendPayoutFailedNotification::class,
        ],
        KycApproved::class => [
            // Covered by SendKycDecisionNotification in $subscribe below
        ],
        KycRejected::class => [
            // Covered by SendKycDecisionNotification in $subscribe below
        ],
    ];

    protected $subscribe = [
        WriteBookingAuditLog::class,
        WriteSessionAuditLog::class,
        WriteSessionSystemMessages::class,
        SendKycDecisionNotification::class,
        WriteKycAuditLog::class,
    ];

    public function boot(): void {}

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
