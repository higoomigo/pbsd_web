<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PagesController;
// use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\GuestBeritaController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [UserController::class, 'welcome'])->name('welcome');

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// BERITA ROUTE
// Route::resource('guest.berita', GuestBeritaController::class);
Route::get('berita-pusat-studi', [GuestBeritaController::class, 'index'])->name('guest.berita.index');
Route::get('berita/{slug}', [GuestBeritaController::class, 'show'])->name('guest.berita.show');


//------------------------//
//  DROPDOWN PROFIL ROUTE //
Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/visi-misi', [UserController::class, 'visiMisi'])->name('visi-misi');
Route::get('/struktur-organisasi', [UserController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
// Route::get('/roadmap-asta-cita', [UserController::class, 'roadmapAsta'])->name('roadmap-asta');
Route::get('/kebijakan-tata-kelola', [UserController::class, 'kebijakan'])->name('kebijakan');
Route::get('/mitra-strategis', [UserController::class, 'mitra'])->name('mitra');

// Route::get()




















// LANDING BUTTONS ROUTES //
Route::get('/profil', [UserController::class, 'profilFull'])->name('profil-full');



//------------------------//
//  DROPDOWN AKADEMIK ROUTE //
Route::get('/publikasi', [UserController::class, 'publikasi'])->name('publikasi');
Route::get('/jurnal', [UserController::class, 'jurnal'])->name('jurnal');
Route::get('/kegiatan-ilmiah', [UserController::class, 'kegiatanIlmiah'])->name('kegiatan-ilmiah');
Route::get('/international-visit', [UserController::class, 'internationalVisit'])->name('international-visit');
Route::get('/profil-peneliti', [UserController::class, 'profilPeneliti'])->name('profil-peneliti');
Route::get('/lulusan', [UserController::class, 'lulusanS3'])->name('lulusan-s3');

Route::get('/tim-peneliti', [UserController::class, 'timPeneliti'])->name('tim-peneliti');
Route::get('/kontak', [UserController::class, 'kontak'])->name('kontak');

//-------------------------------//
// dropdown KOMERSIALISASI Route //
Route::get('/produk-inovasi-pusat-studi', [UserController::class, 'produkInovasi'])->name('produk-inovasi');
Route::get('/paten-hki', [UserController::class, 'patenHki'])->name('paten-hki');
Route::get('/kerjasama-riset', [UserController::class, 'kerjasamaRiset'])->name('kerjasama-riset');
Route::get('/kontrak-nonriset', [UserController::class, 'kontrakNonRiset'])->name('kontrak-nonriset');   
Route::get('/umkm-binaan', [UserController::class, 'umkmBinaan'])->name('umkm-binaan');
Route::get('/unit-bisnis', [UserController::class, 'unitBisnisDanLayanan'])->name('unit-bisnis');

//-------------------------------//
// dropdown Fasilitas Route -----//
Route::get('/fasilitas-riset-lab', [UserController::class, 'fasilitasRiset'])->name('fasilitas-riset');
Route::get('/sop-prosedur', [UserController::class, 'sopProsedur'])->name('sop');
Route::get('/program-magang', [UserController::class, 'programMagang'])->name('magang');
Route::get('/capacity-building-workshop', [UserController::class, 'capacityBuilding'])->name('capacity-building');
Route::get('/booking-fasilitas', [UserController::class, 'bookingFasilitas'])->name('booking');

//-------------------------------//
// dropdown Publikasi Route -----//
Route::get('/media', [UserController::class, 'media'])->name('media');
// Route::get('/berita-agenda', [UserController::class, 'beritaAgenda'])->name('berita-agenda');
// Route::get('/berita-pusat-studi', [UserController::class, 'berita'])->name('berita-guest');
// Route::get()
// Route::get('/artikel',[ArtikelController::class, 'showGuest'])->name('artikel.showGuest');
// Route::get('/berita-pusat-studi', [UserController::class, 'berita'])->name('berita');
// Route::get('/berita-pusat-studi', [PagesController::class, 'newsIndex'])->name('news.index');
// Route::get('/berita-pusat-studi/{slug}', [PagesController::class, 'newsShow'])->name('news.show');