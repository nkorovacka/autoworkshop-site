<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            return;
        }

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->decimal('total_price', 10, 2);
            $table->unsignedInteger('total_items')->default(0);
            $table->string('status')->default('pending');
            $table->string('shipping_method');
            $table->string('shipping_address')->nullable();
            $table->string('payment_method')->default('card');
            $table->string('card_holder');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
