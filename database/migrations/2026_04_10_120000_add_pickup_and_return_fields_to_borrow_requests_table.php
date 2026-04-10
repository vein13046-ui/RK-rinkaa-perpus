<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->timestamp('pickup_deadline')->nullable()->after('approved_at');
            $table->timestamp('picked_up_at')->nullable()->after('pickup_deadline');
            $table->timestamp('return_requested_at')->nullable()->after('picked_up_at');
            $table->timestamp('return_approved_at')->nullable()->after('return_requested_at');
            $table->timestamp('cancelled_at')->nullable()->after('return_approved_at');
        });
    }

    public function down(): void
    {
        Schema::table('borrow_requests', function (Blueprint $table) {
            $table->dropColumn([
                'pickup_deadline',
                'picked_up_at',
                'return_requested_at',
                'return_approved_at',
                'cancelled_at',
            ]);
        });
    }
};
