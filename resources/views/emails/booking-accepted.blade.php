<x-emails.layout :subject="__('Your booking has been accepted')">
    <p class="greeting">Booking confirmed ✓</p>
    <p class="intro">{{ $message }}</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Subject</span>
            <span class="card-value">{{ $subject }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Tutor</span>
            <span class="card-value">{{ $tutorName }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Scheduled</span>
            <span class="card-value">{{ $scheduledAt }}</span>
        </div>
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/bookings/{{ $bookingId }}">View Booking</a>
    </div>
</x-emails.layout>