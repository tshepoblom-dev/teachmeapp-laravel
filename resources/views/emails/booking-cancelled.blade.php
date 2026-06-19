<x-emails.layout :subject="__('Booking cancelled')">
    <p class="greeting">Booking cancelled</p>
    <p class="intro">{{ $message }}</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Subject</span>
            <span class="card-value">{{ $subject }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Cancelled by</span>
            <span class="card-value">{{ $cancelledBy }}</span>
        </div>
        @if($penaltyApplied)
        <div class="card-row">
            <span class="card-label">Cancellation fee</span>
            <span class="card-value">R{{ number_format($penaltyApplied, 2) }}</span>
        </div>
        @endif
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/bookings">View My Bookings</a>
    </div>
</x-emails.layout>