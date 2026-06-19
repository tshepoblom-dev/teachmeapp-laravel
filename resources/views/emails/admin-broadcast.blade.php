<x-emails.layout :subject="$title">

    <p class="greeting">{{ $title }}</p>

    <div class="alert">
        This is a message from the TeachMe App team.
    </div>

    <p class="intro" style="white-space: pre-line;">{{ $body }}</p>

    <hr class="divider" />

    <p style="font-size:12px;color:#9ca3af;">
        You received this email because you have an account on TeachMe App.
        To manage your notification preferences, visit your
        <a href="{{ config('app.url') }}/settings/notifications" style="color:#007B43;">notification settings</a>.
    </p>

</x-emails.layout>
