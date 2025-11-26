<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Produkts
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Klienta dati
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();

            // Pasūtījuma info
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('total_price', 8, 2);

            // Piegādes info UZREIZ šeit
            $table->string('delivery_method')->default('pickup'); // pickup / delivery
            $table->string('delivery_address')->nullable();       // adrese / pakomāts, ja delivery

            $table->string('status')->default('new'); // new / confirmed / done

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
