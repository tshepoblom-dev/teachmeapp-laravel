<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // In-session / post-session incident reports
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reporter_id')->constrained('users');
            $table->foreignId('reported_id')->constrained('users');
            $table->text('reason');
            $table->text('description')->nullable();
            // What the reporter chose to do at submission time
            $table->enum('action_taken', ['continue_session', 'end_session']);
            $table->enum('status', [
                'pending',
                'under_review',
                'resolved',
                'dismissed',
            ])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'created_at']);
        });

        // Post-session reviews (one per booking)
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('reviewer_id')->constrained('users');
            $table->foreignId('reviewee_id')->constrained('users');
            $table->tinyInteger('rating');                      // 1–5
            $table->text('comment')->nullable();
            $table->json('tags')->nullable();                   // ["patient","knowledgeable"]
            $table->boolean('is_visible')->default(true);
            $table->timestamp('reviewed_at')->useCurrent();
            $table->timestamps();

            $table->index(['reviewee_id', 'is_visible']);
        });

        // Session in-app chat
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_id')->constrained('users');
            $table->text('message');
            $table->json('attachments')->nullable();
            $table->boolean('is_system_message')->default(false);
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('created_at')->useCurrent();
            // No updated_at — messages are immutable

            $table->index(['session_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
        Schema::dropIfExists('reviews');
        Schema::dropIfExists('reports');
    }
};
