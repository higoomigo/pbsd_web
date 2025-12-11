@extends('layout-web.app')

@section('title', $peneliti->nama . ' — Profil Peneliti')
@section('judul_halaman', 'Profil Peneliti')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Breadcrumb --}}
            <nav class="mb-8">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('welcome') }}" class="hover:text-blue-600">Beranda</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <a href="{{ route('guest.peneliti.index') }}" class="hover:text-blue-600">Profil Peneliti</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                        <span class="text-gray-900">{{ $peneliti->nama }}</span>
                    </li>
                </ol>
            </nav>

            {{-- Main Content --}}
            <div class="bg-white  border border-gray-300 shadow-sm overflow-hidden">
                
                {{-- Header --}}
                <div class="bg-gray-50 px-6 py-8 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row items-center gap-6">
                        
                        {{-- Foto --}}
                        <div class="flex-shrink-0">
                            @if($peneliti->foto_path)
                                <div class="w-24 h-24 rounded-full bg-white border-4 border-white shadow-lg overflow-hidden">
                                    <img src="{{ Storage::url($peneliti->foto_path) }}" 
                                         alt="Foto {{ $peneliti->nama }}"
                                         class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-24 h-24 rounded-full bg-blue-100 border-4 border-white shadow-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        {{-- Info --}}
                        <div class="text-center md:text-left">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ $peneliti->nama }}
                            </h1>
                            
                            @if($peneliti->posisi)
                                @php
                                    $badgeColor = match($peneliti->posisi) {
                                        'Internal' => 'bg-blue-100 text-blue-800 border-blue-200',
                                        'Eksternal' => 'bg-green-100 text-green-800 border-green-200',
                                        'Kolaborator' => 'bg-purple-100 text-purple-800 border-purple-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200'
                                    };
                                @endphp
                                <div class="mb-2">
                                    <span class="inline-block px-3 py-1 {{ $badgeColor }} text-sm rounded-full border">
                                        {{ $peneliti->posisi }}
                                    </span>
                                </div>
                            @endif

                            @if($peneliti->jabatan)
                                <p class="text-gray-600 mb-3 text-lg">
                                    {{ $peneliti->jabatan }}
                                </p>
                            @endif

                            {{-- Bidang Keahlian --}}
                            @if($peneliti->bidang_keahlian)
                                <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                                    @foreach($peneliti->bidang_keahlian as $bidang)
                                        <span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 text-sm rounded-full">
                                            {{ $bidang }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Content --}}
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        {{-- Main Content --}}
                        <div class="lg:col-span-2 space-y-6">
                            
                            {{-- Deskripsi Singkat --}}
                            @if($peneliti->deskripsi_singkat)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Profil Singkat</h2>
                                    <p class="text-gray-600 leading-relaxed">
                                        {{ $peneliti->deskripsi_singkat }}
                                    </p>
                                </div>
                            @endif

                            {{-- Biografi --}}
                            @if($peneliti->biografi)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Biografi</h2>
                                    <div class="text-gray-600 leading-relaxed whitespace-pre-line">
                                        {{ $peneliti->biografi }}
                                    </div>
                                </div>
                            @endif

                            {{-- Pendidikan --}}
                            @if($peneliti->riwayat_pendidikan)
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Riwayat Pendidikan</h2>
                                    <div class="text-gray-600 leading-relaxed whitespace-pre-line">
                                        {{ $peneliti->riwayat_pendidikan }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Sidebar --}}
                        <div class="space-y-6">
                            
                            {{-- Kontak --}}
                            <div class="bg-gray-50  p-4 border border-gray-200">
                                <h3 class="font-semibold text-gray-900 mb-3">Kontak</h3>
                                <div class="space-y-2">
                                    @if($peneliti->email)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="text-sm text-gray-600">{{ $peneliti->email }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Tombol Kembali --}}
                            <div>
                                <a href="{{ route('guest.peneliti.index') }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium  hover:bg-gray-50 transition-colors">
                                    Kembali ke Daftar Peneliti
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection