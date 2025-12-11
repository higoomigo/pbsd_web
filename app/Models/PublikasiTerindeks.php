<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PublikasiTerindeks extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'publikasi_terindeks';

    protected $fillable = [
        'judul',
        'abstrak',
        'penulis',
        'daftar_penulis',
        'nama_jurnal',
        'issn',
        'volume',
        'issue',
        'tahun_terbit',
        'halaman',
        'indeksasi',
        'quartile',
        'impact_factor',
        'doi',
        'url_jurnal',
        'file_pdf',
        'cover_image',
        'bidang_ilmu',
        'kategori_publikasi',
        'is_active',
        'jumlah_dikutip',
        'tanggal_publish',
        'user_id',
        'dosen_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tahun_terbit' => 'integer',
        'quartile' => 'integer',
        'jumlah_dikutip' => 'integer',
        'tanggal_publish' => 'date',
        'daftar_penulis' => 'array'
    ];

    /**
     * Relasi many-to-many dengan keywords
     */
    // public function keywords(): BelongsToMany
    // {
    //     return $this->belongsToMany(Keyword::class, 'publikasi_keyword');
    // }

    /**
     * Relasi dengan user/dosen
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function dosen()
    // {
    //     return $this->belongsTo(Dosen::class);
    // }

    /**
     * Scope untuk filter aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk filter berdasarkan indeksasi
     */
    public function scopeByIndeksasi($query, $indeksasi)
    {
        return $query->where('indeksasi', $indeksasi);
    }

    /**
     * Scope untuk filter berdasarkan tahun
     */
    public function scopeByTahun($query, $tahun)
    {
        return $query->where('tahun_terbit', $tahun);
    }

    /**
     * Scope untuk filter berdasarkan bidang ilmu
     */
    public function scopeByBidangIlmu($query, $bidang)
    {
        return $query->where('bidang_ilmu', $bidang);
    }

    /**
     * Scope untuk search
     */
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('abstrak', 'like', "%{$search}%")
              ->orWhere('penulis', 'like', "%{$search}%")
              ->orWhere('nama_jurnal', 'like', "%{$search}%");
        });
    }

    /**
     * Accessor untuk quartile lengkap
     */
    public function getQuartileLengkapAttribute()
    {
        return $this->quartile ? 'Q' . $this->quartile : '-';
    }

    /**
     * Accessor untuk daftar penulis sebagai array
     */
    // public function getDaftarPenulisArrayAttribute()
    // {
    //     if (is_array($this->daftar_penulis)) {
    //         return $this->daftar_penulis;
    //     }
        
    //     if (is_string($this->daftar_penulis) && !empty($this->daftar_penulis)) {
    //         return json_decode($this->daftar_penulis, true) ?? [];
    //     }
        
    //     return [];
    // }

    /**
     * Method untuk daftar pilihan indeksasi
     */
    public static function getIndeksasiOptions()
    {
        return [
            'SCOPUS' => 'Scopus',
            'WOS' => 'Web of Science',
            'SINTA' => 'SINTA',
            'DOAJ' => 'DOAJ',
            'GARUDA' => 'Garuda',
            'CROSSREF' => 'Crossref',
            'LIPI' => 'LIPI',
            'Lainya' => 'Lainnya'
        ];
    }

    /**
     * Method untuk daftar pilihan bidang ilmu
     */
    // public static function getBidangIlmuOptions()
    // {
    //     return [
    //         'computer_science' => 'Computer Science',
    //         'engineering' => 'Engineering',
    //         'mathematics' => 'Mathematics',
    //         'physics' => 'Physics',
    //         'chemistry' => 'Chemistry',
    //         'biology' => 'Biology',
    //         'medicine' => 'Medicine',
    //         'social_sciences' => 'Social Sciences',
    //         'business' => 'Business',
    //         'economics' => 'Economics',
    //         'education' => 'Education',
    //         'law' => 'Law',
    //         'arts' => 'Arts & Humanities',
    //         'lainnya' => 'Lainnya'
    //     ];
    // }

    /**
     * Method untuk daftar pilihan kategori publikasi
     */
    // public static function getKategoriPublikasiOptions()
    // {
    //     return [
    //         'article' => 'Journal Article',
    //         'conference' => 'Conference Paper',
    //         'review' => 'Review Article',
    //         'book_chapter' => 'Book Chapter',
    //         'proceeding' => 'Conference Proceeding',
    //         'patent' => 'Patent',
    //         'other' => 'Other'
    //     ];
    // }

    /**
     * Format citation (contoh sederhana)
     */
    // public function getCitationAttribute()
    // {
    //     return sprintf(
    //         "%s (%s). %s. %s, %s(%s), %s.",
    //         $this->penulis,
    //         $this->tahun_terbit,
    //         $this->judul,
    //         $this->nama_jurnal,
    //         $this->volume,
    //         $this->issue,
    //         $this->halaman
    //     );
    // }
}