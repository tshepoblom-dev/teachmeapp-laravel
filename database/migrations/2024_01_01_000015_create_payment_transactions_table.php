<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('wallet_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('booking_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('payment_method_id')->constrained();
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('ZAR');
            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'refunded',
                'cancelled',
            ])->default('pending');
            $table->string('gateway_transaction_id', 255)->nullable()->index(); // Gateway's reference
            $table->string('gateway_status', 100)->nullable();                  // Raw status from gateway
            $table->json('metadata')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->decimal('refund_amount', 12, 2)->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status']);
            $table->index(['payment_method_id', 'status']);
        });

        // Now add the FK from wallet_transactions to payment_transactions
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->foreign('payment_transaction_id')
                ->references('id')
                ->on('payment_transactions')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropForeign(['payment_transaction_id']);
        });

        Schema::dropIfExists('payment_transactions');
    }
};
