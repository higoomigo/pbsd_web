<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    
    protected $fillable = [
        'nama_fasilitas',
        'deskripsi',
        'gambar_path',
        'alt_text',
        'tampil_beranda',
        'urutan_tampil',
    ];

    protected $casts = [
        'tampil_beranda' => 'boolean',
    ];

    // Scope untuk fasilitas yang ditampilkan di beranda
    public function scopeDiBeranda($query)
    {
        return $query->where('tampil_beranda', true)
                    ->orderBy('urutan_tampil', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    // Scope untuk mengurutkan berdasarkan urutan tampil
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan_tampil', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    // Method untuk mengambil fasilitas yang ditampilkan di beranda (max 6)
    public static function getUntukBeranda($limit = 6)
    {
        return static::diBeranda()->take($limit)->get();
    }

    // Method untuk mengambil semua fasilitas dengan urutan
    public static function getSemuaDenganUrutan()
    {
        return static::urutan()->get();
    }

    // Method untuk update status tampil di beranda
    public function updateTampilBeranda($status)
    {
        $this->update(['tampil_beranda' => $status]);
        return $this;
    }

    // Method untuk update urutan tampil
    public function updateUrutan($urutan)
    {
        $this->update(['urutan_tampil' => $urutan]);
        return $this;
    }
}