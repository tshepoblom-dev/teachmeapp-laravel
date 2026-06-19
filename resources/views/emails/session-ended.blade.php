<x-emails.layout :subject="__('Session ended')">
    <p class="greeting">Session wrapped up</p>
    <p class="intro">{{ $message }}</p>

    @if($netEarned)
    <div class="alert">
        R{{ number_format($netEarned, 2) }} has been credited to your wallet.
    </div>
    @endif

    <div class="card">
        <div class="card-row">
            <span class="card-label">Subject</span>
            <span class="card-value">{{ $subject }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Duration</span>
            <span class="card-value">{{ $durationMinutes }} minute(s)</span>
        </div>
    </div>

    <div class="btn-wrap">
        @if($recipient === 'student')
            <a class="btn" href="{{ config('app.url') }}/bookings/{{ $bookingId }}/review">Leave a Review</a>
        @else
            <a class="btn" href="{{ config('app.url') }}/wallet">View Wallet</a>
        @endif
    </div>
</x-emails.layout>