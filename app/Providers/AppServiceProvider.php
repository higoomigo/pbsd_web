<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Models\Berita;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layout-web.app', function ($view) {
            // Jangan tampilkan aside di halaman berita (index & show)
            $hideForThisPage =
            request()->routeIs('guest.berita.*') ||
            // request()->routeIs('mitra') ||
            request()->routeIs('guest.artikel.*') ||
            // request()->routeIs('welcome') ||
            request()->routeIs('guest.peneliti.*') ||
            request()->routeIs('guest.kegiatan-penelitian.*') ||
            request()->routeIs('guest.kerjasama-riset.*') ||
            // request()->routeIs('guest.publikasi-terindeks.show') ||
            
            request()->routeIs('galeri.*') ||
            request()->is('/');

            if ($hideForThisPage) {
                // Pastikan flag diset supaya layout tahu sidebar off
                $view->with('showAside', false);
                return; // jangan query sidebarBerita
            }

            $sidebarBerita = Berita::published()
                ->latest('published_at')
                ->take(5)
                ->get(['id','judul','slug','ringkasan','thumbnail_path','published_at','author_id','kategori']);

            $view->with('sidebarBerita', $sidebarBerita);
        });
    }
}
