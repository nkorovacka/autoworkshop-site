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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();

        // Klienta info
        $table->string('customer_name');
        $table->string('customer_phone');
        $table->string('customer_email')->nullable();

        // Auto un pakalpojumi
        $table->string('car_model');
        $table->string('condition');
        $table->date('date');
        $table->string('time_slot');
        $table->text('services'); // saglabāsim kā tekstu (piem.: "exterior, interior")

        // Cena
        $table->decimal('total_price', 8, 2);

        $table->timestamps();
    });
}



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
