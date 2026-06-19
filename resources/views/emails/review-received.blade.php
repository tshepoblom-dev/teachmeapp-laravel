<x-emails.layout :subject="__('You received a new review')">
    <p class="greeting">New review ⭐</p>
    <p class="intro">{{ $message }}</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">From</span>
            <span class="card-value">{{ $reviewerName }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Rating</span>
            <span class="card-value">{{ $stars }} ({{ $rating }}/5)</span>
        </div>
        @if ($comment)
        <div class="card-row">
            <span class="card-label">Comment</span>
            <span class="card-value">{{ $comment }}</span>
        </div>
        @endif
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/bookings/{{ $bookingId }}">View Booking</a>
    </div>
</x-emails.layout>
