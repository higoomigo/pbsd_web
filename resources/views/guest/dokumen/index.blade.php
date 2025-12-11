@extends('layout-web.app')

@section('title', 'Koleksi Dokumen — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Koleksi Dokumen')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Statistik --}}
            <div class="text-center mb-10">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Koleksi Digital</h1>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Telusuri koleksi digital dokumen, naskah, dan publikasi terkait 
                    pelestarian bahasa dan sastra daerah.
                </p>
                <div class="flex justify-center gap-6 mt-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-700">{{ $totalKoleksi }}</div>
                        <div class="text-sm text-gray-600">Koleksi</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-700">{{ $totalDokumen }}</div>
                        <div class="text-sm text-gray-600">Total Dokumen</div>
                    </div>
                </div>
            </div>

            {{-- Grid Koleksi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($koleksiList as $koleksi)
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                        
                        {{-- Cover Image --}}
                        <div class="h-48 bg-gray-100 overflow-hidden relative">
                            @if($koleksi->cover_path)
                                <img src="{{ Storage::url($koleksi->cover_path) }}" 
                                     alt="{{ $koleksi->judul }}"
                                     class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                            @endif
                            
                            {{-- Kategori Badge --}}
                            @if($koleksi->kategori)
                                <div class="absolute top-4 left-4">
                                    <span class="inline-block px-3 py-1 bg-white/90 backdrop-blur-sm text-blue-700 text-xs font-semibold rounded-full shadow-sm">
                                        {{ $koleksi->kategori }}
                                    </span>
                                </div>
                            @endif
                            
                            {{-- Jumlah Dokumen --}}
                            <div class="absolute bottom-4 right-4">
                                <div class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold shadow-lg">
                                    {{ $koleksi->dokumen_count ?? 0 }} dokumen
                                </div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-6">
                            {{-- Judul Koleksi --}}
                            <h3 class="font-bold text-xl text-gray-900 mb-3 line-clamp-1">
                                <a href="{{ route('guest.dokumen.koleksi.show', $koleksi->id) }}" 
                                   class="hover:text-blue-600 transition-colors">
                                    {{ $koleksi->judul }}
                                </a>
                            </h3>

                            {{-- Deskripsi --}}
                            @if($koleksi->deskripsi_singkat)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                    {{ $koleksi->deskripsi_singkat }}
                                </p>
                            @endif

                            {{-- Metadata --}}
                            <div class="space-y-2 text-sm text-gray-500 mb-6">
                                {{-- Tahun --}}
                                @if($koleksi->tahun_mulai)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>
                                            @if($koleksi->tahun_selesai && $koleksi->tahun_selesai != $koleksi->tahun_mulai)
                                                {{ $koleksi->tahun_mulai }} - {{ $koleksi->tahun_selesai }}
                                            @else
                                                {{ $koleksi->tahun_mulai }}
                                            @endif
                                        </span>
                                    </div>
                                @endif

                                {{-- Lembaga --}}
                                @if($koleksi->lembaga)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="line-clamp-1">{{ $koleksi->lembaga }}</span>
                                    </div>
                                @endif

                                {{-- Lokasi --}}
                                @if($koleksi->lokasi_fisik)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <span class="line-clamp-1">{{ $koleksi->lokasi_fisik }}</span>
                                    </div>
                                @endif
                            </div>

                            {{-- Action Button --}}
                            <div class="pt-4 border-t border-gray-100">
                                <a href="{{ route('guest.dokumen.koleksi.show', $koleksi->id) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors group">
                                    <span>Lihat Koleksi</span>
                                    <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Empty State --}}
                    <div class="col-span-full bg-white rounded-xl border border-gray-200 p-12 text-center">
                        <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 rounded-full flex items-center justify-center">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-3">Belum ada koleksi tersedia</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">
                            Saat ini belum ada koleksi dokumen yang dipublikasikan.
                        </p>
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center px-5 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            {{-- @if($koleksiList->hasPages())
                <div class="mt-10 flex justify-center">
                    <div class="bg-white rounded-lg border border-gray-200 px-4 py-3 shadow-sm">
                        {{ $koleksiList->links() }}
                    </div>
                </div>
            @endif --}}

        </div>
    </div>
</div>

<style>
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection