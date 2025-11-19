<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Mitra;

class MitraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mitra = Mitra::all();
        return view('admin.profil.mitra.index', compact('mitra'));
    }
    
    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('admin.profil.mitra.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'   => ['required','string','max:255'],
            'jenis'  => ['required','in:Pemerintah,Perguruan Tinggi,Lembaga Riset,Komunitas,Industri'],
            'deskripsi' => ['nullable','string'],
            'website' => ['nullable','url','max:255'],
            'email_kontak' => ['nullable','email','max:255'],
            'telepon' => ['nullable','string','max:50'],
            'instagram' => ['nullable','url','max:255'],
            'youtube'   => ['nullable','url','max:255'],
            'mulai'     => ['nullable','date'],
            'berakhir'  => ['nullable','date','after_or_equal:mulai'],
            'status'    => ['required','in:Aktif,Tidak Aktif'],
            'urutan'    => ['nullable','integer','min:0'],
            'tampil_beranda' => ['sometimes','boolean'],
            'logo' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:3072'],
            'dokumen_mou' => ['nullable','mimes:pdf','max:10240'],
        ]);
        //inisialiasi model
        $mitra = new Mitra();

        if ($request->hasFile('logo')) {
        if (!empty($mitra->logo_path)) Storage::delete($mitra->logo_path);
            $mitra->logo_path = $request->file('logo')->store('mitra/logo', 'public');
        }
        if ($request->hasFile('dokumen_mou')) {
        if (!empty($mitra->dokumen_mou_path)) Storage::delete($mitra->dokumen_mou_path);
            $mitra->dokumen_mou_path = $request->file('dokumen_mou')->store('mitra/mou', 'public');
        }

        $mitra->fill($request->only([
            'nama','jenis','deskripsi','website','email_kontak','telepon',
            'instagram','youtube','mulai','berakhir','status','urutan'
        ]));
        $mitra->tampil_beranda = $request->boolean('tampil_beranda');
        $mitra->save();
        return redirect()->route('admin.profil.mitra.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $mitra = Mitra::findOrFail($id);
        return view('admin.profil.mitra.edit', compact('mitra'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mitra $mitra)
    {
        $request->validate([
            'nama'   => ['required','string','max:255'],
            'jenis'  => ['required','in:Pemerintah,Perguruan Tinggi,Lembaga Riset,Komunitas,Industri'],
            'deskripsi' => ['nullable','string'],
            'website' => ['nullable','url','max:255'],
            'email_kontak' => ['nullable','email','max:255'],
            'telepon' => ['nullable','string','max:50'],
            'instagram' => ['nullable','url','max:255'],
            'youtube'   => ['nullable','url','max:255'],
            'mulai'     => ['nullable','date'],
            'berakhir'  => ['nullable','date','after_or_equal:mulai'],
            'status'    => ['required','in:Aktif,Tidak Aktif'],
            'urutan'    => ['nullable','integer','min:0'],
            'tampil_beranda' => ['sometimes','boolean'],
            'logo' => ['nullable','image','mimes:jpg,jpeg,png,webp,svg','max:3072'],
            'dokumen_mou' => ['nullable','mimes:pdf','max:10240'],
        ]);

        // isi field biasa
        $mitra->fill($request->only([
            'nama','jenis','deskripsi','website','email_kontak','telepon',
            'instagram','youtube','mulai','berakhir','status','urutan'
        ]));
        $mitra->tampil_beranda = $request->boolean('tampil_beranda');

        // ganti logo jika ada file baru
        if ($request->hasFile('logo')) {
            if (!empty($mitra->logo_path)) {
                Storage::disk('public')->delete($mitra->logo_path);
            }
            $mitra->logo_path = $request->file('logo')->store('mitra/logo', 'public');
        }

        // ganti dokumen MoU jika ada file baru
        if ($request->hasFile('dokumen_mou')) {
            if (!empty($mitra->dokumen_mou_path)) {
                Storage::disk('public')->delete($mitra->dokumen_mou_path);
            }
            $mitra->dokumen_mou_path = $request->file('dokumen_mou')->store('mitra/mou', 'public');
        }

        $mitra->save();

        return redirect()
            ->route('admin.profil.mitra.index')
            ->with('success', 'Mitra berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mitra $mitra)
    {
        // hapus file terkait terlebih dahulu
        if (!empty($mitra->logo_path)) {
            Storage::disk('public')->delete($mitra->logo_path);
        }
        if (!empty($mitra->dokumen_mou_path)) {
            Storage::disk('public')->delete($mitra->dokumen_mou_path);
        }

        $mitra->delete();

        return redirect()
            ->route('admin.profil.mitra.index')
            ->with('success', 'Mitra berhasil dihapus.');
    }
}
