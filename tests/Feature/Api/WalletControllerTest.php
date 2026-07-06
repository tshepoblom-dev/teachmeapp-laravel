<?php

namespace Tests\Feature\Api;

use App\Models\PaymentMethod;
use App\Models\User;
use App\Models\WalletTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WalletControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_view_wallet_with_payment_methods(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        PaymentMethod::create([
            'code' => 'eft', 'name' => 'EFT', 'is_active' => true, 'display_order' => 1,
            'payment_flow' => 'redirect', 'supported_currencies' => ['ZAR'],
        ]);

        $response = $this->actingAs($student)->getJson('/api/wallet');

        $response->assertOk()
            ->assertJsonPath('data.balance', 0)
            ->assertJsonPath('data.escrow_balance', 0)
            ->assertJsonCount(1, 'data.payment_methods');
    }

    public function test_tutor_can_view_wallet_without_payment_methods(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);

        $response = $this->actingAs($tutor)->getJson('/api/wallet');

        $response->assertOk()->assertJsonMissingPath('data.payment_methods');
    }

    public function test_wallet_transactions_are_paginated(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $wallet = $student->wallet;

        for ($i = 0; $i < 25; $i++) {
            WalletTransaction::create([
                'wallet_id' => $wallet->id,
                'type' => 'deposit',
                'amount' => 10,
                'direction' => 'credit',
                'balance_before' => 0,
                'balance_after' => 10,
            ]);
        }

        $response = $this->actingAs($student)->getJson('/api/wallet/transactions');

        $response->assertOk()
            ->assertJsonCount(20, 'data.data')
            ->assertJsonPath('data.meta.last_page', 2);
    }
}
