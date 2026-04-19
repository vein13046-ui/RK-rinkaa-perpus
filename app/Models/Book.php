<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'kategori',
        'tahun_terbit',
        'isbn',
        'stok',
        'cover',
        'kode_buku',
        'profile_path',
        'book_profile',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'book_profile' => 'array',
    ];

    public function getCoverUrlAttribute(): string
    {
        $defaultCover = asset('cover_buku/default-cover.svg');
        $cover = trim((string) $this->cover);

        if ($cover === '') {
            return $defaultCover;
        }

        if (Storage::disk('public')->exists($cover)) {
            return route('public.storage.show', ['path' => $cover]);
        }

        return $defaultCover;
    }

    public function borrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class);
    }
}
