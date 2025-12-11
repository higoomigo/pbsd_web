<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
{
    /**
     * Menyimpan komentar baru
     */
    public function store(Request $request, Artikel $artikel)
    {
        // Validasi input
        $validated = $this->validateKomentar($request);

        // Buat komentar
        $komentar = $this->createKomentar($artikel, $validated);

        return back()->with('success', $this->getSuccessMessage($komentar));
    }

    /**
     * Menampilkan form edit komentar
     */
    public function edit(Artikel $artikel, Komentar $komentar)
    {
        // Cek authorization manual (tanpa policy)
        if (!$this->canEdit($komentar)) {
            return redirect()->route('guest.artikel.show', $artikel->slug)
                ->with('error', 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }

        return view('artikel.komentar.edit', compact('artikel', 'komentar'));
    }

    /**
     * Update komentar
     */
    public function update(Request $request, Artikel $artikel, Komentar $komentar)
    {
        // Cek authorization manual
        if (!$this->canEdit($komentar)) {
            return redirect()->route('guest.artikel.show', $artikel->slug)
                ->with('error', 'Anda tidak memiliki izin untuk mengedit komentar ini.');
        }

        // Validasi
        $validated = $request->validate([
            'konten' => 'required|string|min:3|max:1000',
        ]);

        // Update komentar
        $komentar->update(['konten' => $validated['konten']]);

        return redirect()->route('guest.artikel.show', $artikel->slug)
            ->with('success', 'Komentar berhasil diperbarui.');
    }

    /**
     * Hapus komentar
     */
    public function destroy(Artikel $artikel, Komentar $komentar)
    {
        // Cek authorization manual
        if (!$this->canDelete($komentar)) {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini.');
        }

        $komentar->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Reply komentar
     */
    public function reply(Request $request, Artikel $artikel, Komentar $parent)
    {
        // Cek apakah user login untuk reply
        if (!Auth::check()) {
            return back()->with('error', 'Anda harus login untuk membalas komentar.');
        }

        // Validasi input
        $validated = $this->validateKomentar($request);

        // Buat reply
        $reply = $this->createKomentar($artikel, $validated, $parent);

        return back()->with('success', $this->getSuccessMessage($reply));
    }

    /**
     * Private method untuk validasi
     */
    private function validateKomentar(Request $request)
    {
        $rules = [
            'konten' => 'required|string|min:3|max:1000',
        ];

        // Jika guest, tambahkan validasi nama dan email
        if (!Auth::check()) {
            $rules['nama'] = 'required|string|max:100';
            $rules['email'] = 'required|email|max:100';
        }

        return $request->validate($rules);
    }

    /**
     * Private method untuk membuat komentar
     */
    private function createKomentar(Artikel $artikel, array $data, ?Komentar $parent = null)
    {
        $komentar = new Komentar();
        $komentar->artikel_id = $artikel->id;
        $komentar->konten = $data['konten'];

        // Set parent jika ada
        if ($parent) {
            $komentar->parent_id = $parent->id;
        }

        // Jika user login
        if (Auth::check()) {
            $komentar->user_id = Auth::id();
            $komentar->is_approved = true; // Auto-approve untuk user terdaftar
        } else {
            $komentar->nama = $data['nama'];
            $komentar->email = $data['email'];
            $komentar->is_approved = false; // Moderasi untuk tamu
        }

        $komentar->save();
        return $komentar;
    }

    /**
     * Private method untuk success message
     */
    private function getSuccessMessage(Komentar $komentar)
    {
        if (Auth::check()) {
            return 'Komentar berhasil ditambahkan!';
        }

        return 'Komentar berhasil ditambahkan. Komentar Anda akan ditampilkan setelah disetujui oleh admin.';
    }

    /**
     * Cek apakah user bisa edit komentar
     */
    private function canEdit(Komentar $komentar): bool
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return false;
        }

        // Cek apakah komentar milik user
        if ($komentar->user_id !== Auth::id()) {
            return false;
        }

        // Hanya boleh edit dalam 30 menit setelah dibuat
        $minutesSinceCreated = $komentar->created_at->diffInMinutes(now());
        return $minutesSinceCreated <= 30;
    }

    /**
     * Cek apakah user bisa hapus komentar
     */
    private function canDelete(Komentar $komentar): bool
    {
        // Cek apakah user login
        if (!Auth::check()) {
            return false;
        }

        // Cek apakah komentar milik user
        return $komentar->user_id === Auth::id();
    }
}