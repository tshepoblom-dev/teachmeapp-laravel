<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $subject ?? config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 15px;
            line-height: 1.6;
            color: #1a1a2e;
            background-color: #F4F5F8;
        }

        .wrapper {
            max-width: 600px;
            margin: 32px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 24px rgba(0,0,0,.08);
        }

        /* ── Header ── */
        .header {
            background: #141F3E;
            padding: 28px 40px;
        }
        .brand {
            font-size: 24px;
            font-weight: 700;
            color: #ffffff;
            letter-spacing: -0.5px;
            text-decoration: none;
        }
        .brand-dot { color: #007B43; }

        /* ── Body ── */
        .body {
            padding: 36px 40px 28px;
        }
        .greeting {
            font-size: 20px;
            font-weight: 700;
            color: #141F3E;
            margin-bottom: 12px;
        }
        .intro {
            color: #444;
            margin-bottom: 24px;
        }

        /* ── Card (detail block) ── */
        .card {
            background: #F4F5F8;
            border-radius: 8px;
            padding: 20px 24px;
            margin-bottom: 24px;
        }
        .card-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
            border-bottom: 1px solid #e5e7eb;
            font-size: 14px;
        }
        .card-row:last-child { border-bottom: none; }
        .card-label { color: #6b7280; }
        .card-value { font-weight: 600; color: #141F3E; }

        /* ── CTA button ── */
        .btn-wrap { text-align: center; margin-bottom: 28px; }
        .btn {
            display: inline-block;
            background: #007B43;
            color: #ffffff !important;
            text-decoration: none;
            padding: 13px 32px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: 0.2px;
        }

        /* ── Divider ── */
        .divider {
            border: none;
            border-top: 1px solid #e5e7eb;
            margin: 4px 0 24px;
        }

        /* ── Alert / highlight box ── */
        .alert {
            border-left: 4px solid #007B43;
            background: #f0faf5;
            border-radius: 0 8px 8px 0;
            padding: 14px 18px;
            margin-bottom: 24px;
            font-size: 14px;
            color: #065f46;
        }

        /* ── Footer ── */
        .footer {
            background: #F4F5F8;
            padding: 20px 40px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
        }
        .footer a { color: #007B43; text-decoration: none; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="header">
            <span class="brand">Teach<span class="brand-dot">Me</span></span>
        </div>

        <div class="body">
            {{ $slot }}
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} TeachMe App. All rights reserved.<br>
            <a href="{{ config('app.url') }}">{{ config('app.url') }}</a>
            &nbsp;·&nbsp;
            <a href="{{ config('app.url') }}/settings/notifications">Manage notifications</a>
        </div>
    </div>
</body>
</html>