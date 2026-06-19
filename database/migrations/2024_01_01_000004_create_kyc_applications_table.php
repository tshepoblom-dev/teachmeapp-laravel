<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kyc_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('application_type', ['new_tutor', 'student_upgrade']);
            $table->enum('status', [
                'pending',
                'under_review',
                'approved',
                'rejected',
                'resubmitted',
            ])->default('pending');
            $table->timestamp('submitted_at');
            $table->timestamp('reviewed_at')->nullable();
            // Admin user who reviewed
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('rejection_reason')->nullable();    // Shown to applicant
            $table->text('admin_notes')->nullable();         // Internal only
            $table->unsignedTinyInteger('resubmission_count')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_applications');
    }
};
