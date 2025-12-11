<?php

namespace App\Http\Controllers;

use App\Models\GaleriAlbum;
use App\Models\GaleriMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;

class GaleriAlbumController extends Controller
{
    /**
     * Menampilkan beranda galeri dengan stats dan album unggulan
     */
    public function beranda()
    {
        // Featured albums for homepage
        $albums = GaleriAlbum::published()
            ->where('tampil_beranda', true)
            ->with(['media' => function($query) {
                $query->urutan()->limit(4);
            }])
            ->withCount('media')
            ->orderBy('urutan', 'asc')
            ->orderBy('published_at', 'desc')
            ->limit(6)
            ->get();

        // Stats for homepage
        $totalAlbums = GaleriAlbum::published()->count();
        $totalFotos = GaleriMedia::where('tipe', 'foto')
            ->whereHas('album', function($q) {
                $q->published();
            })->count();
        $totalVideos = GaleriMedia::where('tipe', 'video')
            ->whereHas('album', function($q) {
                $q->published();
            })->count();
        $totalYoutubes = GaleriMedia::where('tipe', 'youtube')
            ->whereHas('album', function($q) {
                $q->published();
            })->count();
        $totalAllMedia = $totalFotos + $totalVideos + $totalYoutubes;

        // Additional stats
        $latestAlbum = GaleriAlbum::published()->latest('published_at')->first();
        $activeYears = GaleriAlbum::published()->distinct('tahun')->count('tahun');
        $lastUpdate = GaleriAlbum::published()->latest('updated_at')->first()?->updated_at;

        return view('galeri.albums.beranda', compact(
            'albums',
            'totalAlbums',
            'totalFotos', 
            'totalVideos',
            'totalYoutubes',
            'totalAllMedia',
            'latestAlbum',
            'activeYears',
            'lastUpdate'
        ));
    }

    /**
     * Menampilkan daftar semua album galeri yang dipublikasi
     */
    public function index(Request $request)
    {
        $query = GaleriAlbum::published()
            ->withCount('media')
            ->orderBy('urutan', 'asc')
            ->orderBy('published_at', 'desc');

        // Filter by kategori
        if ($request->has('kategori') && $request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by tahun
        if ($request->has('tahun') && $request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('deskripsi_singkat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%");
            });
        }

        $albums = $query->paginate(12);
        
        // Data untuk filter
        $kategoriList = GaleriAlbum::published()
            ->whereNotNull('kategori')
            ->distinct()
            ->pluck('kategori')
            ->filter()
            ->sort();

        $tahunList = GaleriAlbum::published()
            ->whereNotNull('tahun')
            ->distinct()
            ->pluck('tahun')
            ->filter()
            ->sortDesc();

        return view('galeri.albums.index', compact('albums', 'kategoriList', 'tahunList'));
    }

    /**
     * Menampilkan detail album dan media di dalamnya
     */
    public function show(Request $request, $slug)
    {
        Log::info('Mencari album dengan slug:', ['slug' => $slug]);
        
        $album = GaleriAlbum::published()
            ->where('slug', $slug)
            ->withCount('media')
            ->first();
        if (!$album) {
            Log::error('Album tidak ditemukan:', ['slug' => $slug]);
            abort(404);
        }
        
        // Increment view count
        // $album->increment('views');
        
        // Get active tab
        $activeTab = $request->get('tab', 'foto');
        
        // Get media by type
        $fotos = $album->media()
            ->tipe('foto')
            ->urutan()
            ->get();

        $videos = $album->media()
            ->tipe('video')
            ->urutan()
            ->get();

        $youtubes = $album->media()
            ->tipe('youtube')
            ->urutan()
            ->get();

        // Get all media
        $allMedia = $album->media()
            ->urutan()
            ->get();

        return view('galeri.albums.show', compact(
            'album',
            'fotos',
            'videos',
            'youtubes',
            'allMedia',
            'activeTab'
        ));
    }

    /**
     * Menampilkan preview media (lightbox/detail modal)
     */
    public function showMedia(GaleriAlbum $album, GaleriMedia $media)
    {
        // Pastikan media termasuk dalam album
        if ($media->galeri_album_id !== $album->id) {
            abort(404);
        }

        // Pastikan album published
        if (!$album->is_published || $album->published_at > now()) {
            abort(404);
        }

        $media->load('album');

        // Media sebelumnya dan berikutnya dalam album
        $previousMedia = GaleriMedia::where('galeri_album_id', $album->id)
            ->where('id', '<', $media->id)
            ->urutan()
            ->first();

        $nextMedia = GaleriMedia::where('galeri_album_id', $album->id)
            ->where('id', '>', $media->id)
            ->urutan()
            ->first();

        return view('galeri.media.show', compact(
            'album', 
            'media', 
            'previousMedia', 
            'nextMedia'
        ));
    }

    protected function youtubeEmbedId(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                $url = $attributes['youtube_url'] ?? '';
                if (empty($url)) {
                    return null;
                }
                
                $pattern = '/(?:youtu\.be\/|v=|embed\/|watch\?v=|&v=)([^&?]*)/i';
                
                if (preg_match($pattern, $url, $matches)) {
                    return $matches[1];
                }

                return null;
            }
        );
    }

    private function extractYouTubeId($url)
{
        if (!$url) return '';
        
        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&?#]+)/', $url, $matches);
        
        return $matches[1] ?? '';
    }
}