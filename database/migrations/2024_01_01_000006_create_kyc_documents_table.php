<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kyc_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kyc_application_id')->constrained()->cascadeOnDelete();
            // Denormalised for direct user queries without joining kyc_applications
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('document_type', [
                'national_id',
                'passport',
                'drivers_licence',
                'selfie',
                'proof_of_qualification',
                'proof_of_address',
                'other',
            ]);
            $table->string('file_path', 255);               // Private disk path — never public
            $table->string('file_hash', 64);                // SHA-256 integrity check
            $table->string('mime_type', 100);
            $table->unsignedInteger('file_size_kb');
            $table->enum('status', ['uploaded', 'verified', 'rejected'])->default('uploaded');
            $table->timestamp('verified_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_documents');
    }
};
