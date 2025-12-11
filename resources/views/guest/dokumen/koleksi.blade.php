@extends('layout-web.app')

@section('title', 'Koleksi Dokumen — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Repositori Dokumen')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <p class="text-lg text-gray-700 mb-6">
                Telusuri koleksi digital dokumen, naskah, dan publikasi terkait 
                pelestarian bahasa dan sastra daerah yang dikelola oleh Pusat Studi.
            </p>
            {{-- Hero Section --}}
            {{-- <div class="bg-gradient-to-r from-zinc-50 to-indigo-50 rounded-2xl p-8 mb-10">
                <div class="max-w-3xl">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Koleksi Digital</h1>
                    
                    
                    {{-- Statistik --}}
                    {{-- <div class="flex flex-wrap gap-6">
                        <div class="bg-white  px-5 py-3 shadow-sm border border-zinc-100">
                            <div class="text-2xl font-bold text-zinc-700">{{ $totalKoleksi }}</div>
                            <div class="text-sm text-gray-600">Koleksi</div>
                        </div>
                        <div class="bg-white  px-5 py-3 shadow-sm border border-zinc-100">
                            <div class="text-2xl font-bold text-zinc-700">{{ $totalDokumen }}</div>
                            <div class="text-sm text-gray-600">Total Dokumen</div>
                        </div>
                    </div>
                </div>
            </div>  --}}

            {{-- Sorting Options --}}
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="text-gray-700">
                        Menampilkan <span class="font-semibold">{{ $koleksis->total() }}</span> koleksi
                    </div>
                    
                    <div class="flex items-center gap-3">
                        <span class="text-sm text-gray-600">Urutkan:</span>
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}" 
                               class="px-3 py-1.5 text-sm rounded-full {{ request('sort', 'terbaru') == 'terbaru' ? 'bg-zinc-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Terbaru
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'a-z']) }}" 
                               class="px-3 py-1.5 text-sm rounded-full {{ request('sort') == 'a-z' ? 'bg-zinc-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                A-Z
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'z-a']) }}" 
                               class="px-3 py-1.5 text-sm rounded-full {{ request('sort') == 'z-a' ? 'bg-zinc-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Z-A
                            </a>
                            <a href="{{ request()->fullUrlWithQuery(['sort' => 'populer']) }}" 
                               class="px-3 py-1.5 text-sm rounded-full {{ request('sort') == 'populer' ? 'bg-zinc-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                                Terpopuler
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grid Koleksi --}}
            @if($koleksis->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($koleksis as $koleksi)
                        <div class="group">
                            <div class="bg-white  border border-gray-200 overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 h-full flex flex-col">
                                
                                {{-- Cover Image --}}
                                <div class="relative h-56 bg-gradient-to-br from-zinc-50 to-gray-50 overflow-hidden">
                                    @if($koleksi->cover_path)
                                        <img src="{{ Storage::url($koleksi->cover_path) }}" 
                                             alt="{{ $koleksi->judul }}"
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="text-center p-6">
                                                <div class="w-16 h-16 mx-auto mb-3 bg-zinc-100 rounded-full flex items-center justify-center">
                                                    <svg class="w-8 h-8 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                    </svg>
                                                </div>
                                                <p class="text-sm text-gray-500">Tidak ada gambar sampul</p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    {{-- Overlay Gradient --}}
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    
                                    {{-- Badges --}}
                                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                                        {{-- @if($koleksi->kategori)
                                            <span class="inline-block px-3 py-1 bg-white/95 backdrop-blur-sm text-zinc-700 text-xs font-semibold rounded-full shadow-sm">
                                                {{ $koleksi->kategori }}
                                            </span>
                                        @endif --}}
                                        
                                        {{-- @if($koleksi->is_published && $koleksi->tampil_beranda)
                                            <span class="inline-block px-3 py-1 bg-yellow-500/95 text-white text-xs font-semibold rounded-full shadow-sm">
                                                <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                Unggulan
                                            </span>
                                        @endif --}}
                                    </div>
                                    
                                    {{-- Dokumen Count --}}
                                    <div class="absolute bottom-4 right-4">
                                        <div class="bg-white/95 backdrop-blur-sm px-4 py-2 rounded-full shadow-lg">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-zinc-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                <span class="font-bold text-zinc-700">{{ $koleksi->dokumen_count ?? 0 }}</span>
                                                <span class="text-sm text-gray-600">dokumen</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Content --}}
                                <div class="p-6 flex-1 flex flex-col">
                                    {{-- Judul --}}
                                    <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-2 group-hover:text-zinc-600 transition-colors">
                                        <a href="{{ route('guest.dokumen.koleksi.show', $koleksi->id) }}">
                                            {{ $koleksi->judul }}
                                        </a>
                                    </h3>

                                    {{-- Deskripsi --}}
                                    @if($koleksi->deskripsi_singkat)
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-1">
                                            {{ $koleksi->deskripsi_singkat }}
                                        </p>
                                    @endif

                                    {{-- Metadata --}}
                                    {{-- <div class="space-y-3 text-sm text-gray-500 mb-6"> --}}
                                        {{-- Tahun --}}
                                        {{-- @if($koleksi->tahun_mulai)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                <span>
                                                    @if($koleksi->tahun_selesai && $koleksi->tahun_selesai != $koleksi->tahun_mulai)
                                                        Periode: {{ $koleksi->tahun_mulai }} - {{ $koleksi->tahun_selesai }}
                                                    @else
                                                        Tahun: {{ $koleksi->tahun_mulai }}
                                                    @endif
                                                </span>
                                            </div>
                                        @endif --}}

                                        {{-- Lembaga --}}
                                        {{-- @if($koleksi->lembaga)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                </svg>
                                                <span class="line-clamp-1">{{ $koleksi->lembaga }}</span>
                                            </div>
                                        @endif --}}

                                        {{-- Sumber --}}
                                        {{-- @if($koleksi->sumber)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="line-clamp-1">Sumber: {{ $koleksi->sumber }}</span>
                                            </div>
                                        @endif --}}

                                        {{-- View Count --}}
                                        {{-- @if($koleksi->view_count > 0)
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                                <span>{{ number_format($koleksi->view_count) }} dilihat</span>
                                            </div>
                                        @endif
                                    </div> --}}

                                    {{-- Action Button --}}
                                    <div class="pt-4 border-t border-gray-100 mt-auto">
                                        <a href="{{ route('guest.dokumen.koleksi.show', $koleksi->id) }}" 
                                           class="w-full inline-flex items-center justify-center px-2 py-2 bg-zinc-600 text-white text-sm  hover:bg-zinc-700 transition-all duration-300 group">
                                            <span>Lihat Dokumen</span>
                                            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
                    <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Belum ada koleksi tersedia</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">
                        Saat ini belum ada koleksi dokumen yang dipublikasikan. Silakan kunjungi kembali nanti.
                    </p>
                    <a href="{{ route('welcome') }}" 
                       class="inline-flex items-center px-5 py-3 bg-zinc-600 text-white font-medium  hover:bg-zinc-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Beranda
                    </a>
                </div>
            @endif

            {{-- Pagination --}}
            @if($koleksis->hasPages())
                <div class="mt-12">
                    <div class="flex justify-center">
                        <div class="bg-white  border border-gray-200 px-6 py-4 shadow-sm">
                            {{ $koleksis->withQueryString()->links() }}
                        </div>
                    </div>
                    
                    {{-- Pagination Info --}}
                    <div class="text-center mt-4 text-gray-600 text-sm">
                        Menampilkan <span class="font-semibold">{{ $koleksis->firstItem() }}</span> - 
                        <span class="font-semibold">{{ $koleksis->lastItem() }}</span> dari 
                        <span class="font-semibold">{{ $koleksis->total() }}</span> koleksi
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection