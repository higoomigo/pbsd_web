<?php

namespace App\Http\Controllers;

use App\Models\Peneliti;
use Illuminate\Http\Request;

class GuestPenelitiController extends Controller
{
    /**
     * Display a listing of the researchers grouped by position.
     */
    public function index()
    {
        // Ambil semua peneliti yang published dan aktif, diurutkan
        $penelitis = Peneliti::where('is_published', true)
            ->orderBy('urutan', 'asc')
            ->orderBy('nama', 'asc')
            ->get();

        // Kelompokkan berdasarkan posisi
        $penelitiInternal = $penelitis->where('tipe', 'Internal')->values();
        $penelitiEksternal = $penelitis->where('tipe', 'Eksternal')->values();
        $penelitiKolaborator = $penelitis->where('tipe', 'Kolaborator')->values();
        $penelitiLainnya = $penelitis->whereNotIn('tipe', ['Internal', 'Eksternal', 'Kolaborator'])->values();
    
        return view('guest.peneliti.index', compact(
            'penelitiInternal',
            'penelitiEksternal', 
            'penelitiKolaborator',
            'penelitiLainnya'
        ));
    }   

    /**
     * Display the specified researcher.
     */

   /**
     * Display the specified researcher.
     */
    public function show($slug)
    {
        // Cari peneliti berdasarkan slug
        $peneliti = Peneliti::where('slug', $slug)->first();
        
        // Jika tidak ditemukan atau tidak published/aktif, 404
        // if (!$peneliti || !$peneliti->is_published || $peneliti->status !== 'Aktif') {
        //     abort(404);
        // }

        return view('guest.peneliti.show', compact('peneliti'));
    }

    /**
     * API endpoint for filtering (optional - for AJAX requests)
     */
    public function filter(Request $request)
    {
        $query = Peneliti::published()
            ->aktif()
            ->urutan();

        if ($request->has('q') && $request->q) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->q . '%')
                  ->orWhere('posisi', 'like', '%' . $request->q . '%')
                  ->orWhere('jabatan', 'like', '%' . $request->q . '%')
                  ->orWhere('deskripsi_singkat', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->has('bidang') && $request->bidang) {
            $query->whereJsonContains('bidang_keahlian', $request->bidang);
        }

        if ($request->has('posisi') && $request->posisi) {
            $query->where('posisi', $request->posisi);
        }

        $penelitis = $query->get();

        return response()->json([
            'success' => true,
            'data' => $penelitis,
            'count' => $penelitis->count()
        ]);
    }
}