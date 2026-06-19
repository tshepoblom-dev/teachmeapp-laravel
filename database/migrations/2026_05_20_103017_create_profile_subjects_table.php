<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profile_subjects', function (Blueprint $table) {
            $table->foreignId('profile_id')->constrained('profiles')->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->cascadeOnDelete();
            $table->primary(['profile_id', 'subject_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profile_subjects');
    }
};