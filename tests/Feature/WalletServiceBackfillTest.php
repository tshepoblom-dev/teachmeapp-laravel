<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Wallet;
use App\Services\WalletService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletServiceBackfillTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_or_create_wallet_returns_existing_wallet(): void
    {
        $user = User::factory()->create();
        $existing = $user->wallet;

        $wallet = app(WalletService::class)->getOrCreateWallet($user->fresh());

        $this->assertSame($existing->id, $wallet->id);
        $this->assertSame(1, Wallet::where('user_id', $user->id)->count());
    }

    public function test_get_or_create_wallet_self_heals_when_wallet_is_missing(): void
    {
        $user = User::factory()->create();
        Wallet::where('user_id', $user->id)->delete();

        $this->assertNull($user->wallet()->first());

        $wallet = app(WalletService::class)->getOrCreateWallet($user->fresh());

        $this->assertNotNull($wallet);
        $this->assertSame($user->id, $wallet->user_id);
        $this->assertSame('0.00', (string) $wallet->balance);
        $this->assertSame('ZAR', $wallet->currency);
    }
}
