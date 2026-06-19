<x-emails.layout :subject="__('Session complete — invoice attached')">
    <p class="greeting">Session complete!</p>
    <p class="intro">{{ $message }}</p>

    @if($netEarned)
    <div class="alert">
        R{{ number_format($netEarned, 2) }} has been added to your wallet.
    </div>
    @endif

    <div class="card">
        <div class="card-row">
            <span class="card-label">Subject</span>
            <span class="card-value">{{ $subject }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Status</span>
            <span class="card-value">Completed</span>
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