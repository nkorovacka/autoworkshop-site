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

            if (Schema::hasColumn('orders', 'card_last4')) {
                $columnsToDrop[] = 'card_last4';
            }

            if (Schema::hasColumn('orders', 'items_summary')) {
                $columnsToDrop[] = 'items_summary';
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
            if (!Schema::hasColumn('orders', 'card_last4')) {
                $table->string('card_last4', 4)->nullable()->after('card_holder');
            }

            if (!Schema::hasColumn('orders', 'items_summary')) {
                $table->longText('items_summary')->nullable()->after('card_last4');
            }
        });
    }
};
