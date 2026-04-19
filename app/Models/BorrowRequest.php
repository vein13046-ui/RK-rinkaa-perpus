<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class BorrowRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'book_id',
        'borrower_name',
        'borrow_days',
        'payment_method',
        'pickup_method',
        'delivery_distance_meters',
        'daily_rate',
        'delivery_rate_per_100m',
        'daily_cost',
        'delivery_cost',
        'total_cost',
        'status',
        'approved_by',
        'admin_note',
        'damage_agreement',
        'approved_at',
        'pickup_deadline',
        'picked_up_at',
        'return_requested_at',
        'return_approved_at',
        'cancelled_at',
        'rejected_at',
        'returned_at',
        'due_date',
    ];

    protected $casts = [
        'damage_agreement' => 'boolean',
        'approved_at' => 'datetime',
        'pickup_deadline' => 'datetime',
        'picked_up_at' => 'datetime',
        'return_requested_at' => 'datetime',
        'return_approved_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'rejected_at' => 'datetime',
        'returned_at' => 'datetime',
        'due_date' => 'date',
        'borrow_days' => 'integer',
        'delivery_distance_meters' => 'integer',
        'daily_rate' => 'integer',
        'delivery_rate_per_100m' => 'integer',
        'daily_cost' => 'integer',
        'delivery_cost' => 'integer',
        'total_cost' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public static function expireOverduePickups(): int
    {
        return DB::transaction(function () {
            $expired = static::query()
                ->where('status', 'approved')
                ->whereNotNull('pickup_deadline')
                ->whereNull('picked_up_at')
                ->where('pickup_deadline', '<=', now())
                ->lockForUpdate()
                ->get();

            $count = 0;

            foreach ($expired as $borrowRequest) {
                $book = Book::whereKey($borrowRequest->book_id)->lockForUpdate()->first();

                if ($book) {
                    $book->increment('stok');
                }

                $borrowRequest->update([
                    'status' => 'cancelled',
                    'cancelled_at' => now(),
                ]);

                $count++;
            }

            return $count;
        });
    }

    public function getPickupCodeAttribute(): string
    {
        $slot = (int) floor(((int) now()->format('H') * 60 + (int) now()->format('i')) / 20);
        $seed = $this->id . '|' . now()->format('Y-m-d') . '|' . $slot . '|' . config('app.key');
        $hash = strtoupper(substr(hash('sha256', $seed), 0, 12));

        return implode('-', str_split($hash, 4));
    }

    public function getPickupCodeVariantsAttribute(): array
    {
        $codes = [];

        foreach ([0, 1] as $offset) {
            $time = now()->subMinutes($offset * 20);
            $slot = (int) floor(((int) $time->format('H') * 60 + (int) $time->format('i')) / 20);
            $seed = $this->id . '|' . $time->format('Y-m-d') . '|' . $slot . '|' . config('app.key');
            $hash = strtoupper(substr(hash('sha256', $seed), 0, 12));
            $codes[] = implode('-', str_split($hash, 4));
        }

        return array_values(array_unique($codes));
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu konfirmasi',
            'approved' => 'Siap diambil',
            'picked_up' => 'Sudah diambil',
            'return_pending' => 'Menunggu pengembalian',
            'returned' => 'Sudah dikembalikan',
            'cancelled' => 'Dibatalkan',
            'rejected' => 'Ditolak',
            default => ucfirst((string) $this->status),
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash' => 'Cash',
            default => ucfirst((string) $this->payment_method),
        };
    }

    public function getPickupMethodLabelAttribute(): string
    {
        return match ($this->pickup_method) {
            'delivery' => 'Diantar',
            'self_pickup' => 'Diambil ke tempat',
            default => ucfirst((string) $this->pickup_method),
        };
    }
}
