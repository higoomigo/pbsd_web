<?php

namespace App\Http\Controllers;

use App\Models\GaleriMedia;
use App\Models\GaleriAlbum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Response;


class GaleriMediaController extends Controller
{
    /**
     * Menampilkan semua media dari semua album (gallery global)
     */
    public function index(Request $request)
    {
        $query = GaleriMedia::with(['album' => function($q) {
                $q->published();
            }])
            ->whereHas('album', function($q) {
                $q->published();
            })
            ->urutan();

        // Filter by tipe media
        if ($request->has('tipe') && in_array($request->tipe, ['foto', 'video', 'youtube'])) {
            $query->where('tipe', $request->tipe);
        }

        // Filter by album
        if ($request->has('album_id') && $request->album_id) {
            $query->where('galeri_album_id', $request->album_id);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('album', function($q2) use ($search) {
                      $q2->where('judul', 'like', "%{$search}%")
                         ->orWhere('kategori', 'like', "%{$search}%");
                  });
            });
        }

        $media = $query->paginate(24);

        // Data untuk filter
        $albumList = GaleriAlbum::published()
            ->has('media')
            ->orderBy('judul')
            ->pluck('judul', 'id');

        return view('galeri.media.index', compact('media', 'albumList'));
    }

    /**
     * Menampilkan media foto saja
     */
    public function foto(Request $request)
    {
        $query = GaleriMedia::with(['album' => function($q) {
                $q->published();
            }])
            ->whereHas('album', function($q) {
                $q->published();
            })
            ->where('tipe', 'foto')
            ->urutan();

        // Filter by album
        if ($request->has('album_id') && $request->album_id) {
            $query->where('galeri_album_id', $request->album_id);
        }

        // Filter by tahun
        if ($request->has('tahun') && $request->tahun) {
            $query->whereHas('album', function($q) use ($request) {
                $q->where('tahun', $request->tahun);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('album', function($q2) use ($search) {
                      $q2->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $fotos = $query->paginate(20);

        // Data untuk filter dan stats
        $albumList = GaleriAlbum::published()
            ->has('media')
            ->whereHas('media', function($q) {
                $q->where('tipe', 'foto');
            })
            ->orderBy('judul')
            ->pluck('judul', 'id');

        $tahunList = GaleriAlbum::published()
            ->whereHas('media', function($q) {
                $q->where('tipe', 'foto');
            })
            ->whereNotNull('tahun')
            ->distinct()
            ->pluck('tahun')
            ->filter()
            ->sortDesc();

        // Stats untuk view
        $albumCount = $albumList->count();
        $tahunCount = $tahunList->count();
        $latestYear = $tahunList->first();

        return view('galeri.media.foto', compact(
            'fotos', 
            'albumList', 
            'tahunList',
            'albumCount',
            'tahunCount',
            'latestYear'
        ));
    }

    /**
     * Menampilkan media video saja (uploaded video)
     */
    public function video(Request $request)
    {
        $query = GaleriMedia::with(['album' => function($q) {
                $q->published();
            }])
            ->whereHas('album', function($q) {
                $q->published();
            })
            ->where('tipe', 'video')
            ->urutan();

        // Filter by album
        if ($request->has('album_id') && $request->album_id) {
            $query->where('galeri_album_id', $request->album_id);
        }

        // Filter by tahun
        if ($request->has('tahun') && $request->tahun) {
            $query->whereHas('album', function($q) use ($request) {
                $q->where('tahun', $request->tahun);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('album', function($q2) use ($search) {
                      $q2->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $videos = $query->paginate(12);

        // Data untuk filter
        $albumList = GaleriAlbum::published()
            ->has('media')
            ->whereHas('media', function($q) {
                $q->where('tipe', 'video');
            })
            ->orderBy('judul')
            ->pluck('judul', 'id');

        $tahunList = GaleriAlbum::published()
            ->whereHas('media', function($q) {
                $q->where('tipe', 'video');
            })
            ->whereNotNull('tahun')
            ->distinct()
            ->pluck('tahun')
            ->filter()
            ->sortDesc();

        return view('galeri.media.video', compact('videos', 'albumList', 'tahunList'));
    }

    /**
     * Menampilkan media YouTube saja
     */
    public function youtube(Request $request)
    {
        $query = GaleriMedia::with(['album' => function($q) {
                $q->published();
            }])
            ->whereHas('album', function($q) {
                $q->published();
            })
            ->where('tipe', 'youtube')
            ->urutan();

        // Filter by album
        if ($request->has('album_id') && $request->album_id) {
            $query->where('galeri_album_id', $request->album_id);
        }

        // Filter by tahun
        if ($request->has('tahun') && $request->tahun) {
            $query->whereHas('album', function($q) use ($request) {
                $q->where('tahun', $request->tahun);
            });
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('judul', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('album', function($q2) use ($search) {
                      $q2->where('judul', 'like', "%{$search}%");
                  });
            });
        }

        $youtubes = $query->paginate(12);

        // Data untuk filter dan stats
        $albumList = GaleriAlbum::published()
            ->has('media')
            ->whereHas('media', function($q) {
                $q->where('tipe', 'youtube');
            })
            ->orderBy('judul')
            ->pluck('judul', 'id');

        $tahunList = GaleriAlbum::published()
            ->whereHas('media', function($q) {
                $q->where('tipe', 'youtube');
            })
            ->whereNotNull('tahun')
            ->distinct()
            ->pluck('tahun')
            ->filter()
            ->sortDesc();

        // Stats untuk view
        $albumCount = $albumList->count();
        $latestYear = $tahunList->first();

        return view('galeri.media.youtube', compact(
            'youtubes', 
            'albumList', 
            'tahunList',
            'albumCount',
            'latestYear'
        ));
    }

    /**
     * Menampilkan detail single media
     */
    public function show(GaleriMedia $media)
    {
        // Pastikan media bisa diakses
        if (!$media->album->is_published || $media->album->published_at > now()) {
            abort(404);
        }

        $media->load('album');

        // Media terkait dalam album yang sama
        $mediaTerkait = GaleriMedia::where('galeri_album_id', $media->galeri_album_id)
            ->where('id', '!=', $media->id)
            ->whereHas('album', function($q) {
                $q->published();
            })
            ->urutan()
            ->limit(6)
            ->get();

        return view('galeri.media.show', compact('media', 'mediaTerkait'));
    }

    /**
     * Download media file (jika diizinkan)
     */
    public function download(GaleriMedia $media)
    {
        // Pastikan media bisa diakses
        if (!$media->album->is_published || $media->album->published_at > now()) {
            abort(404);
        }

        // Hanya untuk file yang ada dan tipe foto/video
        if (!in_array($media->tipe, ['foto', 'video']) || !$media->file_path) {
            abort(404);
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($media->file_path)) {
            abort(404, 'File tidak ditemukan.');
        }

        // Dapatkan extension file
        $extension = pathinfo($media->file_path, PATHINFO_EXTENSION);
        $filename = Str::slug($media->judul) . '.' . $extension;

        // Increment download count jika ada field
        if (in_array('download_count', $media->getFillable())) {
            $media->increment('download_count');
        }

        return Storage::disk('public')->download($media->file_path, $filename);
    }

    /**
     * Stream video untuk player
     */
    public function streamVideo(GaleriMedia $media)
    {
        // Pastikan media bisa diakses dan bertipe video
        if (!$media->album->is_published || $media->album->published_at > now() || $media->tipe !== 'video') {
            abort(404);
        }

        // Pastikan file exists
        if (!$media->file_path || !Storage::disk('public')->exists($media->file_path)) {
            abort(404);
        }

        $path = Storage::disk('public')->path($media->file_path);
        
        // Get file size for headers
        $size = Storage::disk('public')->size($media->file_path);
        $mime = $this->getMimeType($media->file_path);

        // Basic video streaming headers
        $headers = [
            'Content-Type' => $mime,
            'Content-Length' => $size,
            'Content-Disposition' => 'inline',
            'Cache-Control' => 'public, max-age=3600',
        ];

        return response()->file($path, $headers);
    }

    /**
     * API untuk mengambil data media (untuk AJAX/JSON)
     */
    public function apiMedia(Request $request)
{
    $query = GaleriMedia::with(['album' => function($q) {
            $q->published()->select('id', 'judul', 'slug', 'cover_path');
        }])
        ->whereHas('album', function($q) {
            $q->published();
        })
        ->urutan();

    if ($request->has('album_id')) {
        $query->where('galeri_album_id', $request->album_id);
    }

    if ($request->has('tipe')) {
        $query->where('tipe', $request->tipe);
    }

    if ($request->has('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('keterangan', 'like', "%{$search}%")
              ->orWhereHas('album', function($q2) use ($search) {
                  $q2->where('judul', 'like', "%{$search}%");
              });
        });
    }

    $perPage = $request->get('per_page', 12);
    $media = $query->paginate($perPage);

    // Transform data untuk response - FIX: gunakan asset()
    $media->getCollection()->transform(function ($item) {
        return [
            'id' => $item->id,
            'judul' => $item->judul,
            'keterangan' => $item->keterangan,
            'tipe' => $item->tipe,
            'file_path' => $item->file_path ? asset('storage/' . $item->file_path) : null,
            'thumbnail_path' => $item->thumbnail_path ? asset('storage/' . $item->thumbnail_path) : null,
            'youtube_url' => $item->youtube_url,
            'is_utama' => $item->is_utama,
            'taken_at' => $item->taken_at?->format('d M Y'),
            'album' => [
                'id' => $item->album->id,
                'judul' => $item->album->judul,
                'slug' => $item->album->slug,
                'cover_path' => $item->album->cover_path ? asset('storage/' . $item->album->cover_path) : null,
            ]
        ];
    });

    return response()->json([
        'data' => $media->items(),
        'current_page' => $media->currentPage(),
        'last_page' => $media->lastPage(),
        'per_page' => $media->perPage(),
        'total' => $media->total(),
    ]);
}

    /**
     * Get mime type based on file extension
     */
    private function getMimeType($filePath)
    {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        
        $mimeTypes = [
            'mp4' => 'video/mp4',
            'mov' => 'video/quicktime',
            'avi' => 'video/x-msvideo',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'webp' => 'image/webp',
        ];

        return $mimeTypes[$extension] ?? 'application/octet-stream';
    }

    /**
     * Get media stats for dashboard
     */
    public function stats()
    {
        $totalMedia = GaleriMedia::whereHas('album', function($q) {
            $q->published();
        })->count();

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

        $latestMedia = GaleriMedia::with('album')
            ->whereHas('album', function($q) {
                $q->published();
            })
            ->latest()
            ->limit(5)
            ->get();

        return response()->json([
            'total_media' => $totalMedia,
            'total_fotos' => $totalFotos,
            'total_videos' => $totalVideos,
            'total_youtubes' => $totalYoutubes,
            'latest_media' => $latestMedia
        ]);
    }
}