<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\Admin\BeritaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// LANDING BUTTONS ROUTES //
Route::get('/profil', [UserController::class, 'profilFull'])->name('profil-full');

//  DROPDOWN PROFIL //
Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/visi-misi', [UserController::class, 'visiMisi'])->name('visi-misi');
Route::get('/struktur-organisasi', [UserController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
Route::get('/roadmap-asta-cita', [UserController::class, 'roadmapAsta'])->name('roadmap-asta');
Route::get('/kebijakan-tata-kelola', [UserController::class, 'kebijakan'])->name('kebijakan');
Route::get('/mitra-strategis', [UserController::class, 'mitra'])->name('mitra');


Route::get('/tim-peneliti', [UserController::class, 'timPeneliti'])->name('tim-peneliti');
Route::get('/kontak', [UserController::class, 'kontak'])->name('kontak');

// Route::get('/berita-pusat-studi', [UserController::class, 'berita'])->name('berita');

//  News Res.  //
// Route::resource('news', NewsController::class);


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin', [UserController::class, 'admin'])->name('admin');

    //   Here Route Navbar Menus   //
    // Route::get('/admin/visi-misi', [UserController::class, 'adminVisiMisi'])->name('admin.visi-misi'); 
    //-------------------------------//
    //   Admin's Navigate Route      //
    //-------------------------------//
    Route::get('/admin/profil', [AdminController::class, 'adminProfil'])->name('admin.profil');
    Route::get('/admin/akademik', [AdminController::class, 'adminAkademik'])->name('admin.akademik');
    Route::get('/admin/komersialisasi', [AdminController::class, 'adminKomersialisasi'])->name('admin.komersialisasi');
    Route::get('/admin/fasilitas', [AdminController::class, 'adminFasilitas'])->name('admin.fasilitas');
    Route::get('/admin/publikasi-data', [AdminController::class, 'adminPublikasiData'])->name('admin.publikasi-data');
    Route::get('/admin/kontak', [AdminController::class, 'adminKontak'])->name('admin.kontak');


    Route::get('/admin/profil/edit-visi-misi', [PagesController::class, 'editVisiMisi'])->name('visimisi.edit');
    Route::patch('/admin/profil/edit-visi-misi', [PagesController::class, 'updateVisiMisi'])->name('visimisi.update');

    //-------------------------------//
    //  ADMIN PUBLIKASI DATA ROUTES  //
    //-------------------------------//
    Route::resource('berita', BeritaController::class);
    // Route::get('/admin/publikasi-data/create', [AdminController::class, 'createPublikasiData'])->name('admin.publikasi-data.create');

    // RESOURCES
    Route::resource('visi_misi', VisiMisiController::class);
});



// HERE GOES THE DUMMY ROUTES
Route::get('/berita', [UserController::class, 'berita'])->name('beritashow');



require __DIR__.'/auth.php';

