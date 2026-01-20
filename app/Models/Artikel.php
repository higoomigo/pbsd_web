<?php

// app/Models/Artikel.php
namespace App\Models;

use Coderflex\Laravisit\Concerns\CanVisit; // Import Interface
use Coderflex\Laravisit\Concerns\HasVisits; // Import Trait
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Artikel extends Model implements CanVisit
{
    use HasFactory;
    use HasVisits; // Gunakan Trait HasVisits

    protected $table = 'artikels'; // ganti ke 'beritas' kalau pakai tabel beritas

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'penulis',        // <— teks penulis manual
        'author_id',      // <— FK ke users (opsional)
        'tag',
        'thumbnail_path',
        'ringkasan',
        'konten',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    // Relasi ke users (opsional)
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    /**
     * Relasi ke komentar
     */
    public function komentars(): HasMany
    {
        return $this->hasMany(Komentar::class)
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Relasi ke komentar yang sudah disetujui
     */
    public function komentarApproved(): HasMany
    {
        return $this->hasMany(Komentar::class)
                    ->approved()
                    ->main()
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Relasi ke semua komentar termasuk yang belum disetujui (untuk admin)
     */
    public function komentarAll(): HasMany
    {
        return $this->hasMany(Komentar::class)
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Hitung jumlah komentar yang disetujui
     */
    public function getJumlahKomentarAttribute(): int
    {
        return $this->komentarApproved()->count();
    }

    /**
     * Hitung jumlah semua komentar termasuk pending
     */
    public function getJumlahSemuaKomentarAttribute(): int
    {
        return $this->komentars()->count();
    }

    /**
     * Hitung jumlah komentar pending
     */
    public function getJumlahKomentarPendingAttribute(): int
    {
        return $this->komentars()->pending()->count();
    }

    /**
     * Scope published
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Format tags dari string ke array
     */
    public function getTagsArrayAttribute(): array
    {
        if (empty($this->tag)) {
            return [];
        }

        return array_map('trim', explode(',', $this->tag));
    }

    /**
     * Cek apakah artikel memiliki komentar
     */
    public function hasKomentar(): bool
    {
        return $this->jumlah_komentar > 0;
    }

    /**
     * Cek apakah artikel memiliki komentar pending
     */
    public function hasKomentarPending(): bool
    {
        return $this->jumlah_komentar_pending > 0;
    }

    /**
     * Ambil komentar terbaru
     */
    public function komentarTerbaru($limit = 5)
    {
        return $this->komentarApproved()
                    ->with('user')
                    ->take($limit)
                    ->get();
    }
}
