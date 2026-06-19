<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete();
            $table->enum('type', [
                'deposit',
                'withdrawal',
                'escrow_hold',
                'escrow_release',
                'escrow_refund',
                'platform_fee',
                'payout',
                'refund',
            ]);
            $table->decimal('amount', 12, 2);                   // Always positive
            $table->enum('direction', ['credit', 'debit']);
            $table->decimal('balance_before', 12, 2);           // Immutable audit ledger
            $table->decimal('balance_after', 12, 2);
            $table->string('reference', 255)->nullable();        // External reference
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();                // Extra context
            // Linked to a payment_transaction record when applicable
            // FK added after payment_transactions table is created
            $table->unsignedBigInteger('payment_transaction_id')->nullable()->index();
            $table->timestamps();

            $table->index(['wallet_id', 'type']);
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
