<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Seminar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'seminars';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'ringkasan',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'tempat',
        'alamat_lengkap',
        'link_virtual',
        'pembicara',
        'institusi_pembicara',
        'bio_pembicara',
        'foto_pembicara',
        'tipe',
        'format',
        'topik',
        'bidang_ilmu',
        'gratis',
        'biaya',
        'link_pendaftaran',
        'batas_pendaftaran',
        'kuota_peserta',
        'peserta_terdaftar',
        'poster',
        'dokumen_materi',
        'video_rekaman',
        'galeri_foto',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'is_published',
        'is_featured',
        'is_cancelled',
        'published_at',
        'archived_at',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
        'batas_pendaftaran' => 'date',
        'gratis' => 'boolean',
        'biaya' => 'decimal:2',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'is_cancelled' => 'boolean',
        'published_at' => 'datetime',
        'archived_at' => 'datetime',
        'galeri_foto' => 'array',
        'kuota_peserta' => 'integer',
        'peserta_terdaftar' => 'integer'
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($seminar) {
            if (empty($seminar->slug)) {
                $seminar->slug = Str::slug($seminar->judul);
            }
        });

        static::updating(function ($seminar) {
            if ($seminar->isDirty('judul') && empty($seminar->slug)) {
                $seminar->slug = Str::slug($seminar->judul);
            }
        });
    }

    /**
     * Relasi dengan user (admin yang membuat)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk seminar yang published
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('is_cancelled', false)
                     ->where(function($q) {
                         $q->whereNull('archived_at')
                           ->orWhere('archived_at', '>', now());
                     });
    }

    /**
     * Scope untuk seminar yang featured
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk seminar yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('tanggal', '>=', now()->format('Y-m-d'));
    }

    /**
     * Scope untuk seminar yang telah berlalu
     */
    public function scopePast($query)
    {
        return $query->where('tanggal', '<', now()->format('Y-m-d'));
    }

    /**
     * Scope untuk seminar berdasarkan tipe
     */
    public function scopeByType($query, $type)
    {
        return $query->where('tipe', $type);
    }

    /**
     * Scope untuk seminar berdasarkan format
     */
    public function scopeByFormat($query, $format)
    {
        return $query->where('format', $format);
    }

    /**
     * Accessor untuk status seminar
     */
    public function getStatusAttribute()
    {
        if ($this->is_cancelled) {
            return 'dibatalkan';
        }

        if ($this->tanggal < now()->format('Y-m-d')) {
            return 'selesai';
        }

        if ($this->batas_pendaftaran && $this->batas_pendaftaran < now()->format('Y-m-d')) {
            return 'pendaftaran_tutup';
        }

        return 'akan_datang';
    }

    /**
     * Accessor untuk status label
     */
    public function getStatusLabelAttribute()
    {
        $statuses = [
            'dibatalkan' => ['label' => 'Dibatalkan', 'color' => 'bg-red-100 text-red-800'],
            'selesai' => ['label' => 'Selesai', 'color' => 'bg-gray-100 text-gray-800'],
            'pendaftaran_tutup' => ['label' => 'Pendaftaran Tutup', 'color' => 'bg-amber-100 text-amber-800'],
            'akan_datang' => ['label' => 'Akan Datang', 'color' => 'bg-green-100 text-green-800'],
        ];

        return $statuses[$this->status] ?? ['label' => 'Unknown', 'color' => 'bg-gray-100 text-gray-800'];
    }

    /**
     * Accessor untuk format waktu lengkap
     */
    public function getWaktuLengkapAttribute()
    {
        $waktuMulai = \Carbon\Carbon::parse($this->waktu_mulai)->format('H:i');
        $waktuSelesai = $this->waktu_selesai 
            ? ' - ' . \Carbon\Carbon::parse($this->waktu_selesai)->format('H:i') 
            : '';
        
        return $waktuMulai . $waktuSelesai;
    }

    /**
     * Accessor untuk tanggal format Indonesia
     */
    public function getTanggalIndoAttribute()
    {
        return \Carbon\Carbon::parse($this->tanggal)->translatedFormat('d F Y');
    }

    /**
     * Accessor untuk biaya format
     */
    public function getBiayaFormatAttribute()
    {
        if ($this->gratis) {
            return 'Gratis';
        }
        
        return 'Rp ' . number_format($this->biaya, 0, ',', '.');
    }

    /**
     * Method untuk cek kuota tersedia
     */
    public function getKuotaTersediaAttribute()
    {
        if (!$this->kuota_peserta) {
            return 'Tidak Terbatas';
        }
        
        $tersedia = $this->kuota_peserta - $this->peserta_terdaftar;
        return max(0, $tersedia);
    }

    /**
     * Method untuk opsi tipe seminar
     */
    public static function getTipeOptions()
    {
        return [
            'nasional' => 'Nasional',
            'internasional' => 'Internasional',
            'workshop' => 'Workshop',
            'webinar' => 'Webinar',
            'lainnya' => 'Lainnya'
        ];
    }

    /**
     * Method untuk opsi format seminar
     */
    public static function getFormatOptions()
    {
        return [
            'offline' => 'Offline',
            'online' => 'Online',
            'hybrid' => 'Hybrid'
        ];
    }
}