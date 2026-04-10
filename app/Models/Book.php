<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
    ];

    public function borrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class);
    }
}
