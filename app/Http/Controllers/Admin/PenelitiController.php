<?php

namespace App\Http\Controllers\Admin;

use App\Models\Peneliti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class PenelitiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peneliti = Peneliti::orderBy('urutan')
            ->orderBy('nama')
            ->get();

        return view('admin.profil.peneliti.index', compact('peneliti'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = ['Aktif', 'Pensiun', 'Alumni', 'Mitra'];
        $types = ['Internal', 'Eksternal', 'Kolaborator'];
        $positions = ['Peneliti', 'Peneliti Utama', 'Asisten Peneliti', 'Research Fellow', 'Kepala Lab'];
        
        return view('admin.profil.peneliti.create', compact('statuses', 'types', 'positions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request['tampil_beranda']);
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'bidang_keahlian' => 'nullable|array',
            'bidang_keahlian.*' => 'string|max:100',
            'posisi' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'riwayat_pendidikan' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'google_scholar' => 'nullable|url|max:255',
            'researchgate' => 'nullable|url|max:255',
            'deskripsi_singkat' => 'nullable|string|max:500',
            'biografi' => 'nullable|string',
            'publikasi_terpilih' => 'nullable|array',
            'publikasi_terpilih.*' => 'string|max:255',
            'penelitian_unggulan' => 'nullable|array',
            'penelitian_unggulan.*' => 'string|max:255',
            'pencapaian' => 'nullable|string',
            'status' => 'required|in:Aktif,Pensiun,Alumni,Mitra',
            'tipe' => 'required|in:Internal,Eksternal,Kolaborator',
            'urutan' => 'nullable|integer|min:0',
            'tampil_beranda' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('peneliti/fotos', 'public');
            $validated['foto_path'] = $path;
        }

        // Prepare social links
        $socialLinks = [];
        if ($request->filled('linkedin')) $socialLinks['linkedin'] = $request->linkedin;
        if ($request->filled('google_scholar')) $socialLinks['google_scholar'] = $request->google_scholar;
        if ($request->filled('researchgate')) $socialLinks['researchgate'] = $request->researchgate;
        $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;

        // Handle JSON fields
        $validated['bidang_keahlian'] = $request->filled('bidang_keahlian') ? $request->bidang_keahlian : null;
        $validated['publikasi_terpilih'] = $request->filled('publikasi_terpilih') ? $request->publikasi_terpilih : null;
        $validated['penelitian_unggulan'] = $request->filled('penelitian_unggulan') ? $request->penelitian_unggulan : null;

        // Set published_at if published
        if ($request->boolean('is_published')) {
            $validated['published_at'] = now();
        }

        // dd($validated['is_published'], $validated['tampil_beranda']);
        // Set default values for checkboxes
        $validated['tampil_beranda'] = $request->boolean('tampil_beranda');
        $validated['is_published'] = $request->boolean('is_published');

        Peneliti::create($validated);

        return redirect()->route('admin.profil.peneliti.index')
            ->with('success', 'Data peneliti berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peneliti $peneliti)
    {
        return view('admin.profil.peneliti.show', compact('peneliti'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peneliti $peneliti)
    {
        $statuses = ['Aktif', 'Pensiun', 'Alumni', 'Mitra'];
        $types = ['Internal', 'Eksternal', 'Kolaborator'];
        $positions = ['Peneliti', 'Peneliti Utama', 'Asisten Peneliti', 'Research Fellow', 'Kepala Lab'];
        
        return view('admin.profil.peneliti.edit', compact('peneliti', 'statuses', 'types', 'positions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peneliti $peneliti)
    {
        
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'bidang_keahlian' => 'nullable|array',
            'bidang_keahlian.*' => 'string|max:100',
            'posisi' => 'required|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'riwayat_pendidikan' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'linkedin' => 'nullable|url|max:255',
            'google_scholar' => 'nullable|url|max:255',
            'researchgate' => 'nullable|url|max:255',
            'deskripsi_singkat' => 'nullable|string|max:500',
            'biografi' => 'nullable|string',
            'publikasi_terpilih' => 'nullable|array',
            'publikasi_terpilih.*' => 'string|max:255',
            'penelitian_unggulan' => 'nullable|array',
            'penelitian_unggulan.*' => 'string|max:255',
            'pencapaian' => 'nullable|string',
            'status' => 'required|in:Aktif,Pensiun,Alumni,Mitra',
            'tipe' => 'required|in:Internal,Eksternal,Kolaborator',
            'urutan' => 'nullable|integer|min:0',
            'tampil_beranda' => 'boolean',
            'is_published' => 'boolean',
        ]);

        // Handle photo upload
        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($peneliti->foto_path) {
                Storage::disk('public')->delete($peneliti->foto_path);
            }
            
            $path = $request->file('foto')->store('peneliti/fotos', 'public');
            $validated['foto_path'] = $path;
        }

        // Prepare social links
        $socialLinks = [];
        if ($request->filled('linkedin')) $socialLinks['linkedin'] = $request->linkedin;
        if ($request->filled('google_scholar')) $socialLinks['google_scholar'] = $request->google_scholar;
        if ($request->filled('researchgate')) $socialLinks['researchgate'] = $request->researchgate;
        $validated['social_links'] = !empty($socialLinks) ? $socialLinks : null;

        // Handle JSON fields
        $validated['bidang_keahlian'] = $request->filled('bidang_keahlian') ? $request->bidang_keahlian : null;
        $validated['publikasi_terpilih'] = $request->filled('publikasi_terpilih') ? $request->publikasi_terpilih : null;
        $validated['penelitian_unggulan'] = $request->filled('penelitian_unggulan') ? $request->penelitian_unggulan : null;

        // Set published_at if published and wasn't published before
        if ($request->boolean('is_published') && !$peneliti->is_published) {
            $validated['published_at'] = now();
        }
        
        // Set default values for checkboxes
        $validated['tampil_beranda'] = $request->boolean('tampil_beranda');
        $validated['is_published'] = $request->boolean('is_published');

        $peneliti->update($validated);

        return redirect()->route('admin.profil.peneliti.index')
            ->with('success', 'Data peneliti berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peneliti $peneliti)
    {
        // Delete photo if exists
        if ($peneliti->foto_path) {
            Storage::disk('public')->delete($peneliti->foto_path);
        }

        $peneliti->delete();

        return redirect()->route('admin.profil.peneliti.index')
            ->with('success', 'Data peneliti berhasil dihapus.');
    }

    /**
     * Update urutan (for drag & drop sorting)
     */
    public function updateUrutan(Request $request)
    {
        $request->validate([
            'urutan' => 'required|array',
            'urutan.*' => 'integer|exists:peneliti,id',
        ]);

        foreach ($request->urutan as $index => $id) {
            Peneliti::where('id', $id)->update(['urutan' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Toggle tampil beranda
     */
    public function toggleBeranda(Peneliti $peneliti)
    {
        $peneliti->update([
            'tampil_beranda' => !$peneliti->tampil_beranda
        ]);

        return back()->with('success', 'Status tampil beranda berhasil diubah.');
    }

    /**
     * Toggle publish status
     */
    public function togglePublish(Peneliti $peneliti)
    {
        $peneliti->update([
            'is_published' => !$peneliti->is_published,
            'published_at' => $peneliti->is_published ? null : now()
        ]);

        return back()->with('success', 'Status publish berhasil diubah.');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,show_homepage,hide_homepage,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:peneliti,id',
        ]);

        $peneliti = Peneliti::whereIn('id', $request->ids);

        switch ($request->action) {
            case 'publish':
                $peneliti->update([
                    'is_published' => true,
                    'published_at' => now()
                ]);
                $message = 'Peneliti berhasil dipublish.';
                break;

            case 'unpublish':
                $peneliti->update([
                    'is_published' => false,
                    'published_at' => null
                ]);
                $message = 'Peneliti berhasil diunpublish.';
                break;

            case 'show_homepage':
                $peneliti->update(['tampil_beranda' => true]);
                $message = 'Peneliti berhasil ditampilkan di beranda.';
                break;

            case 'hide_homepage':
                $peneliti->update(['tampil_beranda' => false]);
                $message = 'Peneliti berhasil disembunyikan dari beranda.';
                break;

            case 'delete':
                // Delete photos first
                $penelitiWithPhotos = Peneliti::whereIn('id', $request->ids)
                    ->whereNotNull('foto_path')
                    ->get();
                
                foreach ($penelitiWithPhotos as $p) {
                    Storage::disk('public')->delete($p->foto_path);
                }

                $peneliti->delete();
                $message = 'Peneliti berhasil dihapus.';
                break;
        }

        return redirect()->route('admin.profil.peneliti.index')
            ->with('success', $message);
    }
}