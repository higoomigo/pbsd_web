<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Berita;
use App\Models\VisiMisi;
use App\Http\Controller\VisiMisiController;
use App\Models\User;
use App\Models\Penelitian;
use App\Models\PublikasiTerindeks;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    // Route::get('/admin/profil', [AdminController::class, 'adminProfil'])->name('admin.profil');
    // Route::get('/admin/akademik', [AdminController::class, 'adminAkademik'])->name('admin.akademik');
    // Route::get('/admin/komersialisasi', [AdminController::class, 'adminKomersialisasi'])->name('admin.komersialisasi');
    // Route::get('/admin/fasilitas', [AdminController::class, 'adminFasilitas'])->name('admin.fasilitas');
    // Route::get('/admin/publikasi-data', [AdminController::class, 'adminPublikasiData'])->name('admin.publikasi-data');
    // Route::get('/admin/kontak', [AdminController::class, 'adminKontak'])->name('admin.kontak');

    /**
     * Menampilkan daftar semua user
     */

    // public function __construct()
    // {
    //     $this->middleware(function ($request, $next) {
    //         // Skip untuk route publikasi
    //         if ($request->routeIs('admin.publikasi-data.*') || 
    //             $request->routeIs('admin.upload.inline')) {
    //             return $next($request);
    //         }
            
    //         // Cek admin untuk route lainnya
    //         if (auth()->user()->role !== 'admin') {
    //             abort(403, 'Hanya admin yang bisa mengakses halaman ini.');
    //         }
            
    //         return $next($request);
    //     });
    // }


    


    public function index(Request $request)
    {
        // // Cek role admin
        // if (auth()->user()->role !== 'admin') {
        //     abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        // }

        $query = User::query();
        
        // Filter berdasarkan role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }
        
        // Search by name atau email
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        $users = $query->latest()->paginate(10);
        $roles = User::getRoles();
        
        return view('admin.user.index', compact('users', 'roles'));
    }

    /**
     * Menampilkan form untuk edit user
     */
    public function edit(User $user)
    {
        $assignableRoles = User::getAssignableRoles();
        return view('admin.user.edit', compact('user', 'assignableRoles'));
    }

    /**
     * Update data user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:' . implode(',', array_keys(User::getAssignableRoles()))],
        ]);

        $user->update($validated);
        
        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus user
     */
    public function destroy(User $user)
    {
        // Jangan hapus admin sendiri
        if (auth()->id() === $user->id) {
            return redirect()->back()
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        
        $user->delete();
        
        return redirect()->route('admin.user.index')
            ->with('success', 'User berhasil dihapus!');
    }

    /**
     * Verifikasi user (ubah role dari pending ke user)
     */
    public function verify(User $user)
    {
        $user->update(['role' => User::ROLE_USER]);
        
        return redirect()->back()
            ->with('success', 'User berhasil diverifikasi!');
    }

    public function adminProfil()
    {
        // $visimisi = VisiMisi::find(1);
        // return view('admin.profil.index', compact('visimisi'));
        // Cek role admin
        // if (auth()->user()->role !== 'admin') {
        //     abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        // }
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

    public function adminPenelitian()
    {
        $publikasiTerindeks = PublikasiTerindeks::all();
        return to_route('admin.penelitian.publikasi-terindeks.index');
    }


    // public function adminKontak()
    // {
    //     return view('admin.kontak.index');
    // }
}
