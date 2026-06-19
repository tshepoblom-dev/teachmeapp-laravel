<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // PayFast-specific transaction data
        Schema::create('payfast_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_transaction_id')
                ->unique()
                ->constrained('payment_transactions')
                ->cascadeOnDelete();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->string('pf_payment_id', 255)->nullable()->unique(); // PayFast's ID from ITN
            $table->string('m_payment_id', 255)->unique();              // Our internal merchant ref
            $table->decimal('amount_gross', 12, 2);
            $table->decimal('amount_fee', 12, 2)->default(0);           // PayFast's fee
            $table->decimal('amount_net', 12, 2);                       // Credited to wallet
            $table->string('item_name', 255);
            $table->enum('payment_status', [
                'initiated',
                'complete',
                'failed',
                'cancelled',
            ])->default('initiated');
            $table->boolean('itn_verified')->default(false);            // ITN signature verified
            $table->json('itn_payload')->nullable();                    // Raw ITN for audit
            $table->string('signature', 255)->nullable();
            $table->timestamps();

            $table->index('m_payment_id');
        });

        // Stripe-specific transaction data
        Schema::create('stripe_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_transaction_id')
                ->unique()
                ->constrained('payment_transactions')
                ->cascadeOnDelete();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->string('stripe_payment_intent_id', 255)->unique();
            $table->string('stripe_customer_id', 255)->nullable();
            $table->string('payment_method_id_stripe', 255)->nullable(); // Stripe PM ID
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('ZAR');
            $table->decimal('fee_amount', 12, 2)->nullable();            // Stripe fee
            $table->decimal('net_amount', 12, 2)->nullable();
            $table->string('status', 50);                               // Stripe's raw status
            $table->json('webhook_payload')->nullable();                 // Raw webhook data
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stripe_transactions');
        Schema::dropIfExists('payfast_transactions');
    }
};
