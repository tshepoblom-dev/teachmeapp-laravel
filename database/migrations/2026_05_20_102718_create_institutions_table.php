<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('institutions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbreviation', 20)->nullable();   // e.g. UCT, CPUT, TUT
            $table->enum('type', [
                'university',
                'university_of_technology',
                'private_college',
                'tvet_college',
                'high_school',
                'other',
            ])->default('other');
            $table->string('city', 100)->nullable();
            $table->string('province', 100)->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('institutions');
    }
};