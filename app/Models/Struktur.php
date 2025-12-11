<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Struktur extends Model
{
    protected $table = 'strukturs'; // atau 'struktur' sesuai migrasi kamu
    protected $fillable = [
        'deskripsi',
        'gambar_path',
        'alt_text',
    ];
}
