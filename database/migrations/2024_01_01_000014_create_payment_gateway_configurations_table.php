<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_gateway_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_method_id')->constrained()->cascadeOnDelete();
            $table->enum('environment', ['sandbox', 'production']);
            $table->string('config_key', 100);              // e.g. 'merchant_id', 'secret_key'
            $table->text('config_value_encrypted');         // Encrypted with Laravel Crypt
            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();

            // One value per key per gateway per environment
            $table->unique(['payment_method_id', 'environment', 'config_key'], 'pgc_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_gateway_configurations');
    }
};
