<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class KegiatanPenelitianController extends Controller
{
    /**
     * Display a listing of research activities.
     */
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $kategori = $request->get('kategori');

        // Definisikan kategori-kategori yang termasuk dalam "Kegiatan Penelitian"
        $kategoriPenelitian = [
            'Penelitian', 
            'Riset', 
            'Seminar', 
            'Workshop', 
            'Konferensi', 
            'Publikasi Ilmiah',
            'Kegiatan Akademik'
        ];

        $berita = Berita::query()
            ->with(['author:id,name'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            // Filter khusus untuk kegiatan penelitian
            ->whereIn('kategori', $kategoriPenelitian)
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('ringkasan', 'like', "%{$q}%")
                        ->orWhere('konten', 'like', "%{$q}%")
                        ->orWhere('tag', 'like', "%{$q}%");
                });
            })
            ->when($kategori && in_array($kategori, $kategoriPenelitian), fn($qr) => $qr->where('kategori', $kategori))
            ->orderByDesc('published_at')
            ->select(['id','judul','slug','ringkasan','thumbnail_path','published_at','author_id','kategori','tag'])
            ->paginate(9)
            ->withQueryString();

        // Untuk dropdown filter, gunakan kategori penelitian saja
        $kategoriList = $kategoriPenelitian;

        return view('guest.kegiatan-penelitian.index', compact('berita', 'kategoriList', 'q', 'kategori'));
    }

    /**
     * Display the specified research activity.
     */
    public function show(string $slug)
    {
        $kategoriPenelitian = [
            'Penelitian', 
            'Riset', 
            'Seminar', 
            'Workshop', 
            'Konferensi', 
            'Publikasi Ilmiah',
            'Kegiatan Akademik'
        ];

        $berita = Berita::with('author:id,name')
            ->where('slug', $slug)
            ->whereIn('kategori', $kategoriPenelitian)
            ->firstOrFail();

        // Related activities: kegiatan penelitian lainnya
        $terkait = Berita::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $berita->id)
            ->whereIn('kategori', $kategoriPenelitian)
            ->latest('published_at')
            ->take(3)
            ->get(['id','judul','slug','thumbnail_path','published_at','kategori']);

        return view('guest.kegiatan-penelitian.show', compact('berita', 'terkait'));
    }
}