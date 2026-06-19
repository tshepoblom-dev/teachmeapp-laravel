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
        Schema::table('users', function (Blueprint $table) {
                $table->timestamp('consent_accepted_at')->nullable()->after('fcm_token');
                $table->string('consent_ip', 45)->nullable()->after('consent_accepted_at');
                $table->text('consent_user_agent')->nullable()->after('consent_ip');
          });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['consent_accepted_at', 'consent_ip', 'consent_user_agent']);
        });
    }
};
