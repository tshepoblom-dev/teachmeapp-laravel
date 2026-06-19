<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escrow_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('student_wallet_id')->constrained('wallets');
            $table->foreignId('tutor_wallet_id')->constrained('wallets');
            $table->decimal('amount', 12, 2);                           // Total held amount

            // Commission fields — snapshotted at release time
            $table->decimal('commission_rate_snapshot', 5, 2)->nullable(); // % used at release
            $table->decimal('commission_amount', 12, 2)->nullable();        // Actual ZAR deducted
            $table->decimal('net_to_tutor', 12, 2)->nullable();             // amount - commission_amount

            $table->enum('status', [
                'held',
                'released',
                'refunded',
                'disputed',
            ])->default('held');

            $table->timestamp('held_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->timestamp('refunded_at')->nullable();
            $table->text('release_reason')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrow_transactions');
    }
};
