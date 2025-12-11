@extends('layout-web.app')

@section('title', 'Fasilitas — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Fasilitas Kami')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="grid lg:grid-cols-1 gap-6 mb-6 md:pb-12 bg-base-100">

            {{-- Deskripsi Halaman Fasilitas --}}
            <div class="px-4 sm:px-6">
                <div class="text-center max-w-3xl mx-auto">
                    {{-- <h2 class="text-2xl font-bold text-zinc-900 mb-4">Fasilitas Pendukung</h2> --}}
                    <p class="text-zinc-600 leading-relaxed text-start">
                        Pusat Studi Pelestarian Bahasa Dan Sastra Daerah dilengkapi dengan berbagai fasilitas 
                        modern untuk mendukung kegiatan penelitian, pembelajaran, dan pelestarian budaya.
                    </p>
                </div>
            </div>

            {{-- Daftar Fasilitas --}}
            <div class="px-4 sm:px-6">
                @if($fasilitas->count() > 0)
                    <div class="space-y-16">
                        @foreach($fasilitas as $item)
                            @php
                                $gambar = $item->gambar_path ? Storage::url($item->gambar_path) : null;
                            @endphp
                            
                            <div class="w-full">
                                {{-- Header Fasilitas --}}
                                <div class="text-center mb-8">
                                    <h2 class="text-3xl font-title text-zinc-900 mb-4">{{ $item->nama_fasilitas }}</h2>
                                    {{-- @if($item->tampil_beranda)
                                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Ditampilkan di Beranda
                                        </div>
                                    @endif --}}
                                </div>

                                {{-- Gambar Fasilitas --}}
                                <div class="mb-8">
                                    @if($gambar)
                                        <div class="w-full bg-white rounded-lg overflow-hidden shadow-sm">
                                            <img 
                                                src="{{ $gambar }}" 
                                                alt="{{ $item->alt_text ?? $item->nama_fasilitas }}"
                                                class="w-full h-auto max-h-96 object-cover"
                                                loading="lazy"
                                            >
                                            @if($item->alt_text)
                                                <div class="px-4 py-3 bg-zinc-50 border-t border-zinc-200">
                                                    <p class="text-sm text-zinc-600 text-center">{{ $item->alt_text }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <div class="w-full h-64 bg-zinc-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-16 h-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Deskripsi Fasilitas --}}
                                <div class="max-w-4xl mx-auto">
                                    <div class="prose prose-lg max-w-none text-zinc-700 leading-relaxed">
                                        <div class="whitespace-pre-line">
                                            {{ $item->deskripsi }}
                                        </div>
                                    </div>
                                </div>

                                {{-- Separator --}}
                                @if(!$loop->last)
                                    <div class="mt-16 pt-8 border-t border-zinc-200"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- Jika tidak ada fasilitas --}}
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                        <h3 class="text-lg font-medium text-zinc-900 mb-2">Belum Ada Fasilitas</h3>
                        <p class="text-zinc-600 max-w-md mx-auto">
                            Saat ini belum ada data fasilitas yang tersedia untuk ditampilkan.
                            Informasi mengenai fasilitas akan segera diupdate.
                        </p>
                    </div>
                @endif
            </div>

            {{-- Informasi Footer --}}
            <div class="px-4 sm:px-6 mt-12">
                <div class="bg-zinc-50 rounded-lg p-6 text-center">
                    <p class="text-sm text-zinc-600">
                        Untuk informasi lebih lanjut mengenai fasilitas atau jika membutuhkan akses khusus,
                        silakan menghubungi administrator Pusat Studi.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection