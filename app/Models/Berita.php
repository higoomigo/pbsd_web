<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Berita extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'beritas';

    protected $fillable = [
        'judul',
        'slug',
        'kategori',
        'tag',              // disimpan sebagai string "a, b, c"
        'ringkasan',
        'konten',
        'thumbnail_path',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /** Relasi opsional ke User sebagai penulis */
    public function author()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id');
    }

    /** Helper kecil: tags sebagai array (dibaca saja) */
    public function getTagsArrayAttribute(): array
    {
        if (! $this->tag) return [];
        return array_values(array_filter(array_map('trim', explode(',', $this->tag))));
    }

     public function scopePublished($q)
    {
        return $q->whereNotNull('published_at')
                 ->where('published_at', '<=', now());
    }
}
