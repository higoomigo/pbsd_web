@extends('layout-web.app')

@section('title', $kebijakan->judul . ' — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Detail Kebijakan')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="grid lg:grid-cols-3 md:grid-cols-1 gap-6 mb-6 pt-12 md:pb-12 bg-base-100">

            <div class="col-span-3 px-4 sm:px-6 pb-8">
                <div class="space-y-6">

                    {{-- Breadcrumb --}}
                    <nav class="flex" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('guest.kebijakan.index') }}" 
                                   class="inline-flex items-center text-sm font-medium text-zinc-700 hover:text-indigo-600">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Kebijakan Organisasi
                                </a>
                            </li>
                            <li aria-current="page">
                                <div class="flex items-center">
                                    <svg class="w-6 h-6 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-medium text-zinc-500 md:ml-2">Detail</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    {{-- Header Dokumen --}}
                    <div class="bg-white  rounded-lg p-6 shadow-sm">
                        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                            <div class="flex-1">
                                <h1 class="text-2xl font-bold text-zinc-800 mb-3">{{ $kebijakan->judul }}</h1>
                                
                                {{-- Status Badge --}}
                                @php
                                    $statusColor = match($kebijakan->status) {
                                        'Aktif' => 'bg-green-100 text-green-800 border-green-200',
                                        'Revisi' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'Tidak Berlaku' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800 border-gray-200'
                                    };
                                @endphp
                                <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $statusColor }} mb-4">
                                    {{ $kebijakan->status }}
                                </div>

                                {{-- Meta Information --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm text-zinc-600">
                                    @if($kebijakan->kategori)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                            </svg>
                                            <span class="font-medium">Kategori:</span>
                                            <span>{{ $kebijakan->kategori }}</span>
                                        </div>
                                    @endif

                                    @if($kebijakan->nomor_dokumen)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="font-medium">Nomor:</span>
                                            <span class="font-mono">{{ $kebijakan->nomor_dokumen }}</span>
                                        </div>
                                    @endif

                                    @if($kebijakan->versi)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4a1 1 0 011-1h4M4 8v8a2 2 0 002 2h8a2 2 0 002-2V8m-6 6h2m-6 0h2m4-6V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v4"/>
                                            </svg>
                                            <span class="font-medium">Versi:</span>
                                            <span>{{ $kebijakan->versi }}</span>
                                        </div>
                                    @endif

                                    @if($kebijakan->tanggal_berlaku)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                            <span class="font-medium">Berlaku:</span>
                                            <span>{{ $kebijakan->tanggal_berlaku->format('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if($kebijakan->tanggal_tinjau_berikutnya)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <span class="font-medium">Tinjau Ulang:</span>
                                            <span>{{ $kebijakan->tanggal_tinjau_berikutnya->format('d M Y') }}</span>
                                        </div>
                                    @endif

                                    @if($kebijakan->siklus_tinjau)
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            <span class="font-medium">Siklus Tinjau:</span>
                                            <span>{{ $kebijakan->siklus_tinjau }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-2 lg:gap-3">
                                @if($kebijakan->dokumen_path)
                                    <a href="{{ Storage::url($kebijakan->dokumen_path) }}" 
                                       target="_blank"
                                       class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Unduh Dokumen
                                    </a>
                                @endif
                                
                                <a href="{{ route('guest.kebijakan.index') }}" 
                                   class="inline-flex items-center justify-center gap-2 px-4 py-2 border border-zinc-300 text-zinc-700 text-sm font-medium rounded-md hover:bg-zinc-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Kembali ke Daftar
                                </a>
                            </div>
                        </div>

                        {{-- Otoritas dan Penanggung Jawab --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-zinc-200">
                            @if($kebijakan->otoritas_pengesah)
                                <div>
                                    <h3 class="text-sm font-medium text-zinc-700 mb-2">Otoritas Pengesah</h3>
                                    <p class="text-zinc-600">{{ $kebijakan->otoritas_pengesah }}</p>
                                </div>
                            @endif

                            @if($kebijakan->penanggung_jawab)
                                <div>
                                    <h3 class="text-sm font-medium text-zinc-700 mb-2">Penanggung Jawab</h3>
                                    <p class="text-zinc-600">{{ $kebijakan->penanggung_jawab }}</p>
                                </div>
                            @endif

                            @if($kebijakan->unit_terkait)
                                <div class="md:col-span-2">
                                    <h3 class="text-sm font-medium text-zinc-700 mb-2">Unit Terkait</h3>
                                    <p class="text-zinc-600">{{ $kebijakan->unit_terkait }}</p>
                                </div>
                            @endif
                        </div>

                        {{-- Tags --}}
                        @if($kebijakan->tags)
                            @php
                                $tags = collect(explode(',', $kebijakan->tags))
                                            ->map(fn($t) => trim($t))
                                            ->filter();
                            @endphp
                            @if($tags->isNotEmpty())
                                <div class="mt-6 pt-6 border-t border-zinc-200">
                                    <h3 class="text-sm font-medium text-zinc-700 mb-3">Tags</h3>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($tags as $tag)
                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-zinc-100 text-zinc-700 text-sm">
                                                #{{ $tag }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    {{-- Ringkasan --}}
                    @if($kebijakan->ringkasan)
                        <div class="bg-white  rounded-lg p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-zinc-800 mb-4">Ringkasan</h2>
                            <div class="prose prose-zinc max-w-none">
                                <p class="text-zinc-600 leading-relaxed">{{ $kebijakan->ringkasan }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Isi Dokumen --}}
                    <div class="bg-white  rounded-lg p-6 shadow-sm">
                        <h2 class="text-lg font-semibold text-zinc-800 mb-4">Isi Dokumen</h2>
                        <div class="prose prose-zinc max-w-none">
                            @if($kebijakan->isi)
                                {!! $kebijakan->isi !!}
                            @else
                                <div class="text-center py-8 text-zinc-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p>Konten dokumen belum tersedia.</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Lampiran --}}
                    @if($kebijakan->lampiran_paths && count($kebijakan->lampiran_paths) > 0)
                        <div class="bg-white  rounded-lg p-6 shadow-sm">
                            <h2 class="text-lg font-semibold text-zinc-800 mb-4">Lampiran</h2>
                            <div class="space-y-3">
                                @foreach($kebijakan->lampiran_paths as $index => $lampiran)
                                    <div class="flex items-center justify-between p-3 border border-zinc-200 rounded-lg hover:bg-zinc-50 transition-colors">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            <span class="text-sm text-zinc-700">Lampiran {{ $index + 1 }}</span>
                                        </div>
                                        <a href="{{ Storage::url($lampiran) }}" 
                                           target="_blank"
                                           class="inline-flex items-center gap-1 px-3 py-1 text-xs font-medium text-emerald-600 bg-emerald-50 rounded-md hover:bg-emerald-100 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Unduh
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Navigation --}}
                    <div class="flex flex-col sm:flex-row gap-4 justify-between pt-6 border-t border-zinc-200">
                        <a href="{{ route('guest.kebijakan.index') }}" 
                           class="inline-flex items-center gap-2 px-4 py-2 border border-zinc-300 text-zinc-700 text-sm font-medium rounded-md hover:bg-zinc-50 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Daftar Kebijakan
                        </a>
                        
                        @if($kebijakan->dokumen_path)
                            <a href="{{ Storage::url($kebijakan->dokumen_path) }}" 
                               target="_blank"
                               class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-md hover:bg-emerald-700 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Unduh Dokumen Lengkap
                            </a>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection