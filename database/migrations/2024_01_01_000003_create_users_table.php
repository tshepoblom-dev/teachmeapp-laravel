<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Replaces the default Laravel/Jetstream users migration.
 * Adds role, account_status, suspension fields, login tracking,
 * and default_payment_method_id FK.
 *
 * tutor_tiers and payment_methods must exist before this runs.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Jetstream 2FA
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->timestamp('two_factor_confirmed_at')->nullable();

            // Platform role — guards middleware and route access
            $table->enum('role', ['student', 'tutor', 'admin'])->default('student');

            // Account lifecycle
            $table->enum('account_status', [
                'active',
                'suspended',
                'banned',
                'pending_kyc',
            ])->default('active');
            $table->timestamp('suspended_until')->nullable();
            $table->text('suspension_reason')->nullable();

            // Jetstream profile photo
            $table->string('profile_photo_path', 2048)->nullable();

            // Login audit
            $table->timestamp('last_login_at')->nullable();
            $table->string('last_login_ip', 45)->nullable();

            // User's default payment gateway (set in preferences)
            $table->foreignId('default_payment_method_id')
                ->nullable()
                ->constrained('payment_methods')
                ->nullOnDelete();

            $table->rememberToken();
            $table->timestamps();
        });

        // Laravel default support table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
        // NOTE: No HTTP sessions table — API-first; use SESSION_DRIVER=file or redis in .env
    }

    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
