<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriAlbum extends Model
{
    use HasFactory;

    protected $table = 'galeri_albums';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi_singkat', // TAMBAH
        'deskripsi',
        'kategori',
        'tahun',             // TAMBAH (ganti koleksi)
        'tanggal_mulai',     // TAMBAH (ganti sumber)
        'tanggal_selesai',   // TAMBAH
        'cover_path',
        'lokasi',
        'published_at',
        'is_published',
        'tampil_beranda',    // TAMBAH
        'urutan',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'tanggal_mulai' => 'date',     // TAMBAH
        'tanggal_selesai' => 'date',   // TAMBAH
        'is_published' => 'boolean',
        'tampil_beranda' => 'boolean', // TAMBAH
    ];

    // Scope untuk hanya album yang dipublikasi
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    public function media()
    {
        return $this->hasMany(GaleriMedia::class, 'galeri_album_id');
    }
}