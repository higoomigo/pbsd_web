<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seminar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Seminar::query();

        // Filter berdasarkan tipe
        if ($request->has('tipe') && $request->tipe != '') {
            $query->where('tipe', $request->tipe);
        }

        // Filter berdasarkan format
        if ($request->has('format') && $request->format != '') {
            $query->where('format', $request->format);
        }

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'published') {
                $query->where('is_published', true);
            } elseif ($request->status == 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status == 'cancelled') {
                $query->where('is_cancelled', true);
            } elseif ($request->status == 'featured') {
                $query->where('is_featured', true);
            }
        }

        // Filter berdasarkan tanggal
        if ($request->has('rentang_tanggal') && $request->rentang_tanggal != '') {
            $dates = explode(' - ', $request->rentang_tanggal);
            if (count($dates) == 2) {
                $query->whereBetween('tanggal', [\Carbon\Carbon::parse($dates[0])->format('Y-m-d'), \Carbon\Carbon::parse($dates[1])->format('Y-m-d')]);
            }
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('pembicara', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('tempat', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'tanggal');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $seminars = $query->paginate(15);
        $tipeOptions = Seminar::getTipeOptions();
        $formatOptions = Seminar::getFormatOptions();

        return view('admin.penelitian.seminar.index', compact(
            'seminars',
            'tipeOptions',
            'formatOptions'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipeOptions = Seminar::getTipeOptions();
        $formatOptions = Seminar::getFormatOptions();
        
        return view('admin.penelitian.seminar.create', compact(
            'tipeOptions',
            'formatOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:seminars',
            'deskripsi' => 'required|string',
            'ringkasan' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'tempat' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'link_virtual' => 'nullable|url',
            'pembicara' => 'required|string|max:255',
            'institusi_pembicara' => 'nullable|string|max:255',
            'bio_pembicara' => 'nullable|string',
            'foto_pembicara' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipe' => 'required|in:nasional,internasional,workshop,webinar,lainnya',
            'format' => 'required|in:offline,online,hybrid',
            'topik' => 'nullable|string|max:100',
            'bidang_ilmu' => 'nullable|string|max:100',
            'gratis' => 'boolean',
            'biaya' => 'nullable|numeric|min:0',
            'link_pendaftaran' => 'nullable|url',
            'batas_pendaftaran' => 'nullable|date|after_or_equal:today',
            'kuota_peserta' => 'nullable|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen_materi' => 'nullable|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'video_rekaman' => 'nullable|url',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'is_cancelled' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Handle file uploads
        if ($request->hasFile('foto_pembicara')) {
            $path = $request->file('foto_pembicara')->store('seminar/pembicara', 'public');
            $validated['foto_pembicara'] = $path;
        }

        if ($request->hasFile('poster')) {
            $path = $request->file('poster')->store('seminar/poster', 'public');
            $validated['poster'] = $path;
        }

        if ($request->hasFile('dokumen_materi')) {
            $path = $request->file('dokumen_materi')->store('seminar/materi', 'public');
            $validated['dokumen_materi'] = $path;
        }

        // Set published_at if published
        if ($request->has('is_published') && $request->is_published) {
            $validated['published_at'] = now();
        }

        // Set default values
        $validated['user_id'] = auth()->id();
        $validated['peserta_terdaftar'] = 0;

        Seminar::create($validated);

        return redirect()->route('admin.penelitian.seminar.index')
            ->with('success', 'Seminar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $seminar = Seminar::findOrFail($id);
        
        return view('admin.penelitian.seminar.show', compact('seminar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $seminar = Seminar::findOrFail($id);
        $tipeOptions = Seminar::getTipeOptions();
        $formatOptions = Seminar::getFormatOptions();
        
        return view('admin.penelitian.seminar.edit', compact(
            'seminar',
            'tipeOptions',
            'formatOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $seminar = Seminar::findOrFail($id);
        
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:seminars,slug,' . $seminar->id,
            'deskripsi' => 'required|string',
            'ringkasan' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
            'tempat' => 'required|string|max:255',
            'alamat_lengkap' => 'nullable|string',
            'link_virtual' => 'nullable|url',
            'pembicara' => 'required|string|max:255',
            'institusi_pembicara' => 'nullable|string|max:255',
            'bio_pembicara' => 'nullable|string',
            'foto_pembicara' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tipe' => 'required|in:nasional,internasional,workshop,webinar,lainnya',
            'format' => 'required|in:offline,online,hybrid',
            'topik' => 'nullable|string|max:100',
            'bidang_ilmu' => 'nullable|string|max:100',
            'gratis' => 'boolean',
            'biaya' => 'nullable|numeric|min:0',
            'link_pendaftaran' => 'nullable|url',
            'batas_pendaftaran' => 'nullable|date|after_or_equal:today',
            'kuota_peserta' => 'nullable|integer|min:1',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'dokumen_materi' => 'nullable|mimes:pdf,doc,docx,ppt,pptx|max:5120',
            'video_rekaman' => 'nullable|url',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'is_cancelled' => 'boolean',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        // Handle file uploads
        if ($request->hasFile('foto_pembicara')) {
            // Delete old file if exists
            if ($seminar->foto_pembicara) {
                Storage::disk('public')->delete($seminar->foto_pembicara);
            }
            
            $path = $request->file('foto_pembicara')->store('seminar/pembicara', 'public');
            $validated['foto_pembicara'] = $path;
        } else {
            unset($validated['foto_pembicara']);
        }

        if ($request->hasFile('poster')) {
            // Delete old file if exists
            if ($seminar->poster) {
                Storage::disk('public')->delete($seminar->poster);
            }
            
            $path = $request->file('poster')->store('seminar/poster', 'public');
            $validated['poster'] = $path;
        } else {
            unset($validated['poster']);
        }

        if ($request->hasFile('dokumen_materi')) {
            // Delete old file if exists
            if ($seminar->dokumen_materi) {
                Storage::disk('public')->delete($seminar->dokumen_materi);
            }
            
            $path = $request->file('dokumen_materi')->store('seminar/materi', 'public');
            $validated['dokumen_materi'] = $path;
        } else {
            unset($validated['dokumen_materi']);
        }

        // Update published_at if published status changed
        if ($request->has('is_published') && $request->is_published && !$seminar->is_published) {
            $validated['published_at'] = now();
        } elseif ($request->has('is_published') && !$request->is_published && $seminar->is_published) {
            $validated['published_at'] = null;
        }

        $seminar->update($validated);

        return redirect()->route('admin.penelitian.seminar.index')
            ->with('success', 'Seminar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $seminar = Seminar::findOrFail($id);
        
        // Delete files if exist
        if ($seminar->foto_pembicara) {
            Storage::disk('public')->delete($seminar->foto_pembicara);
        }
        
        if ($seminar->poster) {
            Storage::disk('public')->delete($seminar->poster);
        }
        
        if ($seminar->dokumen_materi) {
            Storage::disk('public')->delete($seminar->dokumen_materi);
        }

        $seminar->delete();

        return redirect()->route('admin.penelitian.seminar.index')
            ->with('success', 'Seminar berhasil dihapus.');
    }

    /**
     * Toggle published status
     */
    public function togglePublished($id)
    {
        $seminar = Seminar::findOrFail($id);
        
        $seminar->update([
            'is_published' => !$seminar->is_published,
            'published_at' => !$seminar->is_published ? now() : null
        ]);

        $status = $seminar->is_published ? 'dipublikasikan' : 'disembunyikan';
        return back()->with('success', "Seminar berhasil $status.");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->update(['is_featured' => !$seminar->is_featured]);

        $status = $seminar->is_featured ? 'ditandai sebagai unggulan' : 'dihapus dari unggulan';
        return back()->with('success', "Seminar berhasil $status.");
    }

    /**
     * Toggle cancelled status
     */
    public function toggleCancelled($id)
    {
        $seminar = Seminar::findOrFail($id);
        $seminar->update(['is_cancelled' => !$seminar->is_cancelled]);

        $status = $seminar->is_cancelled ? 'dibatalkan' : 'diaktifkan kembali';
        return back()->with('success', "Seminar berhasil $status.");
    }
}