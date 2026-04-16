<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('kode_buku')->unique()->after('isbn');
            $table->string('profile_path')->nullable()->after('kode_buku');
            $table->json('book_profile')->nullable()->after('profile_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->dropColumn(['kode_buku', 'profile_path', 'book_profile']);
        });
    }
};
