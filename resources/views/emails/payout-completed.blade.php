<x-emails.layout :subject="__('Your payout has been processed')">
    <p class="greeting">Payout successful 💸</p>
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
        @if ($processedAt)
        <div class="card-row">
            <span class="card-label">Processed</span>
            <span class="card-value">{{ $processedAt }}</span>
        </div>
        @endif
    </div>

    <div class="alert">
        Funds should appear in your bank account within 1–3 business days depending on your bank.
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/tutor/wallet/payouts">View Payouts</a>
    </div>
</x-emails.layout>
