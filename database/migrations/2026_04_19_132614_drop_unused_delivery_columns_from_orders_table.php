<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            $columnsToDrop = [];

            if (Schema::hasColumn('orders', 'delivery_method')) {
                $columnsToDrop[] = 'delivery_method';
            }

            if (Schema::hasColumn('orders', 'delivery_address')) {
                $columnsToDrop[] = 'delivery_address';
            }

            if ($columnsToDrop !== []) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'delivery_method')) {
                $table->string('delivery_method')->default('pickup')->after('total_price');
            }

            if (!Schema::hasColumn('orders', 'delivery_address')) {
                $table->string('delivery_address')->nullable()->after('delivery_method');
            }
        });
    }
};
