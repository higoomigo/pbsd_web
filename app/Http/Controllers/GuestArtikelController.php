<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Artikel;
use App\Http\Controllers\Controller;

class GuestArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q        = $request->string('q')->toString();
        $kategori = $request->string('kategori')->toString();

        $artikel = Artikel::query()
            ->with('author')
            ->when($q, function ($qBuilder) use ($q) {
                $qBuilder->where(function ($x) use ($q) {
                    $x->where('judul', 'like', "%{$q}%")
                      ->orWhere('ringkasan', 'like', "%{$q}%")
                      ->orWhere('konten', 'like', "%{$q}%")
                      ->orWhere('tag', 'like', "%{$q}%");
                });
            })
            ->when($kategori, fn($qB) => $qB->where('kategori', $kategori))
            // gunakan scope published() kalau sudah ada; kalau belum:
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        $kategoriList = Artikel::select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori');

        return view('guest.artikel.index', compact('artikel','q','kategori','kategoriList'));
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
        $artikel = Artikel::where('slug', $slug)
        ->where('published_at', '<=', now())
        ->with(['author', 'komentarApproved' => function($query) {
            $query->with(['user', 'approvedReplies.user'])
                  ->orderBy('created_at', 'desc');
        }])
        ->firstOrFail();

        // Get previous and next articles
        $previousArticle = Artikel::where('published_at', '<=', now())
            ->where('published_at', '<', $artikel->published_at)
            ->orderBy('published_at', 'desc')
            ->first();

        $nextArticle = Artikel::where('published_at', '<=', now())
            ->where('published_at', '>', $artikel->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        return view('guest.artikel.show', compact('artikel', 'previousArticle', 'nextArticle'));
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
