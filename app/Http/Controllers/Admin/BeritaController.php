<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;


class BeritaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $berita = Berita::all();
        return view('admin.publikasi-data.berita.index', compact('berita'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publikasi-data.berita.create');
    }

    /**
     * Store a newly created resource in storage.
     */
        public function store(Request $request)
        {
            // 1) Validasi
            $data = $request->validate([
                'judul'         => ['required', 'string', 'max:255'],
                'slug'          => ['nullable', 'string', 'max:255'],
                'kategori'      => ['nullable', 'string', 'max:100'],
                'tag'           => ['nullable', 'string', 'max:500'], // "a, b, c"
                'ringkasan'     => ['nullable', 'string', 'max:600'],
                'konten'        => ['required', 'string'],
                'thumbnail'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
                'published_at'  => ['nullable', 'date'],
            ]);

            // 2) Slug (fallback dari judul) + pastikan unik
            $baseSlug = $data['slug'] ?: Str::slug($data['judul']);
            $data['slug'] = $this->makeUniqueSlug($baseSlug);

            // 3) Normalisasi tag (rapikan, hilangkan duplikat, simpan jadi string "a, b, c")
            $data['tag'] = $this->normalizeTags($data['tag'] ?? '');

            // 4) Handle thumbnail (opsional)
            $thumbPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbPath = $request->file('thumbnail')->store('berita/thumbnail', 'public');
            }

            // 5) Simpan
            $berita = new Berita();
            $berita->judul         = $data['judul'];
            $berita->slug          = $data['slug'];
            $berita->kategori      = $data['kategori'];
            $berita->tag           = $data['tag'];          // simpan sebagai string "a, b, c"
            $berita->ringkasan     = $data['ringkasan'] ?? null;
            $berita->konten        = $data['konten'];
            $berita->thumbnail_path= $thumbPath;
            $berita->published_at  = $data['published_at'] ?? null;
            // opsional: simpan penulis
            if (auth()->check()) {
                $berita->author_id = auth()->id();
            }
            $berita->save();

            return redirect()
                ->route('admin.publikasi-data.berita.index')
                ->with('success', 'Berita berhasil ditambahkan.');
        }

        
    

    /**
     * Display the specified resource.
     */
    public function show(string $berita)
    {
        $berita = Berita::findOrFail($berita);
        return view('admin.publikasi-data.berita.show', compact('berita'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $berita = Berita::findOrFail($id);
        return view('admin.publikasi-data.berita.edit', compact('berita'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $berita = Berita::findOrFail($id);

        // 1) Validasi
        $data = $request->validate([
            'judul'         => ['required', 'string', 'max:255'],
            'slug'          => ['nullable', 'string', 'max:255'],
            'kategori'      => ['required', 'in:Kegiatan,Pengumuman,Rilis,Opini,Publikasi'],
            'tag'           => ['nullable', 'string', 'max:500'],
            'ringkasan'     => ['nullable', 'string', 'max:600'],
            'konten'        => ['required', 'string'],
            'thumbnail'     => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'published_at'  => ['nullable', 'date'],
        ]);

        // 2) Slug (pakai yang dikirim kalau ada; else generate dari judul), dan pastikan unik (abaikan ID saat ini)
        $baseSlug   = $data['slug'] ?: Str::slug($data['judul']);
        $finalSlug  = $this->makeUniqueSlug($baseSlug, $berita->id);

        // 3) Normalisasi tag
        $tags = $this->normalizeTags($data['tag'] ?? '');

        // 4) Handle thumbnail baru (opsional) — hapus lama jika ada
        $thumbPath = $berita->thumbnail_path;
        if ($request->hasFile('thumbnail')) {
            if ($thumbPath && Storage::disk('public')->exists($thumbPath)) {
                Storage::disk('public')->delete($thumbPath);
            }
            $thumbPath = $request->file('thumbnail')->store('berita/thumbnail', 'public');
        }

        // 5) Update field
        $berita->judul          = $data['judul'];
        $berita->slug           = $finalSlug;
        $berita->kategori       = $data['kategori'];
        $berita->tag            = $tags;
        $berita->ringkasan      = $data['ringkasan'] ?? null;
        $berita->konten         = $data['konten'];
        $berita->thumbnail_path = $thumbPath;
        $berita->published_at   = $data['published_at'] ?? null;

        // opsional: ubah author ke editor saat ini (kalau memang kebijakanmu begitu)
        // if (auth()->check()) {
        //     $berita->author_id = auth()->id();
        // }

        $berita->save();

        return redirect()
            ->route('admin.publikasi-data.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $berita = Berita::findOrFail($id);

        // Hapus thumbnail jika ada
        if ($berita->thumbnail_path && Storage::disk('public')->exists($berita->thumbnail_path)) {
            Storage::disk('public')->delete($berita->thumbnail_path);
        }

        $berita->delete();

        return redirect()
            ->route('admin.publikasi-data.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * Buat slug unik dengan menambahkan -2, -3, ... jika sudah ada.
     */
    private function makeUniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug = $base !== '' ? $base : Str::random(8);
        $original = $slug;
        $i = 2;

        while (
            Berita::when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $original.'-'.$i;
            $i++;
        }
        return $slug;
    }

    /**
     * Normalisasi tag: "a, b , a" -> "a, b"
     */
    private function normalizeTags(string $raw): ?string
    {
        if (trim($raw) === '') return null;

        $parts = array_filter(array_map(
            fn($s) => trim(preg_replace('/\s+/', ' ', $s)),
            explode(',', $raw)
        ));

        // lowercase opsional, kalau mau konsisten:
        // $parts = array_map('mb_strtolower', $parts);

        $unique = array_values(array_unique($parts));
        return count($unique) ? implode(', ', $unique) : null;
    }
}
