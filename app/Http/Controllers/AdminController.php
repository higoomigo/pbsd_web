<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('admin.profil.index');
    }

    public function adminAkademik()
    {
        return view('admin.akademik.index');
    }

    public function adminKomersialisasi()
    {
        return view('admin.komersialisasi.index');
    }

    public function adminFasilitas()
    {
        return view('admin.fasilitas.index');
    }

    public function adminPublikasiData()
    {
        return view('admin.publikasi-data.index');
    }

    public function adminKontak()
    {
        return view('admin.kontak.index');
    }
}
