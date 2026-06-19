<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\BookingAccepted' => 
    array (
      0 => 'App\\Listeners\\SendBookingAcceptedNotification',
    ),
    'App\\Events\\BookingCancelled' => 
    array (
      0 => 'App\\Listeners\\SendBookingCancelledNotification',
    ),
    'App\\Events\\BookingDeclined' => 
    array (
      0 => 'App\\Listeners\\SendBookingDeclinedNotification',
    ),
    'App\\Events\\BookingCompleted' => 
    array (
      0 => 'App\\Listeners\\SendBookingCompletedNotification',
      1 => 'App\\Listeners\\DispatchTierEvaluation',
      2 => 'App\\Listeners\\GenerateInvoiceOnBookingCompleted',
    ),
    'App\\Events\\SessionStarted' => 
    array (
      0 => 'App\\Listeners\\SendSessionStartedNotification',
    ),
    'App\\Events\\SessionEnded' => 
    array (
      0 => 'App\\Listeners\\SendSessionEndedNotification',
    ),
    'App\\Events\\ReviewReceived' => 
    array (
      0 => 'App\\Listeners\\SendReviewReceivedNotification',
    ),
    'App\\Events\\ReportResolved' => 
    array (
      0 => 'App\\Listeners\\SendReportResolvedNotification',
    ),
    'App\\Events\\PayoutCompleted' => 
    array (
      0 => 'App\\Listeners\\SendPayoutCompletedNotification',
    ),
    'App\\Events\\PayoutFailed' => 
    array (
      0 => 'App\\Listeners\\SendPayoutFailedNotification',
    ),
    'App\\Events\\KycApproved' => 
    array (
    ),
    'App\\Events\\KycRejected' => 
    array (
    ),
  ),
  'Illuminate\\Foundation\\Support\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\BookingCompleted' => 
    array (
      0 => 'App\\Listeners\\DispatchTierEvaluation@handle',
      1 => 'App\\Listeners\\GenerateInvoiceOnBookingCompleted@handle',
      2 => 'App\\Listeners\\SendBookingCompletedNotification@handle',
      3 => 'App\\Listeners\\WriteBookingAuditLog@handleBookingCompleted',
    ),
    'App\\Events\\BookingAccepted' => 
    array (
      0 => 'App\\Listeners\\SendBookingAcceptedNotification@handle',
      1 => 'App\\Listeners\\WriteBookingAuditLog@handleBookingAccepted',
    ),
    'App\\Events\\BookingCancelled' => 
    array (
      0 => 'App\\Listeners\\SendBookingCancelledNotification@handle',
      1 => 'App\\Listeners\\WriteBookingAuditLog@handleBookingCancelled',
    ),
    'App\\Events\\BookingDeclined' => 
    array (
      0 => 'App\\Listeners\\SendBookingDeclinedNotification@handle',
    ),
    'App\\Events\\KycApproved' => 
    array (
      0 => 'App\\Listeners\\SendKycDecisionNotification@handleKycApproved',
      1 => 'App\\Listeners\\WriteKycAuditLog@handleKycApproved',
    ),
    'App\\Events\\KycRejected' => 
    array (
      0 => 'App\\Listeners\\SendKycDecisionNotification@handleKycRejected',
      1 => 'App\\Listeners\\WriteKycAuditLog@handleKycRejected',
    ),
    'App\\Events\\PayoutCompleted' => 
    array (
      0 => 'App\\Listeners\\SendPayoutCompletedNotification@handle',
    ),
    'App\\Events\\PayoutFailed' => 
    array (
      0 => 'App\\Listeners\\SendPayoutFailedNotification@handle',
    ),
    'App\\Events\\ReportResolved' => 
    array (
      0 => 'App\\Listeners\\SendReportResolvedNotification@handle',
    ),
    'App\\Events\\ReviewReceived' => 
    array (
      0 => 'App\\Listeners\\SendReviewReceivedNotification@handle',
    ),
    'App\\Events\\SessionEnded' => 
    array (
      0 => 'App\\Listeners\\SendSessionEndedNotification@handle',
      1 => 'App\\Listeners\\WriteSessionAuditLog@handleSessionEnded',
      2 => 'App\\Listeners\\WriteSessionSystemMessages@handleSessionEnded',
    ),
    'App\\Events\\SessionStarted' => 
    array (
      0 => 'App\\Listeners\\SendSessionStartedNotification@handle',
      1 => 'App\\Listeners\\WriteSessionAuditLog@handleSessionStarted',
      2 => 'App\\Listeners\\WriteSessionSystemMessages@handleSessionStarted',
    ),
  ),
);