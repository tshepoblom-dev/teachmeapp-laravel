<x-emails.layout :subject="__('Congratulations — tier upgrade')">
    <p class="greeting">Tier upgrade! 🏆</p>
    <p class="intro">{{ $message }}</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">New tier</span>
            <span class="card-value">{{ $tierName }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Commission rate</span>
            <span class="card-value">{{ $commissionRate }}%</span>
        </div>
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/dashboard">View Dashboard</a>
    </div>
</x-emails.layout>