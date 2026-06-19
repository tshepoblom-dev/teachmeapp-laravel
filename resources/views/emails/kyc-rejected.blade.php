<x-emails.layout :subject="__('KYC application update')">
    <p class="greeting">Identity verification update</p>
    <p class="intro">Unfortunately your KYC application was not approved at this time.</p>

    @if($rejectionReason)
    <div class="card">
        <div class="card-row">
            <span class="card-label">Reason</span>
            <span class="card-value">{{ $rejectionReason }}</span>
        </div>
    </div>
    @endif

    <p class="intro" style="margin-bottom:24px;">
        You're welcome to re-submit with the correct documentation. If you believe this is an error, please contact support.
    </p>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/kyc">Re-submit Application</a>
    </div>
</x-emails.layout>