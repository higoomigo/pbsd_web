<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/visi-misi', [UserController::class, 'visiMisi'])->name('visi-misi');
Route::get('/struktur-organisasi', [UserController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
Route::get('/tim-peneliti', [UserController::class, 'timPeneliti'])->name('tim-peneliti');
Route::get('/kontak', [UserController::class, 'kontak'])->name('kontak');
Route::get('/berita-pusat-studi', [UserController::class, 'berita'])->name('berita');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

