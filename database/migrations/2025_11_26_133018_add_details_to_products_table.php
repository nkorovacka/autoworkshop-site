<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('stock')->default(0);      // atlikums noliktavā
            $table->string('supplier')->nullable();            // piegādātājs
            $table->string('origin_country')->nullable();      // valsts
            $table->text('usage_instructions')->nullable();    // kā lietot
            $table->text('long_description')->nullable();      // plašāks apraksts
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'stock',
                'supplier',
                'origin_country',
                'usage_instructions',
                'long_description',
            ]);
        });
    }
};
