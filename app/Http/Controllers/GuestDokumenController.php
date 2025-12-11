<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\KoleksiDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class GuestDokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(Request $request)
    // {
    //     // Query utama hanya dokumen yang published
    //     $query = Dokumen::with(['koleksi' => function($q) {
    //             $q->where('is_published', true);
    //         }])
    //         ->where('is_published', true)
    //         ->whereHas('koleksi', function($q) {
    //             $q->where('is_published', true);
    //         });

    //     // Filter by koleksi
    //     if ($request->has('koleksi') && $request->koleksi) {
    //         $query->where('koleksi_dokumen_id', $request->koleksi);
    //         $currentKoleksi = KoleksiDokumen::where('is_published', true)
    //             ->findOrFail($request->koleksi);
    //     } else {
    //         $currentKoleksi = null;
    //     }

    //     // Filter by kategori
    //     if ($request->has('kategori') && $request->kategori) {
    //         $query->where('kategori', $request->kategori);
    //     }

    //     // Search
    //     if ($request->has('search') && $request->search) {
    //         $search = $request->search;
    //         $query->where(function($q) use ($search) {
    //             $q->where('judul', 'LIKE', "%{$search}%")
    //               ->orWhere('kode', 'LIKE', "%{$search}%")
    //               ->orWhere('penulis', 'LIKE', "%{$search}%")
    //               ->orWhere('ringkasan', 'LIKE', "%{$search}%")
    //               ->orWhere('deskripsi_singkat', 'LIKE', "%{$search}%");
    //         });
    //     }

    //     // Get koleksi yang published untuk filter
    //     $koleksiList = KoleksiDokumen::where('is_published', true)
    //         ->orderBy('urutan', 'asc')
    //         ->orderBy('judul', 'asc')
    //         ->get();

    //     // Get unique categories for filter
    //     $kategoriList = Dokumen::where('is_published', true)
    //         ->select('kategori')
    //         ->whereNotNull('kategori')
    //         ->distinct()
    //         ->pluck('kategori');

    //     // Get dokumen utama untuk slider/featured
    //     $dokumenUtama = Dokumen::where('is_published', true)
    //         ->where('is_utama', true)
    //         ->with('koleksi')
    //         ->orderBy('urutan', 'asc')
    //         ->limit(5)
    //         ->get();

    //     // Get koleksi yang tampil di beranda
    //     $koleksiBeranda = KoleksiDokumen::where('is_published', true)
    //         ->where('tampil_beranda', true)
    //         ->orderBy('urutan', 'asc')
    //         ->limit(6)
    //         ->get();

    //     // Sorting
    //     $sort = $request->get('sort', 'terbaru');
    //     switch ($sort) {
    //         case 'terlama':
    //             $query->orderBy('tahun_terbit', 'asc')
    //                   ->orderBy('created_at', 'asc');
    //             break;
    //         case 'a-z':
    //             $query->orderBy('judul', 'asc');
    //             break;
    //         case 'z-a':
    //             $query->orderBy('judul', 'desc');
    //             break;
    //         case 'terpopuler':
    //             $query->orderBy('view_count', 'desc')
    //                   ->orderBy('download_count', 'desc');
    //             break;
    //         default: // terbaru
    //             $query->orderBy('published_at', 'desc')
    //                   ->orderBy('created_at', 'desc');
    //             break;
    //     }

    //     // Pagination
    //     $dokumens = $query->paginate(12);

    //     // Statistik
    //     $totalDokumen = Dokumen::where('is_published', true)->count();
    //     $totalKoleksi = KoleksiDokumen::where('is_published', true)->count();

    //     return view('guest.dokumen.index', compact(
    //         'dokumens',
    //         'koleksiList',
    //         'kategoriList',
    //         'currentKoleksi',
    //         'dokumenUtama',
    //         'koleksiBeranda',
    //         'totalDokumen',
    //         'totalKoleksi',
    //         'sort'
    //     ));
    // }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $dokumen = Dokumen::with(['koleksi' => function($q) {
                $q->where('is_published', true);
            }])
            ->where('is_published', true)
            ->whereHas('koleksi', function($q) {
                $q->where('is_published', true);
            })
            ->findOrFail($id);

        // Increment view count
        $dokumen->increment('view_count');

        // Dokumen terkait (dalam koleksi yang sama)
        $dokumenTerkait = Dokumen::where('is_published', true)
            ->where('koleksi_dokumen_id', $dokumen->koleksi_dokumen_id)
            ->where('id', '!=', $dokumen->id)
            ->orderBy('published_at', 'desc')
            ->limit(4)
            ->get();

        // Dokumen populer
        $dokumenPopuler = Dokumen::where('is_published', true)
            ->where('id', '!=', $dokumen->id)
            ->orderBy('view_count', 'desc')
            ->limit(5)
            ->get();

        return view('guest.dokumen.show', compact(
            'dokumen',
            'dokumenTerkait',
            'dokumenPopuler'
        ));
    }

    /**
     * Download dokumen
     */
    public function download($id)
    {
        $dokumen = Dokumen::with('koleksi')
            ->where('is_published', true)
            ->findOrFail($id);

        // Increment download count
        $dokumen->increment('download_count');

        // Jika menggunakan Google Drive, redirect ke Google Drive
        if ($dokumen->google_drive_id && $dokumen->google_drive_link) {
            return redirect($dokumen->google_drive_link);
        }
        
        // Jika file lokal
        if (!$dokumen->file_digital_path) {
            abort(404, 'File tidak tersedia');
        }

        $path = Storage::disk('public')->path($dokumen->file_digital_path);
        $filename = Str::slug($dokumen->judul) . '.' . pathinfo($dokumen->file_digital_path, PATHINFO_EXTENSION);
        
        return Response::download($path, $filename);
    }

    /**
     * View dokumen (inline)
     */
    public function view($id)
    {
        $dokumen = Dokumen::where('is_published', true)
            ->findOrFail($id);
        
        // Jika menggunakan Google Drive, redirect ke Google Drive view
        if ($dokumen->google_drive_id && $dokumen->google_drive_link) {
            return redirect($dokumen->google_drive_link);
        }
        
        // Jika file lokal (hanya untuk PDF/image)
        if (!$dokumen->file_digital_path) {
            abort(404, 'File tidak tersedia');
        }

        $path = Storage::disk('public')->path($dokumen->file_digital_path);
        $mimeType = mime_content_type($path);
        
        // Increment view count
        $dokumen->increment('view_count');
        
        return Response::file($path, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline'
        ]);
    }

    /**
     * Display koleksi dokumen (hanya koleksi)
     */
    public function koleksi(Request $request)
    {
        // Query koleksi yang published
        $query = KoleksiDokumen::where('is_published', true)
            ->withCount(['dokumen' => function($q) {
                $q->where('is_published', true);
            }]);

        // Sorting
        $sort = $request->get('sort', 'terbaru');
        switch ($sort) {
            case 'a-z':
                $query->orderBy('judul', 'asc');
                break;
            case 'z-a':
                $query->orderBy('judul', 'desc');
                break;
            case 'terlama':
                $query->orderBy('created_at', 'asc');
                break;
            case 'populer':
                $query->orderBy('view_count', 'desc');
                break;
            default: // terbaru
                $query->orderBy('created_at', 'desc');
                break;
        }

        // Pagination
        $koleksis = $query->paginate(9);

        // Statistik
        $totalKoleksi = KoleksiDokumen::where('is_published', true)->count();
        $totalDokumen = Dokumen::where('is_published', true)->count();

        return view('guest.dokumen.koleksi', compact(
            'koleksis',
            'totalKoleksi',
            'totalDokumen',
            'sort'
        ));
    }

    /**
     * Show koleksi detail
     */
    public function showKoleksi($id)
    {
        $koleksi = KoleksiDokumen::where('is_published', true)
            ->withCount(['dokumen' => function($q) {
                $q->where('is_published', true);
            }])
            ->findOrFail($id);

        // Increment view count
        // $koleksi->increment('view_count');

        // Get dokumen dalam koleksi
        $dokumens = Dokumen::where('is_published', true)
            ->where('koleksi_dokumen_id', $koleksi->id)
            ->orderBy('urutan', 'asc')
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('guest.dokumen.koleksi-show', compact(
            'koleksi',
            'dokumens'
        ));
    }
}