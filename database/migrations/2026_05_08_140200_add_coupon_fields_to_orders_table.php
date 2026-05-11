<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('orders', 'coupon_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('coupon_id')->nullable()->after('user_id');
                $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null');
            });
        }

        if (! Schema::hasColumn('orders', 'discount_amount')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->decimal('discount_amount', 10, 2)->default(0)->after('total_amount');
            });
        }

        if (! Schema::hasColumn('orders', 'shipping_address')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('shipping_address')->nullable()->after('payment_status');
            });
        }

        if (! Schema::hasColumn('orders', 'order_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('order_number')->unique()->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'coupon_id')) {
                $table->dropForeign(['coupon_id']);
                $table->dropColumn('coupon_id');
            }
            if (Schema::hasColumn('orders', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
        });
    }
};
