<?php

namespace Tests\Feature\Api;

use App\Models\PayoutAccount;
use App\Models\User;
use App\Services\WalletService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayoutControllerTest extends TestCase
{
    use RefreshDatabase;

    private function payoutAccountPayload(): array
    {
        return [
            'account_type' => 'bank',
            'account_holder_name' => 'Jane Doe',
            'account_number' => '1234567890',
            'branch_code' => '123456',
            'bank_name' => 'Test Bank',
        ];
    }

    public function test_tutor_can_create_payout_account(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);

        $response = $this->actingAs($tutor)->postJson('/api/payout/accounts', $this->payoutAccountPayload());

        $response->assertCreated();
        $this->assertDatabaseHas('payout_accounts', ['user_id' => $tutor->id, 'bank_name' => 'Test Bank']);
        $response->assertJsonMissingPath('data.account_number');
        $response->assertJsonMissingPath('data.account_number_encrypted');
    }

    public function test_student_can_also_create_payout_account(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->postJson('/api/payout/accounts', $this->payoutAccountPayload());

        $response->assertCreated();
        $this->assertDatabaseHas('payout_accounts', ['user_id' => $student->id]);
    }

    public function test_admin_forbidden_from_payout_routes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)->getJson('/api/payout/accounts')->assertForbidden();
    }

    public function test_tutor_cannot_set_default_on_other_tutors_account(): void
    {
        $tutorA = User::factory()->create(['role' => 'tutor']);
        $tutorB = User::factory()->create(['role' => 'tutor']);

        $account = PayoutAccount::create([
            'user_id' => $tutorB->id,
            'account_type' => 'bank',
            'account_holder_name' => 'Tutor B',
            'account_number_encrypted' => encrypt('111'),
            'bank_name' => 'Bank B',
            'is_verified' => true,
        ]);

        $this->actingAs($tutorA)
            ->postJson("/api/payout/accounts/{$account->id}/default")
            ->assertForbidden();
    }

    public function test_payout_request_on_unverified_account_returns_error(): void
    {
        $tutor = User::factory()->create(['role' => 'tutor']);
        app(WalletService::class)->credit($tutor->wallet, 200, ['type' => \App\Enums\WalletTransactionType::Deposit]);

        $account = PayoutAccount::create([
            'user_id' => $tutor->id,
            'account_type' => 'bank',
            'account_holder_name' => 'Tutor',
            'account_number_encrypted' => encrypt('111'),
            'bank_name' => 'Bank',
            'is_verified' => false,
        ]);

        $response = $this->actingAs($tutor)->postJson('/api/payout/request', [
            'amount' => 100,
            'payout_account_id' => $account->id,
        ]);

        $response->assertStatus(422)->assertJsonPath('success', false);
    }
}
