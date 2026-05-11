<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->string('status')->default('pending')->change();
            $table->string('pickup_address')->nullable()->after('admin_notes');
            $table->string('tracking_number')->nullable();
            $table->timestamp('pickup_date')->nullable();
            $table->timestamp('refund_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('return_requests', function (Blueprint $table) {
            $table->dropColumn(['pickup_address', 'tracking_number', 'pickup_date', 'refund_date']);
        });
    }
};
