# Architecture

## Overview

TeachMeApp is a Laravel 12 tutoring marketplace with two front doors onto the
same backend: a server-rendered **Inertia/Vue web app** (students, tutors,
and admins) and a **Sanctum-protected JSON API**, built out ahead of a
planned mobile client. Both surfaces share the same models, services, and
business rules under `app/`.

For the mobile client build spec (a Flutter app for the student and tutor
roles), see [`docs/flutter-app-prompt.md`](flutter-app-prompt.md).

## Tech stack

| Concern | Choice |
|---|---|
| Backend framework | Laravel 12 (PHP ^8.2) |
| Frontend | Inertia.js (`inertiajs/inertia-laravel` ^3.1) + Vue 3.5, Tailwind CSS 4, Vite 7 |
| API auth | Laravel Sanctum ^4.3 |
| Route sharing | Ziggy (Laravel routes in JS) |
| Real-time | Laravel Reverb (Pusher protocol) + `laravel-echo` / `pusher-js` |
| Video | Agora RTC (`agora-rtc-sdk-ng` client, `boogiefromzk/agora-token` server-side) |
| Push notifications | Firebase via `kreait/laravel-firebase` + `fcm` notification channel |
| Payments | PayFast, Ozow, plus an internal `wallet_balance` gateway |
| Invoices | `barryvdh/laravel-dompdf` |
| DB / queue / cache / session | All on the `database` driver; SQLite by default |

## Directory structure

```
app/
  Agora/          # Video channel/token helpers
  Console/        # Artisan commands (e.g. wallets:backfill)
  Contracts/       # Interfaces (e.g. PaymentGatewayInterface)
  Enums/
  Events/
  Http/            # Controllers, Requests, Resources, Middleware
  Jobs/
  Listeners/
  Models/
  Notifications/
  Observers/       # e.g. UserObserver (provisions Profile + Wallet on register)
  Providers/
  Services/        # Business logic: Wallet, Escrow, Invoice, Payout, Payment/*
  Traits/
resources/js/Pages/
  Admin/ Auth/ Student/ Tutor/   # Inertia page components
  Home.vue HowItWorks.vue Pricing.vue Legal/
routes/
  web.php          # Inertia, session-based
  api.php          # Sanctum, JSON
  channels.php     # Broadcast channel authorization
  console.php
database/
  factories/ migrations/ seeders/
config/
  agora.php firebase.php ozow.php payfast.php platform.php
```

## Two front doors

**Web** (`routes/web.php`) — Inertia, session-based, role-gated route groups:
- `role:admin` → `users`, `institutions`, `subjects`, `kyc`, `sessions`, `gateways`, `tiers`, `settings`, `bookings`, `notifications`
- `role:tutor` → `bookings`, `sessions`, `kyc`
- `role:student` → `bookings`, `wallet`

**API** (`routes/api.php`) — Sanctum, grouped under `auth:sanctum` +
`check.account.status`: an `email` prefix, a `payment` prefix, an `admin`
group (including `payment/gateways`), a shared `role:student,tutor` group, a
`role:student` group, a `role:tutor` group (including `tutor/availability`),
and a `role:admin` group.

See [`docs/API_REFERENCE.md`](API_REFERENCE.md) for the full route-by-route
breakdown.

## Real-time

Broadcasting runs over Laravel Reverb. From `routes/channels.php`:

- `App.Models.User.{id}` — private channel, authorized only for the owning
  user; delivers notification broadcasts.
- `session.{sessionId}` — private channel, authorized only for the session's
  student or tutor; carries `SessionStatusChanged`, `SessionStarted`, and
  `SessionEnded` events.

`Broadcast::routes(['middleware' => ['web', 'auth']])` registers the
`/broadcasting/auth` endpoint Echo uses to authorize private channels.

## Video

Video sessions run on Agora RTC. `app/Agora` plus `boogiefromzk/agora-token`
handle channel/token issuance server-side; `AgoraChannel` is the persistence
model. Configuration lives in `config/agora.php`:

- `app_id`, `app_certificate` (server-side only — never expose the
  certificate client-side or in API responses)
- `recording_enabled`, `recording_storage_bucket/key/secret` — cloud
  recording, used in the session-end flow

## Notifications

Push notifications go through Firebase Cloud Messaging
(`kreait/laravel-firebase`, `fcm` notification channel). Delivery channels
are toggled platform-wide via the `NOTIFICATION_CHANNELS` env var
(`database` is always active; `mail` and `fcm` are optional).

## Storage

Invoice PDFs are generated with dompdf and written to the `private` disk,
served only via short-lived signed URLs. See
[`docs/MONEY_FLOW.md`](MONEY_FLOW.md#invoiceservice).

## Known cleanup item

`TutorAvailabilityController::logOwnershipCheck()` currently writes a
`Log::error(...)` entry on every `toggle` and `destroy` call. This is
leftover debug instrumentation from a past 403 investigation and should be
removed or downgraded in a future pass — see
[`docs/API_REFERENCE.md`](API_REFERENCE.md#tutor-only) for the route
context.

---

For the mobile client build spec, see
[`docs/flutter-app-prompt.md`](flutter-app-prompt.md).
