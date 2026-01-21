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
            if (!Schema::hasColumn('orders', 'total_items')) {
                $table->unsignedInteger('total_items')->default(0)->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'items_summary')) {
                $table->longText('items_summary')->nullable()->after('card_last4');
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'items_summary')) {
                $table->dropColumn('items_summary');
            }
            if (Schema::hasColumn('orders', 'total_items')) {
                $table->dropColumn('total_items');
            }
        });
    }
};
