<?php
require __DIR__.'/vendor/autoload.php';
$app = require __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$u = App\Models\User::find(1153);
echo 'role: ' . $u->role->value . PHP_EOL;
echo 'raw slots: ' . $u->availabilitySlots()->get()->toJson() . PHP_EOL;
echo 'active slots: ' . $u->availabilitySlots->where('is_active', true)->values()->toJson() . PHP_EOL;
echo 'profile is_available: ' . ($u->profile->is_available ?? 'NO PROFILE') . PHP_EOL;
echo 'kyc_status: ' . ($u->profile->kyc_status ?? 'NO PROFILE') . PHP_EOL;
