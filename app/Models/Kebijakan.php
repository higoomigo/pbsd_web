<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kebijakan extends Model
{
    // Kalau nama tabel sesuai konvensi (kebijakans), nggak perlu $table.
    protected $table = 'kebijakans';

    protected $fillable = [
        'judul',
        'kategori',
        'nomor_dokumen',
        'versi',
        'ringkasan',
        'isi',
        'otoritas_pengesah',
        'penanggung_jawab',
        'unit_terkait',
        'tanggal_berlaku',
        'tanggal_tinjau_berikutnya',
        'siklus_tinjau',
        'dokumen_path',
        'lampiran_paths',
        'status',
        'tags',
    ];

    protected $casts = [
        'tanggal_berlaku'          => 'date',
        'tanggal_tinjau_berikutnya'=> 'date',
        'lampiran_paths'           => 'array',   // json -> array
    ];

    /**
     * Scope untuk hanya kebijakan yang berstatus publik.
     */
    public function scopePublik($query)
    {
        return $query->where('status', 'Publik');
    }
}
