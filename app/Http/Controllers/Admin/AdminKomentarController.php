<?php

namespace App\Http\Controllers\Admin;

use App\Models\Komentar;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AdminKomentarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = Komentar::with(['artikel', 'user'])
            ->orderBy('created_at', 'desc');
        
        // Tanpa menggunakan scope, langsung dengan where
        switch ($status) {
            case 'approved':
                $query->where('is_approved', true);
                break;
            case 'pending':
                $query->where('is_approved', false);
                break;
            default:
                // semua komentar
                break;
        }
        
        $komentars = $query->paginate(20);
        
        return view('admin.komentar.index', compact('komentars', 'status'));
    }
    
    /**
     * Display komentar by artikel
     */
    public function byArtikel(Artikel $artikel, Request $request)
    {
        $status = $request->get('status', 'all');
        
        $query = $artikel->komentars()
            ->with(['user'])
            ->orderBy('created_at', 'desc');
        
        // Tanpa menggunakan scope, langsung dengan where
        switch ($status) {
            case 'approved':
                $query->where('is_approved', true);
                break;
            case 'pending':
                $query->where('is_approved', false);
                break;
            default:
                // semua komentar
                break;
        }
        
        $komentars = $query->paginate(20);
        
        return view('admin.komentar.by-artikel', compact('komentars', 'artikel', 'status'));
    }
    
    /**
     * Approve komentar
     */
    public function approve(Komentar $komentar)
    {
        // dd("askdjfnaksdnfjkansdfkjasdfj");
        $komentar->is_approved = true;
        $komentar->save();
        
    return back()->with('success', 'Komentar berhasil disetujui.');
    }
    
    /**
     * Reject komentar
     */
    public function reject(Komentar $komentar)
    {
        $komentar->is_approved = false;
        $komentar->save();
        // $komentar->delete();
        
        return back()->with('success', 'Komentar berhasil ditolak/ditarik.');
    }

    // public function destroy(Komentar $komentar)
    // {
    //     $komentar->delete();
        
    //     return back()->with('success', 'Komentar berhasil dihapus.');
    // }   
    
    /**
     * Bulk action for komentar
     */
    public function bulkAction(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'ids' => 'required|array|min:1'
        ], [
            'ids.required' => 'Pilih minimal satu komentar',
            'ids.min' => 'Pilih minimal satu komentar'
        ]);
        
        $action = $validated['action'];
        $ids = $validated['ids'];
        
        // Filter array untuk menghapus nilai null/empty
        $ids = array_filter($ids);
        
        if (empty($ids)) {
            return back()->with('error', 'Tidak ada komentar yang dipilih.');
        }
        
        // Validasi bahwa semua ID benar-benar ada di database
        $existingIds = Komentar::whereIn('id', $ids)->pluck('id')->toArray();
        $nonExistingIds = array_diff($ids, $existingIds);
        
        if (!empty($nonExistingIds)) {
            return back()->with('error', 'Beberapa komentar tidak ditemukan. Silakan refresh halaman.');
        }
        
        $affected = 0;
        
        try {
            switch ($action) {
                case 'approve':
                    $affected = Komentar::whereIn('id', $ids)
                        ->update([
                            'is_approved' => true,
                            'updated_at' => now()
                        ]);
                    $message = $affected . ' komentar berhasil disetujui.';
                    break;
                    
                case 'reject':
                case 'delete':
                    $affected = Komentar::whereIn('id', $ids)->delete();
                    $message = $affected . ' komentar berhasil ' . 
                              ($action === 'reject' ? 'ditolak' : 'dihapus.');
                    break;
                    
                default:
                    return back()->with('error', 'Aksi tidak valid.');
            }
            
            return back()->with('success', $message);
            
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Komentar $komentar)
    {
        // Load relasi dengan pengecekan jika ada
        $komentar->load(['artikel', 'user']);
        
        // Jika ada relasi parent, load juga
        if (method_exists($komentar, 'parent')) {
            $komentar->load(['parent']);
        }
        
        return view('admin.komentar.show', compact('komentar'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komentar $komentar)
    {
        try {
            $komentar->delete();
            return back()->with('success', 'Komentar berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus komentar: ' . $e->getMessage());
        }
    }
}