@extends('layout-web.app')
@section('title', $koleksi->judul . ' — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Repositori Dokumen')
@section('content')

<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        {{-- <li>
                            <a href="{{ route('welcome') }}" class="text-gray-500 hover:text-blue-600 text-sm">
                                Beranda
                            </a>
                        </li> --}}
                        {{-- <li>
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </li> --}}
                        <li>
                            <a href="{{ route('guest.dokumen.koleksi.index') }}" class="text-gray-500 hover:text-blue-600 text-sm">
                                Koleksi
                            </a>
                        </li>
                        <li>
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </li>
                        <li aria-current="page">
                            <span class="text-blue-600 font-medium text-sm">{{ Str::limit($koleksi->judul, 40) }}</span>
                        </li>
                    </ol>
                </nav>
            </div>

            
            {{-- <div class="bg-white -2xl border border-gray-200 p-8 mb-8 shadow-sm">
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="lg:w-1/3">
                        <div class="bg-gradient-to-br from-blue-50 to-gray-50 -xl overflow-hidden shadow-md">
                            @if($koleksi->cover_path)
                                <img src="{{ Storage::url($koleksi->cover_path) }}" 
                                     alt="{{ $koleksi->judul }}"
                                     class="w-full h-64 object-cover">
                            @else
                                <div class="w-full h-64 flex items-center justify-center">
                                    <div class="text-center">
                                        <div class="w-20 h-20 mx-auto mb-3 bg-blue-100 -full flex items-center justify-center">
                                            <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm text-gray-500">Tidak ada gambar sampul</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    
                    <div class="lg:w-2/3">
                        
                        <div class="flex flex-wrap gap-2 mb-4">
                            @if($koleksi->kategori)
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm font-medium -full">
                                    {{ $koleksi->kategori }}
                                </span>
                            @endif
                            
                            @if($koleksi->is_published && $koleksi->tampil_beranda)
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-sm font-medium -full">
                                    Koleksi Unggulan
                                </span>
                            @endif
                            
                            <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium -full">
                                {{ $koleksi->dokumen_count ?? 0 }} Dokumen
                            </span>
                        </div>

                        
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $koleksi->judul }}</h1>

                        
                        @if($koleksi->deskripsi_singkat)
                            <p class="text-gray-700 text-lg mb-6 leading-relaxed">
                                {{ $koleksi->deskripsi_singkat }}
                            </p>
                        @endif

                        @if($koleksi->deskripsi_lengkap)
                            <div class="prose prose-blue max-w-none mb-6">
                                {!! nl2br(e($koleksi->deskripsi_lengkap)) !!}
                            </div>
                        @endif

                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            @if($koleksi->tahun_mulai)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 -lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Periode</div>
                                        <div class="font-medium text-gray-900">
                                            @if($koleksi->tahun_selesai && $koleksi->tahun_selesai != $koleksi->tahun_mulai)
                                                {{ $koleksi->tahun_mulai }} - {{ $koleksi->tahun_selesai }}
                                            @else
                                                {{ $koleksi->tahun_mulai }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            @if($koleksi->lembaga)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 -lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Lembaga</div>
                                        <div class="font-medium text-gray-900">{{ $koleksi->lembaga }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($koleksi->lokasi_fisik)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 -lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Lokasi Fisik</div>
                                        <div class="font-medium text-gray-900">{{ $koleksi->lokasi_fisik }}</div>
                                    </div>
                                </div>
                            @endif

                            @if($koleksi->sumber)
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-blue-50 -lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Sumber</div>
                                        <div class="font-medium text-gray-900">{{ $koleksi->sumber }}</div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        
                        <div class="flex items-center gap-6 text-sm text-gray-600">
                            @if($koleksi->view_count > 0)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{ number_format($koleksi->view_count) }} dilihat
                                </div>
                            @endif
                            
                            @if($koleksi->published_at)
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Dipublikasikan: {{ \Carbon\Carbon::parse($koleksi->published_at)->translatedFormat('d F Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div> --}}

            
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">Dokumen dalam Arsip</h2>
                    <p class="text-gray-600 mt-1">
                        {{ $dokumens->total() }} dokumen tersedia
                    </p>
                </div>
                
                
                <div class="flex items-center gap-3">
                    <span class="text-sm text-gray-600">Urutkan:</span>
                    <select class="px-4 py-2 border border-gray-300 -lg focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option>Terbaru</option>
                        <option>A-Z</option>
                        <option>Z-A</option>
                        <option>Terpopuler</option>
                    </select>
                </div>
            </div>

            {{-- Dokumen List --}}
            @if($dokumens->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($dokumens as $dokumen)
                        <div class="bg-white -xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition-shadow">
                            {{-- File Type Icon --}}
                            <div class="flex items-center gap-4 mb-4">
                                <div class="flex-shrink-0">
                                    @php
                                        $extension = $dokumen->file_digital_path ? 
                                            pathinfo($dokumen->file_digital_path, PATHINFO_EXTENSION) : 
                                            ($dokumen->google_drive_id ? 'cloud' : 'unknown');
                                        
                                        $iconConfig = match(strtolower($extension)) {
                                            'pdf' => ['color' => 'bg-red-100 text-red-600', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                            'jpg', 'jpeg', 'png', 'webp' => ['color' => 'bg-green-100 text-green-600', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                                            'doc', 'docx' => ['color' => 'bg-blue-100 text-blue-600', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                            'xls', 'xlsx' => ['color' => 'bg-green-100 text-green-600', 'icon' => 'M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                                            'cloud' => ['color' => 'bg-yellow-100 text-yellow-600', 'icon' => 'M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4 4 0 003 15z'],
                                            default => ['color' => 'bg-gray-100 text-gray-600', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z']
                                        };
                                    @endphp
                                    <div class="w-12 h-12 {{ $iconConfig['color'] }} -lg flex items-center justify-center">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconConfig['icon'] }}"/>
                                        </svg>
                                    </div>
                                </div>
                                
                                <div>
                                    <h3 class="font-semibold text-gray-900 text-lg mb-2 line-clamp-2">
                                        <a href="{{ route('guest.dokumen.show', $dokumen->id) }}" class="hover:text-blue-600">
                                            {{ $dokumen->judul }}
                                        </a>
                                    </h3>
                                    {{-- @if($dokumen->is_utama)
                                        <span class="inline-block px-2 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium ">
                                            Utama
                                        </span>
                                    @endif
                                    @if($dokumen->kategori)
                                        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs font-medium  ml-1">
                                            {{ $dokumen->kategori }}
                                        </span>
                                    @endif --}}
                                </div>
                            </div>

                            {{-- Dokumen Info --}}
                            

                            @if($dokumen->deskripsi_singkat)
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                    {{ $dokumen->deskripsi_singkat }}
                                </p>
                            @endif

                            {{-- Metadata --}}
                            <div class="space-y-2 text-xs text-gray-500 mb-4">
                                @if($dokumen->tahun_terbit)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $dokumen->tahun_terbit }}</span>
                                    </div>
                                @endif

                                @if($dokumen->penulis)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                        <span>{{ Str::limit($dokumen->penulis, 30) }}</span>
                                    </div>
                                @endif

                                {{-- @if($dokumen->view_count > 0)
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span>{{ number_format($dokumen->view_count) }} dilihat</span>
                                    </div>
                                @endif --}}
                            </div>

                            {{-- Actions --}}
                            <div class="flex gap-2">
                                <a href="{{ route('guest.dokumen.show', $dokumen->id) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium hover:bg-gray-50">
                                    Detail
                                </a>
                                
                                @if($dokumen->file_digital_path || $dokumen->google_drive_id)
                                    <a href="{{ $dokumen->file_digital_path ? route('guest.dokumen.download', $dokumen->id) : $dokumen->google_drive_link }}" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium hover:bg-blue-700"
                                       @if(!$dokumen->file_digital_path) target="_blank" rel="noopener noreferrer" @endif>
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                        </svg>
                                        Unduh
                                    </a>
                                @endif
                                @if($dokumen->google_drive_link)
                                    <a href="{{ $dokumen->google_drive_link }}" 
                                       class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium hover:bg-green-700"
                                       target="_blank" rel="noopener noreferrer">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                        </svg>
                                        Buka di Drive
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Pagination --}}
                @if($dokumens->hasPages())
                    <div class="mt-8">
                        <div class="flex justify-center">
                            <div class="bg-white -lg border border-gray-200 px-4 py-3 shadow-sm">
                                {{ $dokumens->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            @else
                {{-- Empty State for Dokumen --}}
                <div class="bg-white -2xl border border-gray-200 p-12 text-center">
                    <div class="w-20 h-20 mx-auto mb-6 bg-gray-100 -full flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Belum ada dokumen</h3>
                    <p class="text-gray-600 mb-6">
                        Saat ini belum ada dokumen yang tersedia dalam koleksi ini.
                    </p>
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
</style>
@endsection