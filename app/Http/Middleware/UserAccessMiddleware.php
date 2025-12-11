<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Route;

class UserAccessMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek user sudah login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Cek jika user pending
        if ($user->role === 'pending') {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->withErrors(['email' => 'Akun Anda belum diverifikasi admin.']);
        }

        // Jika user biasa (role = 'user'), cek akses
        if ($user->role === 'user') {
            $currentRoute = $request->route()->getName();
            
            // Route yang boleh diakses user biasa
            $allowedRoutes = [
                'admin.dashboard',
                'profile.edit',
                'profile.update',
                'profile.destroy',
                'admin.publikasi-data.index',
                'admin.publikasi-data.berita.index',
                'admin.publikasi-data.berita.create',
                'admin.publikasi-data.berita.store',
                'admin.publikasi-data.berita.edit',
                'admin.publikasi-data.berita.update',
                'admin.publikasi-data.berita.show',
                'admin.publikasi-data.berita.destroy',
                'admin.publikasi-data.dokumen.index',
                'admin.publikasi-data.dokumen.create',
                'admin.publikasi-data.dokumen.store',
                'admin.publikasi-data.dokumen.edit',
                'admin.publikasi-data.dokumen.update',
                'admin.publikasi-data.dokumen.show',
                'admin.publikasi-data.dokumen.destroy',
                'admin.publikasi-data.dokumen.view',
                'admin.publikasi-data.galeri.albums.index',
                'admin.publikasi-data.galeri.albums.create',
                'admin.publikasi-data.galeri.albums.store',
                'admin.publikasi-data.galeri.albums.edit',
                'admin.publikasi-data.galeri.albums.update',
                'admin.publikasi-data.galeri.albums.show',
                'admin.publikasi-data.galeri.albums.destroy',
                'admin.publikasi-data.galeri.media.index',
                'admin.publikasi-data.galeri.media.create',
                'admin.publikasi-data.galeri.media.store',
                'admin.publikasi-data.galeri.media.edit',
                'admin.publikasi-data.galeri.media.update',
                'admin.publikasi-data.galeri.media.destroy',
                'admin.publikasi-data.galeri.media.set-utama',
                'admin.publikasi-data.artikel.index',
                'admin.publikasi-data.artikel.create',
                'admin.publikasi-data.artikel.store',
                'admin.publikasi-data.artikel.edit',
                'admin.publikasi-data.artikel.update',
                'admin.publikasi-data.artikel.show',
                'admin.publikasi-data.artikel.destroy',
                'admin.publikasi-data.komentar.index',
                'admin.publikasi-data.komentar.by-artikel',
                'admin.publikasi-data.komentar.approve',
                'admin.publikasi-data.komentar.reject',
                'admin.publikasi-data.komentar.bulk-action',
                'admin.publikasi-data.komentar.destroy',
                'admin.publikasi-data.komentar.show',
                'admin.upload.inline',
            ];
            
            // Jika bukan route yang diizinkan, redirect ke dashboard
            if (!in_array($currentRoute, $allowedRoutes)) {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'Anda hanya bisa mengakses dashboard dan publikasi.');
            }
        }

        return $next($request);
    }
}