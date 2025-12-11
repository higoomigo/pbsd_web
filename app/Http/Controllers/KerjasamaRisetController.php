<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class KerjasamaRisetController extends Controller
{
    /**
     * Display a listing of research collaborations.
     */
    public function index(Request $request)
    {
        $q = trim($request->get('q', ''));
        $kategori = $request->get('kategori');

        // Kategori khusus untuk kerjasama riset
        $kategoriKerjasama = [
            'Kerjasama Riset',
            'Kolaborasi Penelitian', 
            'MoU Riset',
            'Partnership',
            'Proyek Bersama',
            'Jaringan Riset'
        ];

        $berita = Berita::query()
            ->with(['author:id,name'])
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            // Filter khusus untuk kerjasama riset - bisa dari kategori atau tag
            ->where(function($query) use ($kategoriKerjasama) {
                $query->whereIn('kategori', $kategoriKerjasama)
                      ->orWhere('tag', 'like', '%kerjasama%')
                      ->orWhere('tag', 'like', '%kolaborasi%')
                      ->orWhere('tag', 'like', '%partnership%')
                      ->orWhere('tag', 'like', '%mou%')
                      ->orWhere('judul', 'like', '%kerjasama%')
                      ->orWhere('judul', 'like', '%kolaborasi%');
            })
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('ringkasan', 'like', "%{$q}%")
                        ->orWhere('konten', 'like', "%{$q}%")
                        ->orWhere('tag', 'like', "%{$q}%");
                });
            })
            ->when($kategori && in_array($kategori, $kategoriKerjasama), fn($qr) => $qr->where('kategori', $kategori))
            ->orderByDesc('published_at')
            ->select(['id','judul','slug','ringkasan','thumbnail_path','published_at','author_id','kategori','tag'])
            ->paginate(9)
            ->withQueryString();

        // Untuk dropdown filter, gunakan kategori kerjasama riset
        $kategoriList = $kategoriKerjasama;

        return view('guest.kerjasama-riset.index', compact('berita', 'kategoriList', 'q', 'kategori'));
    }

    /**
     * Display the specified research collaboration.
     */
    public function show(string $slug)
    {
        $kategoriKerjasama = [
            'Kerjasama Riset',
            'Kolaborasi Penelitian', 
            'MoU Riset',
            'Partnership',
            'Proyek Bersama',
            'Jaringan Riset'
        ];

        $berita = Berita::with('author:id,name')
            ->where('slug', $slug)
            ->where(function($query) use ($kategoriKerjasama) {
                $query->whereIn('kategori', $kategoriKerjasama)
                      ->orWhere('tag', 'like', '%kerjasama%')
                      ->orWhere('tag', 'like', '%kolaborasi%')
                      ->orWhere('tag', 'like', '%partnership%')
                      ->orWhere('tag', 'like', '%mou%')
                      ->orWhere('judul', 'like', '%kerjasama%')
                      ->orWhere('judul', 'like', '%kolaborasi%');
            })
            ->firstOrFail();

        // Related collaborations: kerjasama riset lainnya
        $terkait = Berita::query()
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->where('id', '!=', $berita->id)
            ->where(function($query) use ($kategoriKerjasama) {
                $query->whereIn('kategori', $kategoriKerjasama)
                      ->orWhere('tag', 'like', '%kerjasama%')
                      ->orWhere('tag', 'like', '%kolaborasi%')
                      ->orWhere('tag', 'like', '%partnership%')
                      ->orWhere('tag', 'like', '%mou%');
            })
            ->latest('published_at')
            ->take(3)
            ->get(['id','judul','slug','thumbnail_path','published_at','kategori']);

        return view('guest.kerjasama-riset.show', compact('berita', 'terkait'));
    }
}