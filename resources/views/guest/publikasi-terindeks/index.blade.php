@extends('layout-web.app')

@section('title', 'Publikasi Terindeks — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Publikasi Terindeks')

@section('content')
<div class="mb-20">
    <div class="">
        <div class="grid lg:grid-cols-1 gap-6 mb-6 pt-12  bg-base-100">

            {{-- Deskripsi Halaman Publikasi --}}
            <div class="px-4 sm:px-6">
                <div class="text-left max-w-3xl mx-auto mb-12">
                    {{-- <h2 class="text-2xl font-bold text-zinc-900 mb-4">Publikasi Terindeks</h2> --}}
                    <p class="text-zinc-600 leading-relaxed">
                        Karya ilmiah dan penelitian yang telah dipublikasikan dalam jurnal-jurnal terindeks 
                        nasional maupun internasional oleh tim Pusat Studi Pelestarian Bahasa Dan Sastra Daerah.
                    </p>
                </div>
            </div>

            {{-- Filter dan Pencarian --}}
            <div class="px-4 sm:px-6">
                <div class="bg-white shadow-sm border border-zinc-200 p-6 mb-8">
                    <form method="GET" action="{{ route('guest.publikasi-terindeks.index') }}" class="space-y-4">
                        <div class="grid lg:grid-cols-4 gap-4">
                            {{-- Pencarian --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Cari Publikasi</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Judul, penulis, atau jurnal..."
                                       class="w-full px-4 py-2 border border-zinc-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            </div>

                            {{-- Filter Indeksasi --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Indeksasi</label>
                                <select name="indeksasi" class="w-full px-4 py-2 border border-zinc-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Semua Indeksasi</option>
                                    @foreach($indeksasiOptions as $key => $label)
                                        <option value="{{ $key }}" {{ request('indeksasi') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Filter Tahun --}}
                            <div>
                                <label class="block text-sm font-medium text-zinc-700 mb-1">Tahun</label>
                                <select name="tahun" class="w-full px-4 py-2 border border-zinc-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="">Semua Tahun</option>
                                    @foreach($years as $year)
                                        <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Tombol Filter --}}
                            <div class="flex items-end">
                                <div class="flex gap-2 w-full">
                                    <button type="submit"
                                            class="flex-1 px-4 py-2 bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">
                                        Filter
                                    </button>
                                    <a href="{{ route('guest.publikasi-terindeks.index') }}"
                                       class="px-4 py-2 bg-zinc-200 text-zinc-700 font-medium hover:bg-zinc-300 transition-colors">
                                        Reset
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Daftar Publikasi --}}
            <div class="px-4 sm:px-6">
                @if($publikasis->count() > 0)
                    <div class="space-y-6">
                        @foreach($publikasis as $publikasi)
                            @php
                                $cover = $publikasi->cover_image ? Storage::url($publikasi->cover_image) : null;
                                $quartileDisplay = $publikasi->quartile ? 'Q' . $publikasi->quartile : '-';
                            @endphp
                            
                            <div class="bg-white shadow-sm border border-zinc-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                <div class="flex flex-col md:flex-row">
                                    {{-- Cover Image (Kiri) --}}
                                    <div class="md:w-1/4  flex-shrink-0">
                                        @if($cover)
                                            <img 
                                                src="{{ $cover }}" 
                                                alt="Cover {{ $publikasi->judul }}"
                                                class="w-full h-48 md:h-full object-cover"
                                                loading="lazy"
                                            >
                                        @else
                                            <div class="w-full h-48 md:h-full bg-gradient-to-br from-gray-50 to-blue-100 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Konten Publikasi (Kanan) --}}
                                    <div class="md:w-3/4 p-6">
                                        <div class="flex flex-col h-full">
                                            {{-- Header dengan Badge --}}
                                            <div class="flex items-start justify-between mb-4">
                                                <div>
                                                    {{-- Judul --}}
                                                    <h3 class="text-xl font-bold text-zinc-900 mb-2 line-clamp-2">
                                                        <a href="{{ route('guest.publikasi-terindeks.show', $publikasi->id) }}" 
                                                           class="hover:text-indigo-600 transition-colors">
                                                            {{ $publikasi->judul }}
                                                        </a>
                                                    </h3>
                                                    
                                                    {{-- Penulis --}}
                                                    <div class="flex items-center gap-2 mb-1">
                                                        <svg class="w-4 h-4 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                        </svg>
                                                        <span class="text-sm text-zinc-600">
                                                            {{ Str::limit($publikasi->penulis, 60) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                
                                                {{-- Badge Indeksasi --}}
                                                <div class="flex flex-col items-end gap-2 ml-4">
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-600 text-white whitespace-nowrap">
                                                        {{ $publikasi->indeksasi }}
                                                    </span>
                                                    @if($publikasi->quartile)
                                                        <span class="px-2 py-1 text-xs font-bold bg-purple-100 text-purple-800 rounded whitespace-nowrap">
                                                            {{ $quartileDisplay }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Jurnal & Tahun --}}
                                            <div class="mb-4">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <svg class="w-4 h-4 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                                    </svg>
                                                    <span class="text-sm font-medium text-zinc-700">
                                                        {{ $publikasi->nama_jurnal }}
                                                    </span>
                                                </div>
                                                
                                                <div class="flex items-center gap-4 text-sm text-zinc-500">
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                        <span>{{ $publikasi->tahun_terbit }}</span>
                                                    </div>
                                                    
                                                    @if($publikasi->issn)
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                            <span>ISSN: {{ $publikasi->issn }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($publikasi->volume || $publikasi->issue)
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                                            </svg>
                                                            <span>
                                                                @if($publikasi->volume && $publikasi->issue)
                                                                    Vol. {{ $publikasi->volume }}, Iss. {{ $publikasi->issue }}
                                                                @elseif($publikasi->volume)
                                                                    Vol. {{ $publikasi->volume }}
                                                                @else
                                                                    Iss. {{ $publikasi->issue }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($publikasi->halaman)
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                                            </svg>
                                                            <span>Hlm. {{ $publikasi->halaman }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- Abstrak Singkat --}}
                                            @if($publikasi->abstrak)
                                                <div class="mb-4 flex-grow">
                                                    <p class="text-sm text-zinc-600 line-clamp-2">
                                                        {{ Str::limit(strip_tags($publikasi->abstrak), 200) }}
                                                    </p>
                                                </div>
                                            @endif

                                            {{-- Footer dengan Tombol & Metadata --}}
                                            <div class="flex items-center justify-between pt-4 border-t border-zinc-100">
                                                <div class="flex items-center gap-4 text-sm">
                                                    @if($publikasi->doi)
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                                            </svg>
                                                            <span class="text-blue-600 font-mono text-xs">{{ Str::limit($publikasi->doi, 25) }}</span>
                                                        </div>
                                                    @endif
                                                    
                                                    @if($publikasi->jumlah_dikutip > 0)
                                                        <div class="flex items-center gap-1">
                                                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                            </svg>
                                                            <span class="text-amber-600 font-medium">{{ $publikasi->jumlah_dikutip }} dikutip</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex items-center gap-3">
                                                    @if($publikasi->file_pdf)
                                                        <a href="{{ route('guest.publikasi-terindeks.download', $publikasi->id) }}"
                                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium 
                                                                  border border-green-200 text-green-700 bg-green-50
                                                                  hover:bg-green-100 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                            </svg>
                                                            PDF
                                                        </a>
                                                    @endif
                                                    
                                                    <a href="{{ route('guest.publikasi-terindeks.show', $publikasi->id) }}"
                                                       class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition-colors duration-200">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        Lihat Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if($publikasis->hasPages())
                        <div class="mt-12">
                            <div class="flex items-center justify-center">
                                {{ $publikasis->links('pagination.custom') }}
                            </div>
                        </div>
                    @endif
                @else
                    {{-- Jika tidak ada publikasi --}}
                    <div class="text-center py-16">
                        <svg class="w-20 h-20 text-zinc-400 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-zinc-900 mb-3">Belum Ada Publikasi</h3>
                        <p class="text-zinc-600 max-w-md mx-auto mb-6">
                            Saat ini belum ada publikasi terindeks yang tersedia untuk ditampilkan.
                        </p>
                        @if(request()->hasAny(['search', 'indeksasi', 'tahun']))
                            <a href="{{ route('guest.publikasi-terindeks.index') }}"
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">
                                Tampilkan Semua Publikasi
                            </a>
                        @endif
                    </div>
                @endif
            </div>

            {{-- Statistik & Informasi --}}
            <div class="px-4 sm:px-6 mt-12">
                <div class=" p-8">
                    <div class="text-center mb-8">
                        <h3 class="text-xl font-bold text-zinc-900 mb-2">Statistik Publikasi</h3>
                        <p class="text-zinc-600">Rekap publikasi berdasarkan indeksasi</p>
                    </div>
                    
                    <div class="grid lg:grid-cols-3 gap-4">
                        @php
                            $stats = [
                                'SCOPUS' => App\Models\PublikasiTerindeks::active()->where('indeksasi', 'SCOPUS')->count(),
                                // 'WOS' => App\Models\PublikasiTerindeks::active()->where('indeksasi', 'WOS')->count(),
                                'SINTA' => App\Models\PublikasiTerindeks::active()->where('indeksasi', 'SINTA')->count(),
                                'Total' => App\Models\PublikasiTerindeks::active()->count()
                            ];
                        @endphp
                        
                        @foreach($stats as $label => $count)
                            <div class="bg-white p-4 text-center shadow-sm">
                                <div class="text-2xl font-bold text-indigo-600 mb-1">{{ $count }}</div>
                                <div class="text-sm font-medium text-zinc-700">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
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
    
    @media (max-width: 768px) {
        .flex-col.md\:flex-row {
            flex-direction: column;
        }
        .md\:w-1\/4 {
            width: 100%;
        }
        .md\:w-3\/4 {
            width: 100%;
        }
    }
</style>
@endpush