<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GaleriMedia extends Model
{
    use HasFactory;

    protected $table = 'galeri_media';

    // protected $table = 'galeri_media';
    
    protected $primaryKey = 'id'; // ✅ PASTIKAN INI ADA
    protected $fillable = [
        'galeri_album_id',
        'tipe',
        'judul',
        'keterangan',
        'file_path',
        'thumbnail_path',
        'youtube_url',
        'taken_at',
        'urutan',
        'is_utama',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
        'is_utama' => 'boolean',
    ];

    // Scope untuk urutan media
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc')
                     ->orderBy('created_at', 'desc');
    }

    // Scope untuk media utama
    public function scopeUtama($query)
    {
        return $query->where('is_utama', true);
    }

    // Scope berdasarkan tipe
    public function scopeTipe($query, $tipe)
    {
        return $query->where('tipe', $tipe);
    }

    public function album()
    {
        return $this->belongsTo(GaleriAlbum::class, 'galeri_album_id');
    }
}