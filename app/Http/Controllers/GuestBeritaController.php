<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;

class GuestBeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q        = trim($request->get('q', ''));
        $kategori = $request->get('kategori');

        $berita = Berita::query()
            ->with(['author:id,name']) // <- eager load author (hanya kolom yang perlu)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now())
            ->when($q !== '', function ($qr) use ($q) {
                $qr->where(function ($sub) use ($q) {
                    $sub->where('judul', 'like', "%{$q}%")
                        ->orWhere('ringkasan', 'like', "%{$q}%")
                        ->orWhere('konten', 'like', "%{$q}%")
                        ->orWhere('tag', 'like', "%{$q}%");
                });
            })
            ->when($kategori, fn($qr) => $qr->where('kategori', $kategori))
            ->orderByDesc('published_at')
            ->select(['id','judul','slug','ringkasan','thumbnail_path','published_at','author_id','kategori'])
            ->paginate(9)
            ->withQueryString();

        $kategoriList = ['Kegiatan','Pengumuman','Rilis','Opini','Publikasi'];

        return view('guest.publikasi.berita', compact('berita', 'kategoriList', 'q', 'kategori'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
         $berita = Berita::with('author:id,name')
            ->where('slug', $slug)
            ->firstOrFail();

        // Related/terkait (opsional): 3 item terbaru selain current, prioritaskan kategori sama
        $terkait = Berita::published()
            ->where('id', '!=', $berita->id)
            ->when($berita->kategori, fn($q) => $q->where('kategori', $berita->kategori))
            ->latest('published_at')
            ->take(3)
            ->get(['id','judul','slug','thumbnail_path','published_at','kategori']);

        return view('guest.berita.show', compact('berita', 'terkait'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
