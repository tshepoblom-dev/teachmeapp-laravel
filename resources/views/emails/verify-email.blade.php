<x-emails.layout :subject="__('Verify your TeachMe App email address')">

    <p class="greeting">Confirm your email address</p>
    <p class="intro">
        Thanks for joining TeachMe App! Before you can book or host sessions,
        we need to verify your email address.
    </p>

    <div class="btn-wrap">
        <a href="{{ $url }}" class="btn">Verify my email</a>
    </div>

    <p style="font-size:13px;color:#6b7280;margin-bottom:20px;">
        This link expires in <strong>60 minutes</strong>. If you didn't create a TeachMe App account,
        you can safely ignore this email.
    </p>

    <hr class="divider" />

    <p style="font-size:12px;color:#9ca3af;">
        Can't click the button? Copy and paste this URL into your browser:<br>
        <a href="{{ $url }}" style="color:#007B43;word-break:break-all;">{{ $url }}</a>
    </p>

</x-emails.layout>
