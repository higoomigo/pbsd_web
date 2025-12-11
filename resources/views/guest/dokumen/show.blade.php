@extends('layout-web.app')

@section('title', $dokumen->judul . ' — Repositori Dokumen')
@section('judul_halaman', 'Detail Dokumen')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb --}}
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('welcome') }}" class="hover:text-blue-600 transition-colors">Beranda</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <a href="{{ route('guest.dokumen.koleksi.index') }}" class="hover:text-blue-600 transition-colors">Repositori Dokumen</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-gray-900">{{ Str::limit($dokumen->judul, 40) }}</span>
                    </li>
                </ol>
            </nav>

            {{-- Main Content --}}
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                
                {{-- Header --}}
                <div class="bg-gray-50 px-6 py-8 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
                        
                        {{-- Icon Dokumen --}}
                        <div class="flex-shrink-0">
                            @if($dokumen->file_digital_path)
                                @php
                                    $extension = pathinfo($dokumen->file_digital_path, PATHINFO_EXTENSION);
                                    $iconColor = match(strtolower($extension)) {
                                        'pdf' => 'text-red-600 bg-red-100 border-red-200',
                                        'jpg', 'jpeg', 'png', 'webp' => 'text-green-600 bg-green-100 border-green-200',
                                        'tiff' => 'text-blue-600 bg-blue-100 border-blue-200',
                                        default => 'text-gray-600 bg-gray-100 border-gray-200'
                                    };
                                @endphp
                                <div class="w-20 h-20 rounded-2xl {{ $iconColor }} border-4 border-white shadow-lg flex items-center justify-center">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-2xl bg-gray-100 border-4 border-white shadow-lg flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Informasi Utama --}}
                        <div class="flex-1">
                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                                <div class="flex-1">
                                    <h1 class="text-2xl font-bold text-gray-900 mb-3 leading-tight">
                                        {{ $dokumen->judul }}
                                    </h1>
                                    
                                    {{-- Badges --}}
                                    <div class="flex flex-wrap gap-2 mb-4">
                                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 text-sm rounded-full border border-blue-200 font-medium">
                                            {{ $dokumen->koleksi->judul }}
                                        </span>
                                        @if($dokumen->kategori)
                                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full border border-gray-200">
                                                {{ $dokumen->kategori }}
                                            </span>
                                        @endif
                                        @if($dokumen->file_digital_path)
                                            @php
                                                $extension = pathinfo($dokumen->file_digital_path, PATHINFO_EXTENSION);
                                            $fileColor = match(strtolower($extension)) {
                                                'pdf' => 'bg-red-100 text-red-800 border-red-200',
                                                'jpg', 'jpeg', 'png', 'webp' => 'bg-green-100 text-green-800 border-green-200',
                                                'tiff' => 'bg-blue-100 text-blue-800 border-blue-200',
                                                default => 'bg-gray-100 text-gray-800 border-gray-200'
                                            };
                                            $fileType = strtoupper($extension);
                                            $fileSize = Storage::disk('public')->size($dokumen->file_digital_path);
                                            $fileSizeFormatted = number_format($fileSize / 1024 / 1024, 2) . ' MB';
                                        @endphp
                                        <span class="inline-block px-3 py-1 {{ $fileColor }} text-sm rounded-full border font-medium">
                                            {{ $fileType }} • {{ $fileSizeFormatted }}
                                        </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex flex-col sm:flex-row lg:flex-col gap-2">
                                    @if($dokumen->file_digital_path)
                                        <a href="{{ route('guest.dokumen.download', $dokumen->id) }}" 
                                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download File
                                        </a>
                                    @endif
                                    <a href="{{ route('guest.dokumen.koleksi.index') }}" 
                                       class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                        </svg>
                                        Kembali
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {{-- Main Content --}}
                        <div class="lg:col-span-2 space-y-8">
                            
                            {{-- Ringkasan --}}
                            @if($dokumen->ringkasan)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Ringkasan</h2>
                                    <div class="prose prose-gray max-w-none">
                                        <p class="text-gray-600 leading-relaxed whitespace-pre-line">
                                            {{ $dokumen->ringkasan }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            {{-- Preview File --}}
                            @if($dokumen->file_digital_path)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Pratinjau Dokumen</h2>
                                    <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center">
                                        @if(in_array(pathinfo($dokumen->file_digital_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'webp']))
                                            {{-- Preview Gambar --}}
                                            <div class="max-w-2xl mx-auto">
                                                <img src="{{ Storage::url($dokumen->file_digital_path) }}" 
                                                     alt="Preview {{ $dokumen->judul }}"
                                                     class="rounded-lg shadow-sm max-h-96 mx-auto">
                                                <p class="text-sm text-gray-500 mt-3">
                                                    Klik tombol Download di atas untuk mendapatkan file resolusi penuh.
                                                </p>
                                            </div>
                                        @else
                                            {{-- Preview untuk file non-gambar --}}
                                            <div class="flex flex-col items-center justify-center py-8">
                                                <div class="w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                    </svg>
                                                </div>
                                                <p class="text-gray-600 mb-4">
                                                    File {{ strtoupper(pathinfo($dokumen->file_digital_path, PATHINFO_EXTENSION)) }} tersedia untuk diunduh.
                                                </p>
                                                <a href="{{ route('guest.dokumen.download', $dokumen->id) }}" 
                                                   class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                                    </svg>
                                                    Download File ({{ number_format(Storage::disk('public')->size($dokumen->file_digital_path) / 1024 / 1024, 2) }} MB)
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Catatan --}}
                            @if($dokumen->catatan)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-4">Catatan</h2>
                                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                        <p class="text-yellow-800 leading-relaxed whitespace-pre-line">
                                            {{ $dokumen->catatan }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Sidebar Metadata --}}
                        <div class="space-y-6">
                            
                            {{-- Informasi Dokumen --}}
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-4 text-lg">Informasi Dokumen</h3>
                                <div class="space-y-4">
                                    @if($dokumen->kode)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Kode</span>
                                            <p class="text-gray-900 font-mono text-sm">{{ $dokumen->kode }}</p>
                                        </div>
                                    @endif

                                    @if($dokumen->tahun_terbit)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Tahun Terbit</span>
                                            <p class="text-gray-900">{{ $dokumen->tahun_terbit }}</p>
                                        </div>
                                    @endif

                                    @if($dokumen->tanggal_terbit)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Tanggal Terbit</span>
                                            <p class="text-gray-900">{{ $dokumen->tanggal_terbit->format('d F Y') }}</p>
                                        </div>
                                    @endif

                                    @if($dokumen->format_asli)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Format Asli</span>
                                            <p class="text-gray-900">{{ $dokumen->format_asli }}</p>
                                        </div>
                                    @endif

                                    @if($dokumen->prioritas)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Prioritas</span>
                                            <div class="flex items-center gap-2">
                                                <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                    <div class="bg-blue-600 h-2 rounded-full" style="width: {{ ($dokumen->prioritas / 10) * 100 }}%"></div>
                                                </div>
                                                <span class="text-sm text-gray-600">{{ $dokumen->prioritas }}/10</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Informasi Sumber --}}
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-4 text-lg">Informasi Sumber</h3>
                                <div class="space-y-4">
                                    @if($dokumen->sumber)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Sumber</span>
                                            <p class="text-gray-900">{{ $dokumen->sumber }}</p>
                                        </div>
                                    @endif

                                    @if($dokumen->lembaga)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Lembaga</span>
                                            <p class="text-gray-900">{{ $dokumen->lembaga }}</p>
                                        </div>
                                    @endif

                                    @if($dokumen->lokasi_fisik)
                                        <div>
                                            <span class="block text-sm font-medium text-gray-700 mb-1">Lokasi Fisik</span>
                                            <p class="text-gray-900">{{ $dokumen->lokasi_fisik }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Quick Actions --}}
                            <div class="bg-blue-50 rounded-lg p-6 border border-blue-200">
                                <h3 class="font-semibold text-blue-900 mb-4">Aksi Cepat</h3>
                                <div class="space-y-3">
                                    <a href="{{ route('guest.dokumen.koleksi.index') }}" 
                                       class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-white border border-blue-300 text-blue-700 text-sm font-medium rounded-lg hover:bg-blue-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                        Lihat Semua Dokumen
                                    </a>
                                    @if($dokumen->file_digital_path)
                                        <a href="{{ route('guest.dokumen.download', $dokumen->id) }}" 
                                           class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download File
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection