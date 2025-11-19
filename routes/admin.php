<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\StrukturController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\KebijakanController;
use App\Http\Controllers\Admin\MitraController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DokumenController;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('admin', [UserController::class, 'admin'])->name('admin');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [AdminController::class, 'adminProfil'])->name('index'); 
            Route::resource('visimisi', VisiMisiController::class);
            Route::resource('struktur', StrukturController::class);
            Route::resource('kebijakan', KebijakanController::class);
            Route::resource('mitra', MitraController::class);
        });

        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/', [AdminController::class, 'adminAkademik'])->name('index'); 
            // submenu goes here
        });

        
        Route::prefix('publikasi-data')->name('publikasi-data.')->group(function () {
            Route::get('/', [AdminController::class, 'adminPublikasiData'])->name('index');
            // submenu goes here
            Route::resource('berita', BeritaController::class);
            Route::resource('dokumen', DokumenController::class);
            Route::resource('galeri', GaleriController::class);
            Route::resource('artikel', ArtikelController::class);
        });

        Route::prefix('komersialisasi')->name('komersialisasi.')->group(function () {
            Route::get('/', [AdminController::class, 'adminKomersialisasi'])->name('index');
            // submenu goes here
            // Route::resource('berita', BeritaController::class);

        });
        Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
            Route::get('/', [AdminController::class, 'adminFasilitas'])->name('index');
            // submenu goes here
            // Route::resource('berita', BeritaController::class);

        });
        Route::prefix('kontak')->name('kontak.')->group(function () {
            Route::get('/', [AdminController::class, 'adminKontak'])->name('index');
            // submenu goes here
            // Route::resource('berita', BeritaController::class);

        });

    //   Here Route Navbar Menus   //
    // Route::get('/admin/visi-misi', [UserController::class, 'adminVisiMisi'])->name('admin.visi-misi'); 
    //-------------------------------//
    //   Admin's Navigate Route      //
    //-------------------------------//
    // Route::get('/admin/akademik', [AdminController::class, 'adminAkademik'])->name('admin.akademik');
    // Route::get('/admin/komersialisasi', [AdminController::class, 'adminKomersialisasi'])->name('admin.komersialisasi');
    // Route::get('/admin/fasilitas', [AdminController::class, 'adminFasilitas'])->name('admin.fasilitas');
    // Route::get('/admin/kontak', [AdminController::class, 'adminKontak'])->name('admin.kontak');

    //-------------------------------//
    //  ADMIN PUBLIKASI DATA ROUTES  //
    //-------------------------------//
    Route::resource('berita', BeritaController::class);
    });
});