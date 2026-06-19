<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Domain sessions table — tutoring video sessions.
 * Not to be confused with the Laravel HTTP sessions driver table.
 * SESSION_DRIVER must be set to 'file' or 'redis' in .env.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained()->cascadeOnDelete();

            // Agora channel — permanent for session lifecycle
            $table->string('agora_channel_name', 255)->unique();

            // Short-lived tokens — regenerated on every join request
            $table->text('agora_token_student')->nullable();
            $table->text('agora_token_tutor')->nullable();
            $table->unsignedInteger('agora_uid_student');
            $table->unsignedInteger('agora_uid_tutor');

            // Lifecycle timestamps
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->foreignId('ended_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('early_termination_reason')->nullable();

            // Recording
            $table->boolean('recording_enabled')->default(true);
            $table->string('recording_url', 511)->nullable();

            $table->enum('status', [
                'waiting',
                'active',
                'ended',
                'abandoned',
                'disputed',
            ])->default('waiting');

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
    }
};
