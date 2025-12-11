<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class GaleriAlbumController extends Controller
{
    /**
     * STEP 1: Index – daftar album galeri untuk admin
     */
    public function index()
    {
        $albums = GaleriAlbum::withCount('media')
            ->orderBy('urutan')
            ->orderByDesc('published_at')
            ->get();

        return view('admin.publikasi-data.galeri.albums.index', compact('albums'));
    }

    /**
     * STEP 2: Form create album
     */
    public function create()
    {
        // kirim instance kosong supaya view bisa pakai $album?->field
        $album = new GaleriAlbum();

        // list kategori & koleksi bisa kamu sesuaikan
        $kategoriList = ['Kegiatan', 'Program', 'Kolaborasi', 'Dokumentasi', 'Lainnya'];
        $koleksiList  = ['Foto', 'Video', 'Foto & Video'];

        return view('admin.publikasi-data.galeri.albums.create', compact('album', 'kategoriList', 'koleksiList'));
    }

    /**
     * STEP 3: Simpan album baru
     */
    public function store(Request $request)
    {
        // 3.1 Validasi input - SESUAIKAN DENGAN FORM
        $data = $request->validate([
            'judul'              => ['required', 'string', 'max:255'],
            'slug'               => ['nullable', 'string', 'max:255'],
            'deskripsi_singkat'  => ['nullable', 'string', 'max:255'],
            'deskripsi'          => ['nullable', 'string'],
            'kategori'           => ['nullable', 'string', 'max:100'],
            'kategori_manual'    => ['nullable', 'string', 'max:100'],
            'tahun'              => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'tanggal_mulai'      => ['nullable', 'date'],
            'tanggal_selesai'    => ['nullable', 'date'],
            'lokasi'             => ['nullable', 'string', 'max:255'],
            'tampil_beranda'     => ['nullable', 'boolean'],
            'urutan'             => ['nullable', 'integer', 'min:0'],
            'cover'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:12000'],
        ]);

        // 3.2 Generate slug unik (kalau kosong)
        $slug = $data['slug'] ?: Str::slug($data['judul']);
        $slug = $this->makeUniqueSlug($slug);

        // 3.3 Handle kategori - prioritaskan manual jika diisi
        $kategoriFinal = !empty($data['kategori_manual']) ? $data['kategori_manual'] : ($data['kategori'] ?? null);

        // 3.4 Handle tanggal published - sesuaikan dengan kebutuhan
        $published_at = now(); // atau bisa dari input jika ada

        // 3.5 Siapkan payload untuk create
        $payload = [
            'judul'             => $data['judul'],
            'slug'              => $slug,
            'deskripsi_singkat' => $data['deskripsi_singkat'] ?? null,
            'deskripsi'         => $data['deskripsi'] ?? null,
            'kategori'          => $kategoriFinal,
            'tahun'             => $data['tahun'] ?? null,
            'tanggal_mulai'     => $data['tanggal_mulai'] ?? null,
            'tanggal_selesai'   => $data['tanggal_selesai'] ?? null,
            'lokasi'            => $data['lokasi'] ?? null,
            'published_at'      => $published_at,
            'is_published'      => true, // default true atau sesuaikan
            'tampil_beranda'    => $request->has('tampil_beranda'), // handle checkbox
            'urutan'            => $data['urutan'] ?? 0,
        ];

        $album = new GaleriAlbum($payload);

        // 3.6 Upload cover (opsional)
        if ($request->hasFile('cover')) {
            $album->cover_path = $request->file('cover')->store('galeri/cover', 'public');
        }

        $album->save();

        return redirect()
            ->route('admin.publikasi-data.galeri.albums.index')
            ->with('success', 'Album galeri berhasil dibuat.');
    }

    /**
     * STEP 4: Tampilkan detail album (admin)
     */
    public function show(GaleriAlbum $album)
    {
        // muat media terkait (foto/video)
        $album->load('media');

        return view('admin.publikasi-data.galeri.albums.show', compact('album'));
    }

    /**
     * STEP 5: Form edit album
     */
    public function edit(GaleriAlbum $album)
    {
        $kategoriList = ['Kegiatan', 'Program', 'Kolaborasi', 'Dokumentasi', 'Lainnya'];
        $koleksiList  = ['Foto', 'Video', 'Foto & Video'];

        // mapping is_published -> status form
        $status = $album->is_published ? 'Publik' : 'Draft';

        return view('admin.publikasi-data.galeri.albums.edit', compact('album', 'kategoriList', 'koleksiList', 'status'));
    }

    /**
     * STEP 6: Update album
     */
    public function update(Request $request, GaleriAlbum $album)
    {
        // Validasi input - SESUAIKAN DENGAN FORM
        $data = $request->validate([
            'judul'              => ['required', 'string', 'max:255'],
            'slug'               => ['nullable', 'string', 'max:255'],
            'deskripsi_singkat'  => ['nullable', 'string', 'max:255'],
            'deskripsi'          => ['nullable', 'string'],
            'kategori'           => ['nullable', 'string', 'max:100'],
            'kategori_manual'    => ['nullable', 'string', 'max:100'],
            'tahun'              => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'tanggal_mulai'      => ['nullable', 'date'],
            'tanggal_selesai'    => ['nullable', 'date'],
            'lokasi'             => ['nullable', 'string', 'max:255'],
            'is_published'       => ['required', 'in:0,1'], // dari dropdown
            'published_at'       => ['nullable', 'date'],
            'tampil_beranda'     => ['nullable', 'boolean'],
            'urutan'             => ['nullable', 'integer', 'min:0'],
            'cover'              => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:12000'],
            'hapus_cover'        => ['nullable', 'boolean'], // untuk opsi hapus cover
        ]);

        // Handle kategori - prioritaskan manual jika diisi
        $kategoriFinal = !empty($data['kategori_manual']) ? $data['kategori_manual'] : ($data['kategori'] ?? null);

        // Handle slug
        $slugInput = $data['slug'] ?: $album->slug;
        $slug = $this->makeUniqueSlug($slugInput, $album->id);

        // Handle published_at - jika status published tapi tanggal kosong, pakai sekarang
        $published_at = $data['published_at'];
        if ($data['is_published'] && !$published_at) {
            $published_at = now();
        }

        // Siapkan payload
        $payload = [
            'judul'             => $data['judul'],
            'slug'              => $slug,
            'deskripsi_singkat' => $data['deskripsi_singkat'] ?? null,
            'deskripsi'         => $data['deskripsi'] ?? null,
            'kategori'          => $kategoriFinal,
            'tahun'             => $data['tahun'] ?? null,
            'tanggal_mulai'     => $data['tanggal_mulai'] ?? null,
            'tanggal_selesai'   => $data['tanggal_selesai'] ?? null,
            'lokasi'            => $data['lokasi'] ?? null,
            'published_at'      => $data['is_published'] ? $published_at : null,
            'is_published'      => $data['is_published'],
            'tampil_beranda'    => $request->boolean('tampil_beranda'),
            'urutan'            => $data['urutan'] ?? 0,
        ];

        $album->fill($payload);

        // Handle cover
        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if ($album->cover_path) {
                Storage::disk('public')->delete($album->cover_path);
            }
            // Upload cover baru
            $album->cover_path = $request->file('cover')->store('galeri/cover', 'public');
        } elseif ($request->boolean('hapus_cover')) {
            // Hapus cover jika opsi hapus dicentang
            if ($album->cover_path) {
                Storage::disk('public')->delete($album->cover_path);
                $album->cover_path = null;
            }
        }

        $album->save();

        return redirect()
            ->route('admin.publikasi-data.galeri.albums.index')
            ->with('success', 'Album galeri berhasil diperbarui.');
    }
    /**
     * STEP 7: Hapus album
     * (opsional: hapus juga file cover & media terkait)
     */
    public function destroy(GaleriAlbum $album)
    {
        // hapus cover dari storage
        if ($album->cover_path) {
            Storage::disk('public')->delete($album->cover_path);
        }

        // kalau mau sekalian hapus file media, idealnya di-handle di observer atau di relasi GaleriMedia
        foreach ($album->media as $media) {
            if ($media->file_path) {
                Storage::disk('public')->delete($media->file_path);
            }
            if ($media->thumbnail_path) {
                Storage::disk('public')->delete($media->thumbnail_path);
            }
        }

        $album->delete();

        return redirect()
            ->route('admin.publikasi-data.galeri.albums.index')
            ->with('success', 'Album galeri berhasil dihapus.');
    }

    /**
     * Helper: generate slug unik
     */
    protected function makeUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug   = Str::slug($baseSlug) ?: Str::random(8);
        $original = $slug;
        $i = 2;

        while (
            GaleriAlbum::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $original.'-'.$i;
            $i++;
        }

        return $slug;
    }
}
