<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $fillable = [
    'name',
    'description',
    'base_price',
];

    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');                    // Produkta nosaukums
            $table->text('description')->nullable();   // Apraksts (nav obligāts)
            $table->decimal('price', 8, 2);            // Cena (piem., 12.99)
            $table->string('image')->nullable();       // Attēla ceļš (nav obligāts)
            $table->timestamps();                      // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
    
