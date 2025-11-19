<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\VisiMisi;
use App\Http\Controller\VisiMisiController;

class AdminController extends Controller
{
    // Route::get('/admin/profil', [AdminController::class, 'adminProfil'])->name('admin.profil');
    // Route::get('/admin/akademik', [AdminController::class, 'adminAkademik'])->name('admin.akademik');
    // Route::get('/admin/komersialisasi', [AdminController::class, 'adminKomersialisasi'])->name('admin.komersialisasi');
    // Route::get('/admin/fasilitas', [AdminController::class, 'adminFasilitas'])->name('admin.fasilitas');
    // Route::get('/admin/publikasi-data', [AdminController::class, 'adminPublikasiData'])->name('admin.publikasi-data');
    // Route::get('/admin/kontak', [AdminController::class, 'adminKontak'])->name('admin.kontak');

    public function adminProfil()
    {
        // $visimisi = VisiMisi::find(1);
        // return view('admin.profil.index', compact('visimisi'));

        return to_route('admin.profil.visimisi.index');
    }

    public function adminAkademik()
    {
        return view('admin.akademik.index');
    }

    // public function adminKomersialisasi()
    // {
    //     return view('admin.komersialisasi.index');
    // }

    public function adminFasilitas()
    {
        return view('admin.fasilitas.index');
    }

    public function adminPublikasiData()
    {
        $berita = Berita::all();
        return to_route('admin.publikasi-data.berita.index');
    }

    public function adminKontak()
    {
        return view('admin.kontak.index');
    }
}
