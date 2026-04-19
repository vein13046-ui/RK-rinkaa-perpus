<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SupportThread extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'issue_type',
        'status',
        'last_message_at',
        'unread_user_count',
        'unread_admin_count',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
        'unread_user_count' => 'integer',
        'unread_admin_count' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(SupportMessage::class)->orderBy('created_at');
    }

    public function latestMessage(): HasOne
    {
        return $this->hasOne(SupportMessage::class)->latestOfMany();
    }

    public static function issueOptions(): array
    {
        return [
            'bug' => 'Bug / Error',
            'password' => 'Lupa Password',
            'transaction' => 'Masalah Transaksi',
            'borrow' => 'Masalah Peminjaman',
            'lost_book' => 'Laporan Buku Hilang',
            'other' => 'Lainnya',
        ];
    }

    public function getIssueTypeLabelAttribute(): string
    {
        return static::issueOptions()[$this->issue_type] ?? 'Belum dipilih';
    }

    public function getIssuePromptAttribute(): string
    {
        return match ($this->issue_type) {
            'bug' => 'Jelaskan bug yang kamu temukan, langkahnya, dan apa yang seharusnya terjadi.',
            'password' => 'Jelaskan kendala lupa password atau akses akun yang kamu alami.',
            'transaction' => 'Jelaskan masalah transaksi yang terjadi dengan detail.',
            'borrow' => 'Jelaskan masalah peminjaman, status, atau kendala pengambilan buku.',
            'lost_book' => 'Jelaskan laporan buku hilang dan informasi yang perlu diketahui admin.',
            'other' => 'Tulis pesanmu dengan bebas dan jelaskan kebutuhanmu kepada admin.',
            default => 'Pilih jenis masalah terlebih dahulu agar admin lebih cepat membantu.',
        };
    }

    public function getIssuePlaceholderAttribute(): string
    {
        return match ($this->issue_type) {
            'bug' => 'Contoh: ketika klik tombol pinjam, halaman tidak merespons...',
            'password' => 'Contoh: saya lupa password dan tidak bisa login...',
            'transaction' => 'Contoh: pembayaran berhasil tapi status belum berubah...',
            'borrow' => 'Contoh: status peminjaman tidak muncul / buku belum bisa diambil...',
            'lost_book' => 'Contoh: saya ingin melaporkan buku yang hilang atau rusak...',
            'other' => 'Tulis pesan kamu di sini...',
            default => 'Pilih jenis masalah terlebih dahulu...',
        };
    }
}
