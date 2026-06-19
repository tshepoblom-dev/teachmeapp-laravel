<x-emails.layout :subject="__('Reset your TeachMe App password')">

    <p class="greeting">Reset your password</p>
    <p class="intro">
        We received a request to reset the password for your TeachMe App account.
        Click the button below to choose a new one.
    </p>

    <div class="btn-wrap">
        <a href="{{ $url }}" class="btn">Reset my password</a>
    </div>

    <p style="font-size:13px;color:#6b7280;margin-bottom:20px;">
        This link expires in <strong>60 minutes</strong>. If you didn't request a password reset,
        you can safely ignore this email — your password won't change.
    </p>

    <hr class="divider" />

    <p style="font-size:12px;color:#9ca3af;">
        Can't click the button? Copy and paste this URL into your browser:<br>
        <a href="{{ $url }}" style="color:#007B43;word-break:break-all;">{{ $url }}</a>
    </p>

</x-emails.layout>
