<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Peneliti extends Model
{
    use HasFactory;

    protected $table = 'penelitis';

    protected $fillable = [
        'nama',
        'slug',
        'gelar_depan',
        'gelar_belakang',
        'foto_path',
        'bidang_keahlian',
        'posisi',
        'jabatan',
        'riwayat_pendidikan',
        'email',
        'phone',
        'website',
        'social_links',
        'deskripsi_singkat',
        'biografi',
        'publikasi_terpilih',
        'penelitian_unggulan',
        'pencapaian',
        'status',
        'tipe',
        'urutan',
        'tampil_beranda',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'bidang_keahlian' => 'array',
        'social_links' => 'array',
        'publikasi_terpilih' => 'array',
        'penelitian_unggulan' => 'array',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'tampil_beranda' => 'boolean',
        'urutan' => 'integer',
    ];

    /**
     * Boot function for automatic slug generation
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($researcher) {
            if (empty($researcher->slug)) {
                $researcher->slug = Str::slug($researcher->nama);
                
                // Make slug unique
                $originalSlug = $researcher->slug;
                $count = 2;
                while (static::where('slug', $researcher->slug)->exists()) {
                    $researcher->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });

        static::updating(function ($researcher) {
            // Update slug if nama changed
            if ($researcher->isDirty('nama') && empty($researcher->getOriginal('slug'))) {
                $researcher->slug = Str::slug($researcher->nama);
                
                // Make slug unique
                $originalSlug = $researcher->slug;
                $count = 2;
                while (static::where('slug', $researcher->slug)
                          ->where('id', '!=', $researcher->id)
                          ->exists()) {
                    $researcher->slug = $originalSlug . '-' . $count;
                    $count++;
                }
            }
        });
    }

    /**
     * Scope for published researchers
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope for active researchers
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }

    /**
     * Scope for homepage display
     */
    public function scopeTampilBeranda($query)
    {
        return $query->where('tampil_beranda', true);
    }

    /**
     * Scope ordered by urutan
     */
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan')->orderBy('nama');
    }

    /**
     * Get full name with titles
     */
    public function getNamaLengkapAttribute()
    {
        $nama = $this->nama;
        if ($this->gelar_depan) {
            $nama = $this->gelar_depan . ' ' . $nama;
        }
        if ($this->gelar_belakang) {
            $nama = $nama . ', ' . $this->gelar_belakang;
        }
        return $nama;
    }

    /**
     * Get first bidang keahlian
     */
    public function getBidangUtamaAttribute()
    {
        return $this->bidang_keahlian ? $this->bidang_keahlian[0] ?? null : null;
    }

    /**
     * Check if researcher has social links
     */
    public function hasSocialLinks()
    {
        return !empty($this->social_links) && count(array_filter($this->social_links)) > 0;
    }

    /**
     * Get photo URL
     */
    public function getFotoUrlAttribute()
    {
        return $this->foto_path ? asset('storage/' . $this->foto_path) : null;
    }

    /**
     * Route key for URL
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}