<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    private const ADMIN_FIXED_AVATAR = 'avatars/admin-profile.jpg';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_photo',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get profile photo URL with default fallback
     */
    public function profilePhotoUrl(): string
    {
        if (($this->role ?? 'user') === 'admin') {
            $fixedAdminAvatar = public_path(self::ADMIN_FIXED_AVATAR);
            if (is_file($fixedAdminAvatar)) {
                return asset(self::ADMIN_FIXED_AVATAR);
            }

            return asset('default-avatar.svg');
        }

        $disk = Storage::disk('public');
        $profilePhotoPath = $this->normalizePublicPath($this->profile_photo);

        if ($profilePhotoPath && $disk->exists($profilePhotoPath)) {
            return $disk->url($profilePhotoPath);
        }

        return asset('default-avatar.svg');
    }

    private function normalizePublicPath(?string $value): ?string
    {
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (filter_var($value, FILTER_VALIDATE_URL)) {
            $path = parse_url($value, PHP_URL_PATH);
            $value = is_string($path) ? $path : '';
        }

        $value = str_replace('\\', '/', $value);
        $value = ltrim($value, '/');

        if (str_starts_with($value, 'storage/')) {
            $value = substr($value, strlen('storage/'));
        }

        return $value !== '' ? $value : null;
    }

    public function borrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class);
    }

    public function handledBorrowRequests(): HasMany
    {
        return $this->hasMany(BorrowRequest::class, 'approved_by');
    }
}
