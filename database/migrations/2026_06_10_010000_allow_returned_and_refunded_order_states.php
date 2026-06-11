<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled', 'returned') NOT NULL DEFAULT 'pending'");
            DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('pending', 'completed', 'failed', 'refunded') NOT NULL DEFAULT 'pending'");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::table('orders')->where('status', 'returned')->update(['status' => 'delivered']);
            DB::table('orders')->where('payment_status', 'refunded')->update(['payment_status' => 'completed']);
            DB::statement("ALTER TABLE orders MODIFY status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending'");
            DB::statement("ALTER TABLE orders MODIFY payment_status ENUM('pending', 'completed', 'failed') NOT NULL DEFAULT 'pending'");
        }
    }
};
