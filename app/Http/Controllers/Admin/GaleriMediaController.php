<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GaleriAlbum;
use App\Models\GaleriMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class GaleriMediaController extends Controller
{
    /**
     * INDEX: list media dalam 1 album
     * Route: admin.publikasi-data.galeri.media.index (galeri/albums/{album}/media)
     */
    public function index(Request $request)
    {
        // Filter by album jika ada parameter
        $albumId = $request->get('album_id');
        
        if ($albumId) {
            $album = GaleriAlbum::findOrFail($albumId);
            $media = $album->media()->paginate(12);
        } else {
            // JIKA TIDAK ADA ALBUM_ID, TAMPILKAN SEMUA MEDIA
            $media = GaleriMedia::with('album')->orderBy('created_at', 'desc')->paginate(12);
            $album = null; // ← SET NULL
        }
        
        return view('admin.publikasi-data.galeri.media.index', compact('album', 'media'));
    }

    /**
     * CREATE: form tambah media dalam album tertentu
     */
    public function create(Request $request)
    {

        // $albumId = $request->get('album_id');
    
    // // Validasi: album_id wajib ada
    // if (!$albumId) {
    //     return redirect()
    //         ->route('admin.publikasi-data.galeri.albums.index')
    //         ->with('error', 'Pilih album terlebih dahulu.');
    // }

    // $album = GaleriAlbum::find($albumId);
    
    // // Validasi: album harus exist
    // if (!$album) {
    //     return redirect()
    //         ->route('admin.publikasi-data.galeri.albums.index')
    //         ->with('error', 'Album tidak ditemukan.');
    // }

    // $media = new GaleriMedia();
    // $tipeList = ['foto', 'video', 'youtube'];
    // $albums = GaleriAlbum::all(); // tetap load untuk fallback

    // return view('admin.publikasi-data.galeri.media.create', compact('album', 'media', 'tipeList', 'albums')); //

        $albumId = $request->get('album_id');
        $album = $albumId ? GaleriAlbum::find($albumId) : null;
        // dd($albumId);
        
        $media = new GaleriMedia();
        $tipeList = ['foto', 'video', 'youtube'];
        
        // Get all albums for dropdown
        $albums = GaleriAlbum::all();

        return view('admin.publikasi-data.galeri.media.create', compact('album', 'media', 'tipeList', 'albums'));
    }

    /**
     * STORE: simpan media baru - SESUAI MODEL BARU
     */
    public function store(Request $request)
{
    // Validasi
    $data = $request->validate([
        'galeri_album_id' => ['required', 'exists:galeri_albums,id'],
        'tipe'          => ['required', 'in:foto,video,youtube'],
        'judul'         => ['required', 'string', 'max:255'],
        'keterangan'    => ['nullable', 'string'],
        'youtube_url'   => ['nullable', 'url', 'max:500'],
        'taken_at'      => ['nullable', 'date'],
        'urutan'        => ['nullable', 'integer', 'min:0'],
        'is_utama'      => ['sometimes', 'boolean'],

        'file_path' => [
            'nullable',
            'file',
            'max:20480',
            'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo'
        ],
        'thumbnail_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
    ]);

    // Cari album
    $album = GaleriAlbum::find($data['galeri_album_id']);
    
    // Validasi logika tambahan
    if ($data['tipe'] === 'foto' && !$request->hasFile('file_path')) {
        return back()
            ->withErrors(['file_path' => 'Untuk tipe Foto, file gambar wajib diunggah.'])
            ->withInput();
    }

    if ($data['tipe'] === 'video' && !$request->hasFile('file_path')) {
        return back()
            ->withErrors(['file_path' => 'Untuk tipe Video, file video wajib diunggah.'])
            ->withInput();
    }

    if ($data['tipe'] === 'youtube' && empty($data['youtube_url'])) {
        return back()
            ->withErrors(['youtube_url' => 'Untuk tipe YouTube, URL YouTube wajib diisi.'])
            ->withInput();
    }

    // Jika ada media utama, reset yang lain
    if ($request->boolean('is_utama')) {
        $album->media()->update(['is_utama' => false]);
    }

    // Create media
    $media = new GaleriMedia();
    $media->galeri_album_id = $data['galeri_album_id'];
    $media->tipe            = $data['tipe'];
    $media->judul           = $data['judul'];
    $media->keterangan      = $data['keterangan'] ?? null;
    $media->youtube_url     = $data['youtube_url'] ?? null;
    $media->taken_at        = $data['taken_at'] ?? null;
    $media->urutan          = $data['urutan'] ?? 0;
    $media->is_utama        = $request->boolean('is_utama');

    // Upload file
    if ($request->hasFile('file_path')) {
        $media->file_path = $request->file('file_path')->store('galeri/media', 'public');
    }

    // Upload thumbnail
    if ($request->hasFile('thumbnail_path')) {
        $media->thumbnail_path = $request->file('thumbnail_path')->store('galeri/media/thumb', 'public');
    }

    $media->save();

    return redirect()
        ->route('admin.publikasi-data.galeri.media.index', ['album_id' => $album->id])
        ->with('success', 'Media galeri berhasil ditambahkan ke album "' . $album->judul . '".');
}

    /**
     * SHOW: detail 1 media (opsional, untuk admin)
     * Route (shallow): galeri/media/{media}
     */
    public function show(GaleriMedia $media) // ✅ GANTI: $medium -> $media
    {
        $media->load('album');

        return view('admin.publikasi-data.galeri.media.show', [
            'media' => $media,
            'album' => $media->album,
        ]);
    }

    /**
     * EDIT: form edit 1 media
     */
    public function edit(GaleriMedia $media) // ✅ GANTI: $medium -> $media
    {
        $media->load('album');
        // dd($media->album);
        $tipeList = ['foto', 'video', 'youtube'];

        return view('admin.publikasi-data.galeri.media.edit', [
            'album'    => $media->album,
            'media'    => $media,
            'tipeList' => $tipeList,
        ]);
    }

    /**
     * UPDATE: simpan perubahan media - SESUAI MODEL BARU
     */
    public function update(Request $request, GaleriMedia $media)
{
    // dd('masuk update');
    // ✅ DEBUG: Cek file input
    Log::info('=== UPDATE MEDIA DEBUG ===');
    Log::info('Has file_path:', ['has' => $request->hasFile('file_path')]);
    Log::info('Has thumbnail_path:', ['has' => $request->hasFile('thumbnail_path')]);
    Log::info('All files:', $request->files->all());
    Log::info('Current file_path:', ['current' => $media->file_path]);
    Log::info('Current thumbnail_path:', ['current' => $media->thumbnail_path]);
    Log::info('=====================');

    $data = $request->validate([
        'tipe'          => ['required', 'in:foto,video,youtube'],
        'judul'         => ['required', 'string', 'max:255'],
        'keterangan'    => ['nullable', 'string'],
        'youtube_url'   => ['nullable', 'url', 'max:500'],
        'taken_at'      => ['nullable', 'date'],
        'urutan'        => ['nullable', 'integer', 'min:0'],
        'is_utama'      => ['sometimes', 'boolean'],

        'file_path' => [
            'nullable',
            'file',
            'max:20480',
            'mimetypes:image/jpeg,image/png,image/webp,video/mp4,video/quicktime,video/x-msvideo'
        ],
        'thumbnail_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
    ]);

    // ✅ PERBAIKI VALIDASI: HANYA JIKA UBAH TIPE ATAU FILE LAMA TIDAK ADA
    if ($data['tipe'] === 'foto') {
        // Jika TIDAK ada file baru DAN TIDAK ada file lama
        if (!$request->hasFile('file_path') && !$media->file_path) {
            return back()
                ->withErrors(['file_path' => 'Untuk tipe Foto, file gambar wajib diunggah.'])
                ->withInput();
        }
    }

    if ($data['tipe'] === 'video') {
        // Jika TIDAK ada file baru DAN TIDAK ada file lama  
        if (!$request->hasFile('file_path') && !$media->file_path) {
            return back()
                ->withErrors(['file_path' => 'Untuk tipe Video, file video wajib diunggah.'])
                ->withInput();
        }
    }

    if ($data['tipe'] === 'youtube') {
        // Jika URL kosong DAN URL lama juga kosong
        if (empty($data['youtube_url']) && !$media->youtube_url) {
            return back()
                ->withErrors(['youtube_url' => 'Untuk tipe YouTube, URL YouTube wajib diisi.'])
                ->withInput();
        }
    }

    // ✅ PERBAIKI: HANYA VALIDASI JIKA BENAR-BENAR UBAH TIPE
    if ($media->tipe !== $data['tipe']) {
        // Jika ubah dari youtube ke foto/video
        if (($data['tipe'] === 'foto' || $data['tipe'] === 'video')) {
            // Butuh file baru ATAU sudah ada file lama
            if (!$request->hasFile('file_path') && !$media->file_path) {
                return back()
                    ->withErrors(['file_path' => 'Untuk mengubah ke tipe ' . $data['tipe'] . ', file wajib diunggah.'])
                    ->withInput();
            }
        }
        
        // Jika ubah dari foto/video ke youtube
        if ($data['tipe'] === 'youtube') {
            // Butuh URL baru ATAU sudah ada URL lama
            if (empty($data['youtube_url']) && !$media->youtube_url) {
                return back()
                    ->withErrors(['youtube_url' => 'Untuk mengubah ke tipe YouTube, URL YouTube wajib diisi.'])
                    ->withInput();
            }
        }
    }

    // Jika ada media utama, reset yang lain
    if ($request->boolean('is_utama')) {
        $media->album->media()->where('id', '!=', $media->id)->update(['is_utama' => false]);
    }

    $media->tipe        = $data['tipe'];
    $media->judul       = $data['judul'];
    $media->keterangan  = $data['keterangan'] ?? null;
    $media->youtube_url = $data['youtube_url'] ?? null;
    $media->taken_at    = $data['taken_at'] ?? null;
    $media->urutan      = $data['urutan'] ?? 0;
    $media->is_utama    = $request->boolean('is_utama');

    // ✅ FILE HANDLING: HANYA GANTI JIKA ADA UPLOAD BARU
    if ($request->hasFile('file_path')) {
        // Hapus file lama jika ada
        if ($media->file_path) {
            Storage::disk('public')->delete($media->file_path);
        }
        // Upload file baru
        $media->file_path = $request->file('file_path')->store('galeri/media', 'public');
    }
    // ✅ JIKA TIDAK ADA UPLOAD BARU, file_path TETAP PAKAI YANG LAMA

    // ✅ THUMBNAIL HANDLING: HANYA GANTI JIKA ADA UPLOAD BARU
    if ($request->hasFile('thumbnail_path')) {
        // Hapus thumbnail lama jika ada
        if ($media->thumbnail_path) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }
        // Upload thumbnail baru
        $media->thumbnail_path = $request->file('thumbnail_path')->store('galeri/media/thumb', 'public');
    }
    // ✅ JIKA TIDAK ADA UPLOAD BARU, thumbnail_path TETAP PAKAI YANG LAMA

    $media->save();
    $albumId = $media->galeri_album_id;
    return redirect()
        ->route('admin.publikasi-data.galeri.media.index', compact('albumId'))
        ->with('success', 'Media galeri berhasil diperbarui.');
}

    /**
     * DESTROY: hapus 1 media
     */
    public function destroy(GaleriMedia $media) // ✅ GANTI: $medium -> $media
    {

        // dd('masuk destroy');
        $albumId = $media->galeri_album_id;

        if ($media->file_path) {
            Storage::disk('public')->delete($media->file_path);
        }

        if ($media->thumbnail_path) {
            Storage::disk('public')->delete($media->thumbnail_path);
        }

        $media->delete();

        return redirect()
            ->route('admin.publikasi-data.galeri.media.index', compact('albumId'))
            ->with('success', 'Media galeri berhasil dihapus.');
    }

    /**
     * SET UTAMA: jadikan media sebagai cover album
     */
    public function setUtama(GaleriMedia $media) // ✅ GANTI: $medium -> $media
    {
        // Reset semua media utama di album ini
        $media->album->media()->update(['is_utama' => false]);
        
        // Set media ini sebagai utama
        $media->update(['is_utama' => true]);

        return back()->with('success', 'Media berhasil dijadikan cover album.');
    }

    /**
     * REORDER: update urutan media
     */
    public function reorder(Request $request, GaleriAlbum $album)
    {
        $request->validate([
            'media_order' => ['required', 'array'],
            'media_order.*.id' => ['required', 'exists:galeri_media,id'],
            'media_order.*.order' => ['required', 'integer'],
        ]);

        foreach ($request->media_order as $item) {
            GaleriMedia::where('id', $item['id'])
                ->where('galeri_album_id', $album->id)
                ->update(['urutan' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}