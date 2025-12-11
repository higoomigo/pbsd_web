<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KoleksiDokumen extends Model
{
    use HasFactory;

    protected $table = 'koleksi_dokumen';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi_singkat',
        'deskripsi_lengkap',
        'kategori',
        'tahun_mulai',
        'tahun_selesai',
        'cover_path',
        'lokasi_fisik',
        'lembaga',
        'sumber',
        'published_at',
        'is_published',
        'tampil_beranda',
        'urutan',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'tampil_beranda' => 'boolean',
        'tahun_mulai' => 'integer',
        'tahun_selesai' => 'integer',
    ];

    // Scope untuk koleksi yang dipublikasi
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    // Scope untuk koleksi yang tampil di beranda
    public function scopeBeranda($query)
    {
        return $query->where('tampil_beranda', true);
    }

    // Urut default
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan', 'asc')
                     ->orderBy('tahun_mulai', 'desc')
                     ->orderBy('created_at', 'desc');
    }

    // Relasi ke dokumen
    public function dokumen()
    {
        return $this->hasMany(Dokumen::class, 'koleksi_dokumen_id');
    }

    // Dokumen utama/cover
    public function dokumenUtama()
    {
        return $this->hasOne(Dokumen::class, 'koleksi_dokumen_id')
                    ->where('is_utama', true);
    }

    // Total dokumen dalam koleksi
    public function getTotalDokumenAttribute()
    {
        return $this->dokumen()->count();
    }

    // Format tahun (misal: 1900-1950)
    public function getRentangTahunAttribute()
    {
        if ($this->tahun_mulai && $this->tahun_selesai) {
            return $this->tahun_mulai . ' - ' . $this->tahun_selesai;
        } elseif ($this->tahun_mulai) {
            return 'Sejak ' . $this->tahun_mulai;
        }
        
        return null;
    }
}