<x-emails.layout :subject="__('KYC approved — you\'re ready to teach')">
    <p class="greeting">You're verified! 🎉</p>
    <p class="intro">{{ $message }}</p>

    <div class="alert">
        Your profile is now live and students can book sessions with you.
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/dashboard">Go to Dashboard</a>
    </div>
</x-emails.layout>