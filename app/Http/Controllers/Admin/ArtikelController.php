<?php

namespace App\Http\Controllers\Admin;

// use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // 1. Ambil data dasar artikel yang akan dipaginasi
        $artikel = Artikel::with('author')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        $artikelIds = $artikel->pluck('id');

        // 2. 💡 SOLUSI FINAL: Ambil hitungan views menggunakan DB::table (JAMINAN BERHASIL)
        $artikelVisitCounts = DB::table('laravisits')
            // Filter hanya ID artikel yang ada di halaman ini
            ->whereIn('visitable_id', $artikelIds)
            // Filter hanya untuk Model Artikel
            ->where('visitable_type', Artikel::class) 
            // Hitung views per ID
            ->select('visitable_id', DB::raw('COUNT(*) as visits_count'))
            ->groupBy('visitable_id')
            ->get()
            // Konversi ke format [id => views_count]
            ->keyBy('visitable_id')
            ->map(fn($item) => $item->visits_count); // Ambil hanya jumlah hitungan

        // 3. Gabungkan hitungan yang benar ke dalam objek paginasi utama ($artikel)
        $artikel->getCollection()->transform(function ($item) use ($artikelVisitCounts) {
            // Ambil hitungan views dari collection DB::table, jika null beri nilai 0
            $item->visits_count = $artikelVisitCounts->get($item->id) ?? 0;
            return $item;
        });

        // 4. Kirim HANYA satu variabel yang sudah lengkap ke view
        return view('admin.publikasi-data.artikel.index', [
            'artikel' => $artikel,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publikasi-data.artikel.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'        => ['required','string','max:255'],
            'slug'         => ['nullable','string','max:255'],
            'kategori'     => ['required','in:Opini,Esai,Analisis,Publikasi'],
            'penulis'      => ['required','string','max:500'], // ⬅️ wajib sekarang
            'tag'          => ['nullable','string','max:500'],
            'ringkasan'    => ['nullable','string','max:600'],
            'konten'       => ['required','string'],
            'thumbnail'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:3072'],
            'published_at' => ['nullable','date'],
            
        ]);

        $baseSlug    = $data['slug'] ?: Str::slug($data['judul']);
        $data['slug']= $this->makeUniqueSlug($baseSlug);

        $data['tag']     = $this->normalizeTags($data['tag'] ?? '');
        $data['penulis'] = $this->normalizeAuthors($data['penulis'] ?? '');

        $thumbPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbPath = $request->file('thumbnail')->store('artikel/thumbnail','public');
        }

        // reading time (±220 wpm)
        $words   = str_word_count(strip_tags($data['konten']));
        $reading = max(1, (int) ceil($words / 220));

        $artikel = new Artikel();
        $artikel->judul          = $data['judul'];
        $artikel->slug           = $data['slug'];
        $artikel->kategori       = $data['kategori'];
        $artikel->penulis        = $data['penulis'];       // ⬅️ manual, jamak
        $artikel->tag            = $data['tag'];
        $artikel->ringkasan      = $data['ringkasan'] ?? null;
        $artikel->konten         = $data['konten'];
        $artikel->thumbnail_path = $thumbPath;
        $artikel->published_at   = $data['published_at'] ?? null;

        $artikel->save();

        return redirect()
            ->route('admin.publikasi-data.artikel.index')
            ->with('success','Artikel berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Artikel $artikel)
    {
        $artikel->load('author');

        return view('admin.publikasi-data.artikel.show', [
            'artikel' => $artikel,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artikel $artikel)
    {
        // kalau perlu relasi penulis:
        $artikel->load('author');

        return view('admin.publikasi-data.artikel.edit', [
            'artikel' => $artikel,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artikel $artikel)
    {
        $data = $request->validate([
            'judul'        => ['required','string','max:255'],
            'slug'         => ['nullable','string','max:255'],
            'kategori'     => ['required','in:Opini,Esai,Analisis,Publikasi'],
            'penulis'      => ['required','string','max:500'], // ⬅️ wajib
            'tag'          => ['nullable','string','max:500'],
            'ringkasan'    => ['nullable','string','max:600'],
            'konten'       => ['required','string'],
            'thumbnail'    => ['nullable','image','mimes:jpg,jpeg,png,webp','max:3072'],
            'published_at' => ['nullable','date'],
        ]);

        $baseSlug     = $data['slug'] ?: Str::slug($data['judul']);
        $data['slug'] = $this->makeUniqueSlug($baseSlug, $artikel->id);

        $data['tag']     = $this->normalizeTags($data['tag'] ?? '');
        $data['penulis'] = $this->normalizeAuthors($data['penulis'] ?? '');

        if ($request->hasFile('thumbnail')) {
            $newPath = $request->file('thumbnail')->store('artikel/thumbnail','public');
            if ($artikel->thumbnail_path && Storage::disk('public')->exists($artikel->thumbnail_path)) {
                Storage::disk('public')->delete($artikel->thumbnail_path);
            }
            $artikel->thumbnail_path = $newPath;
        }

        if ($artikel->konten !== $data['konten']) {
            $words = str_word_count(strip_tags($data['konten']));
            $artikel->reading_time = max(1, (int) ceil($words / 220));
        }

        $artikel->judul        = $data['judul'];
        $artikel->slug         = $data['slug'];
        $artikel->kategori     = $data['kategori'];
        $artikel->penulis      = $data['penulis'];    // ⬅️ update penulis manual
        $artikel->tag          = $data['tag'];
        $artikel->ringkasan    = $data['ringkasan'] ?? null;
        $artikel->konten       = $data['konten'];
        $artikel->published_at = $data['published_at'] ?? null;

        $artikel->save();

        return redirect()
            ->route('admin.publikasi-data.artikel.index')
            ->with('success','Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Artikel $artikel)
    {
        $artikel->delete();
        return redirect()
            ->route('admin.publikasi-data.artikel.index')
            ->with('success','Artikel berhasil dihapus.');
    }

    /**
     * Buat slug unik dengan menambahkan -2, -3, ... jika sudah ada.
     */
    private function makeUniqueSlug(string $base, ?int $ignoreId = null): string
    {
        $slug     = $base !== '' ? $base : Str::random(8);
        $original = $slug;
        $i = 2;

        while (
            Artikel::when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $original.'-'.$i;
            $i++;
        }
        return $slug;
    }

    /**
     * Rapikan input tag "a, b, c" -> "a, b, c" (trim, unique, buang kosong).
     */
    private function normalizeTags(?string $raw): string
    {
        if (!$raw) return '';
        return collect(explode(',', $raw))
            ->map(fn($t) => trim($t))
            ->filter()
            ->unique()
            ->join(', ');
    }

        private function normalizeAuthors(string $raw): string
    {
        // "S. Rahim ,  A. Nur,  m. latu" -> "S. Rahim, A. Nur, M. Latu"
        return collect(explode(',', $raw))
            ->map(fn($n)=>trim($n))
            ->filter()
            ->map(function($n){
                // kapitalisasi title-case tapi biarkan inisial/gelar apa adanya
                return collect(preg_split('/\s+/', $n))
                    ->map(fn($p)=>mb_convert_case($p, MB_CASE_TITLE, 'UTF-8'))
                    ->join(' ');
            })
            ->unique()
            ->values()
            ->join(', ');
    }
}
