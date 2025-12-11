<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kebijakan;
use Illuminate\Support\Facades\Storage;


class KebijakanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kebijakan = Kebijakan::all();
        return view('admin.profil.kebijakan.index', compact('kebijakan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.profil.kebijakan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'judul'                => ['required', 'string', 'max:255'],
            'kategori'             => ['required', 'string', 'max:100'],
            'nomor_dokumen'        => ['nullable', 'string', 'max:255'],
            'versi'                => ['nullable', 'string', 'max:50'],
            'ringkasan'            => ['nullable', 'string'],
            'isi'                  => ['nullable', 'string'],
            'otoritas_pengesah'    => ['nullable', 'string', 'max:255'],
            'penanggung_jawab'     => ['nullable', 'string', 'max:255'],
            'unit_terkait'         => ['nullable', 'string', 'max:255'],
            'tanggal_berlaku'      => ['nullable', 'date'],
            'tanggal_tinjau_berikutnya' => ['nullable', 'date', 'after_or_equal:tanggal_berlaku'],
            'siklus_tinjau'        => ['nullable', 'in:Tahunan,Semester,Triwulan,Ad hoc'],
            'status'               => ['required', 'in:Draft,Publik'],
            'tags'                 => ['nullable', 'string', 'max:255'],

            'dokumen'              => ['nullable', 'file', 'mimes:pdf', 'max:10240'], // 10MB
            'lampiran.*'           => ['nullable', 'file', 'max:10240'],
        ]);

        $kebijakan = new Kebijakan($data);

        // Upload dokumen utama (PDF)
        if ($request->hasFile('dokumen')) {
            $kebijakan->dokumen_path = $request->file('dokumen')
                ->store('kebijakan/dokumen', 'public');
        }

        // Upload lampiran (multi-file) -> simpan daftar path sebagai JSON
        if ($request->hasFile('lampiran')) {
            $lampiranPaths = [];
            foreach ($request->file('lampiran') as $lampiran) {
                if ($lampiran->isValid()) {
                    $lampiranPaths[] = $lampiran->store('kebijakan/lampiran', 'public');
                }
            }
            if (!empty($lampiranPaths)) {
                $kebijakan->lampiran_paths = $lampiranPaths; // pastikan kolom json ada
            }
        }

        $kebijakan->save();

        return redirect()
            ->route('admin.profil.kebijakan.index')
            ->with('success', 'Kebijakan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kebijakan $kebijakan)
    {
        // view misal: resources/views/admin/profil/kebijakan/show.blade.php
        return view('admin.profil.kebijakan.show', compact('kebijakan'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kebijakan $kebijakan)
    {

        return view('admin.profil.kebijakan.edit', compact('kebijakan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kebijakan $kebijakan)
    {
        $data = $request->validate([
            'judul'                => ['required', 'string', 'max:255'],
            'kategori'             => ['required', 'string', 'max:100'],
            'nomor_dokumen'        => ['nullable', 'string', 'max:255'],
            'versi'                => ['nullable', 'string', 'max:50'],
            'ringkasan'            => ['nullable', 'string'],
            'isi'                  => ['nullable', 'string'],
            'otoritas_pengesah'    => ['nullable', 'string', 'max:255'],
            'penanggung_jawab'     => ['nullable', 'string', 'max:255'],
            'unit_terkait'         => ['nullable', 'string', 'max:255'],
            'tanggal_berlaku'      => ['nullable', 'date'],
            'tanggal_tinjau_berikutnya' => ['nullable', 'date', 'after_or_equal:tanggal_berlaku'],
            'siklus_tinjau'        => ['nullable', 'in:Tahunan,Semester,Triwulan,Ad hoc'],
            'status'               => ['required', 'in:Draft,Publik'],
            'tags'                 => ['nullable', 'string', 'max:255'],

            'dokumen'              => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'lampiran.*'           => ['nullable', 'file', 'max:10240'],
        ]);

        $kebijakan->fill($data);

        // Jika ada dokumen baru, hapus yang lama lalu simpan yang baru
        if ($request->hasFile('dokumen')) {
            if ($kebijakan->dokumen_path && Storage::disk('public')->exists($kebijakan->dokumen_path)) {
                Storage::disk('public')->delete($kebijakan->dokumen_path);
            }

            $kebijakan->dokumen_path = $request->file('dokumen')
                ->store('kebijakan/dokumen', 'public');
        }

        // Jika ada lampiran baru, gabung dengan yang lama atau replace (pilih salah satu)
        if ($request->hasFile('lampiran')) {
            $existing = is_array($kebijakan->lampiran_paths) ? $kebijakan->lampiran_paths : [];

            $newPaths = [];
            foreach ($request->file('lampiran') as $lampiran) {
                if ($lampiran->isValid()) {
                    $newPaths[] = $lampiran->store('kebijakan/lampiran', 'public');
                }
            }

            // Kalau mau REPLACE semua lampiran lama:
            // $kebijakan->lampiran_paths = $newPaths;

            // Kalau mau GABUNG lampiran lama + baru:
            $kebijakan->lampiran_paths = array_values(array_unique(array_merge($existing, $newPaths)));
        }

        $kebijakan->save();

        return redirect()
            ->route('admin.profil.kebijakan.index')
            ->with('success', 'Kebijakan ' . $kebijakan->judul . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kebijakan $kebijakan)
    {
        Kebijakan::destroy($kebijakan->id);
        return redirect()
            ->route('admin.profil.kebijakan.index')
            ->with('success', 'Kebijakan berhasil dihapus.');

    }
}
