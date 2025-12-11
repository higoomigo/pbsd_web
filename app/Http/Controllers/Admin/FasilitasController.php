<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = Fasilitas::getSemuaDenganUrutan();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        return view('admin.fasilitas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'tampil_beranda' => 'boolean',
            'urutan_tampil' => 'integer|min:0'
        ]);

        // Upload gambar
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('fasilitas', 'public');
        }

        Fasilitas::create([
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'gambar_path' => $gambarPath,
            'alt_text' => $request->alt_text,
            'tampil_beranda' => $request->tampil_beranda ?? false,
            'urutan_tampil' => $request->urutan_tampil ?? 0,
        ]);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function show($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    public function edit($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        return view('admin.fasilitas.edit', compact('fasilitas'));
    }

    public function update(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
    
    $request->validate([
            'nama_fasilitas' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'nullable|string|max:255',
            'tampil_beranda' => 'boolean',
            'urutan_tampil' => 'integer|min:0'
        ]);

        $data = [
            'nama_fasilitas' => $request->nama_fasilitas,
            'deskripsi' => $request->deskripsi,
            'alt_text' => $request->alt_text,
            'tampil_beranda' => $request->tampil_beranda ?? false,
            'urutan_tampil' => $request->urutan_tampil ?? 0,
        ];

        // Upload gambar baru jika ada
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($fasilitas->gambar_path) {
                Storage::disk('public')->delete($fasilitas->gambar_path);
            }
            $data['gambar_path'] = $request->file('gambar')->store('fasilitas', 'public');
        }

        $fasilitas->update($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate.');
    }

    public function destroy($id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        
        // Hapus gambar dari storage
        if ($fasilitas->gambar_path) {
            Storage::disk('public')->delete($fasilitas->gambar_path);
        }
        
        $fasilitas->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus.');
    }

    public function updateTampilBeranda(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update(['tampil_beranda' => $request->tampil_beranda]);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Status beranda berhasil diupdate');
    }

    public function updateUrutan(Request $request, $id)
    {
        $fasilitas = Fasilitas::findOrFail($id);
        $fasilitas->update(['urutan_tampil' => $request->urutan_tampil]);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Urutan berhasil diupdate');
    }
}