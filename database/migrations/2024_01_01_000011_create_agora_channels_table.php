<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('agora_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('session_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('channel_name', 255)->unique();
            $table->boolean('is_active')->default(false);
            $table->timestamp('last_keepalive_at')->nullable();
            $table->unsignedInteger('total_duration_seconds')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('agora_channels');
    }
};
