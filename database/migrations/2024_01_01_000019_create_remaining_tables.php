<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Interactive polls during sessions
        Schema::create('session_polls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->constrained()->cascadeOnDelete();
            $table->string('question', 255);
            $table->json('options');                            // ["A","B","C"]
            $table->foreignId('created_by')->constrained('users');
            $table->enum('status', ['active', 'closed'])->default('active');
            $table->json('results')->nullable();                // Anonymous aggregated results
            $table->timestamps();
        });

        Schema::create('poll_responses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->constrained('session_polls')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->json('response');                           // Selected option(s)
            $table->timestamp('responded_at')->useCurrent();

            $table->unique(['poll_id', 'user_id']);             // One response per user per poll
        });

        // Guardian–student relationships for minors
        Schema::create('parent_user_guardians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained('users')->cascadeOnDelete();
            $table->string('relationship', 50);                 // 'parent','legal_guardian'
            $table->boolean('can_book_sessions')->default(true);
            $table->boolean('can_receive_reports')->default(true);
            $table->boolean('is_primary_contact')->default(false);
            $table->timestamp('consent_provided_at');
            $table->string('consent_proof_ip', 45)->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'guardian_id']);
        });

        // Per-booking invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('booking_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('tutor_id')->constrained('users');
            $table->string('invoice_number', 50)->unique();     // Human-readable e.g. INV-2024-001
            $table->decimal('amount', 12, 2);
            $table->decimal('vat_amount', 12, 2)->default(0);
            $table->decimal('total_amount', 12, 2);
            $table->enum('status', [
                'pending',
                'paid',
                'refunded',
                'cancelled',
            ])->default('pending');
            $table->string('pdf_url', 511)->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['student_id', 'created_at']);
            $table->index(['tutor_id',   'created_at']);
            $table->index(['student_id', 'status']);
        });

        // Admin action audit trail
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('action', 100);                      // e.g. 'user_suspended'
            $table->string('target_type', 100);                 // e.g. 'user','booking','session'
            $table->unsignedBigInteger('target_id');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
            // No updated_at — audit logs are immutable

            $table->index(['target_type', 'target_id']);
            $table->index(['user_id', 'created_at']);
            $table->index('action');
        });

        // Admin-managed platform configuration
        Schema::create('platform_settings', function (Blueprint $table) {
            $table->id();
            $table->string('group', 100);
            $table->string('key', 100);
            $table->text('value');
            $table->enum('data_type', ['string', 'integer', 'decimal', 'boolean', 'json']);
            $table->string('label', 255);
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(false);       // Safe to expose to unauthenticated users
            $table->boolean('is_encrypted')->default(false);    // Value encrypted via Crypt facade
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['group', 'key']);
            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('platform_settings');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('parent_user_guardians');
        Schema::dropIfExists('poll_responses');
        Schema::dropIfExists('session_polls');
    }
};
