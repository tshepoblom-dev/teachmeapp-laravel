<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_availability_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tutor_id')->constrained('users')->cascadeOnDelete();
            $table->tinyInteger('day_of_week');             // 0=Mon … 6=Sun
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_recurring')->default(true); // Repeats weekly if true
            $table->date('valid_from')->nullable();          // Optional bounded range
            $table->date('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['tutor_id', 'day_of_week', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_availability_slots');
    }
};
