<x-emails.layout :subject="'New ' . ucfirst($newUser->role->value) . ' sign-up'">
    <p class="greeting">New {{ ucfirst($newUser->role->value) }} sign-up</p>
    <p class="intro">A new user just registered on TeachMe App. Review their profile to help meet our 2-3 day response commitment.</p>

    <div class="card">
        <div class="card-row">
            <span class="card-label">Name</span>
            <span class="card-value">{{ $newUser->name }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Email</span>
            <span class="card-value">{{ $newUser->email }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Role</span>
            <span class="card-value">{{ ucfirst($newUser->role->value) }}</span>
        </div>
        <div class="card-row">
            <span class="card-label">Registered</span>
            <span class="card-value">{{ $newUser->created_at->format('d M Y, H:i') }}</span>
        </div>
    </div>

    <div class="btn-wrap">
        <a class="btn" href="{{ config('app.url') }}/admin/users/{{ $newUser->id }}">View Profile</a>
    </div>
</x-emails.layout>
