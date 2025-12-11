@extends('layout-web.app')

@section('title', 'Galeri Album — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Galeri Album')

@section('content')
<div class="w-full px-8 sm:px-6 lg:px-28">
    <div class="mb-20">
        <div class="">
            {{-- Header --}}
            <div class="text-center">
                <p class="text-base sm:text-lg text-gray-600 mx-auto text-justify sm:text-start">
                    Koleksi dokumentasi visual kegiatan penelitian, pelestarian bahasa, 
                    dan sastra daerah yang telah dilakukan oleh tim kami.
                </p>
            </div>

            {{-- Filter Section --}}
            <div class=" py-4 sm:py-6 mb-6 sm:mb-8">
                <div class="flex flex-col sm:flex-col md:flex-row gap-4 items-stretch sm:items-center justify-between">
                    <div class="flex flex-col sm:flex-row gap-4">
                        {{-- Filter Kategori --}}
                        <select id="filterKategori" 
                                class="border border-gray-300  px-3 sm:px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kategori)
                                <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                                    {{ $kategori }}
                                </option>
                            @endforeach
                        </select>

                        {{-- Filter Tahun --}}
                        <select id="filterTahun" 
                                class="border border-gray-300  px-3 sm:px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full sm:w-auto">
                            <option value="">Semua Tahun </option>
                            @foreach($tahunList as $tahun)
                                <option value="{{ $tahun }}" {{ request('tahun') == $tahun ? 'selected' : '' }}>
                                    {{ $tahun }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Search --}}
                    <div class="w-full sm:w-auto">
                        <div class="relative">
                            <input 
                                type="text" 
                                id="searchInput" 
                                placeholder="Cari album..." 
                                value="{{ request('search') }}"
                                class="border border-gray-300  pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 w-full"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Albums Grid --}}
            @if($albums->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
                    @foreach($albums as $album)
                        @include('components.galeri.album-card', ['album' => $album])
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8 px-4 sm:px-0">
                    {{ $albums->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white border border-gray-200 p-6 sm:p-8 md:p-12 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-images text-gray-400 text-lg sm:text-xl"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-2">Belum ada album galeri</h3>
                    <p class="text-sm sm:text-base text-gray-600">
                        Saat ini belum ada album galeri yang tersedia.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const filterKategori = document.getElementById('filterKategori');
    const filterTahun = document.getElementById('filterTahun');
    const searchInput = document.getElementById('searchInput');

    function applyFilters() {
        const params = new URLSearchParams();
        
        if (filterKategori.value) params.set('kategori', filterKategori.value);
        if (filterTahun.value) params.set('tahun', filterTahun.value);
        if (searchInput.value) params.set('search', searchInput.value);

        window.location.href = '{{ route('galeri.albums.index') }}?' + params.toString();
    }

    filterKategori.addEventListener('change', applyFilters);
    filterTahun.addEventListener('change', applyFilters);
    
    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(applyFilters, 500);
    });
});
</script>
@endsection