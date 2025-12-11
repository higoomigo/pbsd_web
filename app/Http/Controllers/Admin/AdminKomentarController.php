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
        $status = $request->get('status', 'pending');
        
        $query = Komentar::with(['artikel', 'user'])
            ->orderBy('created_at', 'desc');
        
        switch ($status) {
            case 'approved':
                $query->approved();
                break;
            case 'pending':
                $query->pending();
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
        
        switch ($status) {
            case 'approved':
                $query->approved();
                break;
            case 'pending':
                $query->pending();
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
        $komentar->is_approved = true;
        $komentar->save();
        
        return back()->with('success', 'Komentar berhasil disetujui.');
    }
    
    /**
     * Reject komentar
     */
    public function reject(Komentar $komentar)
    {
        $komentar->delete();
        
        return back()->with('success', 'Komentar berhasil ditolak dan dihapus.');
    }
    
    /**
     * Bulk action for komentar
     */
    public function bulkAction(Request $request)
    {
        // Debug: cek data yang diterima
        // dd($request->all());
        
        $request->validate([
            'action' => 'required|in:approve,reject,delete',
            'ids' => 'required|array',
            'ids.*' => 'exists:komentars,id'
        ]);
        
        $action = $request->input('action');
    $ids = $request->input('ids', []);
        
        // Pastikan ids adalah array dan tidak kosong
        if (!is_array($ids) || empty($ids)) {
            return back()->with('error', 'Tidak ada komentar yang dipilih.');
        }
        // dd("saayskfjhaskjdfhfkj");
        switch ($action) {
            case 'approve':
                $affected = Komentar::whereIn('id', $ids)
                    ->update(['is_approved' => true]);
                $message = $affected . ' komentar berhasil disetujui.';
                break;
                
            case 'reject':
                $affected = Komentar::whereIn('id', $ids)->delete();
                $message = $affected . ' komentar berhasil ditolak dan dihapus.';
                break;
                
            case 'delete':
                $affected = Komentar::whereIn('id', $ids)->delete();
                $message = $affected . ' komentar berhasil dihapus.';
                break;
                
            default:
                return back()->with('error', 'Aksi tidak valid. Pilih antara: approve, reject, atau delete.');
        }
        
        return back()->with('success', $message);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Komentar $komentar)
    {
        $komentar->load(['artikel', 'user', 'parent']);
        
        return view('admin.komentar.show', compact('komentar'));
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Komentar $komentar)
    {
        $komentar->delete();
        
        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}