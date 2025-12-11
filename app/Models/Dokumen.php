<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\KoleksiDokumen;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumen';

    protected $fillable = [
        'koleksi_dokumen_id', // Relasi ke koleksi
        'kode',
        'judul',
        'slug',
        'deskripsi_singkat',
        'kategori',
        'sub_kategori',
        'format_asli',
        'format_digital',
        'ukuran_file',
        'ringkasan',
        'sumber',
        'lembaga',
        'lokasi_fisik',
        'tahun_terbit',
        'tanggal_terbit',
        'penulis',
        'penerbit',
        'bahasa',
        'halaman',
        'prioritas',
        'catatan',
        
        // File fields
        'file_digital_path',
        'thumbnail_path',
        'preview_path',
        
        // Google Drive fields
        'google_drive_id',
        'google_drive_link',
        'google_drive_thumbnail',
        
        // Publication fields
        'published_at',
        'is_published',
        'is_utama',
        'urutan',
        
        // Stats
        'download_count',
        'view_count',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tahun_terbit' => 'integer',
        'prioritas' => 'integer',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
        'is_utama' => 'boolean',
        'download_count' => 'integer',
        'view_count' => 'integer',
        'halaman' => 'integer',
        'ukuran_file' => 'integer',
    ];

    /*
    |-----------------------------------------
    | Scopes
    |-----------------------------------------
    */
    
    // Scope untuk dokumen yang dipublikasi
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->whereNotNull('published_at')
                     ->where('published_at', '<=', now());
    }
    
    // Scope berdasarkan koleksi
    public function scopeKoleksi($query, $koleksiId)
    {
        return $query->where('koleksi_dokumen_id', $koleksiId);
    }
    
    // Scope berdasarkan kategori
    public function scopeKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }
    
    // Scope untuk dokumen utama
    public function scopeUtama($query)
    {
        return $query->where('is_utama', true);
    }
    
    // Urut default
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc')
                     ->orderBy('prioritas', 'asc')
                     ->orderBy('tahun_terbit', 'desc')
                     ->orderBy('created_at', 'desc');
    }
    
    // Filter berdasarkan tahun
    public function scopeTahun($query, $tahun)
    {
        return $query->where('tahun_terbit', $tahun);
    }
    
    // Filter berdasarkan format
    public function scopeFormat($query, $format)
    {
        return $query->where('format_digital', $format);
    }
    
    /*
    |-----------------------------------------
    | Google Drive Methods
    |-----------------------------------------
    */
    
    // Cek apakah menggunakan Google Drive
    public function getMenggunakanGoogleDriveAttribute()
    {
        return !empty($this->google_drive_id) || !empty($this->google_drive_link);
    }
    
    // Get link Google Drive
    public function getLinkGoogleDriveAttribute()
    {
        if ($this->google_drive_link) {
            return $this->google_drive_link;
        }
        
        if ($this->google_drive_id) {
            return "https://drive.google.com/file/d/{$this->google_drive_id}/view";
        }
        
        return null;
    }
    
    // Get download link Google Drive
    public function getDownloadGoogleDriveAttribute()
    {
        if ($this->google_drive_id) {
            return "https://drive.google.com/uc?export=download&id={$this->google_drive_id}";
        }
        
        return null;
    }
    
    // Get thumbnail Google Drive
    public function getThumbnailGoogleDriveAttribute()
    {
        if ($this->google_drive_thumbnail) {
            return $this->google_drive_thumbnail;
        }
        
        if ($this->google_drive_id) {
            return "https://drive.google.com/thumbnail?id={$this->google_drive_id}&sz=w400";
        }
        
        return null;
    }
    
    /*
    |-----------------------------------------
    | File Methods
    |-----------------------------------------
    */
    
    // Get thumbnail URL (prioritas Google Drive, lalu local)
    public function getThumbnailUrlAttribute()
    {
        if ($this->google_drive_thumbnail) {
            return $this->google_drive_thumbnail;
        }
        
        if ($this->thumbnail_path && Storage::exists($this->thumbnail_path)) {
            return Storage::url($this->thumbnail_path);
        }
        
        // Default thumbnail berdasarkan format
        return $this->getDefaultThumbnail();
    }
    
    // Get file URL
    public function getFileUrlAttribute()
    {
        // Priority: Google Drive
        if ($this->menggunakan_google_drive) {
            return $this->download_google_drive ?? $this->link_google_drive;
        }
        
        // Priority: Local file
        if ($this->file_digital_path && Storage::exists($this->file_digital_path)) {
            return Storage::url($this->file_digital_path);
        }
        
        return null;
    }
    
    // Get default thumbnail
    protected function getDefaultThumbnail()
    {
        $thumbnails = [
            'pdf' => '/images/pdf-icon.png',
            'doc' => '/images/doc-icon.png',
            'docx' => '/images/doc-icon.png',
            'xls' => '/images/xls-icon.png',
            'xlsx' => '/images/xls-icon.png',
            'jpg' => '/images/image-icon.png',
            'jpeg' => '/images/image-icon.png',
            'png' => '/images/image-icon.png',
            'mp3' => '/images/audio-icon.png',
            'mp4' => '/images/video-icon.png',
        ];
        
        $ext = strtolower(pathinfo($this->judul, PATHINFO_EXTENSION));
        return $thumbnails[$ext] ?? '/images/document-icon.png';
    }
    
    // Format ukuran file
    public function getUkuranFileFormattedAttribute()
    {
        if (!$this->ukuran_file) return null;
        
        $bytes = $this->ukuran_file;
        if ($bytes == 0) return '0 Bytes';
        
        $k = 1024;
        $sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes) / log($k));
        
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
    
    /*
    |-----------------------------------------
    | Relasi
    |-----------------------------------------
    */
    
    public function koleksi()
    {
        return $this->belongsTo(KoleksiDokumen::class, 'koleksi_dokumen_id');
    }
    
    /*
    |-----------------------------------------
    | Methods
    |-----------------------------------------
    */
    
    public function incrementViewCount()
    {
        $this->view_count++;
        $this->save();
    }
    
    public function incrementDownloadCount()
    {
        $this->download_count++;
        $this->save();
    }
}