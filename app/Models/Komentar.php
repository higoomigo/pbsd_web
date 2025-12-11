<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komentar extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'komentars';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'artikel_id',
        'user_id',
        'nama',
        'email',
        'konten',
        'is_approved',
        'parent_id',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_approved' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relasi ke Artikel
     */
    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class);
    }

    /**
     * Relasi ke User (jika login)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke komentar parent (untuk reply)
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Komentar::class, 'parent_id');
    }

    /**
     * Relasi ke komentar anak (replies)
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Komentar::class, 'parent_id')
                    ->orderBy('created_at', 'asc');
    }

    /**
     * Relasi ke komentar anak yang sudah approved
     */
    public function approvedReplies(): HasMany
    {
        return $this->hasMany(Komentar::class, 'parent_id')
                    ->approved()
                    ->orderBy('created_at', 'asc');
    }

    /**
     * Scope untuk komentar yang sudah disetujui
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope untuk komentar yang belum disetujui
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }

    /**
     * Scope untuk komentar utama (bukan reply)
     */
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope untuk komentar terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope untuk komentar terlama
     */
    public function scopeOldest($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    /**
     * Cek apakah komentar ini adalah reply
     */
    public function getIsReplyAttribute(): bool
    {
        return !is_null($this->parent_id);
    }

    /**
     * Cek apakah komentar ini adalah komentar utama
     */
    public function getIsMainAttribute(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Nama komentator
     */
    public function getNamaKomentarAttribute(): string
    {
        return $this->user_id ? $this->user->name : ($this->nama ?? 'Anonymous');
    }

    /**
     * Email komentator
     */
    public function getEmailKomentarAttribute(): ?string
    {
        return $this->user_id ? $this->user->email : $this->email;
    }

    /**
     * Format tanggal untuk display
     */
    public function getTanggalAttribute(): string
    {
        return $this->created_at->translatedFormat('d F Y');
    }

    /**
     * Format waktu untuk display
     */
    public function getWaktuAttribute(): string
    {
        return $this->created_at->translatedFormat('H:i');
    }

    /**
     * Format tanggal lengkap
     */
    public function getTanggalLengkapAttribute(): string
    {
        return $this->created_at->translatedFormat('d F Y, H:i');
    }

    /**
     * Cek apakah komentar bisa dihapus oleh user tertentu
     */
    public function canDeleteBy(User $user): bool
    {
        // Admin bisa hapus semua komentar
        if ($user->is_admin ?? false) {
            return true;
        }

        // User hanya bisa hapus komentar sendiri
        return $this->user_id === $user->id;
    }

    /**
     * Cek apakah komentar bisa diedit oleh user tertentu
     */
    public function canEditBy(User $user): bool
    {
        // Admin bisa edit semua komentar
        if ($user->is_admin ?? false) {
            return true;
        }

        // User hanya bisa edit komentar sendiri dalam waktu tertentu (misal 30 menit)
        if ($this->user_id === $user->id) {
            $minutesSinceCreated = $this->created_at->diffInMinutes(now());
            return $minutesSinceCreated <= 30; // Boleh edit dalam 30 menit
        }

        return false;
    }
    /**
     * Cek apakah komentar bisa diedit oleh user
     */
    public function canBeEditedBy($user): bool
    {
        if (!$user) {
            return false;
        }

        // Cek apakah komentar milik user
        if ($this->user_id !== $user->id) {
            return false;
        }

        // Hanya boleh edit dalam 30 menit setelah dibuat
        $minutesSinceCreated = $this->created_at->diffInMinutes(now());
        return $minutesSinceCreated <= 30;
    }

    /**
     * Cek apakah komentar bisa dihapus oleh user
     */
    public function canBeDeletedBy($user): bool
    {
        if (!$user) {
            return false;
        }

        // Cek apakah komentar milik user
        return $this->user_id === $user->id;
    }

    /**
     * Cek apakah user bisa reply ke komentar ini
     */
    public function canBeRepliedBy($user): bool
    {
        return $user !== null; // Hanya user login yang bisa reply
    }    
}