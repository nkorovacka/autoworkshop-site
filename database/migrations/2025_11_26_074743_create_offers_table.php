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
    Schema::create('offers', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->string('type'); // 'webinar' vai 'detailing'
        $table->text('description')->nullable();
        $table->string('event_date')->nullable(); // piemēram "2025-12-20 19:00"

        // Vietu ierobežojums
        $table->boolean('is_limited')->default(false);
        $table->unsignedInteger('capacity')->nullable();
        $table->unsignedInteger('registrations_count')->default(0);

        // Detailing piedāvājumiem ar laika slotiem
        $table->boolean('has_timeslots')->default(false);

        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}






    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
