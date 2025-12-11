<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PublikasiTerindeks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PublikasiTerindeksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = PublikasiTerindeks::query();

        // Filter berdasarkan indeksasi
        if ($request->has('indeksasi') && $request->indeksasi != '') {
            $query->where('indeksasi', $request->indeksasi);
        }

        // Filter berdasarkan tahun
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun_terbit', $request->tahun);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('is_active', $request->status == 'active');
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('abstrak', 'like', "%{$search}%")
                  ->orWhere('penulis', 'like', "%{$search}%")
                  ->orWhere('nama_jurnal', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $publikasis = $query->paginate(15);
        $indeksasiOptions = PublikasiTerindeks::getIndeksasiOptions();
        
        // Get distinct years for filter
        $years = PublikasiTerindeks::select('tahun_terbit')
            ->distinct()
            ->orderBy('tahun_terbit', 'desc')
            ->pluck('tahun_terbit');

        return view('admin.penelitian.publikasi-terindeks.index', compact(
            'publikasis', 
            'indeksasiOptions', 
            'years'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $indeksasiOptions = PublikasiTerindeks::getIndeksasiOptions();
        
        return view('admin.penelitian.publikasi-terindeks.create', compact('indeksasiOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:500',
            'abstrak' => 'nullable|string',
            'penulis' => 'required|string|max:255',
            'nama_jurnal' => 'required|string|max:255',
            'issn' => 'nullable|string|max:50',
            'volume' => 'nullable|string|max:20',
            'issue' => 'nullable|string|max:20',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'halaman' => 'nullable|string|max:20',
            'indeksasi' => 'required|in:SCOPUS,WOS,SINTA,DOAJ,GARUDA,CROSSREF,LIPI,Lainya',
            'quartile' => 'nullable|integer|min:1|max:4',
            'impact_factor' => 'nullable|string|max:20',
            'doi' => 'nullable|string|max:100',
            'url_jurnal' => 'nullable|url|max:255',
            'file_pdf' => 'nullable|mimes:pdf|max:5120', // 5MB max
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bidang_ilmu' => 'nullable|string|max:100',
            'kategori_publikasi' => 'nullable|string|max:100',
            'jumlah_dikutip' => 'nullable|integer|min:0',
            'tanggal_publish' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        // Handle file uploads
        if ($request->hasFile('file_pdf')) {
            $pdfPath = $request->file('file_pdf')->store('publikasi/pdf', 'public');
            $validated['file_pdf'] = $pdfPath;
        }

        if ($request->hasFile('cover_image')) {
            $imagePath = $request->file('cover_image')->store('publikasi/images', 'public');
            $validated['cover_image'] = $imagePath;
        }

        // Set default values
        $validated['is_active'] = $request->has('is_active') ? true : false;
        $validated['jumlah_dikutip'] = $validated['jumlah_dikutip'] ?? 0;

        PublikasiTerindeks::create($validated);

        return redirect()->route('admin.penelitian.publikasi-terindeks.index')
            ->with('success', 'Publikasi terindeks berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PublikasiTerindeks $publikasiTerindeks)
    {
        return view('admin.penelitian.publikasi-terindeks.show', compact('publikasiTerindeks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PublikasiTerindeks $publikasiTerindeks)
    {
        $indeksasiOptions = PublikasiTerindeks::getIndeksasiOptions();
        
        return view('admin.penelitian.publikasi-terindeks.edit', compact('publikasiTerindeks', 'indeksasiOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PublikasiTerindeks $publikasiTerindeks)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:500',
            'abstrak' => 'nullable|string',
            'penulis' => 'required|string|max:255',
            'nama_jurnal' => 'required|string|max:255',
            'issn' => 'nullable|string|max:50',
            'volume' => 'nullable|string|max:20',
            'issue' => 'nullable|string|max:20',
            'tahun_terbit' => 'required|integer|min:1900|max:' . date('Y'),
            'halaman' => 'nullable|string|max:20',
            'indeksasi' => 'required|in:SCOPUS,WOS,SINTA,DOAJ,GARUDA,CROSSREF,LIPI,Lainya',
            'quartile' => 'nullable|integer|min:1|max:4',
            'impact_factor' => 'nullable|string|max:20',
            'doi' => 'nullable|string|max:100',
            'url_jurnal' => 'nullable|url|max:255',
            'file_pdf' => 'nullable|mimes:pdf|max:5120',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bidang_ilmu' => 'nullable|string|max:100',
            'kategori_publikasi' => 'nullable|string|max:100',
            'jumlah_dikutip' => 'nullable|integer|min:0',
            'tanggal_publish' => 'nullable|date',
            'is_active' => 'boolean'
        ]);

        // Handle PDF file update
        if ($request->hasFile('file_pdf')) {
            // Delete old PDF if exists
            if ($publikasiTerindeks->file_pdf) {
                Storage::disk('public')->delete($publikasiTerindeks->file_pdf);
            }
            
            $pdfPath = $request->file('file_pdf')->store('publikasi/pdf', 'public');
            $validated['file_pdf'] = $pdfPath;
        } else {
            // Keep old file if not updated
            unset($validated['file_pdf']);
        }

        // Handle cover image update
        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($publikasiTerindeks->cover_image) {
                Storage::disk('public')->delete($publikasiTerindeks->cover_image);
            }
            
            $imagePath = $request->file('cover_image')->store('publikasi/images', 'public');
            $validated['cover_image'] = $imagePath;
        } else {
            // Keep old image if not updated
            unset($validated['cover_image']);
        }

        // Handle checkbox
        $validated['is_active'] = $request->has('is_active') ? true : false;

        $publikasiTerindeks->update($validated);

        return redirect()->route('admin.penelitian.publikasi-terindeks.index')
            ->with('success', 'Publikasi terindeks berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PublikasiTerindeks $publikasiTerindeks)
    {
        // Delete files if exist
        if ($publikasiTerindeks->file_pdf) {
            Storage::disk('public')->delete($publikasiTerindeks->file_pdf);
        }
        
        if ($publikasiTerindeks->cover_image) {
            Storage::disk('public')->delete($publikasiTerindeks->cover_image);
        }

        $publikasiTerindeks->delete();

        return redirect()->route('admin.penelitian.publikasi-terindeks.index')
            ->with('success', 'Publikasi terindeks berhasil dihapus.');
    }

    /**
     * Toggle status aktif/non-aktif
     */
    public function toggleStatus(PublikasiTerindeks $publikasiTerindeks)
    {
        $publikasiTerindeks->update(['is_active' => !$publikasiTerindeks->is_active]);

        $status = $publikasiTerindeks->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return back()->with('success', "Publikasi berhasil $status.");
    }

    /**
     * Download PDF file
     */
    public function downloadPdf(PublikasiTerindeks $publikasiTerindeks)
    {
        if (!$publikasiTerindeks->file_pdf) {
            return back()->with('error', 'File PDF tidak tersedia.');
        }

        $path = storage_path('app/public/' . $publikasiTerindeks->file_pdf);
        
        if (!file_exists($path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        return response()->download($path, $publikasiTerindeks->judul . '.pdf');
    }
}