<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\StrukturController;
use App\Http\Controllers\Admin\GaleriAlbumController;
use App\Http\Controllers\Admin\GaleriMediaController;
use App\Http\Controllers\Admin\KebijakanController;
use App\Http\Controllers\Admin\MitraController;
use App\Http\Controllers\Admin\PenelitiController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\VisiMisiController;
use App\Http\Controllers\Admin\ArtikelController;
use App\Http\Controllers\Admin\DokumenController;
use App\Http\Controllers\Admin\AdminKoleksiDokumenController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\AdminKomentarController;
use App\Http\Controllers\Admin\PublikasiTerindeksController;
use App\Http\Controllers\Admin\KegiatanPenelitianController;
use App\Http\Controllers\Admin\KerjasamaRisetController;
use App\Http\Controllers\Admin\SeminarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\CollaborationContactController; 

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route::get('admin', [UserController::class, 'admin'])->name('admin');
    

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::resource('user', AdminController::class);
        Route::post('/users/{user}/verify', [AdminController::class, 'verify'])->name('user.verify');

         Route::post('/upload/inline', function (Request $request) {
            $request->validate([
                'file' => ['required','image','mimes:jpg,jpeg,png,webp','max:4096'],
            ]);

            $path = $request->file('file')->store('inline', 'public');
            return response()->json([
                'location' => Storage::url($path),
            ]);
        })->name('upload.inline');

        Route::prefix('profil')->name('profil.')->group(function () {
            Route::get('/', [AdminController::class, 'adminProfil'])->name('index'); 
            Route::resource('visimisi', VisiMisiController::class);
            Route::resource('struktur', StrukturController::class);
            Route::resource('kebijakan', KebijakanController::class);
            Route::resource('mitra', MitraController::class);
            Route::resource('struktur', StrukturController::class);
            Route::resource('peneliti', PenelitiController::class);
            Route::post('peneliti/bulk-action', [PenelitiController::class, 'bulkAction'])->name('peneliti.bulk-action');
            Route::post('peneliti/{peneliti}/toggle-beranda', [PenelitiController::class, 'toggleBeranda'])->name('peneliti.toggle-beranda');
            Route::post('peneliti/{peneliti}/toggle-publish', [PenelitiController::class, 'togglePublish'])->name('peneliti.toggle-publish');
            Route::post('peneliti/update-urutan', [PenelitiController::class, 'updateUrutan'])->name('peneliti.update-urutan');
        });

        Route::prefix('akademik')->name('akademik.')->group(function () {
            Route::get('/', [AdminController::class, 'adminAkademik'])->name('index'); 
            // submenu goes here
        });

        
        Route::prefix('publikasi-data')->name('publikasi-data.')->group(function () {
            Route::get('/', [AdminController::class, 'adminPublikasiData'])->name('index');
            // submenu goes here
            Route::resource('berita', BeritaController::class);
            Route::resource('koleksi-dokumen', AdminKoleksiDokumenController::class);
        
            // Dokumen (seperti GaleriMedia)
            Route::resource('dokumen', DokumenController::class);
            Route::get('/dokumen/{id}/view', [DokumenController::class, 'view'])->name('dokumen.view');
            Route::get('/dokumen/{id}/download', [DokumenController::class, 'download'])->name('dokumen.download');
            
            Route::prefix('galeri')->name('galeri.')->group(function () {
                // Album galeri (CRUD)
                Route::resource('albums', GaleriAlbumController::class);
                // Media di dalam album (nested resource, shallow biar URL edit/delete simple)
                // Media - SIMPLE VERSION
                Route::get('media', [GaleriMediaController::class, 'index'])->name('media.index');
                Route::get('media/create', [GaleriMediaController::class, 'create'])->name('media.create');
                Route::post('media', [GaleriMediaController::class, 'store'])->name('media.store');
                Route::get('media/{media}/edit', [GaleriMediaController::class, 'edit'])->name('media.edit');
                Route::put('media/{media}', [GaleriMediaController::class, 'update'])->name('media.update');
                Route::delete('media/{media}', [GaleriMediaController::class, 'destroy'])->name('media.destroy');
                Route::post('media/{media}/set-utama', [GaleriMediaController::class, 'setUtama'])->name('media.set-utama');
            });
            Route::resource('artikel', ArtikelController::class);
            // 🔥 ROUTE ADMIN UNTUK MODERASI KOMENTAR 🔥
            Route::prefix('komentar')->name('komentar.')->group(function () {
                // Index komentar (semua atau per artikel)
                Route::get('/', [AdminKomentarController::class, 'index'])->name('index');
                
                // Komentar per artikel
                Route::get('/artikel/{artikel}', [AdminKomentarController::class, 'byArtikel'])
                    ->name('by-artikel');
                
                // Approve komentar
                Route::post('/{komentar}/approve', [AdminKomentarController::class, 'approve'])
                    ->name('approve');
                
                // Reject komentar
                Route::post('/{komentar}/reject', [AdminKomentarController::class, 'reject'])
                    ->name('reject');
                
                // Bulk actions
                Route::post('/bulk-action', [AdminKomentarController::class, 'bulkAction'])
                    ->name('bulk-action');
                
                // Hapus komentar
                Route::delete('/{komentar}', [AdminKomentarController::class, 'destroy'])
                    ->name('destroy');
                
                // Preview komentar
                Route::get('/{komentar}', [AdminKomentarController::class, 'show'])
                    ->name('show');
            });
        });

        Route::prefix('komersialisasi')->name('komersialisasi.')->group(function () {
            Route::get('/', [AdminController::class, 'adminKomersialisasi'])->name('index');
            // submenu goes here
            // Route::resource('berita', BeritaController::class);

        });

        Route::prefix('kontak')->name('kontak.')->group(function () {
            Route::get('/', [CollaborationContactController::class, 'index'])->name('index');
            Route::get('/export', [CollaborationContactController::class, 'exportCSV'])->name('export');
            Route::get('/{collaboration}', [CollaborationContactController::class, 'show'])->name('show');
            Route::delete('/{collaboration}', [CollaborationContactController::class, 'destroy'])->name('destroy');
            Route::post('/{collaboration}/mark-read', [CollaborationContactController::class, 'markAsRead'])->name('mark-read');
        });

        // Route::resource('fasilitas', FasilitasController::class);
        Route::resource('fasilitas', FasilitasController::class);
        Route::patch('fasilitas/{id}/tampil-beranda', [FasilitasController::class, 'updateTampilBeranda'])->name('fasilitas.updateTampilBeranda');
        Route::patch('fasilitas/{id}/urutan', [FasilitasController::class, 'updateUrutan'])->name('fasilitas.updateUrutan');

        // Route::prefix('fasilitas')->name('fasilitas.')->group(function () {
        //     // Route::get('/', [AdminController::class, 'adminFasilitas'])->name('index');
        //     Route::resource(FasilitasController::class);
        //     // Route::resource('berita', BeritaController::class);

        // });
        // Route::prefix('kontak')->name('kontak.')->group(function () {
        //     Route::get('/', [AdminController::class, 'adminKontak'])->name('index');
        //     // submenu goes here
        //     // Route::resource('berita', BeritaController::class);

        // });

        Route::prefix('penelitian')->name('penelitian.')->group(function () {
            Route::get('/', [AdminController::class, 'adminPenelitian'])->name('index');
            Route::resource('publikasi-terindeks', PublikasiTerindeksController::class)
                ->parameters(['publikasi-terindeks' => 'publikasi_terindeks']);
            Route::resource('kegiatan-penelitian', KegiatanPenelitianController::class);
            Route::resource('kerjasama-riset', KerjasamaRisetController::class);
            // Seminar routes dengan semua method
            Route::resource('seminar', SeminarController::class);
            
            // Route untuk toggle status (gunakan id bukan model binding)
            Route::post('seminar/{id}/toggle-published', 
                [SeminarController::class, 'togglePublished'])
                ->name('seminar.toggle-published');
            
            Route::post('seminar/{id}/toggle-featured', 
                [SeminarController::class, 'toggleFeatured'])
                ->name('seminar.toggle-featured');
            
            Route::post('seminar/{id}/toggle-cancelled', 
                [SeminarController::class, 'toggleCancelled'])
                ->name('seminar.toggle-cancelled');

            Route::post('publikasi-terindeks/{publikasi_terindeks}/toggle-status', 
                [PublikasiTerindeksController::class, 'toggleStatus'])
                ->name('publikasi-terindeks.toggle-status');
                
            // Route untuk download
            Route::get('publikasi-terindeks/{publikasi_terindeks}/download', 
                [PublikasiTerindeksController::class, 'downloadPdf'])
                ->name('publikasi-terindeks.download');
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

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Rute Dashboard Utama (Misalnya, /dashboard atau /admin)
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard'); // Ubah ke nama rute non-admin
    // API endpoint untuk chart data
    Route::get('/dashboard/chart-data', [DashboardController::class, 'chartData'])
        ->name('admin.dashboard.chart-data');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::prefix('publikasi-data')->name('publikasi-data.')->group(function () {
            Route::get('/', [AdminController::class, 'adminPublikasiData'])->name('index');
            // submenu goes here
            Route::resource('berita', BeritaController::class);
            Route::resource('koleksi-dokumen', AdminKoleksiDokumenController::class);
            
            // Dokumen (seperti GaleriMedia)
            Route::resource('dokumen', DokumenController::class);
            Route::get('/dokumen/{id}/view', [DokumenController::class, 'view'])->name('dokumen.view');
            Route::get('/dokumen/{id}/download', [DokumenController::class, 'download'])->name('dokumen.download');
            Route::prefix('galeri')->name('galeri.')->group(function () {
                // Album galeri (CRUD)
                Route::resource('albums', GaleriAlbumController::class);
                // Media di dalam album (nested resource, shallow biar URL edit/delete simple)
                // Media - SIMPLE VERSION
                Route::get('media', [GaleriMediaController::class, 'index'])->name('media.index');
                Route::get('media/create', [GaleriMediaController::class, 'create'])->name('media.create');
                Route::post('media', [GaleriMediaController::class, 'store'])->name('media.store');
                Route::get('media/{media}/edit', [GaleriMediaController::class, 'edit'])->name('media.edit');
                Route::put('media/{media}', [GaleriMediaController::class, 'update'])->name('media.update');
                Route::delete('media/{media}', [GaleriMediaController::class, 'destroy'])->name('media.destroy');
                Route::post('media/{media}/set-utama', [GaleriMediaController::class, 'setUtama'])->name('media.set-utama');
            });
            Route::resource('artikel', ArtikelController::class);

            Route::prefix('komentar')->name('komentar.')->group(function () {
                // Index komentar (semua atau per artikel)
                Route::get('/', [AdminKomentarController::class, 'index'])->name('index');
                
                // Komentar per artikel
                Route::get('/artikel/{artikel}', [AdminKomentarController::class, 'byArtikel'])
                    ->name('by-artikel');
                
                // Approve komentar
                Route::post('/{komentar}/approve', [AdminKomentarController::class, 'approve'])
                    ->name('approve');
                
                // Reject komentar
                Route::post('/{komentar}/reject', [AdminKomentarController::class, 'reject'])
                    ->name('reject');
                
                // Bulk actions
                Route::post('/bulk-action', [AdminKomentarController::class, 'bulkAction'])
                    ->name('bulk-action');
                
                // Hapus komentar
                Route::delete('/{komentar}', [AdminKomentarController::class, 'destroy'])
                    ->name('destroy');
                
                // Preview komentar
                Route::get('/{komentar}', [AdminKomentarController::class, 'show'])
                    ->name('show');
            });
        });
    });
    });