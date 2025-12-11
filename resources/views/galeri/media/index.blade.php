@extends('layout-web.app')

@section('title', 'Galeri Media — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Galeri Media')

@section('content')
<div class="mb-20 px-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-12">
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Jelajahi koleksi lengkap foto, video, dan konten YouTube dari berbagai 
                    kegiatan pelestarian bahasa dan sastra daerah.
                </p>
            </div>

            {{-- Filter Section --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
                <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                    <div class="flex flex-wrap gap-4">
                        {{-- Filter Tipe Media --}}
                        <select id="filterTipe" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Tipe</option>
                            <option value="foto" {{ request('tipe') == 'foto' ? 'selected' : '' }}>Foto</option>
                            <option value="video" {{ request('tipe') == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="youtube" {{ request('tipe') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                        </select>

                        {{-- Filter Album --}}
                        <select id="filterAlbum" class="border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Semua Album</option>
                            @foreach($albumList as $id => $judul)
                                <option value="{{ $id }}" {{ request('album_id') == $id ? 'selected' : '' }}>
                                    {{ $judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Quick Links --}}
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('galeri.media.foto') }}" class="bg-green-100 text-green-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-green-200 transition-colors">
                            <i class="fas fa-camera mr-1"></i>Foto
                        </a>
                        <a href="{{ route('galeri.media.video') }}" class="bg-blue-100 text-blue-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-blue-200 transition-colors">
                            <i class="fas fa-video mr-1"></i>Video
                        </a>
                        <a href="{{ route('galeri.media.youtube') }}" class="bg-red-100 text-red-800 px-3 py-2 rounded-lg text-sm font-medium hover:bg-red-200 transition-colors">
                            <i class="fab fa-youtube mr-1"></i>YouTube
                        </a>
                    </div>
                </div>

                {{-- Search --}}
                <div class="mt-4">
                    <div class="relative max-w-md mx-auto md:mx-0">
                        <input 
                            type="text" 
                            id="searchInput" 
                            placeholder="Cari media..." 
                            value="{{ request('search') }}"
                            class="border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                        >
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-search text-gray-400"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Media Grid --}}
            @if($media->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 mb-8">
                    @foreach($media as $item)
                        @include('components.galeri.media-card', ['media' => $item])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $media->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-images text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Tidak ada media ditemukan</h3>
                    <p class="text-gray-600 mb-4">
                        Coba ubah filter pencarian atau lihat koleksi berdasarkan tipe media.
                    </p>
                    <div class="flex justify-center space-x-3">
                        <a href="{{ route('galeri.media.foto') }}" class="bg-green-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-600 transition-colors">
                            Lihat Foto
                        </a>
                        <a href="{{ route('galeri.media.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-600 transition-colors">
                            Tampilkan Semua
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterTipe = document.getElementById('filterTipe');
    const filterAlbum = document.getElementById('filterAlbum');
    const searchInput = document.getElementById('searchInput');

    function applyFilters() {
        const params = new URLSearchParams();
        
        if (filterTipe.value) params.set('tipe', filterTipe.value);
        if (filterAlbum.value) params.set('album_id', filterAlbum.value);
        if (searchInput.value) params.set('search', searchInput.value);

        window.location.href = '{{ route('galeri.media.index') }}?' + params.toString();
    }

    filterTipe.addEventListener('change', applyFilters);
    filterAlbum.addEventListener('change', applyFilters);
    
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 500);
    });
});
</script>
@endsection