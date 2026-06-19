<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tutor_tiers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 100)->unique();                          // Used by Flutter for theming
            $table->unsignedInteger('sessions_threshold');                  // Min completed sessions to reach this tier
            $table->decimal('commission_rate', 5, 2);                       // Platform's cut %
            $table->decimal('bonus_rate_above_threshold', 5, 2)->nullable(); // Extra % for exceeding threshold
            $table->string('theme_colour_primary', 7);                      // Hex e.g. #CD7F32
            $table->string('theme_colour_secondary', 7);
            $table->string('badge_icon_url', 255)->nullable();
            $table->json('features')->nullable();                           // e.g. ["priority_support","featured_listing"]
            $table->boolean('is_active')->default(true);
            $table->tinyInteger('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tutor_tiers');
    }
};
