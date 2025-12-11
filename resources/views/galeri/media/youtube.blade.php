@extends('layout-web.app')

@section('title', 'Galeri YouTube — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Galeri YouTube')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-12">
                <div class="w-20 h-20 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <i class="fab fa-youtube text-red-600 text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Galeri YouTube</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Koleksi video YouTube dokumentasi kegiatan, webinar, tutorial, 
                    dan konten edukasi pelestarian bahasa dan sastra daerah.
                </p>
            </div>

            {{-- Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                    <div>
                        <div class="text-2xl font-bold text-red-600">{{ $youtubes->total() }}</div>
                        <div class="text-sm text-gray-600">Total Video</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-600">{{ $albumCount }}</div>
                        <div class="text-sm text-gray-600">Album</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ $latestYear }}</div>
                        <div class="text-sm text-gray-600">Tahun Terbaru</div>
                    </div>
                </div>
            </div>

            {{-- Filter --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-4">
                        <select id="filterAlbum" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">Semua Album</option>
                            @foreach($albumList as $id => $judul)
                                <option value="{{ $id }}" {{ request('album_id') == $id ? 'selected' : '' }}>
                                    {{ $judul }}
                                </option>
                            @endforeach
                        </select>

                        <select id="filterTahun" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-red-500">
                            <option value="">Semua Tahun</option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-center space-x-3">
                        <a href="{{ route('galeri.media.index') }}" class="text-gray-600 hover:text-gray-800 transition-colors">
                            <i class="fas fa-arrow-left mr-1"></i>Semua Media
                        </a>
                        <a href="{{ route('galeri.media.foto') }}" class="bg-green-100 text-green-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-green-200 transition-colors">
                            Lihat Foto
                        </a>
                    </div>
                </div>
            </div>

            {{-- YouTube Grid --}}
            @if($youtubes->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($youtubes as $youtube)
                        <div class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                            {{-- YouTube Thumbnail --}}
                            <div class="relative aspect-video bg-gray-900 overflow-hidden cursor-pointer" 
                                 onclick="playYouTube('{{ $youtube->id }}', '{{ $youtube->youtube_url }}')">
                                <div class="w-full h-full bg-gradient-to-br from-red-50 to-red-100 flex items-center justify-center">
                                    <i class="fab fa-youtube text-red-600 text-5xl"></i>
                                </div>
                                
                                {{-- Play Button --}}
                                <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                                    <div class="w-16 h-16 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors">
                                        <i class="fas fa-play text-white text-xl ml-1"></i>
                                    </div>
                                </div>

                                {{-- Album Badge --}}
                                <div class="absolute top-3 left-3 bg-black bg-opacity-60 text-white px-2 py-1 rounded text-xs">
                                    {{ Str::limit($youtube->album->judul, 20) }}
                                </div>

                                {{-- YouTube Badge --}}
                                <div class="absolute bottom-3 right-3 bg-red-600 text-white px-2 py-1 rounded text-xs">
                                    <i class="fab fa-youtube mr-1"></i>YouTube
                                </div>
                            </div>

                            {{-- YouTube Info --}}
                            <div class="p-4">
                                <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">
                                    {{ $youtube->judul }}
                                </h3>
                                
                                @if($youtube->keterangan)
                                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                        {{ $youtube->keterangan }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-sm text-gray-500">
                                    <div class="flex items-center space-x-4">
                                        @if($youtube->taken_at)
                                            <span class="flex items-center">
                                                <i class="fas fa-calendar mr-1"></i>
                                                {{ $youtube->taken_at->format('d M Y') }}
                                            </span>
                                        @endif
                                        
                                        @if($youtube->is_utama)
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">
                                                <i class="fas fa-star mr-1"></i>Utama
                                            </span>
                                        @endif
                                    </div>

                                    <button class="text-red-600 hover:text-red-800 transition-colors flex items-center" 
                                            onclick="playYouTube('{{ $youtube->id }}', '{{ $youtube->youtube_url }}')">
                                        <i class="fab fa-youtube mr-1"></i>Putar
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $youtubes->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-red-100 flex items-center justify-center">
                        <i class="fab fa-youtube text-red-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada video YouTube</h3>
                    <p class="text-gray-600 mb-4">
                        Saat ini belum ada video YouTube yang tersedia dalam galeri.
                    </p>
                    <a href="{{ route('galeri.media.index') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-red-600 transition-colors">
                        Lihat Semua Media
                    </a>
                </div>
            @endif

            {{-- YouTube Modal --}}
            <div id="youtubeModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg w-full max-w-4xl mx-4">
                    <div class="flex justify-between items-center p-4 border-b">
                        <h3 id="youtubeModalTitle" class="text-lg font-semibold"></h3>
                        <button onclick="closeYouTube()" class="text-gray-500 hover:text-gray-700">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                    <div class="p-4">
                        <div id="youtubePlayer" class="w-full aspect-video rounded bg-gray-900">
                            <!-- YouTube iframe will be inserted here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function extractYouTubeId(url) {
    const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
    const match = url.match(regExp);
    return (match && match[7].length === 11) ? match[7] : null;
}

function playYouTube(mediaId, youtubeUrl) {
    const modal = document.getElementById('youtubeModal');
    const title = document.getElementById('youtubeModalTitle');
    const playerContainer = document.getElementById('youtubePlayer');
    
    const videoId = extractYouTubeId(youtubeUrl);
    if (!videoId) {
        alert('URL YouTube tidak valid');
        return;
    }

    // Set title (you might want to fetch the actual title via API)
    title.textContent = 'Memuat video YouTube...';
    
    // Create iframe
    playerContainer.innerHTML = `
        <iframe 
            src="https://www.youtube.com/embed/${videoId}?autoplay=1" 
            frameborder="0" 
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
            allowfullscreen
            class="w-full h-full rounded"
        ></iframe>
    `;
    
    modal.classList.remove('hidden');
}

function closeYouTube() {
    const modal = document.getElementById('youtubeModal');
    const playerContainer = document.getElementById('youtubePlayer');
    
    // Stop video by removing iframe
    playerContainer.innerHTML = '';
    modal.classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('youtubeModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeYouTube();
    }
});
</script>
@endsection