<?php

namespace App\Http\Controllers\Admin;

use App\Models\KoleksiDokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class AdminKoleksiDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $koleksi = KoleksiDokumen::orderBy('urutan', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.publikasi-data.koleksi-dokumen.index', compact('koleksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.publikasi-data.koleksi-dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:koleksi_dokumen,slug'],
            'deskripsi_singkat' => ['nullable', 'string'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'tahun_mulai' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'tahun_selesai' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'lokasi_fisik' => ['nullable', 'string', 'max:255'],
            'lembaga' => ['nullable', 'string', 'max:255'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
            'tampil_beranda' => ['boolean'],
        ]);

        $koleksi = new KoleksiDokumen();
        
        $koleksi->judul = $data['judul'];
        $koleksi->slug = $data['slug'];
        $koleksi->deskripsi_singkat = $data['deskripsi_singkat'] ?? null;
        $koleksi->deskripsi_lengkap = $data['deskripsi_lengkap'] ?? null;
        $koleksi->kategori = $data['kategori'] ?? null;
        $koleksi->tahun_mulai = $data['tahun_mulai'] ?? null;
        $koleksi->tahun_selesai = $data['tahun_selesai'] ?? null;
        $koleksi->lokasi_fisik = $data['lokasi_fisik'] ?? null;
        $koleksi->lembaga = $data['lembaga'] ?? null;
        $koleksi->sumber = $data['sumber'] ?? null;
        $koleksi->urutan = $data['urutan'] ?? 0;
        $koleksi->published_at = $data['published_at'] ?? null;
        $koleksi->is_published = $data['is_published'] ?? false;
        $koleksi->tampil_beranda = $data['tampil_beranda'] ?? false;

        // Upload cover image
        if ($request->hasFile('cover')) {
            $koleksi->cover_path = $request->file('cover')
                ->store('koleksi/cover', 'public');
        }

        $koleksi->save();

        return redirect()
            ->route('admin.publikasi-data.koleksi-dokumen.index')
            ->with('success', 'Koleksi dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Redirect ke halaman dokumen dengan filter koleksi
        return redirect()->route('admin.publikasi-data.dokumen.index', [
            'koleksi' => $id
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $koleksi = KoleksiDokumen::findOrFail($id);
        return view('admin.publikasi-data.koleksi-dokumen.edit', compact('koleksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $koleksi = KoleksiDokumen::findOrFail($id);

        $data = $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:koleksi_dokumen,slug,' . $id],
            'deskripsi_singkat' => ['nullable', 'string'],
            'deskripsi_lengkap' => ['nullable', 'string'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'tahun_mulai' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'tahun_selesai' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'lokasi_fisik' => ['nullable', 'string', 'max:255'],
            'lembaga' => ['nullable', 'string', 'max:255'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'cover' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'urutan' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
            'tampil_beranda' => ['boolean'],
        ]);

        $koleksi->judul = $data['judul'];
        $koleksi->slug = $data['slug'];
        $koleksi->deskripsi_singkat = $data['deskripsi_singkat'] ?? null;
        $koleksi->deskripsi_lengkap = $data['deskripsi_lengkap'] ?? null;
        $koleksi->kategori = $data['kategori'] ?? null;
        $koleksi->tahun_mulai = $data['tahun_mulai'] ?? null;
        $koleksi->tahun_selesai = $data['tahun_selesai'] ?? null;
        $koleksi->lokasi_fisik = $data['lokasi_fisik'] ?? null;
        $koleksi->lembaga = $data['lembaga'] ?? null;
        $koleksi->sumber = $data['sumber'] ?? null;
        $koleksi->urutan = $data['urutan'] ?? 0;
        $koleksi->published_at = $data['published_at'] ?? null;
        $koleksi->is_published = $data['is_published'] ?? false;
        $koleksi->tampil_beranda = $data['tampil_beranda'] ?? false;

        // Update cover image
        if ($request->hasFile('cover')) {
            // Hapus cover lama jika ada
            if (!empty($koleksi->cover_path)) {
                Storage::disk('public')->delete($koleksi->cover_path);
            }
            
            $koleksi->cover_path = $request->file('cover')
                ->store('koleksi/cover', 'public');
        }

        // Hapus cover jika di-request
        if ($request->has('hapus_cover') && $request->hapus_cover == '1') {
            if (!empty($koleksi->cover_path)) {
                Storage::disk('public')->delete($koleksi->cover_path);
                $koleksi->cover_path = null;
            }
        }

        $koleksi->update();

        return redirect()
            ->route('admin.publikasi-data.koleksi-dokumen.index')
            ->with('success', 'Koleksi dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $koleksi = KoleksiDokumen::findOrFail($id);

            // Hapus cover image jika ada
            if (!empty($koleksi->cover_path)) {
                Storage::disk('public')->delete($koleksi->cover_path);
            }

            // Hapus koleksi
            $koleksi->delete();

            return redirect()
                ->route('admin.publikasi-data.koleksi-dokumen.index')
                ->with('success', 'Koleksi dokumen berhasil dihapus.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('admin.publikasi-data.koleksi-dokumen.index')
                ->with('error', 'Koleksi tidak ditemukan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.publikasi-data.koleksi-dokumen.index')
                ->with('error', 'Terjadi kesalahan saat menghapus koleksi: ' . $e->getMessage());
        }
    }
}