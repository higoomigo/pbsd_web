<?php

namespace App\Http\Controllers;

use App\Models\Kebijakan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GuestKebijakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kebijakan::publik(); // Hanya yang status publik

        // Filter pencarian
        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%")
                  ->orWhere('nomor_dokumen', 'like', "%{$search}%")
                  ->orWhere('tags', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $kebijakan = $query->orderBy('tanggal_berlaku', 'desc')
                          ->paginate(10);

        // Data untuk filter
        $kategoriList = Kebijakan::publik()->distinct()->pluck('kategori')->filter();

        return view('guest.kebijakan.index', compact(
            'kebijakan', 
            'kategoriList'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Cari kebijakan berdasarkan ID
        $kebijakan = Kebijakan::publik()->findOrFail($id);
        
        // Jika ingin menggunakan slug, ganti dengan:
        // $kebijakan = Kebijakan::publik()->where('slug', $slug)->firstOrFail();

        // Increment view count jika diperlukan
        // $kebijakan->increment('views');

        // Get related kebijakan (opsional)
        $relatedKebijakan = $this->getRelatedKebijakan($kebijakan);

        return view('guest.kebijakan.show', compact('kebijakan', 'relatedKebijakan'));
    }

    /**
     * Get related kebijakan based on category and tags
     */
    private function getRelatedKebijakan(Kebijakan $kebijakan, $limit = 3)
    {
        return Kebijakan::publik()
            ->where('id', '!=', $kebijakan->id)
            ->where(function($query) use ($kebijakan) {
                // Match by category
                $query->where('kategori', $kebijakan->kategori);
                
                // Or match by tags if available
                if ($kebijakan->tags) {
                    $tags = explode(',', $kebijakan->tags);
                    foreach ($tags as $tag) {
                        $trimmedTag = trim($tag);
                        if (!empty($trimmedTag)) {
                            $query->orWhere('tags', 'like', "%{$trimmedTag}%");
                        }
                    }
                }
            })
            ->orderBy('tanggal_berlaku', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Download dokumen kebijakan
     */
    public function download($id)
    {
        $kebijakan = Kebijakan::publik()->findOrFail($id);

        if (!$kebijakan->dokumen_path) {
            abort(404, 'Dokumen tidak tersedia');
        }

        $path = storage_path('app/public/' . $kebijakan->dokumen_path);
        
        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        $filename = $this->generateDownloadFilename($kebijakan);

        return response()->download($path, $filename);
    }

    /**
     * Download lampiran kebijakan
     */
    public function downloadLampiran($id, $index)
    {
        $kebijakan = Kebijakan::publik()->findOrFail($id);

        if (!$kebijakan->lampiran_paths || !isset($kebijakan->lampiran_paths[$index])) {
            abort(404, 'Lampiran tidak tersedia');
        }

        $lampiranPath = $kebijakan->lampiran_paths[$index];
        $path = storage_path('app/public/' . $lampiranPath);
        
        if (!file_exists($path)) {
            abort(404, 'File lampiran tidak ditemukan');
        }

        $filename = $this->generateLampiranFilename($kebijakan, $index, $lampiranPath);

        return response()->download($path, $filename);
    }

    /**
     * Generate filename for main document download
     */
    private function generateDownloadFilename(Kebijakan $kebijakan)
    {
        $baseName = Str::slug($kebijakan->judul);
        $extension = pathinfo($kebijakan->dokumen_path, PATHINFO_EXTENSION);
        
        if ($kebijakan->nomor_dokumen) {
            return "{$kebijakan->nomor_dokumen}_{$baseName}.{$extension}";
        }
        
        return "{$baseName}.{$extension}";
    }

    /**
     * Generate filename for attachment download
     */
    private function generateLampiranFilename(Kebijakan $kebijakan, $index, $lampiranPath)
    {
        $baseName = Str::slug($kebijakan->judul);
        $extension = pathinfo($lampiranPath, PATHINFO_EXTENSION);
        
        if ($kebijakan->nomor_dokumen) {
            return "{$kebijakan->nomor_dokumen}_{$baseName}_lampiran_" . ($index + 1) . ".{$extension}";
        }
        
        return "{$baseName}_lampiran_" . ($index + 1) . ".{$extension}";
    }

    // /**
    //  * API endpoint for kebijakan data (optional)
    //  */
    // public function apiIndex(Request $request)
    // {
    //     $query = Kebijakan::publik();

    //     if ($request->filled('kategori')) {
    //         $query->where('kategori', $request->kategori);
    //     }

    //     if ($request->filled('status')) {
    //         $query->where('status', $request->status);
    //     }

    //     $kebijakan = $query->orderBy('tanggal_berlaku', 'desc')
    //                       ->paginate($request->get('per_page', 10));

    //     return response()->json([
    //         'data' => $kebijakan->items(),
    //         'meta' => [
    //             'current_page' => $kebijakan->currentPage(),
    //             'last_page' => $kebijakan->lastPage(),
    //             'per_page' => $kebijakan->perPage(),
    //             'total' => $kebijakan->total(),
    //         ]
    //     ]);
    // }

    // /**
    //  * API endpoint for single kebijakan (optional)
    //  */
    // public function apiShow($id)
    // {
    //     $kebijakan = Kebijakan::publik()->findOrFail($id);

    //     return response()->json([
    //         'data' => $kebijakan
    //     ]);
    // }
}