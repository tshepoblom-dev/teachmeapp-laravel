<x-emails.layout :subject="__('Your report has been resolved')">
    <p class="greeting">Report resolved</p>
    <p class="intro">{{ $message }}</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Report #</span>
            <span class="card-value">{{ $reportId }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Outcome</span>
            <span class="card-value">{{ $outcomeLabel }}</span>
        </div>
        @if ($resolvedAt)
        <div class="card-row">
            <span class="card-label">Resolved</span>
            <span class="card-value">{{ $resolvedAt }}</span>
        </div>
        @endif
    </div>

    @if ($adminNotes)
    <div class="alert">
        <strong>Admin note:</strong> {{ $adminNotes }}
    </div>
    @endif

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/dashboard">Go to Dashboard</a>
    </div>
</x-emails.layout>
