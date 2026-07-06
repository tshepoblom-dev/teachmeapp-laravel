# Money Flow

Money never moves gateway-to-bank directly. Every rand passes through the
**Wallet ledger**, and booking payments are held in an **escrow** pattern
until the session completes.

## Lifecycle

```mermaid
sequenceDiagram
    actor Student
    participant PaymentService
    participant GatewayManager
    participant WalletService
    participant EscrowService
    participant InvoiceService
    actor Tutor
    participant PayoutService
    actor Admin

    Student->>PaymentService: initiateDeposit() / initiateBookingPayment()
    PaymentService->>PaymentService: create PaymentTransaction (Pending)
    PaymentService->>GatewayManager: driver(code)
    GatewayManager-->>PaymentService: gateway driver
    PaymentService->>GatewayManager: initializePayment()
    Note over PaymentService,GatewayManager: wallet_balance settles synchronously (direct_success);<br/>PayFast/Ozow wait for a webhook
    GatewayManager-->>PaymentService: handleWebhookResult() (idempotent)
    PaymentService->>WalletService: credit(student wallet)

    Note over Student,EscrowService: Booking accepted
    EscrowService->>WalletService: debit(balance) + credit(escrow_balance)
    EscrowService->>EscrowService: create EscrowTransaction (Held)

    Note over EscrowService,Tutor: Session completed
    EscrowService->>EscrowService: resolve commission rate
    EscrowService->>WalletService: decrement escrow, credit(tutor balance, net)
    EscrowService->>WalletService: recordPlatformFee() (audit-only)
    EscrowService->>InvoiceService: generate paid invoice

    Note over EscrowService,Student: Alternate: cancellation / dispute
    EscrowService->>WalletService: refund() to student (minus optional penalty)
    EscrowService->>Admin: flagAsDisputed() (freeze for review)

    Tutor->>PayoutService: requestWithdrawal()
    PayoutService->>WalletService: debit(balance) immediately
    PayoutService->>PayoutService: create PayoutTransaction (pending)
    Admin->>PayoutService: markProcessing() -> markCompleted() | markFailed()
    Note over PayoutService,WalletService: markFailed() refunds the wallet
```

## WalletService

The single choke point for wallet balance mutations
(`app/Services/WalletService.php`):

- `credit()` / `debit()` both funnel into a private `mutate()` that runs
  inside `DB::transaction()` with `lockForUpdate()`, and record
  `balance_before`/`balance_after` on a new `WalletTransaction` for a full
  audit ledger. `debit()` throws on insufficient funds.
- `getOrCreateWallet()` — defensive provisioning; normal creation happens via
  `UserObserver` at registration.
- `availableBalance()` / `hasSufficientFunds()`.
- `recordPlatformFee()` — an audit-only ledger entry (`wallet_id` null)
  representing platform commission revenue; never touches a real balance.

## EscrowService

Owns the booking-payment lifecycle once funds are already in the student's
wallet (`app/Services/EscrowService.php`):

- **`hold()`** (booking accepted) — locks both wallets, debits the
  student's available balance, increments `wallet.escrow_balance`, and
  creates an `EscrowTransaction` with status `Held`.
- **`release()`** (session completed) — resolves a commission rate from the
  booking's `platform_fee_snapshot`, falling back to the tutor's tier, then
  the platform default; decrements escrow; credits the tutor
  net-of-commission; records the commission via
  `WalletService::recordPlatformFee()`.
- **`refund()`** (cancellation/dispute) — reverses escrow back to the
  student's available balance, supporting partial refunds via a
  `penaltyAmount` (e.g. a late-cancellation fee) captured as a platform fee.
- **`flagAsDisputed()`** — freezes an escrow row for admin review without
  moving money.

## InvoiceService

Generates a PDF invoice via dompdf once a booking completes
(`app/Services/InvoiceService.php`):

- Idempotent per booking (`Invoice::where('booking_id', ...)`).
- Computes 15% VAT on `booking.total_amount`.
- Stores the file on the `private` disk; auto-numbered `INV-{year}-{seq}`;
  status `paid`.
- `signedDownloadUrl()` — a short-lived (2-hour TTL) signed route.
- `pdfContent()` — for streaming.
- `void()` — for admin dispute resolution (file retained for audit).

## PayoutService

Tutor withdrawal domain (`app/Services/PayoutService.php`):

- Payout-account CRUD: `createAccount()` encrypts the account number and
  enforces one default per user; `deleteAccount()` blocks if pending or
  processing payouts exist. Admin verify/unverify workflow.
- `requestWithdrawal()` — enforces a R50 minimum and a verified account,
  then atomically debits the wallet and creates a `PayoutTransaction`
  (status `pending`) — **funds are reserved immediately on request**, not on
  completion.
- `cancelWithdrawal()` — tutor-initiated, pending only; refunds the wallet.
- Admin state machine: `markProcessing()` → `markCompleted()` (dispatches
  `PayoutCompleted`) or `markFailed()` (refunds the wallet, dispatches
  `PayoutFailed`).
- Every state change writes an `AuditLog` entry.

## GatewayManager / PaymentService

**`GatewayManager`** (`app/Services/Payment/GatewayManager.php`) is a
registry: a service provider tags concrete drivers implementing
`App\Contracts\PaymentGatewayInterface` and calls `register()`.
`loadConfiguration()` loads DB-stored `PaymentGatewayConfiguration` rows
(keyed by environment: sandbox/production, derived from `app.env`) and
injects them into each driver via `setConfig()`. `driver($code)` is the
guarded resolver used by application code — it checks the driver is
registered, the `PaymentMethod.is_active` flag in the DB, and
`isConfigured()`. `driverUnchecked()` skips the DB-active check and is used
in webhooks/refunds.

**`PaymentService`** (`app/Services/Payment/PaymentService.php`)
orchestrates two entry flows — `initiateDeposit()` (wallet top-up) and
`initiateBookingPayment()` (pay for a booking) — both resolving a gateway,
creating a `PaymentTransaction` (status `Pending`), calling
`gateway->initializePayment()`, and creating a gateway-specific row (e.g.
`PayfastTransaction`) via `createGatewayRecord()`. If the gateway responds
`direct_success` (true for `wallet_balance`), it settles synchronously via
`settleDeposit()`/`settleBookingPayment()`. Otherwise,
`handleWebhookResult()` is the single webhook entry point: it locates the
`PaymentTransaction` by reference, is idempotent against terminal statuses,
updates the gateway-specific record, and settles (wallet credit for
deposits, wallet debit for booking payments) on success. `refund()`
delegates to the gateway driver and credits the wallet back for
`wallet_balance` transactions.

**Gateways**: `payfast`, `ozow`, and `wallet_balance` (internal,
synchronous). A `StripeTransaction` model exists in the schema but is not
part of this active flow.

## Money API surface

- **`Api/Wallet/WalletController`** — `GET /api/wallet` (balance,
  escrow_balance, currency, available payment methods); `GET
  /api/wallet/transactions` (paginated ledger).
- **`Api/Payout/PayoutController`** — payout account CRUD, set default,
  `POST /api/payout/request`, `POST /api/payout/{payout}/cancel`,
  transactions list.
- **`Api/Invoice/InvoiceController`** — `GET /api/invoices/{invoice}`
  returns a signed download URL, authorizing that the requester is the
  invoice's student or tutor.

See [`docs/API_REFERENCE.md`](API_REFERENCE.md) for full route detail.

## Admin gateway configuration UI

`Admin/GatewayWebController` (Inertia): lists all `PaymentMethod`s with
active/default/configured status; shows masked config values (never
decrypted) plus the driver's config schema; upserts encrypted
`PaymentGatewayConfiguration` rows per environment; toggles `is_active`.
This is how ops enables/disables gateways and manages credentials per
environment without a code deploy.

## Operational note: wallet backfill

`app/Console/Commands/BackfillMissingWallets.php` (`wallets:backfill`) finds
users lacking a `wallets` row and creates zero-balance wallets for them.
Normal provisioning happens via `UserObserver` at registration; this command
is a remediation/safety-net for accounts created before that observer
existed, or for any edge case where the observer failed to fire.
