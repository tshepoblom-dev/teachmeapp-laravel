# Local Setup

## Prerequisites

- PHP ^8.2 + Composer
- Node.js/npm (Vite 7)
- SQLite (default) or MySQL

## Quick start

```bash
composer run setup
```

This runs, in order (see `composer.json`): `composer install`, copies
`.env.example` → `.env` (if `.env` doesn't already exist), `php artisan
key:generate`, `php artisan migrate --force`, `npm install`, `npm run
build`.

If you're using the default SQLite driver and `database/database.sqlite`
doesn't already exist, create it before migrating:

```bash
touch database/database.sqlite
```

(`composer run setup` does not create this file itself in an existing
checkout — that only happens automatically via the `post-create-project-cmd`
hook on a fresh `composer create-project`.)

## Local dev loop

```bash
composer run dev
```

Runs `php artisan serve`, `php artisan queue:listen --tries=1 --timeout=0`,
`php artisan pail --timeout=0`, and `npm run dev` concurrently (one
terminal, color-coded output).

## Environment variables

Sourced from `.env.example`:

| Group | Variables |
|---|---|
| App / DB / session / queue / cache | `DB_CONNECTION=sqlite`, `SESSION_DRIVER=database`, `QUEUE_CONNECTION=database`, `CACHE_STORE=database` (all default to the `database` driver; SQLite is the default DB) |
| Real-time (Reverb) | `BROADCAST_CONNECTION=reverb`, `REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET`, `REVERB_HOST`, `REVERB_PORT`, `REVERB_SCHEME`, and matching `VITE_REVERB_*` for the frontend |
| App URLs | `FRONTEND_URL` |
| PayFast | `PAYFAST_MERCHANT_ID`, `PAYFAST_MERCHANT_KEY`, `PAYFAST_PASSPHRASE`, `PAYFAST_SANDBOX` |
| Ozow | `OZOW_SITE_CODE`, `OZOW_PRIVATE_KEY`, `OZOW_API_KEY`, `OZOW_SANDBOX` |
| Push (FCM) | `FCM_CREDENTIALS_FILE` (path to the Firebase service-account JSON), `FCM_PROJECT_ID`, `NOTIFICATION_CHANNELS` (comma list; `database` is always active regardless of this setting) |

### Env gaps to fill manually

`config/agora.php` reads `AGORA_APP_ID`, `AGORA_APP_CERTIFICATE`,
`AGORA_RECORDING_ENABLED`, `AGORA_RECORDING_BUCKET`, `AGORA_RECORDING_KEY`,
and `AGORA_RECORDING_SECRET` — **none of these appear in `.env.example`**.
Add them by hand for video sessions to work.

## Config files reference

| File | Purpose |
|---|---|
| `config/agora.php` | Video RTC app ID/certificate + cloud recording settings |
| `config/firebase.php` | Firebase service-account/project configuration |
| `config/ozow.php` | Ozow gateway credentials |
| `config/payfast.php` | PayFast gateway credentials |
| `config/platform.php` | Tunable business rules (commission defaults, minimum payout, cancellation penalties, etc.) referenced from `PlatformSetting` |

## Testing

```bash
composer test
```

Clears the config cache, then runs `php artisan test`.

Existing Feature/API coverage:

- `tests/Feature/Api/WalletControllerTest.php`
- `tests/Feature/Api/PayoutControllerTest.php`
- `tests/Feature/Api/ReviewControllerTest.php`
- `tests/Feature/Api/ReportControllerTest.php`
- `tests/Feature/Api/ProfileControllerTest.php`
- `tests/Feature/Api/NotificationControllerTest.php`
- `tests/Feature/Api/ReferenceDataControllerTest.php`
- `tests/Feature/Api/InvoiceControllerTest.php`
- `tests/Feature/Api/Tutor/AvailabilityControllerTest.php`
- `tests/Feature/Api/Tutor/DiscoverControllerTest.php`
- `tests/Feature/WalletServiceBackfillTest.php`

---

See [`docs/ARCHITECTURE.md`](ARCHITECTURE.md) for the "why" behind these
pieces.
