<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->string('payment_method', 20)->default('cash')->after('borrow_days');
            $table->string('pickup_method', 20)->default('self_pickup')->after('payment_method');
            $table->unsignedInteger('delivery_distance_meters')->default(0)->after('pickup_method');
            $table->unsignedInteger('daily_rate')->default(3000)->after('delivery_distance_meters');
            $table->unsignedInteger('delivery_rate_per_100m')->default(500)->after('daily_rate');
            $table->unsignedInteger('daily_cost')->default(0)->after('delivery_rate_per_100m');
            $table->unsignedInteger('delivery_cost')->default(0)->after('daily_cost');
            $table->unsignedInteger('total_cost')->default(0)->after('delivery_cost');
        });
    }

    public function down(): void
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'pickup_method',
                'delivery_distance_meters',
                'daily_rate',
                'delivery_rate_per_100m',
                'daily_cost',
                'delivery_cost',
                'total_cost',
            ]);
        });
    }
};
