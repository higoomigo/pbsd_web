<?php

namespace App\Http\Controllers\Admin;

// use App\Models\User;
use App\Models\Dokumen;
use App\Models\KoleksiDokumen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
        public function index(Request $request)
    {
        $query = Dokumen::with('koleksi');
        
        // Filter by koleksi
        if ($request->has('koleksi') && $request->koleksi) {
            $query->where('koleksi_dokumen_id', $request->koleksi);
            $currentKoleksi = KoleksiDokumen::find($request->koleksi);
        } else {
            $currentKoleksi = null;
        }
        
        // Filter by status
        if ($request->has('status') && $request->status) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'utama') {
                $query->where('is_utama', true);
            }
        }
        
        // Filter by kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }
        
        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'LIKE', "%{$search}%")
                  ->orWhere('kode', 'LIKE', "%{$search}%")
                  ->orWhere('penulis', 'LIKE', "%{$search}%")
                  ->orWhere('ringkasan', 'LIKE', "%{$search}%");
            });
        }
        
        $dokumen = $query->orderBy('urutan', 'asc')
            ->orderBy('prioritas', 'asc')
            ->orderBy('created_at', 'desc')
            ->paginate(25);
        
        $totalDokumen = Dokumen::count();
        $publishedCount = Dokumen::where('is_published', true)->count();
        $utamaCount = Dokumen::where('is_utama', true)->count();
        $googleDriveCount = Dokumen::whereNotNull('google_drive_id')
            ->orWhereNotNull('google_drive_link')
            ->count();
        
        $koleksiList = KoleksiDokumen::where('is_published', true)
            ->orderBy('judul', 'asc')
            ->get();
        
        // Get unique categories for filter
        $kategoriList = Dokumen::select('kategori')
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori');
        
        return view('admin.publikasi-data.dokumen.index', compact(
            'dokumen',
            'totalDokumen',
            'publishedCount',
            'utamaCount',
            'googleDriveCount',
            'koleksiList',
            'kategoriList',
            'currentKoleksi'
        ));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $koleksi = KoleksiDokumen::where('is_published', true)
        ->orderBy('judul', 'asc')
        ->get();
    
        // Get selected koleksi if passed via query string
        $selectedKoleksiId = $request->get('koleksi_dokumen_id');
        $selectedKoleksi = null;
        
        if ($selectedKoleksiId) {
            $selectedKoleksi = KoleksiDokumen::find($selectedKoleksiId);
        }
        
        return view('admin.publikasi-data.dokumen.create', compact('koleksi', 'selectedKoleksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'koleksi_dokumen_id' => ['nullable', 'exists:koleksi_dokumen,id'],
            'kode' => ['nullable', 'string', 'max:50', 'unique:dokumen,kode'],
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:dokumen,slug'],
            'deskripsi_singkat' => ['nullable', 'string', 'max:500'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'sub_kategori' => ['nullable', 'string', 'max:100'],
            'format_asli' => ['nullable', 'string', 'max:100'],
            'format_digital' => ['nullable', 'string', 'max:100'],
            'ringkasan' => ['nullable', 'string'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'lembaga' => ['nullable', 'string', 'max:255'],
            'lokasi_fisik' => ['nullable', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'tanggal_terbit' => ['nullable', 'date'],
            'penulis' => ['nullable', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'bahasa' => ['nullable', 'string', 'max:100'],
            'halaman' => ['nullable', 'integer', 'min:0'],
            'prioritas' => ['nullable', 'integer', 'min:0', 'max:10'],
            'catatan' => ['nullable', 'string'],
            
            // Google Drive fields
            'google_drive_id' => ['nullable', 'string', 'max:255'],
            'google_drive_link' => ['nullable', 'url', 'max:500'],
            'google_drive_thumbnail' => ['nullable', 'url', 'max:500'],
            
            // File uploads
            'file_digital' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,txt,zip,rar', 'max:20480'], // 20MB
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'preview' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            
            // Publication fields
            'urutan' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
            'is_utama' => ['boolean'],
        ]);

        $dokumen = new Dokumen();
        
        // Basic info
        $dokumen->koleksi_dokumen_id = $data['koleksi_dokumen_id'] ?? null;
        $dokumen->kode = $data['kode'] ?? null;
        $dokumen->judul = $data['judul'];
        $dokumen->slug = $data['slug'] ?? Str::slug($data['judul']);
        $dokumen->deskripsi_singkat = $data['deskripsi_singkat'] ?? null;
        $dokumen->kategori = $data['kategori'] ?? null;
        $dokumen->sub_kategori = $data['sub_kategori'] ?? null;
        $dokumen->format_asli = $data['format_asli'] ?? null;
        $dokumen->format_digital = $data['format_digital'] ?? null;
        $dokumen->ringkasan = $data['ringkasan'] ?? null;
        $dokumen->sumber = $data['sumber'] ?? null;
        $dokumen->lembaga = $data['lembaga'] ?? null;
        $dokumen->lokasi_fisik = $data['lokasi_fisik'] ?? null;
        $dokumen->tahun_terbit = $data['tahun_terbit'] ?? null;
        $dokumen->tanggal_terbit = $data['tanggal_terbit'] ?? null;
        $dokumen->penulis = $data['penulis'] ?? null;
        $dokumen->penerbit = $data['penerbit'] ?? null;
        $dokumen->bahasa = $data['bahasa'] ?? null;
        $dokumen->halaman = $data['halaman'] ?? null;
        $dokumen->prioritas = $data['prioritas'] ?? 0;
        $dokumen->catatan = $data['catatan'] ?? null;
        
        // Google Drive fields
        $dokumen->google_drive_id = $data['google_drive_id'] ?? null;
        $dokumen->google_drive_link = $data['google_drive_link'] ?? null;
        $dokumen->google_drive_thumbnail = $data['google_drive_thumbnail'] ?? null;
        
        // Publication fields
        $dokumen->urutan = $data['urutan'] ?? 0;
        $dokumen->published_at = $data['published_at'] ?? null;
        $dokumen->is_published = $data['is_published'] ?? false;
        $dokumen->is_utama = $data['is_utama'] ?? false;

        // Upload file digital (local storage)
        if ($request->hasFile('file_digital')) {
            $file = $request->file('file_digital');
            $dokumen->file_digital_path = $file->store('dokumen/digital', 'public');
            $dokumen->ukuran_file = $file->getSize();
            $dokumen->format_digital = $dokumen->format_digital ?? $file->getClientOriginalExtension();
        }

        // Upload thumbnail
        if ($request->hasFile('thumbnail')) {
            $dokumen->thumbnail_path = $request->file('thumbnail')
                ->store('dokumen/thumbnail', 'public');
        }

        // Upload preview
        if ($request->hasFile('preview')) {
            $dokumen->preview_path = $request->file('preview')
                ->store('dokumen/preview', 'public');
        }

        // Jika menggunakan Google Drive, update ukuran file jika tersedia
        if ($dokumen->google_drive_id && !$dokumen->ukuran_file) {
            // Di sini bisa ditambahkan logika untuk mendapatkan ukuran file dari Google Drive API
            $dokumen->ukuran_file = null; // Default, bisa diisi dengan API call
        }

        $dokumen->save();

        return redirect()
            ->route('admin.publikasi-data.dokumen.index')
            ->with('success', 'Dokumen berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokumen = Dokumen::with('koleksi')->findOrFail($id);
    
        // Increment view count
        $dokumen->incrementViewCount();
        
        return view('admin.publikasi-data.dokumen.show', compact('dokumen'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dokumen = Dokumen::with('koleksi')->findOrFail($id);
        $koleksi = KoleksiDokumen::where('is_published', true)
            ->orderBy('judul', 'asc')
            ->get();
        
        return view('admin.publikasi-data.dokumen.edit', compact('dokumen', 'koleksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $dokumen = Dokumen::findOrFail($id);

        $data = $request->validate([
            'koleksi_dokumen_id' => ['nullable', 'exists:koleksi_dokumen,id'],
            'kode' => ['nullable', 'string', 'max:50', 'unique:dokumen,kode,' . $id],
            'judul' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:dokumen,slug,' . $id],
            'deskripsi_singkat' => ['nullable', 'string', 'max:500'],
            'kategori' => ['nullable', 'string', 'max:100'],
            'sub_kategori' => ['nullable', 'string', 'max:100'],
            'format_asli' => ['nullable', 'string', 'max:100'],
            'format_digital' => ['nullable', 'string', 'max:100'],
            'ringkasan' => ['nullable', 'string'],
            'sumber' => ['nullable', 'string', 'max:255'],
            'lembaga' => ['nullable', 'string', 'max:255'],
            'lokasi_fisik' => ['nullable', 'string', 'max:255'],
            'tahun_terbit' => ['nullable', 'integer', 'min:1800', 'max:' . date('Y')],
            'tanggal_terbit' => ['nullable', 'date'],
            'penulis' => ['nullable', 'string', 'max:255'],
            'penerbit' => ['nullable', 'string', 'max:255'],
            'bahasa' => ['nullable', 'string', 'max:100'],
            'halaman' => ['nullable', 'integer', 'min:0'],
            'prioritas' => ['nullable', 'integer', 'min:0', 'max:10'],
            'catatan' => ['nullable', 'string'],
            
            // Google Drive fields
            'google_drive_id' => ['nullable', 'string', 'max:255'],
            'google_drive_link' => ['nullable', 'url', 'max:500'],
            'google_drive_thumbnail' => ['nullable', 'url', 'max:500'],
            
            // File uploads
            'file_digital' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,jpg,jpeg,png,txt,zip,rar', 'max:20480'], // 20MB
            'thumbnail' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'preview' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            
            // Delete flags
            'hapus_file_digital' => ['nullable', 'boolean'],
            'hapus_thumbnail' => ['nullable', 'boolean'],
            'hapus_preview' => ['nullable', 'boolean'],
            
            // Publication fields
            'urutan' => ['nullable', 'integer', 'min:0'],
            'published_at' => ['nullable', 'date'],
            'is_published' => ['boolean'],
            'is_utama' => ['boolean'],
        ]);

        // Update basic info
        $dokumen->koleksi_dokumen_id = $data['koleksi_dokumen_id'] ?? null;
        $dokumen->kode = $data['kode'] ?? null;
        $dokumen->judul = $data['judul'];
        $dokumen->slug = $data['slug'] ?? $dokumen->slug ?? Str::slug($data['judul']);
        $dokumen->deskripsi_singkat = $data['deskripsi_singkat'] ?? null;
        $dokumen->kategori = $data['kategori'] ?? null;
        $dokumen->sub_kategori = $data['sub_kategori'] ?? null;
        $dokumen->format_asli = $data['format_asli'] ?? null;
        $dokumen->format_digital = $data['format_digital'] ?? null;
        $dokumen->ringkasan = $data['ringkasan'] ?? null;
        $dokumen->sumber = $data['sumber'] ?? null;
        $dokumen->lembaga = $data['lembaga'] ?? null;
        $dokumen->lokasi_fisik = $data['lokasi_fisik'] ?? null;
        $dokumen->tahun_terbit = $data['tahun_terbit'] ?? null;
        $dokumen->tanggal_terbit = $data['tanggal_terbit'] ?? null;
        $dokumen->penulis = $data['penulis'] ?? null;
        $dokumen->penerbit = $data['penerbit'] ?? null;
        $dokumen->bahasa = $data['bahasa'] ?? null;
        $dokumen->halaman = $data['halaman'] ?? null;
        $dokumen->prioritas = $data['prioritas'] ?? 0;
        $dokumen->catatan = $data['catatan'] ?? null;
        
        // Update Google Drive fields
        $dokumen->google_drive_id = $data['google_drive_id'] ?? null;
        $dokumen->google_drive_link = $data['google_drive_link'] ?? null;
        $dokumen->google_drive_thumbnail = $data['google_drive_thumbnail'] ?? null;
        
        // Update publication fields
        $dokumen->urutan = $data['urutan'] ?? $dokumen->urutan;
        $dokumen->published_at = $data['published_at'] ?? null;
        $dokumen->is_published = $data['is_published'] ?? false;
        $dokumen->is_utama = $data['is_utama'] ?? false;

        // Update file digital
        if ($request->hasFile('file_digital')) {
            // Hapus file lama jika ada
            if (!empty($dokumen->file_digital_path)) {
                Storage::disk('public')->delete($dokumen->file_digital_path);
            }
            
            $file = $request->file('file_digital');
            $dokumen->file_digital_path = $file->store('dokumen/digital', 'public');
            $dokumen->ukuran_file = $file->getSize();
            $dokumen->format_digital = $dokumen->format_digital ?? $file->getClientOriginalExtension();
        } elseif ($request->has('hapus_file_digital') && $request->hapus_file_digital == '1') {
            // Hapus file digital
            if (!empty($dokumen->file_digital_path)) {
                Storage::disk('public')->delete($dokumen->file_digital_path);
                $dokumen->file_digital_path = null;
                $dokumen->ukuran_file = null;
            }
        }

        // Update thumbnail
        if ($request->hasFile('thumbnail')) {
            // Hapus thumbnail lama jika ada
            if (!empty($dokumen->thumbnail_path)) {
                Storage::disk('public')->delete($dokumen->thumbnail_path);
            }
            
            $dokumen->thumbnail_path = $request->file('thumbnail')
                ->store('dokumen/thumbnail', 'public');
        } elseif ($request->has('hapus_thumbnail') && $request->hapus_thumbnail == '1') {
            // Hapus thumbnail
            if (!empty($dokumen->thumbnail_path)) {
                Storage::disk('public')->delete($dokumen->thumbnail_path);
                $dokumen->thumbnail_path = null;
            }
        }

        // Update preview
        if ($request->hasFile('preview')) {
            // Hapus preview lama jika ada
            if (!empty($dokumen->preview_path)) {
                Storage::disk('public')->delete($dokumen->preview_path);
            }
            
            $dokumen->preview_path = $request->file('preview')
                ->store('dokumen/preview', 'public');
        } elseif ($request->has('hapus_preview') && $request->hapus_preview == '1') {
            // Hapus preview
            if (!empty($dokumen->preview_path)) {
                Storage::disk('public')->delete($dokumen->preview_path);
                $dokumen->preview_path = null;
            }
        }

        // Jika menggunakan Google Drive, update ukuran file jika tersedia
        if ($dokumen->google_drive_id && !$dokumen->ukuran_file) {
            // Di sini bisa ditambahkan logika untuk mendapatkan ukuran file dari Google Drive API
            $dokumen->ukuran_file = null;
        }

        $dokumen->update();

        return redirect()
            ->route('admin.publikasi-data.dokumen.index')
            ->with('success', 'Dokumen berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $dokumen = Dokumen::findOrFail($id);

            // Hapus file-file terkait
            if (!empty($dokumen->file_digital_path)) {
                Storage::disk('public')->delete($dokumen->file_digital_path);
            }
            
            if (!empty($dokumen->thumbnail_path)) {
                Storage::disk('public')->delete($dokumen->thumbnail_path);
            }
            
            if (!empty($dokumen->preview_path)) {
                Storage::disk('public')->delete($dokumen->preview_path);
            }

            // Hapus dokumen
            $dokumen->delete();

            return redirect()
                ->route('admin.publikasi-data.dokumen.index')
                ->with('success', 'Dokumen berhasil dihapus.');

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()
                ->route('admin.publikasi-data.dokumen.index')
                ->with('error', 'Dokumen tidak ditemukan.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.publikasi-data.dokumen.index')
                ->with('error', 'Terjadi kesalahan saat menghapus dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Download dokumen
     */
    public function download($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        // Jika menggunakan Google Drive, redirect ke Google Drive
        if ($dokumen->menggunakan_google_drive) {
            return redirect($dokumen->download_google_drive);
        }
        
        // Jika file lokal
        if (!$dokumen->file_digital_path) {
            abort(404, 'File tidak tersedia');
        }

        $path = Storage::disk('public')->path($dokumen->file_digital_path);
        $filename = $dokumen->judul . '.' . pathinfo($dokumen->file_digital_path, PATHINFO_EXTENSION);
        
        // Increment download count
        $dokumen->incrementDownloadCount();
        
        return Response::download($path, $filename);
    }

    /**
     * View dokumen (inline)
     */
    public function view($id)
    {
        $dokumen = Dokumen::findOrFail($id);
        
        // Jika menggunakan Google Drive, redirect ke Google Drive view
        if ($dokumen->menggunakan_google_drive) {
            return redirect($dokumen->link_google_drive);
        }
        
        // Jika file lokal (hanya untuk PDF/image)
        if (!$dokumen->file_digital_path) {
            abort(404, 'File tidak tersedia');
        }

        $path = Storage::disk('public')->path($dokumen->file_digital_path);
        $mimeType = mime_content_type($path);
        
        // Increment view count
        $dokumen->incrementViewCount();
        
        return Response::file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline'
        ]);
    }
}