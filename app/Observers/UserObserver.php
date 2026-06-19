<?php

namespace App\Observers;

use App\Enums\KycStatus;
use App\Models\Profile;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    /**
     * After a new user is created, provision their Profile and Wallet.
     *
     * This runs synchronously inside the same transaction as the user insert,
     * so if either fails the whole registration rolls back.
     */
    public function created(User $user): void
    {
        $this->createProfile($user);
        $this->createWallet($user);
    }

    private function createProfile(User $user): void
    {
        try {
            Profile::create([
                'user_id'             => $user->id,
                'timezone'            => 'Africa/Johannesburg',
                'language_preference' => 'en',
                'kyc_status'          => KycStatus::NotSubmitted,
                'is_available'        => false,
                'id_verified'         => false,
                'average_rating'      => 0.00,
                'total_reviews'       => 0,
                'total_sessions_hosted'   => 0,
                'total_sessions_attended' => 0,
            ]);
        } catch (\Throwable $e) {
            Log::error('UserObserver: failed to create profile', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    private function createWallet(User $user): void
    {
        try {
            Wallet::create([
                'user_id'        => $user->id,
                'balance'        => 0.00,
                'escrow_balance' => 0.00,
                'currency'       => 'ZAR',
            ]);
        } catch (\Throwable $e) {
            Log::error('UserObserver: failed to create wallet', [
                'user_id' => $user->id,
                'error'   => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
