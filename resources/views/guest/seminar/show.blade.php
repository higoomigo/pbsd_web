@extends('layout-web.app')

@section('title', $seminar->judul . ' — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Detail Seminar')

@section('content')
<div class="mb-20" >
    <div class="mt-8">
        <div class="grid lg:grid-cols-1 gap-6 mb-6 pt-12 md:pb-12 bg-base-100">
            
            {{-- Breadcrumb --}}
            <div class="px-4 sm:px-6">
                <nav class="flex mb-8" aria-label="Breadcrumb">
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
                                <a href="{{ route('guest.seminar.index') }}" class="ml-1 text-sm font-medium text-zinc-700 hover:text-indigo-600 md:ml-2">
                                    Seminar
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-zinc-500 md:ml-2">
                                    {{ Str::limit($seminar->judul, 50) }}
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="px-4 sm:px-6">
                <div class="max-w-6xl mx-auto">
                    {{-- Header Seminar --}}
                    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6 mb-8">
                        {{-- Badge dan Status --}}
                        <div class="flex flex-wrap gap-2 mb-4">
                            @php
                                $tanggal = \Carbon\Carbon::parse($seminar->tanggal);
                                $isUpcoming = $tanggal->isFuture();
                                $isToday = $tanggal->isToday();
                                $isPast = $tanggal->isPast() && !$isToday;
                            @endphp

                            @if($isToday)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Berlangsung Hari Ini
                                </span>
                            @elseif($isUpcoming)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Akan Datang
                                </span>
                            @elseif($isPast)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd"/>
                                    </svg>
                                    Sudah Lewat
                                </span>
                            @endif

                            @if($seminar->is_featured)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                    Seminar Unggulan
                                </span>
                            @endif

                            @if($seminar->is_cancelled)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Dibatalkan
                                </span>
                            @endif

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $seminar->tipe == 'internasional' ? 'bg-blue-100 text-blue-800' : 
                                   ($seminar->tipe == 'workshop' ? 'bg-purple-100 text-purple-800' : 
                                   ($seminar->tipe == 'webinar' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800')) }}">
                                {{ $seminar->tipe }}
                            </span>

                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                {{ $seminar->format == 'online' ? 'bg-indigo-100 text-indigo-800' : 
                                   ($seminar->format == 'offline' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ $seminar->format == 'online' ? 'Virtual' : 
                                   ($seminar->format == 'offline' ? 'Offline' : 'Hybrid') }}
                            </span>
                        </div>

                        {{-- Judul --}}
                        <h1 class="text-3xl font-bold text-zinc-900 mb-6">{{ $seminar->judul }}</h1>

                        {{-- Info Utama Grid --}}
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                            {{-- Tanggal & Waktu --}}
                            <div class="bg-zinc-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <h3 class="font-medium text-zinc-900">Tanggal & Waktu</h3>
                                </div>
                                <p class="text-zinc-700 ml-8">
                                    {{ $tanggal->translatedFormat('l, d F Y') }}<br>
                                    {{ $seminar->waktu_mulai }} 
                                    @if($seminar->waktu_selesai)
                                        - {{ $seminar->waktu_selesai }}
                                    @endif
                                </p>
                            </div>

                            {{-- Lokasi/Format --}}
                            <div class="bg-zinc-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                            d="{{ $seminar->format == 'online' ? 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9' : 
                                            'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z' }}"/>
                                    </svg>
                                    <h3 class="font-medium text-zinc-900">
                                        {{ $seminar->format == 'online' ? 'Virtual' : 'Lokasi' }}
                                    </h3>
                                </div>
                                @if($seminar->format == 'online')
                                    @if($seminar->link_virtual)
                                        <a href="{{ $seminar->link_virtual }}" 
                                           target="_blank"
                                           class="text-indigo-600 hover:text-indigo-800 ml-8 block">
                                            Join Virtual Meeting
                                        </a>
                                    @else
                                        <p class="text-zinc-700 ml-8">Link akan diberikan setelah pendaftaran</p>
                                    @endif
                                @else
                                    <p class="text-zinc-700 ml-8">
                                        {{ $seminar->tempat }}<br>
                                        @if($seminar->alamat_lengkap)
                                            {{ $seminar->alamat_lengkap }}
                                        @endif
                                    </p>
                                @endif
                            </div>

                            {{-- Biaya --}}
                            <div class="bg-zinc-50 rounded-lg p-4">
                                <div class="flex items-center mb-2">
                                    <svg class="w-5 h-5 text-indigo-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <h3 class="font-medium text-zinc-900">Biaya</h3>
                                </div>
                                <p class="ml-8">
                                    @if($seminar->gratis)
                                        <span class="text-xl font-bold text-green-600">GRATIS</span>
                                    @elseif($seminar->biaya)
                                        <span class="text-xl font-bold text-zinc-900">
                                            Rp {{ number_format($seminar->biaya, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-zinc-700">Informasi akan diberikan</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Aksi Utama --}}
                        @if(!$seminar->is_cancelled && !$isPast)
                            <div class="flex flex-col sm:flex-row gap-4">
                                @if($seminar->link_pendaftaran)
                                    <a href="{{ $seminar->link_pendaftaran }}" 
                                       target="_blank"
                                       class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                        Daftar Sekarang
                                    </a>
                                @endif

                                @if($seminar->format != 'offline' && $seminar->link_virtual)
                                    <a href="{{ $seminar->link_virtual }}" 
                                       target="_blank"
                                       class="inline-flex items-center justify-center px-6 py-3 border border-indigo-600 text-indigo-600 font-medium rounded-lg hover:bg-indigo-50 transition-colors">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                        </svg>
                                        Join Virtual
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Content Grid --}}
                    <div class="grid lg:grid-cols-3 gap-8">
                        {{-- Main Content --}}
                        <div class="lg:col-span-2">
                            {{-- Deskripsi --}}
                            <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6 mb-8">
                                <h2 class="text-2xl font-bold text-zinc-900 mb-4">Deskripsi Kegiatan</h2>
                                <div class="prose prose-zinc max-w-none">
                                    <div class="whitespace-pre-line text-zinc-700 leading-relaxed">
                                        {{ $seminar->deskripsi }}
                                    </div>
                                </div>
                            </div>

                            {{-- Pembicara --}}
                            <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6 mb-8">
                                <h2 class="text-2xl font-bold text-zinc-900 mb-6">Pembicara</h2>
                                <div class="flex items-start space-x-6">
                                    @if($seminar->foto_pembicara)
                                        <img src="{{ Storage::url($seminar->foto_pembicara) }}" 
                                             alt="{{ $seminar->pembicara }}"
                                             class="w-24 h-24 rounded-full object-cover flex-shrink-0">
                                    @else
                                        <div class="w-24 h-24 bg-indigo-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-12 h-12 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h3 class="text-xl font-semibold text-zinc-900 mb-2">{{ $seminar->pembicara }}</h3>
                                        @if($seminar->institusi_pembicara)
                                            <p class="text-lg text-zinc-600 mb-4">{{ $seminar->institusi_pembicara }}</p>
                                        @endif
                                        @if($seminar->bio_pembicara)
                                            <div class="prose prose-zinc max-w-none">
                                                <div class="whitespace-pre-line text-zinc-700 leading-relaxed">
                                                    {{ $seminar->bio_pembicara }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Sidebar --}}
                        <div class="lg:col-span-1">
                            {{-- Poster --}}
                            @if($seminar->poster)
                                <div class="bg-white rounded-lg shadow-sm border border-zinc-200 p-6 mb-8">
                                    <h3 class="font-medium text-zinc-900 mb-4">Poster Seminar</h3>
                                    <img src="{{ Storage::url($seminar->poster) }}" 
                                         alt="Poster {{ $seminar->judul }}"
                                         class="w-full rounded-lg shadow-sm">
                                </div>
                            @endif

                            {{-- Info Pendaftaran --}}
                            @if($seminar->link_pendaftaran)
                                <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-8">
                                    <h3 class="font-medium text-green-900 mb-4">Informasi Pendaftaran</h3>
                                    <div class="space-y-3">
                                        @if($seminar->batas_pendaftaran)
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-green-800">
                                                    Batas pendaftaran: 
                                                    {{ \Carbon\Carbon::parse($seminar->batas_pendaftaran)->translatedFormat('d F Y') }}
                                                </span>
                                            </div>
                                        @endif

                                        @if($seminar->kuota_peserta)
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                                </svg>
                                                <span class="text-green-800">
                                                    Kuota: {{ $seminar->kuota_peserta }} peserta
                                                </span>
                                            </div>
                                        @endif

                                        @if($seminar->peserta_terdaftar)
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 text-green-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                <span class="text-green-800">
                                                    Terdaftar: {{ $seminar->peserta_terdaftar }} peserta
                                                </span>
                                            </div>
                                        @endif
                                    </div>

                                    @if(!$seminar->is_cancelled && !$isPast)
                                        <a href="{{ $seminar->link_pendaftaran }}" 
                                           target="_blank"
                                           class="w-full mt-4 inline-flex items-center justify-center px-4 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Daftar Sekarang
                                        </a>
                                    @endif
                                </div>
                            @endif

                            {{-- Materi & Rekaman --}}
                            @if($seminar->dokumen_materi || $seminar->video_rekaman || $isPast)
                                <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6 mb-8">
                                    <h3 class="font-medium text-indigo-900 mb-4">Materi & Rekaman</h3>
                                    <div class="space-y-3">
                                        @if($seminar->dokumen_materi)
                                            <a href="{{ Storage::url($seminar->dokumen_materi) }}" 
                                               target="_blank"
                                               class="flex items-center text-sm text-indigo-700 hover:text-indigo-900 bg-white px-3 py-2 rounded-lg hover:shadow-sm transition-shadow">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                                Unduh Materi Seminar
                                            </a>
                                        @endif

                                        @if($seminar->video_rekaman)
                                            <a href="{{ $seminar->video_rekaman }}" 
                                               target="_blank"
                                               class="flex items-center text-sm text-indigo-700 hover:text-indigo-900 bg-white px-3 py-2 rounded-lg hover:shadow-sm transition-shadow">
                                                <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                                </svg>
                                                Tonton Rekaman Seminar
                                            </a>
                                        @endif

                                        @if($isPast && !$seminar->dokumen_materi && !$seminar->video_rekaman)
                                            <p class="text-sm text-indigo-700">
                                                Materi dan rekaman seminar akan segera diunggah.
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Related Seminars --}}
                    @if(isset($relatedSeminars) && $relatedSeminars->count() > 0)
                        <div class="mt-12">
                            <h2 class="text-2xl font-bold text-zinc-900 mb-6">Seminar Lainnya</h2>
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach($relatedSeminars as $related)
                                    <div class="bg-white rounded-lg shadow-sm border border-zinc-200 overflow-hidden hover:shadow-md transition-shadow">
                                        <div class="p-5">
                                            <div class="flex items-center justify-between mb-3">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $related->tipe == 'internasional' ? 'bg-blue-100 text-blue-800' : 
                                                       ($related->tipe == 'workshop' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ $related->tipe }}
                                                </span>
                                                @if($related->is_featured)
                                                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                    </svg>
                                                @endif
                                            </div>
                                            
                                            <h3 class="font-semibold text-zinc-900 mb-2 line-clamp-2">
                                                {{ $related->judul }}
                                            </h3>
                                            
                                            <div class="text-sm text-zinc-600 mb-3">
                                                <div class="flex items-center mb-1">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    {{ \Carbon\Carbon::parse($related->tanggal)->translatedFormat('d M Y') }}
                                                </div>
                                            </div>
                                            
                                            <a href="{{ route('guest.seminar.show', $related->slug) }}" 
                                               class="inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                Lihat Detail
                                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection