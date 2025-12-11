@extends('layout-web.app')

@section('title', $berita->judul . ' — Kerjasama Riset — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Detail Kerjasama Riset')

@section('content')
<div class="py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-36">
        
        {{-- Breadcrumb --}}
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-zinc-700 hover:text-indigo-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <a href="{{ route('guest.kerjasama-riset.index') }}" class="ml-1 text-sm font-medium text-zinc-700 hover:text-indigo-600 md:ml-2">
                            Kerjasama Riset
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-zinc-500 md:ml-2">
                            {{ Str::limit($berita->judul, 50) }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-3 gap-8">
            {{-- Main Content --}}
            <div class="lg:col-span-2">
                {{-- Header --}}
                <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6 mb-6">
                    @php
                        $colorClasses = [
                            'Kerjasama Riset' => 'bg-blue-100 text-blue-800',
                            'Kolaborasi Penelitian' => 'bg-indigo-100 text-indigo-800',
                            'MoU Riset' => 'bg-purple-100 text-purple-800',
                            'Partnership' => 'bg-cyan-100 text-cyan-800',
                            'Proyek Bersama' => 'bg-teal-100 text-teal-800',
                            'Jaringan Riset' => 'bg-green-100 text-green-800',
                        ];
                        $badgeColor = $colorClasses[$berita->kategori] ?? 'bg-gray-100 text-gray-800';
                    @endphp

                    {{-- Kategori Badge --}}
                    <div class="mb-4">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $badgeColor }}">
                            {{ $berita->kategori ?? 'Kerjasama Riset' }}
                        </span>
                    </div>

                    {{-- Judul --}}
                    <h1 class="text-3xl font-bold text-zinc-900 mb-4">{{ $berita->judul }}</h1>

                    {{-- Meta Info --}}
                    <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-600 mb-6">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <time datetime="{{ optional($berita->published_at)->format('Y-m-d') }}">
                                {{ optional($berita->published_at)->translatedFormat('d F Y') }}
                            </time>
                        </div>
                        @if($berita->author)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span>{{ $berita->author->name }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Thumbnail --}}
                    @if($berita->thumbnail_path)
                        <div class="mb-6">
                            <img src="{{ Storage::url($berita->thumbnail_path) }}" 
                                 alt="{{ $berita->judul }}"
                                 class="w-full h-auto max-h-[400px] object-cover rounded-lg shadow-sm">
                        </div>
                    @endif

                    {{-- Ringkasan --}}
                    @if($berita->ringkasan)
                        <div class="mb-6 p-4 bg-blue-50 border border-blue-100 rounded-lg">
                            <h3 class="font-medium text-blue-900 mb-2">Ringkasan Kerjasama</h3>
                            <p class="text-blue-800 leading-relaxed">{{ $berita->ringkasan }}</p>
                        </div>
                    @endif
                </div>

                {{-- Konten --}}
                <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6 mb-6">
                    <div class="prose prose-zinc max-w-none">
                        {!! $berita->konten !!}
                    </div>
                </div>

                {{-- Partners Info --}}
                @if($berita->tag)
                    @php
                        $tags = collect(explode(',', $berita->tag))->map(fn($t) => trim($t))->filter();
                        $institutionKeywords = ['universitas', 'university', 'institut', 'institute', 'lembaga', 'pusat studi', 'kampus', 'fakultas'];
                        $partners = $tags->filter(function($tag) use ($institutionKeywords) {
                            foreach ($institutionKeywords as $keyword) {
                                if (stripos($tag, $keyword) !== false) {
                                    return true;
                                }
                            }
                            return false;
                        });
                    @endphp
                    
                    @if($partners->isNotEmpty())
                        <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6 mb-6">
                            <h3 class="font-medium text-zinc-900 mb-4">Institusi Mitra</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($partners as $partner)
                                    <div class="flex items-center p-3 bg-gray-50 rounded-lg">
                                        <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span class="text-sm font-medium text-zinc-800">{{ $partner }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Tags --}}
                    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6">
                        <h3 class="font-medium text-zinc-900 mb-3">Kata Kunci Kerjasama</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-50 text-blue-700 border border-blue-100">
                                    #{{ $tag }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
                {{-- CTA Ajuan Kerjasama --}}
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 border border-green-100 rounded-lg p-5">
                    <h3 class="font-semibold text-green-900 mb-3">Ajukan Kerjasama</h3>
                    <p class="text-sm text-green-800 mb-4">
                        Tertarik bermitra dengan kami? Kirim proposal kerjasama Anda.
                    </p>
                    <a href="{{ route('welcome') . '#kontak' }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Ajukan Proposal
                    </a>
                </div>

                {{-- Jenis Kerjasama --}}
                <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-5">
                    <h3 class="font-semibold text-zinc-900 mb-4">Jenis Kerjasama</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Penelitian Bersama
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Pertukaran Peneliti
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Publikasi Bersama
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Seminar/Konferensi
                        </li>
                    </ul>
                </div>

                {{-- Kerjasama Terkait --}}
                @if($terkait->count() > 0)
                    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-5">
                        <h3 class="font-semibold text-zinc-900 mb-4">Kerjasama Lainnya</h3>
                        <div class="space-y-4">
                            @foreach($terkait as $item)
                                <a href="{{ route('guest.kerjasama-riset.show', $item->slug) }}" 
                                   class="group flex items-start space-x-3 p-2 hover:bg-zinc-50 rounded-lg transition">
                                    <div class="flex-shrink-0 w-16 h-16 overflow-hidden rounded border border-zinc-200 bg-zinc-100">
                                        @if($item->thumbnail_path)
                                            <img src="{{ Storage::url($item->thumbnail_path) }}" 
                                                 alt="{{ $item->judul }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-blue-100">
                                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm font-medium text-zinc-900 group-hover:text-blue-700 line-clamp-2">
                                            {{ $item->judul }}
                                        </h4>
                                        <p class="text-xs text-zinc-500 mt-1">
                                            {{ optional($item->published_at)->translatedFormat('d M Y') }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Link ke Kegiatan Penelitian --}}
                <div class="bg-blue-50 border border-blue-100 rounded-lg p-5">
                    <h3 class="font-semibold text-blue-900 mb-3">Kegiatan Penelitian</h3>
                    <p class="text-sm text-blue-800 mb-4">
                        Lihat juga berbagai kegiatan penelitian lainnya yang telah kami lakukan.
                    </p>
                    <a href="{{ route('guest.penelitian.index') }}" 
                       class="w-full inline-flex items-center justify-center px-4 py-2.5 border border-blue-600 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-50 transition-colors">
                        Lihat Semua Kegiatan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection