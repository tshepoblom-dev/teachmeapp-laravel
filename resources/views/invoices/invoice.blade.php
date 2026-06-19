<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── Header ── */
        .header {
            background: #141F3E;
            color: #fff;
            padding: 32px 40px;
            display: table;
            width: 100%;
        }
        .header-left  { display: table-cell; vertical-align: middle; }
        .header-right { display: table-cell; vertical-align: middle; text-align: right; }

        .brand { font-size: 26px; font-weight: 700; letter-spacing: -0.5px; }
        .brand-dot { color: #007B43; }

        .invoice-label {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(255,255,255,.55);
            margin-bottom: 4px;
        }
        .invoice-number { font-size: 20px; font-weight: 700; }

        /* ── Meta row ── */
        .meta {
            display: table;
            width: 100%;
            padding: 28px 40px;
            border-bottom: 1px solid #eee;
        }
        .meta-cell { display: table-cell; width: 33%; vertical-align: top; }
        .meta-label { font-size: 10px; text-transform: uppercase; letter-spacing: 1px; color: #007B43; font-weight: 700; margin-bottom: 5px; }
        .meta-value { font-size: 13px; color: #141F3E; font-weight: 600; }
        .meta-sub   { font-size: 11px; color: #888; margin-top: 2px; }

        /* ── Parties ── */
        .parties {
            display: table;
            width: 100%;
            padding: 24px 40px 0;
        }
        .party { display: table-cell; width: 50%; vertical-align: top; }
        .party-title {
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #007B43;
            font-weight: 700;
            margin-bottom: 6px;
        }
        .party-name  { font-size: 14px; font-weight: 700; color: #141F3E; }
        .party-email { font-size: 12px; color: #666; margin-top: 2px; }

        /* ── Line items ── */
        .items-wrap { padding: 28px 40px 0; }

        .items-table { width: 100%; border-collapse: collapse; }
        .items-table th {
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #007B43;
            font-weight: 700;
            padding: 10px 12px;
            background: #f7f9f7;
            border-bottom: 2px solid #007B43;
        }
        .items-table th:last-child { text-align: right; }
        .items-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #eee;
            font-size: 13px;
            color: #141F3E;
            vertical-align: top;
        }
        .items-table td:last-child { text-align: right; font-weight: 600; }
        .item-subject { font-weight: 600; }
        .item-meta    { font-size: 11px; color: #888; margin-top: 3px; }

        /* ── Totals ── */
        .totals-wrap { padding: 0 40px 28px; }
        .totals-table { width: 240px; margin-left: auto; border-collapse: collapse; margin-top: 8px; }
        .totals-table td { padding: 6px 10px; font-size: 13px; }
        .totals-table td:last-child { text-align: right; font-weight: 600; }
        .totals-label { color: #666; }

        .total-row td {
            background: #141F3E;
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            padding: 10px 10px;
            border-radius: 0;
        }

        /* ── Badge ── */
        .paid-badge {
            display: inline-block;
            background: #007B43;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            padding: 3px 10px;
            border-radius: 3px;
            margin-left: 8px;
            vertical-align: middle;
        }

        /* ── Footer ── */
        .footer {
            margin: 32px 40px 0;
            padding: 16px 0;
            border-top: 1px solid #eee;
            font-size: 10px;
            color: #aaa;
            text-align: center;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <div class="brand">Teach<span class="brand-dot">Me</span></div>
            <div style="font-size:11px;color:rgba(255,255,255,.5);margin-top:4px;">teachme.co.za</div>
        </div>
        <div class="header-right">
            <div class="invoice-label">Tax Invoice</div>
            <div class="invoice-number">{{ $invoiceNumber }} <span class="paid-badge">Paid</span></div>
        </div>
    </div>

    <!-- Meta -->
    <div class="meta">
        <div class="meta-cell">
            <div class="meta-label">Issue Date</div>
            <div class="meta-value">{{ $issuedAt->format('d M Y') }}</div>
        </div>
        <div class="meta-cell">
            <div class="meta-label">Session Date</div>
            <div class="meta-value">{{ $scheduledAt->format('d M Y') }}</div>
            <div class="meta-sub">{{ $scheduledAt->format('H:i') }} — {{ $booking->duration_minutes }} min</div>
        </div>
        <div class="meta-cell" style="text-align:right;">
            <div class="meta-label">Payment Method</div>
            <div class="meta-value">TeachMe App Wallet</div>
            <div class="meta-sub">Escrow release</div>
        </div>
    </div>

    <!-- Parties -->
    <div class="parties">
        <div class="party">
            <div class="party-title">Billed To</div>
            <div class="party-name">{{ $student->name }}</div>
            <div class="party-email">{{ $student->email }}</div>
        </div>
        <div class="party">
            <div class="party-title">Tutor</div>
            <div class="party-name">{{ $tutor->name }}</div>
            <div class="party-email">{{ $tutor->email }}</div>
        </div>
    </div>

    <!-- Line items -->
    <div class="items-wrap">
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width:55%">Description</th>
                    <th>Duration</th>
                    <th>Rate / hr</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <div class="item-subject">{{ $booking->subject }} Tutoring Session</div>
                        <div class="item-meta">Booking #{{ $booking->id }} · {{ $tutor->name }}</div>
                    </td>
                    <td>{{ $booking->duration_minutes }} min</td>
                    <td>R {{ number_format($booking->hourly_rate_snapshot, 2) }}</td>
                    <td>R {{ number_format($amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="totals-wrap">
        <table class="totals-table">
            <tr>
                <td class="totals-label">Subtotal</td>
                <td>R {{ number_format($amount, 2) }}</td>
            </tr>
            <tr>
                <td class="totals-label">VAT ({{ $vatRate }}%)</td>
                <td>R {{ number_format($vatAmount, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>Total Due</td>
                <td>R {{ number_format($total, 2) }}</td>
            </tr>
        </table>
    </div>

    <!-- Footer -->
    <div class="footer">
        TeachMe App (Pty) Ltd · This is a system-generated invoice · {{ $invoiceNumber }} · {{ $issuedAt->format('d M Y H:i') }}
    </div>

</body>
</html>