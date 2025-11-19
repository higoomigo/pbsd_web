<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    // kalau nama tabel tidak jamak standar, set manual:
    protected $table = 'mitras';

    protected $fillable = [
        'nama',
        'jenis',            // Pemerintah, Perguruan Tinggi, dst.
        'deskripsi',
        'website',
        'email_kontak',
        'telepon',
        'instagram',
        'youtube',
        'mulai',            // date
        'berakhir',         // date nullable
        'status',           // Aktif / Tidak Aktif
        'urutan',           // int
        'tampil_beranda',   // bool
        'logo_path',        // simpan path file logo
        'dokumen_mou_path', // simpan path file pdf
    ];

    protected $casts = [
        'mulai'           => 'date',
        'berakhir'        => 'date',
        'tampil_beranda'  => 'boolean',
        'urutan'          => 'integer',
    ];
}
