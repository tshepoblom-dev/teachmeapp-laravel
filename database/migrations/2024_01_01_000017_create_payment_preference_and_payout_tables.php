<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // User's saved/preferred payment methods
        Schema::create('user_payment_method_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_default')->default(false);
            $table->json('saved_details')->nullable();           // Tokenized details (e.g. card fingerprint)
            $table->string('gateway_customer_id', 255)->nullable(); // e.g. Stripe customer ID

            $table->unique(['user_id', 'payment_method_id'], 'upmp_unique');
            $table->timestamps();
        });

        // Tutor bank/payout accounts
        Schema::create('payout_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('account_type', ['bank', 'payfast', 'stripe', 'paypal']);
            $table->string('account_holder_name', 255);
            $table->text('account_number_encrypted');           // Encrypted at rest
            $table->string('branch_code', 10)->nullable();
            $table->string('bank_name', 100)->nullable();
            $table->string('gateway_account_id', 255)->nullable(); // External reference
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_default')->default(false);
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'is_default']);
        });

        // Tutor payout requests
        Schema::create('payout_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payout_account_id')->constrained()->cascadeOnDelete();
            $table->decimal('amount', 12, 2);
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'cancelled',
            ])->default('pending');
            $table->string('reference', 255)->unique();         // Our internal reference
            $table->string('external_payout_id', 255)->nullable(); // Gateway's reference
            $table->text('failure_reason')->nullable();
            $table->timestamp('processed_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payout_transactions');
        Schema::dropIfExists('payout_accounts');
        Schema::dropIfExists('user_payment_method_preferences');
    }
};
