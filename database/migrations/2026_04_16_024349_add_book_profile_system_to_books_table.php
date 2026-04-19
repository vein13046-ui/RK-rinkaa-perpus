<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table) {
            if (! Schema::hasColumn('books', 'kode_buku')) {
                $table->string('kode_buku')->nullable()->after('isbn');
            }

            if (! Schema::hasColumn('books', 'profile_path')) {
                $table->string('profile_path')->nullable()->after('kode_buku');
            }

            if (! Schema::hasColumn('books', 'book_profile')) {
                $table->json('book_profile')->nullable()->after('profile_path');
            }
        });

        if (Schema::hasColumn('books', 'kode_buku')) {
            $books = DB::table('books')
                ->whereNull('kode_buku')
                ->orderBy('id')
                ->get();

            foreach ($books as $book) {
                $kodeBuku = 'BK' . str_pad((string) $book->id, 6, '0', STR_PAD_LEFT);

                DB::table('books')
                    ->where('id', $book->id)
                    ->update(['kode_buku' => $kodeBuku]);
            }
        }

        // Intentionally skip column alteration here to keep deployment safe
        // on servers that do not have doctrine/dbal installed.
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $columns = [];

        if (Schema::hasColumn('books', 'book_profile')) {
            $columns[] = 'book_profile';
        }

        if (Schema::hasColumn('books', 'profile_path')) {
            $columns[] = 'profile_path';
        }

        if (Schema::hasColumn('books', 'kode_buku')) {
            $columns[] = 'kode_buku';
        }

        if (! empty($columns)) {
            Schema::table('books', function (Blueprint $table) use ($columns) {
                $table->dropColumn($columns);
            });
        }
    }
};
