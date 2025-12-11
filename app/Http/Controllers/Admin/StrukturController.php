<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Struktur;
use Illuminate\Support\Facades\Storage;

class StrukturController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Jika single-entity, ambil record pertama (atau buat baru)
        $struktur = Struktur::first();

        if ($struktur) {
            return redirect()->route('admin.profil.struktur.edit', $struktur->id);
        }

        return redirect()->route('admin.profil.struktur.create');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Single-entity: kalau sudah ada, arahkan ke edit
        if ($existing = Struktur::first()) {
            return redirect()->route('admin.profil.struktur.edit', $existing->id);
        }
        $struktur = Struktur::first();
        return view('admin.profil.struktur.create', compact('struktur'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'deskripsi' => ['nullable', 'string'],
            'gambar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg', 'max:3072'],
            'alt_text'  => ['nullable', 'string', 'max:255'],
        ]);

        $payload = [
            'deskripsi' => $data['deskripsi'] ?? null,
            'alt_text'  => $data['alt_text'] ?? null,
        ];

        if ($request->hasFile('gambar')) {
            // Simpan ke storage public (pastikan sudah jalankan: php artisan storage:link)
            $payload['gambar_path'] = $request->file('gambar')->store('struktur', 'public');
        }

        $struktur = Struktur::create($payload);

        return redirect()
            ->route('admin.profil.struktur.edit', $struktur->id)
            ->with('success', 'Struktur berhasil dibuat.');
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
        $struktur = Struktur::findOrFail($id);

        return view('admin.profil.struktur.edit', compact('struktur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $struktur = Struktur::findOrFail($id);

        $data = $request->validate([
            'deskripsi' => ['nullable', 'string'],
            'gambar'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg', 'max:3072'],
            'alt_text'  => ['nullable', 'string', 'max:255'],
        ]);

        $struktur->deskripsi = $data['deskripsi'] ?? null;
        $struktur->alt_text  = $data['alt_text'] ?? null;

        if ($request->hasFile('gambar')) {
            // Hapus file lama bila ada
            if (!empty($struktur->gambar_path) && Storage::disk('public')->exists($struktur->gambar_path)) {
                Storage::disk('public')->delete($struktur->gambar_path);
            }

            $struktur->gambar_path = $request->file('gambar')->store('struktur', 'public');
        }

        $struktur->save();

        return back()->with('success', 'Struktur berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $struktur = Struktur::findOrFail($id);

        if (!empty($struktur->gambar_path) && Storage::disk('public')->exists($struktur->gambar_path)) {
            Storage::disk('public')->delete($struktur->gambar_path);
        }

        $struktur->delete();

        return redirect()
            ->route('admin.profil.index')
            ->with('success', 'Struktur berhasil dihapus.');
    }
}
