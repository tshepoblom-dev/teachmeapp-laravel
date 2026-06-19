<x-emails.layout :subject="__('Payout failed — funds returned to wallet')">
    <p class="greeting">Payout failed</p>
    <p class="intro">{{ $message }}</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Reference</span>
            <span class="card-value">{{ $reference }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Amount</span>
            <span class="card-value">R{{ $amount }}</span>
        </div>
        @if ($failureReason)
        <div class="card-row">
            <span class="card-label">Reason</span>
            <span class="card-value">{{ $failureReason }}</span>
        </div>
        @endif
    </div>

    <div class="alert" style="border-left-color: #dc2626; background: #fef2f2; color: #991b1b;">
        The full amount has been returned to your wallet. Please check your payout account details and try again, or contact support if the problem persists.
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/tutor/wallet/payouts">View Payouts</a>
    </div>
</x-emails.layout>
