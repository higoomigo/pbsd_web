<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GuestBeritaController;
use App\Http\Controllers\GuestArtikelController;
use App\Http\Controllers\GuestKebijakanController;
use App\Http\Controllers\GuestMitraController;
use App\Http\Controllers\GuestPenelitiController;
use App\Http\Controllers\GuestDokumenController;
use App\Http\Controllers\GaleriAlbumController;
use App\Http\Controllers\GaleriMediaController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\PublikasiTerindeksController;
use App\Http\Controllers\KegiatanPenelitianController;
use App\Http\Controllers\KerjasamaRisetController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\CollaborationController;

// Route::get('/', function () {
//     return view('welcome');
// })name->();

Route::get('/', [UserController::class, 'welcome'])->name('welcome');

// Route::get('/admin/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('admin.dashboard');

// BERITA ROUTE
// Route::resource('guest.berita', GuestBeritaController::class);
Route::get('kegiatan-pusat-studi', [GuestBeritaController::class, 'index'])->name('guest.berita.index');
Route::get('kegiatan/{slug}', [GuestBeritaController::class, 'show'])->name('guest.berita.show');

Route::get('artikel', [GuestArtikelController::class, 'index'])->name('guest.artikel.index');
Route::get('artikel/{slug}', [GuestArtikelController::class, 'show'])->name('guest.artikel.show');
// Rute untuk komentar publik
Route::prefix('artikel/{artikel:slug}')->group(function () {
    // Store komentar (bisa diakses guest)
    Route::post('/komentar', [KomentarController::class, 'store'])->name('komentar.store');
    
    // Reply komentar (hanya user login)
    Route::post('/komentar/{komentar}/reply', [KomentarController::class, 'reply'])
        ->name('komentar.reply')
        ->middleware('auth');
});

// Rute untuk auth user (edit/hapus komentar)
Route::middleware(['auth'])->group(function () {
    Route::get('/artikel/{artikel:slug}/komentar/{komentar}/edit', [KomentarController::class, 'edit'])
        ->name('komentar.edit');
    
    Route::put('/artikel/{artikel:slug}/komentar/{komentar}', [KomentarController::class, 'update'])
        ->name('komentar.update');
    
    Route::delete('/artikel/{artikel:slug}/komentar/{komentar}', [KomentarController::class, 'destroy'])
        ->name('komentar.destroy');
});

Route::get('kebijakan-organisasi', [GuestKebijakanController::class, 'index'])->name('guest.kebijakan.index');
Route::get('kebijakan-organisasi/{slug}', [GuestKebijakanController::class, 'show'])->name('guest.kebijakan.show');

Route::get('mitra', [GuestMitraController::class, 'index'])->name('guest.mitra.index');
Route::get('mitra/{mitra}', [GuestMitraController::class, 'show'])->name('guest.mitra.show');

Route::get('peneliti', [GuestPenelitiController::class, 'index'])->name('guest.peneliti.index');
Route::get('peneliti/{peneliti}', [GuestPenelitiController::class, 'show'])->name('guest.peneliti.show');

Route::get('fasilitas-pusat-studi', [UserController::class, 'fasilitasIndex'])->name('guest.fasilitas.index');

// Album Routes
Route::controller(GaleriAlbumController::class)->group(function () {
    Route::get('/galeri', 'beranda')->name('galeri.albums.beranda');
    Route::get('/galeri/albums', 'index')->name('galeri.albums.index');
    Route::get('/galeri/albums/{slug}', 'show')->name('galeri.albums.show');
    Route::get('/galeri/albums/{album}/media/{media}', 'showMedia')->name('galeri.albums.media.show');
});

// Media Routes  
Route::controller(GaleriMediaController::class)->group(function () {
    Route::get('/galeri/media', 'index')->name('galeri.media.index');
    Route::get('/galeri/media/foto', 'foto')->name('galeri.media.foto');
    Route::get('/galeri/media/video', 'video')->name('galeri.media.video');
    Route::get('/galeri/media/youtube', 'youtube')->name('galeri.media.youtube');
    Route::get('/galeri/media/{media}', 'show')->name('galeri.media.show');
    Route::get('/galeri/media/{media}/download', 'download')->name('galeri.media.download');
    Route::get('/galeri/media/{media}/stream', 'streamVideo')->name('galeri.media.stream');
    
    // API Routes
    Route::get('/galeri/api/media', 'apiMedia')->name('galeri.api.media');
    Route::get('/galeri/api/stats', 'stats')->name('galeri.api.stats');
});

// Route::get('dokumen', [GuestDokumenController::class, 'index'])->name('guest.dokumen.index');
// Route::get('dokumen/{id}', [GuestDokumenController::class, 'show'])->name('guest.dokumen.show');
Route::prefix('dokumen')->name('guest.dokumen.')->group(function () {
    Route::get('/', [GuestDokumenController::class, 'index'])->name('index');
    Route::get('/koleksi', [GuestDokumenController::class, 'koleksi'])->name('koleksi.index');
    Route::get('/koleksi/{id}', [GuestDokumenController::class, 'showKoleksi'])->name('koleksi.show');
    Route::get('/{id}', [GuestDokumenController::class, 'show'])->name('show');
    Route::get('/{id}/download', [GuestDokumenController::class, 'download'])->name('download');
    Route::get('/{id}/view', [GuestDokumenController::class, 'view'])->name('view');
});

// Kolaborasi Kerjasama
Route::post('/collaboration/submit', [CollaborationController::class, 'store'])
    ->name('collaboration.submit');

    // ========== ROUTES UNTUK TESTING ==========
Route::get('/collaboration/test', [CollaborationController::class, 'testNotification']);
Route::get('/collaboration/test-direct', [CollaborationController::class, 'testFonnteDirect']);
Route::get('/collaboration/list', [CollaborationController::class, 'listCollaborations']);

//------------------------//
//  DROPDOWN PROFIL ROUTE //
// Route::get('/about', [UserController::class, 'about'])->name('about');
Route::get('/visi-misi', [UserController::class, 'visiMisi'])->name('visi-misi');
Route::get('/struktur-organisasi', [UserController::class, 'strukturOrganisasi'])->name('struktur-organisasi');


Route::get('/publikasi-terindeks', [PublikasiTerindeksController::class, 'index'])->name('guest.publikasi-terindeks.index');
Route::get('/publikasi-terindeks/{id}', [PublikasiTerindeksController::class, 'show'])->name('guest.publikasi-terindeks.show');


Route::get('/kegiatan-penelitian', [KegiatanPenelitianController::class, 'index'])->name('guest.kegiatan-penelitian.index');
// Route::get('/kegiatan-penelitian', [KegiatanPenelitianController::class, 'index'])->name('guest.penelitian.index');
Route::get('/kegiatan-penelitian/{slug}', [KegiatanPenelitianController::class, 'show'])->name('guest.kegiatan-penelitian.show');
Route::get('/kerjasama-riset', [KerjasamaRisetController::class, 'index'])->name('guest.kerjasama-riset.index');

Route::prefix('seminar')->name('guest.seminar.')->group(function () {
    // Halaman utama seminar
    Route::get('/', [SeminarController::class, 'index'])->name('index');
    
    // Detail seminar
    Route::get('/{slug}', [SeminarController::class, 'show'])->name('show');
    
    // Download file
    Route::get('/{slug}/download-materi', [SeminarController::class, 'downloadMaterial'])->name('download.material');
    Route::get('/{slug}/download-poster', [SeminarController::class, 'downloadPoster'])->name('download.poster');
    
    // Pendaftaran
    Route::post('/{slug}/register', [SeminarController::class, 'register'])->name('register');
    
    // Kategori dan format
    Route::get('/kategori/{category}', [SeminarController::class, 'byCategory'])->name('category');
    Route::get('/format/{format}', [SeminarController::class, 'byFormat'])->name('format');
    
    // Kalender
    Route::get('/kalender', [SeminarController::class, 'calendar'])->name('calendar');
    
    // API untuk kalender
    Route::get('/api/seminars', [SeminarController::class, 'apiIndex'])->name('api.index');
});

// Route Publikasi
// Route::get('/artikel', [UserController::class, 'artikel'])->name('artikel');


















// // Route::get('/roadmap-asta-cita', [UserController::class, 'roadmapAsta'])->name('roadmap-asta');
// Route::get('/kebijakan-tata-kelola', [UserController::class, 'kebijakan'])->name('kebijakan');
// Route::get('/mitra-strategis', [UserController::class, 'mitra'])->name('mitra');

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
// Route::get('/kerjasama-riset', [UserController::class, 'kerjasamaRiset'])->name('kerjasama-riset');
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