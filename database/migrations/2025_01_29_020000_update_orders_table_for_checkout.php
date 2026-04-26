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
            if (!Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
            }
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->default('')->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'customer_phone')) {
                $table->string('customer_phone')->nullable()->after('customer_name');
            }
            if (!Schema::hasColumn('orders', 'total_price')) {
                $table->decimal('total_price', 10, 2)->default(0)->after('user_id');
            }
            if (!Schema::hasColumn('orders', 'status')) {
                $table->string('status')->default('pending')->after('total_price');
            }
            if (!Schema::hasColumn('orders', 'shipping_method')) {
                $table->string('shipping_method')->after('status');
            }
            if (!Schema::hasColumn('orders', 'shipping_address')) {
                $table->string('shipping_address')->nullable()->after('shipping_method');
            }
            if (!Schema::hasColumn('orders', 'payment_method')) {
                $table->string('payment_method')->default('card')->after('shipping_address');
            }
            if (!Schema::hasColumn('orders', 'card_holder')) {
                $table->string('card_holder')->after('payment_method');
            }
            if (!Schema::hasColumn('orders', 'notes')) {
                $table->text('notes')->nullable()->after('card_holder');
            }
            if (!Schema::hasColumn('orders', 'created_at')) {
                $table->timestamps();
            }
        });
    }

    public function down(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            foreach ([
                'notes',
                'card_holder',
                'payment_method',
                'shipping_address',
                'shipping_method',
                'status',
                'total_price',
                'customer_name',
                'customer_phone',
            ] as $column) {
                if (Schema::hasColumn('orders', $column)) {
                    $table->dropColumn($column);
                }
            }

            if (Schema::hasColumn('orders', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
