# API Reference

The JSON API lives in `routes/api.php`, is protected by Sanctum, and mirrors
the business rules implemented in `app/Services/*`. This document describes
what the API exposes **today**. For the list of gaps to close before
building a mobile client against it, see
[`docs/flutter-app-prompt.md` §3 (Part A)](flutter-app-prompt.md).

## Public (no auth)

| Method | Path | Controller |
|---|---|---|
| POST | `auth/register` | `Api\Auth\RegisterController` |
| POST | `auth/login` | `Api\Auth\LoginController` |
| POST | `auth/forgot-password` | `Api\Auth\PasswordResetController::sendLink` |
| POST | `auth/reset-password` | `Api\Auth\PasswordResetController::reset` |
| POST | `payment/webhook/{gateway}` | `Api\Payment\WebhookController::handle` (always 200) |
| GET | `payment/callback/{gateway}` | `Api\Payment\PaymentController::callback` |
| GET | `/tiers`, `/tiers/{tier}` | `TierController` |

`AuthService` backs registration and login: `register()` is transactional
(creates the user + auto-provisions Profile/Wallet via `UserObserver`,
captures POPIA consent, sends email verification, writes an audit log,
issues a Sanctum token); `login()` gates banned/suspended accounts, tracks
last-login, and writes an audit log.

## Authenticated — shared (`auth:sanctum` + `check.account.status`)

| Method | Path | Controller |
|---|---|---|
| POST | `auth/logout` | `Api\Auth\LogoutController` |
| POST / DELETE | `fcm-token` | `FcmTokenController` |
| GET | `notifications` | `Api\Notification\NotificationController::index` |
| POST | `notifications/{id}/read` | `::markRead` |
| POST | `notifications/read-all` | `::markAllRead` |
| GET | `institutions`, `subjects` | `Api\Reference\ReferenceDataController` |
| GET | `email/verify/status` | `Api\Auth\EmailVerificationController::status` |
| POST | `email/verification-notification` | `::send` (throttled) |
| GET | `email/verify/{id}/{hash}` | `::verify` (signed, throttled) |
| GET | `user` | `Api\User\ProfileController::me` |
| PUT | `user/profile` | `::update` (validated by `UpdateProfileRequest`) |
| POST | `user/profile/avatar` | `::avatar` |
| PUT | `user/password` | `::changePassword` |

`ProfileController::update` enforces the tutor minimum hourly rate (from
config) and delegates to `AuthService::updateProfile()`, which splits
user-level vs profile-level fields and strips tutor-only fields for
non-tutors. `ProfileResource` exposes bio/contact/timezone, KYC status,
tutor stats (rating, review count, sessions hosted/attended),
specializations, linked institutions/subjects, and the tutor's tier.

### Payments

| Method | Path | Controller |
|---|---|---|
| GET | `payment/methods` | `Api\Payment\PaymentController::methods` |
| POST | `payment/deposit` | `::deposit` |
| POST | `payment/booking/{booking}` | `::payBooking` |
| GET | `payment/transactions` | `::transactions` |

### Admin gateway config

| Method | Path | Controller |
|---|---|---|
| GET | `admin/payment/gateways` | `Api\Admin\GatewayConfigController::index` |
| GET | `admin/payment/gateways/{code}` | `::show` |
| POST | `admin/payment/gateways/{code}/configure` | `::configure` |
| POST | `admin/payment/gateways/{code}/toggle` | `::toggle` |
| POST | `admin/payment/gateways/{code}/test` | `::test` |

### Bookings (shared — students see own, tutors see own, admins see all)

| Method | Path | Controller |
|---|---|---|
| GET | `/bookings` | `BookingController::index` |
| GET | `/bookings/{booking}` | `::show` |
| GET | `/bookings/upcoming/list` | `::upcoming` |
| POST | `/bookings/{booking}/cancel` | `::cancel` |

### Wallet (shared)

| Method | Path | Controller |
|---|---|---|
| GET | `/wallet` | `Api\Wallet\WalletController::index` |
| GET | `/wallet/transactions` | `::transactions` |

### Payout accounts & payouts (`role:student,tutor`)

| Method | Path | Controller |
|---|---|---|
| GET / POST | `/payout/accounts` | `Api\Payout\PayoutController::accounts` / `storeAccount` |
| POST | `/payout/accounts/{account}/default` | `::setDefaultAccount` |
| DELETE | `/payout/accounts/{account}` | `::deleteAccount` |
| GET | `/payout/transactions` | `::transactions` |
| POST | `/payout/request` | `::requestPayout` |
| POST | `/payout/{payout}/cancel` | `::cancelPayout` |

See [`docs/MONEY_FLOW.md`](MONEY_FLOW.md) for the business rules behind
these three groups.

## Student-only (`role:student`)

| Method | Path | Controller |
|---|---|---|
| POST | `/bookings` | `BookingController::store` |
| POST | `/bookings/{booking}/review` | `Api\Review\ReviewController::store` |

## Tutor-only (`role:tutor`)

| Method | Path | Controller |
|---|---|---|
| GET | `/tutor/bookings/requests` | `BookingController::pendingRequests` |
| POST | `/bookings/{booking}/accept` | `::accept` (triggers escrow hold) |
| POST | `/bookings/{booking}/decline` | `::decline` |

### Tutor availability

`TutorAvailabilitySlot` holds a tutor's weekly recurring schedule
(`day_of_week`, `start_time`, `end_time`, `is_recurring`, `valid_from`/
`valid_until`, `is_active`), managed by `AvailabilityService`. Web
(`Http\Controllers\Tutor\TutorAvailabilityController`) and API
(`Api\Tutor\AvailabilityController`) twins expose the same actions;
ownership is enforced (`tutor_id === auth user`).

| Method | Path | Controller action |
|---|---|---|
| GET | `tutor/availability` | `index` |
| POST | `tutor/availability` | `store` |
| POST | `tutor/availability/bulk` | `bulkStore` (max 50 slots) |
| POST | `tutor/availability/replace` | `replaceAll` (wipes and recreates) |
| PUT | `tutor/availability/{slot}` | `update` |
| PATCH | `tutor/availability/{slot}/toggle` | `toggle` |
| DELETE | `tutor/availability/{slot}` | `destroy` |

**Known TODO:** `logOwnershipCheck()` in the availability controller writes
a `Log::error(...)` entry on every `toggle`/`destroy` call — leftover debug
instrumentation from a past 403 investigation, flagged for future cleanup.

## Authenticated, no role restriction

| Method | Path | Controller |
|---|---|---|
| GET | `/tutors/{tutorId}/availability` | `TutorAvailabilityController::publicSlots` (booking picker) |
| GET | `/tutor/tier/progress` | `TierController::myProgress` |
| GET | `/tutors` | `Api\Tutor\DiscoverController::index` (search/institution/subject/max-rate/min-rating filters) |
| GET | `/tutors/{tutor}/reviews` | `Api\Review\ReviewController::tutorReviews` |
| GET | `/tutors/{user}` | `Api\Tutor\DiscoverController::show` (profile + last 10 visible reviews + active slots) |

## Sessions — core lifecycle

| Method | Path | Controller |
|---|---|---|
| GET | `/sessions/{session}` | `SessionController::show` |
| GET | `/bookings/{booking}/session` | `::showByBooking` |
| GET | `/invoices/{invoice}` | `Api\Invoice\InvoiceController::show` (signed download URL; authorizes the invoice's student or tutor) |
| GET | `/invoices/{invoice}/download` | `InvoiceController::download` (signed route) |
| POST | `/sessions/{session}/join` | `SessionController::join` (returns Agora token + channel info) |
| POST | `/sessions/{session}/token/refresh` | `::refreshToken` |
| POST | `/sessions/{session}/keepalive` | `::keepalive` |
| POST | `/sessions/{session}/start` | `::start` (**tutor only**) |
| POST | `/sessions/{session}/end` | `::end` (either party; triggers escrow release) |
| POST | `/sessions/{session}/report` | `Api\Report\ReportController::store` (can force-end the session via `SessionService` when `action_taken === 'end_session'`) |

## Chat & polls

| Method | Path | Controller |
|---|---|---|
| GET / POST | `/sessions/{session}/chat` | `ChatController::index` / `store` |
| POST | `/sessions/{session}/chat/read` | `::markRead` |
| GET | `/sessions/{session}/chat/unread` | `::unreadCount` |
| GET / POST | `/sessions/{session}/polls` | `PollController::index` / `store` |
| GET | `/sessions/{session}/polls/{poll}` | `::show` |
| POST | `/sessions/{session}/polls/{poll}/respond` | `::respond` |
| POST | `/sessions/{session}/polls/{poll}/close` | `::close` |

## KYC (authenticated, own application)

| Method | Path | Controller |
|---|---|---|
| GET | `/kyc/status` | `KycController::status` |
| POST | `/kyc/apply` | `::apply` |
| POST | `/kyc/documents` | `::uploadDocument` |
| DELETE | `/kyc/documents/{document}` | `::deleteDocument` |

## Admin-only (`role:admin`)

| Method | Path | Controller |
|---|---|---|
| POST | `/admin/bookings/{booking}/dispute` | `BookingController::resolveDispute` |
| GET | `/admin/kyc/stats` \| `applications` \| `applications/{application}` | `AdminKycController` |
| POST | `/admin/kyc/applications/{application}/flag` \| `approve` \| `reject` | `AdminKycController` |
| GET | `/admin/kyc/documents/{document}/url` | `AdminKycController::documentUrl` |
| GET | `/admin/tiers/stats`, `/admin/tiers/commission-preview` | `AdminTierController` |
| POST | `/admin/tiers/re-evaluate` | `::reEvaluate` |
| CRUD | `/admin/tiers[/{tier}]` | `AdminTierController` |
| POST | `/admin/tiers/{tier}/toggle`, `/assign` | `AdminTierController` |

## Web routes (Inertia) — brief map

`routes/web.php` is session-based and role-gated, rendering
`resources/js/Pages/*`:

- **Admin** (`role:admin`) — `users`, `institutions`, `subjects`, `kyc`,
  `sessions`, `payouts`, `gateways`, `tiers`, `settings`, `bookings`,
  `financials`, `audit`, `notifications`, `reviews`, `reports` →
  `resources/js/Pages/Admin/*`.
- **Tutor** (`role:tutor`) — `bookings`, `sessions`, `kyc`, plus a web twin
  of the availability screens → `resources/js/Pages/Tutor/*`.
- **Student** (`role:student`) — `bookings`, `wallet` →
  `resources/js/Pages/Student/*`.

This is a map, not an exhaustive route table — see `routes/web.php` for the
full list.

## API Resources (`app/Http/Resources/`)

| Resource | Exposes |
|---|---|
| `UserResource` | Core user identity fields |
| `ProfileResource` | Bio/contact/timezone, KYC status, tutor stats, specializations, institutions/subjects, tier |
| `BookingResource` | Booking detail incl. rate/fee snapshots |
| `SessionResource` | Session state, Agora channel info |
| `ChatMessageResource` | Chat message detail |
| `PollResource` | Poll detail and results |
| `ReviewResource` | Review rating/comment |
| `ReportResource` | Conduct report detail |
| `NotificationResource` | Notification payload |
| `TierResource` | Tutor tier detail |
| `KycApplicationResource` / `KycDocumentResource` | KYC application/document detail |
| `EscrowResource` | Escrow transaction detail |
| `WalletTransactionResource` | Wallet ledger entry |
| `PaymentTransactionResource` / `PaymentMethodResource` | Payment transaction / method detail |
| `PayoutAccountResource` / `PayoutTransactionResource` | Payout account / transaction detail |
| `AvailabilitySlotResource` | Tutor availability slot |
| `TutorSummaryResource` / `TutorProfileResource` | Tutor discovery card / full profile |
| `InstitutionResource` / `SubjectResource` | Reference/lookup data |

---

For a proposed mobile client and the list of API gaps to close before
building it, see
[`docs/flutter-app-prompt.md`](flutter-app-prompt.md) (Part A).
