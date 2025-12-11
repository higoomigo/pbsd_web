@extends('layout-web.app')

@section('title', 'Seminar & Kegiatan Ilmiah — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Seminar & Kegiatan Ilmiah')

@section('content')
<div class="mb-20">
    <div class="">
        <div class="grid lg:grid-cols-1 gap-6 mb-6 pt-12 md:pb-12 bg-base-100">

            {{-- Deskripsi Halaman Seminar --}}
            <div class="px-4 sm:px-6">
                <div class="text-left max-w-3xl mx-auto mb-12">
                    {{-- <h2 class="text-2xl font-title text-zinc-900 mb-4">Kegiatan Ilmiah & Seminar</h2> --}}
                    <p class="text-zinc-600 leading-relaxed">
                        Ikuti berbagai seminar, workshop, dan kegiatan ilmiah yang diselenggarakan oleh 
                        Pusat Studi Pelestarian Bahasa Dan Sastra Daerah untuk menambah wawasan dan 
                        mendukung perkembangan penelitian di bidang bahasa dan sastra daerah.
                    </p>
                </div>

                {{-- Filter dan Search --}}
                <div class="max-w-6xl mx-auto mb-8">
                    <form method="GET" action="{{ route('guest.seminar.index') }}" class="space-y-4">
                        <div class="flex flex-col md:flex-row gap-4">
                            {{-- Search Input --}}
                            <div class="flex-1">
                                <div class="relative">
                                    <input type="text" 
                                           name="search" 
                                           value="{{ request('search') }}"
                                           placeholder="Cari seminar atau pembicara..."
                                           class="w-full pl-10 pr-4 py-2 border border-zinc-300  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <svg class="absolute left-3 top-2.5 w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {{-- <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/> --}}
                                    </svg>
                                </div>
                            </div>

                            {{-- Filter Tipe --}}
                            <select name="tipe" 
                                    onchange="this.form.submit()"
                                    class="px-4 py-2 border border-zinc-300  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Tipe</option>
                                @foreach($tipeOptions as $value => $label)
                                    <option value="{{ $value }}" {{ request('tipe') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Filter Format --}}
                            <select name="format" 
                                    onchange="this.form.submit()"
                                    class="px-4 py-2 border border-zinc-300  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Semua Format</option>
                                @foreach($formatOptions as $value => $label)
                                    <option value="{{ $value }}" {{ request('format') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>

                            {{-- Sorting --}}
                            <select name="sort" 
                                    onchange="this.form.submit()"
                                    class="px-4 py-2 border border-zinc-300  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Urutkan</option>
                                <option value="upcoming" {{ request('sort') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                                <option value="past" {{ request('sort') == 'past' ? 'selected' : '' }}>Sudah Lewat</option>
                                <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Unggulan</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>

                        {{-- Filter Tanggal --}}
                        <div class="flex flex-wrap gap-4 items-center">
                            <div class="flex items-center space-x-2">
                                <span class="text-sm font-medium text-zinc-700">Rentang Tanggal:</span>
                                <input type="date" 
                                       name="start_date" 
                                       value="{{ request('start_date') }}"
                                       class="px-3 py-1 border border-zinc-300 rounded text-sm">
                                <span class="text-zinc-500">s/d</span>
                                <input type="date" 
                                       name="end_date" 
                                       value="{{ request('end_date') }}"
                                       class="px-3 py-1 border border-zinc-300 rounded text-sm">
                            </div>

                            <button type="submit" 
                                    class="px-4 py-1 bg-indigo-600 text-white text-sm font-medium rounded hover:bg-indigo-700 transition-colors">
                                Terapkan
                            </button>

                            {{-- Reset Filter --}}
                            @if(request()->hasAny(['search', 'tipe', 'format', 'sort', 'start_date', 'end_date']))
                                <a href="{{ route('guest.seminar.index') }}" 
                                   class="text-sm text-zinc-600 hover:text-zinc-900 underline">
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            {{-- Daftar Seminar --}}
            <div class="px-4 sm:px-6">
                @if($seminars->count() > 0)
                    <div class="space-y-6">
                        @foreach($seminars as $seminar)
                            @php
                                $poster = $seminar->poster ? Storage::url($seminar->poster) : null;
                                $fotoPembicara = $seminar->foto_pembicara ? Storage::url($seminar->foto_pembicara) : null;
                                $tanggal = \Carbon\Carbon::parse($seminar->tanggal);
                                $isUpcoming = $tanggal->isFuture();
                                $isToday = $tanggal->isToday();
                                $isPast = $tanggal->isPast() && !$isToday;
                            @endphp
                            
                            <div class="bg-white  shadow-sm border border-zinc-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <div class="flex flex-col lg:flex-row">
                                    {{-- Gambar/Poster --}}
                                    <div class="lg:w-1/3">
                                        @if($poster)
                                            <img 
                                                src="{{ $poster }}" 
                                                alt="Poster {{ $seminar->judul }}"
                                                class="w-full h-48 lg:h-full object-cover"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="w-full h-48 lg:h-full bg-gradient-to-r from-indigo-100 to-purple-100 flex items-center justify-center">
                                                <div class="text-center p-4">
                                                    <svg class="w-12 h-12 text-indigo-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <p class="text-sm text-indigo-600 font-medium">{{ Str::limit($seminar->judul, 50) }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Konten --}}
                                    <div class="lg:w-2/3 p-6">
                                        <div class="flex flex-col h-full">
                                            {{-- Header dengan Badge --}}
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    {{-- Badge Status --}}
                                                    <div class="flex flex-wrap gap-2 mb-2">
                                                        @if($isToday)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Hari Ini
                                                            </span>
                                                        @elseif($isUpcoming)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Akan Datang
                                                            </span>
                                                        @elseif($isPast)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.707-10.293a1 1 0 00-1.414-1.414l-3 3a1 1 0 000 1.414l3 3a1 1 0 001.414-1.414L9.414 11H13a1 1 0 100-2H9.414l1.293-1.293z" clip-rule="evenodd"/>
                                                                </svg>
                                                                Sudah Lewat
                                                            </span>
                                                        @endif

                                                        @if($seminar->is_featured)
                                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                                </svg>
                                                                Unggulan
                                                            </span>
                                                        @endif
                                                    </div>

                                                    {{-- Judul --}}
                                                    <h3 class="text-xl font-semibold text-zinc-900 mb-1">
                                                        {{ $seminar->judul }}
                                                    </h3>
                                                </div>

                                                {{-- Tipe Badge --}}
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $seminar->tipe == 'internasional' ? 'bg-blue-100 text-blue-800' : 
                                                       ($seminar->tipe == 'workshop' ? 'bg-purple-100 text-purple-800' : 
                                                       ($seminar->tipe == 'webinar' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800')) }}">
                                                    {{ $seminar->tipe }}
                                                </span>
                                            </div>

                                            {{-- Informasi Utama --}}
                                            <div class="mb-4 space-y-3">
                                                {{-- Tanggal & Waktu --}}
                                                <div class="flex items-center text-sm text-zinc-600">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                    </svg>
                                                    <div>
                                                        <span class="font-medium">{{ $tanggal->translatedFormat('l, d F Y') }}</span>
                                                        <span class="mx-2">•</span>
                                                        <span>{{ $seminar->waktu_mulai }} 
                                                            @if($seminar->waktu_selesai)
                                                                - {{ $seminar->waktu_selesai }}
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- Pembicara --}}
                                                <div class="flex items-center">
                                                    @if($fotoPembicara)
                                                        <img src="{{ $fotoPembicara }}" 
                                                             alt="{{ $seminar->pembicara }}"
                                                             class="w-8 h-8 rounded-full mr-3 object-cover flex-shrink-0">
                                                    @else
                                                        <div class="w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                                            <svg class="w-4 h-4 text-indigo-600" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                    <div>
                                                        <p class="text-sm font-medium text-zinc-900">{{ $seminar->pembicara }}</p>
                                                        @if($seminar->institusi_pembicara)
                                                            <p class="text-xs text-zinc-600">{{ $seminar->institusi_pembicara }}</p>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Format & Lokasi --}}
                                                <div class="flex items-center text-sm text-zinc-600">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                            d="{{ $seminar->format == 'online' ? 'M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9' : 
                                                            ($seminar->format == 'offline' ? 'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z' : 
                                                            'M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z') }}"/>
                                                    </svg>
                                                    <div>
                                                        <span class="font-medium">{{ $seminar->format == 'online' ? 'Virtual' : 
                                                            ($seminar->format == 'offline' ? 'Offline' : 'Hybrid') }}</span>
                                                        @if($seminar->tempat && $seminar->format != 'online')
                                                            <span class="mx-2">•</span>
                                                            <span>{{ $seminar->tempat }}</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                @if($seminar->topik)
                                                    <div class="flex items-center text-sm text-zinc-600">
                                                        <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                                        </svg>
                                                        <span>{{ $seminar->topik }}</span>
                                                    </div>
                                                @endif
                                            </div>

                                            {{-- Ringkasan --}}
                                            @if($seminar->ringkasan)
                                                <div class="prose prose-sm max-w-none text-zinc-600 mb-4 flex-grow">
                                                    <p class="leading-relaxed line-clamp-2">
                                                        {{ $seminar->ringkasan }}
                                                    </p>
                                                </div>
                                            @endif

                                            {{-- Footer Card --}}
                                            <div class="flex justify-between items-center pt-4 border-t border-zinc-100">
                                                {{-- Biaya --}}
                                                <div>
                                                    @if($seminar->gratis)
                                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                            </svg>
                                                            Gratis
                                                        </span>
                                                    @elseif($seminar->biaya)
                                                        <span class="text-sm font-medium text-zinc-900">
                                                            Biaya: Rp {{ number_format($seminar->biaya, 0, ',', '.') }}
                                                        </span>
                                                    @endif
                                                </div>

                                                {{-- Tombol Detail --}}
                                                <a href="{{ route('guest.seminar.show', $seminar->slug) }}" 
                                                   class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50  hover:bg-indigo-100 transition-colors duration-200">
                                                    Lihat Detail
                                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $seminars->links() }}
                    </div>
                @else
                    {{-- Jika tidak ada seminar --}}
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-zinc-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-zinc-900 mb-2">Belum Ada Seminar</h3>
                        <p class="text-zinc-600 max-w-md mx-auto">
                            Saat ini belum ada seminar atau kegiatan ilmiah yang tersedia.
                            Pantau terus halaman ini untuk informasi seminar terbaru.
                        </p>
                    </div>
                @endif
            </div>

            {{-- Informasi Footer --}}
            <div class="px-4 sm:px-6 mt-12">
                <div class="bg-zinc-50  p-6 text-center">
                    <h4 class="font-medium text-zinc-900 mb-2">Ingin Menyelenggarakan Seminar?</h4>
                    <p class="text-sm text-zinc-600 mb-4">
                        Pusat Studi terbuka untuk kolaborasi penyelenggaraan seminar dan kegiatan ilmiah.
                    </p>
                    <a href="" 
                       class="inline-flex items-center px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50  hover:bg-indigo-100 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Submit form filter secara otomatis saat tanggal berubah
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('change', function() {
            if (this.name === 'start_date' || this.name === 'end_date') {
                // Hanya submit jika kedua tanggal terisi
                const startDate = document.querySelector('input[name="start_date"]').value;
                const endDate = document.querySelector('input[name="end_date"]').value;
                if (startDate && endDate) {
                    this.form.submit();
                }
            }
        });
    });
</script>
@endpush

<style>
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    
    @media (min-width: 1024px) {
        .lg\:h-full {
            height: 100%;
        }
    }
</style>