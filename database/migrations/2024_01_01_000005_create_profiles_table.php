<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->json('subjects')->nullable();                // ["Maths","Physics"]
            $table->decimal('hourly_rate', 10, 2)->nullable();  // Must be >= platform minimum
            $table->boolean('is_available')->default(false);

            // Cached rating stats — updated via observer on each Review
            $table->decimal('average_rating', 3, 2)->default(0.00);
            $table->unsignedInteger('total_reviews')->default(0);

            // Session counters — incremented by EscrowService on completion
            $table->unsignedInteger('total_sessions_hosted')->default(0);
            $table->unsignedInteger('total_sessions_attended')->default(0);

            // Identity verification flag (set on KYC approval)
            $table->boolean('id_verified')->default(false);

            $table->string('phone_number', 20)->nullable();
            $table->string('timezone', 50)->default('Africa/Johannesburg');
            $table->string('language_preference', 10)->default('en');

            // Tutor-specific fields
            $table->json('teaching_specializations')->nullable();    // ["Exam prep","Homework help"]
            $table->string('education_level', 100)->nullable();
            $table->unsignedInteger('years_of_experience')->nullable();

            // Tier — null until first tier threshold is crossed
            $table->foreignId('tutor_tier_id')
                ->nullable()
                ->constrained('tutor_tiers')
                ->nullOnDelete();
            $table->timestamp('tier_assigned_at')->nullable();

            // KYC status — mirrors kyc_applications.status for fast lookups
            $table->enum('kyc_status', [
                'not_submitted',
                'pending',
                'approved',
                'rejected',
            ])->default('not_submitted');

            // Link to the current (latest) KYC application
            $table->foreignId('kyc_application_id')
                ->nullable()
                ->constrained('kyc_applications')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
