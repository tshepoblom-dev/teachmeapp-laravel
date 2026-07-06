<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class BackfillMissingWallets extends Command
{
    protected $signature = 'wallets:backfill';

    protected $description = 'Create a zero-balance wallet for any user missing one';

    public function handle(): int
    {
        $users = User::leftJoin('wallets', 'wallets.user_id', '=', 'users.id')
            ->whereNull('wallets.id')
            ->select('users.id', 'users.email')
            ->get();

        if ($users->isEmpty()) {
            $this->info('No users are missing a wallet.');

            return self::SUCCESS;
        }

        $this->info("Found {$users->count()} user(s) missing a wallet. Creating...");

        foreach ($users as $user) {
            Wallet::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0.00, 'escrow_balance' => 0.00, 'currency' => 'ZAR']
            );

            $this->line("  Created wallet for user #{$user->id} ({$user->email})");
        }

        Log::info('BackfillMissingWallets: backfill complete', ['count' => $users->count()]);

        $this->info("Done. Created {$users->count()} wallet(s).");

        return self::SUCCESS;
    }
}
