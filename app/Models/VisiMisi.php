<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisiMisi extends Model
{
    protected $table = 'visi_misis';

    protected $fillable = ['visi','misi'];

    protected $casts = [
        'misi' => 'array', // otomatis array <-> json
    ];
}
