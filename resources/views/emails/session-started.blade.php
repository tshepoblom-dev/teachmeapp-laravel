<x-emails.layout :subject="__('Your session is starting now')">
    <p class="greeting">Your session is live! 🎓</p>
    <p class="intro">{{ $message }}</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Subject</span>
            <span class="card-value">{{ $subject }}</span>
        </div>
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/sessions/{{ $sessionId }}/join">Join Session Now</a>
    </div>
</x-emails.layout>