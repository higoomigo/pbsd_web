<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PublikasiTerindeks;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublikasiTerindeksController extends Controller
{
    /**
     * Display a listing of publikasi terindeks.
     */
    public function index(Request $request)
    {
        // Query hanya publikasi yang aktif
        $query = PublikasiTerindeks::active();

        // Filter berdasarkan indeksasi
        if ($request->has('indeksasi') && $request->indeksasi != '') {
            $query->where('indeksasi', $request->indeksasi);
        }

        // Filter berdasarkan tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun_terbit', $request->tahun);
        }

        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('abstrak', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('nama_jurnal', 'like', "%{$search}%")
                  ->orWhere('issn', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'tahun_terbit');
        $sortOrder = $request->get('sort_order', 'desc');
        
        // Validasi field sorting
        $allowedSortFields = ['judul', 'penulis', 'nama_jurnal', 'tahun_terbit', 'created_at'];
        $sortBy = in_array($sortBy, $allowedSortFields) ? $sortBy : 'tahun_terbit';
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? $sortOrder : 'desc';
        
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $publikasis = $query->paginate(12);
        
        // Opsi untuk filter dropdown
        $indeksasiOptions = PublikasiTerindeks::getIndeksasiOptions();
        
        // Daftar tahun yang tersedia untuk filter
        $years = PublikasiTerindeks::active()
            ->select('tahun_terbit')
            ->distinct()
            ->orderBy('tahun_terbit', 'desc')
            ->pluck('tahun_terbit');

        // Statistik untuk footer
        $statistics = [
            'total' => PublikasiTerindeks::active()->count(),
            'scopus' => PublikasiTerindeks::active()->where('indeksasi', 'SCOPUS')->count(),
            'wos' => PublikasiTerindeks::active()->where('indeksasi', 'WOS')->count(),
            'sinta' => PublikasiTerindeks::active()->where('indeksasi', 'SINTA')->count(),
        ];

        return view('guest.publikasi-terindeks.index', compact(
            'publikasis', 
            'indeksasiOptions', 
            'years',
            'statistics'
        ));
    }

    /**
     * Display the specified publikasi.
     */
    public function show($id)
    {
        $publikasi = PublikasiTerindeks::active()->findOrFail($id);
        
        // Get related publikasi (same indeksasi, exclude current)
        $relatedPublikasi = PublikasiTerindeks::active()
            ->where('id', '!=', $id)
            ->where('indeksasi', $publikasi->indeksasi)
            ->limit(4)
            ->get();

        // Get publikasi terbaru (untuk sidebar/rekomendasi)
        $latestPublikasi = PublikasiTerindeks::active()
            ->where('id', '!=', $id)
            ->orderBy('tahun_terbit', 'desc')
            ->limit(5)
            ->get();

        // Count publikasi dengan indeksasi yang sama
        $indeksasiCount = PublikasiTerindeks::active()
            ->where('indeksasi', $publikasi->indeksasi)
            ->count();

        return view('guest.publikasi-terindeks.show', compact(
            'publikasi', 
            'relatedPublikasi', 
            'latestPublikasi',
            'indeksasiCount'
        ));
    }

    /**
     * Download PDF file
     */
    public function downloadPdf($id)
    {
        $publikasi = PublikasiTerindeks::active()->findOrFail($id);

        if (!$publikasi->file_pdf) {
            return back()->with('error', 'File PDF tidak tersedia untuk publikasi ini.');
        }

        $path = storage_path('app/public/' . $publikasi->file_pdf);
        
        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan di server.');
        }

        // Log download activity (optional)
        // Anda bisa menambahkan tracking download di sini

        return response()->download($path, 'Publikasi-' . Str::slug($publikasi->judul) . '.pdf');
    }
}