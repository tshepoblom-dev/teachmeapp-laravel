<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('tutor_id')->constrained('users');
            $table->string('subject', 100);
            $table->text('description')->nullable();
            $table->dateTime('scheduled_at');
            $table->unsignedInteger('duration_minutes');

            // Rate and fee snapshots — locked at booking time for dispute protection
            $table->decimal('hourly_rate_snapshot', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->decimal('platform_fee_snapshot', 5, 2);    // Commission % at booking time

            // Which payment gateway was used
            $table->foreignId('payment_method_id')
                ->nullable()
                ->constrained('payment_methods')
                ->nullOnDelete();

            $table->enum('status', [
                'pending',
                'accepted',
                'declined',
                'cancelled',
                'in_progress',
                'completed',
                'disputed',
                'refunded',
            ])->default('pending');

            $table->text('cancellation_reason')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();

            // Audit trail for rescheduling
            $table->foreignId('rescheduled_from_booking_id')
                ->nullable()
                ->constrained('bookings')
                ->nullOnDelete();

            $table->timestamps();

            $table->index(['student_id', 'status']);
            $table->index(['tutor_id', 'status']);
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
