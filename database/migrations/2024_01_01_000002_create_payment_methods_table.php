<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();           // e.g. 'payfast', 'stripe', 'wallet_balance'
            $table->string('name', 100);                    // e.g. 'PayFast', 'Credit Card (Stripe)'
            $table->text('description')->nullable();
            $table->string('logo_url', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);
            $table->integer('display_order')->default(0);
            $table->json('supported_currencies');           // ["ZAR","USD","EUR"]
            $table->decimal('min_amount', 12, 2)->nullable();
            $table->decimal('max_amount', 12, 2)->nullable();
            // How the payment is collected
            $table->enum('payment_flow', ['redirect', 'modal', 'direct', 'wallet']);
            $table->integer('settlement_days')->default(1); // Days until funds settle
            $table->json('config_schema')->nullable();      // JSON schema for admin UI rendering
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
