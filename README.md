# TeachMeApp

TeachMeApp is a tutoring marketplace connecting students and tutors for
paid, escrow-protected 1:1 video tutoring sessions. Students book sessions,
tutors publish weekly availability and get KYC-verified before they can
earn, sessions run over live video with chat and polls, and tutors withdraw
earnings — net of a tier-based commission — to a payout account. Money
flows through a wallet + escrow ledger, never directly card-to-bank.

Built with Laravel 12 + Inertia/Vue 3 + Tailwind 4, a Sanctum JSON API,
Reverb for real-time, Agora for video, Firebase for push notifications, and
PayFast/Ozow for payments.

## Documentation

- [Architecture](docs/ARCHITECTURE.md) — stack, directory layout, request
  paths, real-time, video, notifications
- [Domain Model](docs/DOMAIN_MODEL.md) — entities, relationships, ER diagram
- [Money Flow](docs/MONEY_FLOW.md) — wallet, escrow, payments, invoices,
  payouts
- [API Reference](docs/API_REFERENCE.md) — full route-by-route API surface
- [Setup](docs/SETUP.md) — local environment, configuration, testing
- [Flutter Mobile Client Spec](docs/flutter-app-prompt.md) — build plan for
  the planned mobile client

## Quickstart

Prerequisites: PHP ^8.2, Composer, Node.js/npm.

```bash
composer run setup   # install deps, configure .env, migrate, build assets
composer run dev      # run server + queue worker + logs + Vite, concurrently
```

See [`docs/SETUP.md`](docs/SETUP.md) for full environment variable
reference and known configuration gaps (e.g. Agora credentials).

## License

This project is built on the Laravel framework, open-sourced under the
[MIT license](https://opensource.org/licenses/MIT).
