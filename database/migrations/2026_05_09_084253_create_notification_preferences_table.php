<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_preferences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Notification type key — matches toArray()['type'] in each Notification class
            $table->string('notification_type', 100);

            // Channels the user wants for this type
            // Stored as JSON array: ["database","mail","fcm"]
            $table->json('channels')->nullable();

            // Master on/off toggle for the type
            $table->boolean('enabled')->default(true);

            $table->timestamps();

            $table->unique(['user_id', 'notification_type']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_preferences');
    }
};
