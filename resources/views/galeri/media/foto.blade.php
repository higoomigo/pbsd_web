@extends('layout-web.app')

@section('title', 'Galeri Foto — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Galeri Foto')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-12">
                <div class="w-20 h-20 mx-auto mb-4 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-camera text-green-600 text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Galeri Foto</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Koleksi dokumentasi foto kegiatan penelitian, workshop, dan acara 
                    pelestarian bahasa dan sastra daerah.
                </p>
            </div>

            {{-- Stats --}}
            <div class="bg-white rounded-xl border border-gray-200 p-6 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 text-center">
                    <div>
                        <div class="text-2xl font-bold text-green-600">{{ $fotos->total() }}</div>
                        <div class="text-sm text-gray-600">Total Foto</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-600">{{ $albumCount }}</div>
                        <div class="text-sm text-gray-600">Album</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-600">{{ $tahunCount }}</div>
                        <div class="text-sm text-gray-600">Tahun Aktif</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-yellow-600">{{ $latestYear }}</div>
                        <div class="text-sm text-gray-600">Tahun Terbaru</div>
                    </div>
                </div>
            </div>

            {{-- Filter --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-4">
                        <select id="filterAlbum" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <option value="">Semua Album</option>
                            @foreach($albumList as $id => $judul)
                                <option value="{{ $id }}" {{ request('album_id') == $id ? 'selected' : '' }}>
                                    {{ $judul }}
                                </option>
                            @endforeach
                        </select>

                        <select id="filterTahun" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
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
                        <a href="{{ route('galeri.media.video') }}" class="bg-blue-100 text-blue-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-200 transition-colors">
                            Lihat Video
                        </a>
                    </div>
                </div>
            </div>

            {{-- Photos Grid --}}
            @if($fotos->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-8">
                    @foreach($fotos as $foto)
                        <div class="group relative bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300">
                            <div class="relative aspect-square bg-gray-100 overflow-hidden">
                                <img 
                                    src="{{ asset('storage/' . $foto->file_path) }}" 
                                    alt="{{ $foto->judul }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                                    loading="lazy"
                                >
                                <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300 flex items-center justify-center">
                                    <div class="opacity-0 group-hover:opacity-100 transform translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                        <i class="fas fa-search-plus text-white text-2xl"></i>
                                    </div>
                                </div>
                                
                                {{-- Album Badge --}}
                                <div class="absolute top-2 left-2 bg-black bg-opacity-60 text-white px-2 py-1 rounded text-xs">
                                    {{ Str::limit($foto->album->judul, 15) }}
                                </div>

                                @if($foto->is_utama)
                                    <div class="absolute top-2 right-2 bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                                        <i class="fas fa-star mr-1"></i>Utama
                                    </div>
                                @endif
                            </div>

                            {{-- Photo Info --}}
                            <div class="p-3">
                                <h3 class="font-medium text-gray-900 text-sm mb-1 line-clamp-2">
                                    {{ $foto->judul }}
                                </h3>
                                
                                @if($foto->keterangan)
                                    <p class="text-gray-600 text-xs line-clamp-2 mb-2">
                                        {{ $foto->keterangan }}
                                    </p>
                                @endif

                                <div class="flex items-center justify-between text-xs text-gray-500">
                                    @if($foto->taken_at)
                                        <span>{{ $foto->taken_at->format('d M Y') }}</span>
                                    @else
                                        <span>&nbsp;</span>
                                    @endif
                                    
                                    <div class="flex items-center space-x-2">
                                        <button class="text-green-600 hover:text-green-800 transition-colors" onclick="previewPhoto('{{ $foto->id }}')">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <a href="{{ asset('storage/' . $foto->file_path) }}" 
                                           download 
                                           class="text-blue-600 hover:text-blue-800 transition-colors">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $fotos->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-green-100 flex items-center justify-center">
                        <i class="fas fa-camera text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Belum ada foto</h3>
                    <p class="text-gray-600">
                        Saat ini belum ada foto yang tersedia dalam galeri.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function previewPhoto(photoId) {
    // Implement lightbox functionality here
    console.log('Preview photo:', photoId);
}

document.addEventListener('DOMContentLoaded', function() {
    const filterAlbum = document.getElementById('filterAlbum');
    const filterTahun = document.getElementById('filterTahun');

    function applyFilters() {
        const params = new URLSearchParams();
        
        if (filterAlbum.value) params.set('album_id', filterAlbum.value);
        if (filterTahun.value) params.set('tahun', filterTahun.value);

        window.location.href = '{{ route('galeri.media.foto') }}?' + params.toString();
    }

    filterAlbum.addEventListener('change', applyFilters);
    filterTahun.addEventListener('change', applyFilters);
});
</script>
@endsection