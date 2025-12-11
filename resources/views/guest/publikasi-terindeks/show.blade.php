@extends('layout-web.app')

@section('title', $publikasi->judul . ' — Publikasi Terindeks')
@section('judul_halaman', 'Detail Publikasi')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="mb-6 pt-12 md:pb-12 bg-base-100">

            {{-- Breadcrumb --}}
            <div class="px-4 sm:px-6 mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ url('/') }}" class="inline-flex items-center text-sm font-medium text-zinc-500 hover:text-zinc-700">
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
                                <a href="{{ route('guest.publikasi-terindeks.index') }}" 
                                   class="ml-1 text-sm font-medium text-zinc-500 hover:text-zinc-700 md:ml-2">
                                    Publikasi Terindeks
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                                </svg>
                                <span class="ml-1 text-sm font-medium text-zinc-400 md:ml-2">
                                    Detail
                                </span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="px-4 sm:px-6">
                {{-- Konten Utama --}}
                <div class="mb-8">
                    {{-- Header Publikasi --}}
                    <div class="bg-white shadow-sm border border-zinc-200 overflow-hidden mb-8">
                        {{-- Cover Image --}}
                        @if($publikasi->cover_image)
                            <div class="relative h-64 bg-gradient-to-r from-blue-50 to-indigo-100">
                                <img src="{{ Storage::url($publikasi->cover_image) }}" 
                                     alt="Cover {{ $publikasi->judul }}"
                                     class="w-full h-full object-contain">
                            </div>
                        @endif

                        <div class="p-8">
                            {{-- Badge Indeksasi --}}
                            <div class="flex items-center justify-between mb-6">
                                <div class="flex items-center gap-2">
                                    <span class="px-3 py-1 text-sm font-semibold bg-blue-600 text-white">
                                        {{ $publikasi->indeksasi }}
                                    </span>
                                    @if($publikasi->quartile)
                                        <span class="px-3 py-1 text-sm font-bold bg-purple-100 text-purple-800">
                                            Q{{ $publikasi->quartile }}
                                        </span>
                                    @endif
                                    @if($publikasi->impact_factor)
                                        <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-800">
                                            IF: {{ $publikasi->impact_factor }}
                                        </span>
                                    @endif
                                </div>
                                
                                <div class="text-sm text-zinc-500">
                                    <span class="font-medium">{{ $publikasi->tahun_terbit }}</span>
                                    @if($publikasi->jumlah_dikutip > 0)
                                        <span class="mx-2">•</span>
                                        <span class="text-amber-600 font-medium">
                                            {{ $publikasi->jumlah_dikutip }} dikutip
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Judul --}}
                            <h1 class="text-3xl font-title font-semibold text-zinc-900 mb-4">
                                {{ $publikasi->judul }}
                            </h1>

                            {{-- Penulis --}}
                            <div class="flex items-center gap-2 mb-6">
                                <svg class="w-5 h-5 text-zinc-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-lg text-zinc-700 font-medium">{{ $publikasi->penulis }}</span>
                            </div>

                            {{-- Jurnal Info --}}
                            <div class="bg-zinc-50 p-6 mb-6">
                                <div class="md:flex md:gap-8">
                                    <div class="mb-4 md:mb-0 md:flex-1">
                                        <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">Jurnal</h3>
                                        <p class="text-lg font-bold text-zinc-900">{{ $publikasi->nama_jurnal }}</p>
                                    </div>
                                    <div class="md:flex-1">
                                        <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">Detail</h3>
                                        <div class="space-y-1">
                                            @if($publikasi->issn)
                                                <p class="text-zinc-700">
                                                    <span class="font-medium">ISSN:</span> {{ $publikasi->issn }}
                                                </p>
                                            @endif
                                            @if($publikasi->volume || $publikasi->issue)
                                                <p class="text-zinc-700">
                                                    <span class="font-medium">Volume/Issue:</span> 
                                                    {{ $publikasi->volume ?? '-' }}/{{ $publikasi->issue ?? '-' }}
                                                </p>
                                            @endif
                                            @if($publikasi->halaman)
                                                <p class="text-zinc-700">
                                                    <span class="font-medium">Halaman:</span> {{ $publikasi->halaman }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Abstrak --}}
                            @if($publikasi->abstrak)
                                <div class="mb-8">
                                    <h3 class="text-xl font-bold text-zinc-900 mb-4">Abstrak</h3>
                                    <div class="prose prose-lg max-w-none">
                                        <div class="bg-blue-50 border-l-4 border-blue-500 p-6">
                                            <p class="text-zinc-700 leading-relaxed whitespace-pre-line">
                                                {{ $publikasi->abstrak }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Metadata Tambahan --}}
                            <div class="mb-8">
                                <div class="md:flex md:gap-6 md:flex-wrap">
                                    @if($publikasi->doi)
                                        <div class="bg-white border border-zinc-200 p-4 mb-4 md:mb-0 md:flex-1 min-w-[200px]">
                                            <h4 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">DOI</h4>
                                            <p class="font-mono text-sm text-blue-600 break-all">{{ $publikasi->doi }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($publikasi->url_jurnal)
                                        <div class="bg-white border border-zinc-200 p-4 mb-4 md:mb-0 md:flex-1 min-w-[200px]">
                                            <h4 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">Link Jurnal</h4>
                                            <a href="{{ $publikasi->url_jurnal }}" 
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-800 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                                </svg>
                                                Akses Artikel
                                            </a>
                                        </div>
                                    @endif
                                    
                                    @if($publikasi->bidang_ilmu)
                                        <div class="bg-white border border-zinc-200 p-4 mb-4 md:mb-0 md:flex-1 min-w-[200px]">
                                            <h4 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">Bidang Ilmu</h4>
                                            <p class="text-zinc-700">{{ $publikasi->bidang_ilmu }}</p>
                                        </div>
                                    @endif
                                    
                                    @if($publikasi->kategori_publikasi)
                                        <div class="bg-white border border-zinc-200 p-4 mb-4 md:mb-0 md:flex-1 min-w-[200px]">
                                            <h4 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">Kategori</h4>
                                            <p class="text-zinc-700">{{ $publikasi->kategori_publikasi }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Tombol Aksi --}}
                            <div class="flex flex-wrap gap-4 pt-6 border-t border-zinc-200">
                                @if($publikasi->file_pdf)
                                    <a href="{{ route('guest.publikasi-terindeks.download', $publikasi->id) }}"
                                       class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 text-white font-medium hover:bg-indigo-700 transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Download PDF
                                    </a>
                                @endif
                                
                                <a href="{{ route('guest.publikasi-terindeks.index', ['indeksasi' => $publikasi->indeksasi]) }}"
                                   class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-zinc-300 text-zinc-700 font-medium hover:bg-zinc-50 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                    Lihat Publikasi {{ $publikasi->indeksasi }} Lainnya
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Publikasi Terkait --}}
                    @if($relatedPublikasi->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-2xl font-bold text-zinc-900 mb-6">Publikasi Terkait</h3>
                            <div class="md:flex md:gap-6 md:flex-wrap">
                                @foreach($relatedPublikasi as $related)
                                    <div class="bg-white border border-zinc-200 p-6 mb-4 hover:shadow-md transition-shadow md:flex-1 min-w-[300px]">
                                        <h4 class="font-bold text-zinc-900 mb-2 line-clamp-2">{{ $related->judul }}</h4>
                                        <p class="text-sm text-zinc-600 mb-3">{{ $related->penulis }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-sm font-medium text-zinc-700">{{ $related->nama_jurnal }}</span>
                                            <a href="{{ route('guest.publikasi-terindeks.show', $related->id) }}"
                                               class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                                                Baca →
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

@push('scripts')
<script>
    // Share functions
    function shareOnFacebook() {
        const url = encodeURIComponent(window.location.href);
        const title = encodeURIComponent("{{ $publikasi->judul }}");
        window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&quote=${title}`, '_blank');
    }

    function shareOnTwitter() {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent("{{ $publikasi->judul }}");
        window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank');
    }

    function shareOnLinkedIn() {
        const url = encodeURIComponent(window.location.href);
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
    }

    // Copy citation to clipboard
    function copyCitation() {
        const citation = `{{ $publikasi->penulis }} ({{ $publikasi->tahun_terbit }}). {{ $publikasi->judul }}. {{ $publikasi->nama_jurnal }}, {{ $publikasi->volume ?? '' }}{{ $publikasi->issue ? '(' . $publikasi->issue . ')' : '' }}, {{ $publikasi->halaman ?? '' }}.`;
        
        navigator.clipboard.writeText(citation).then(() => {
            alert('Citation berhasil disalin ke clipboard!');
        }).catch(err => {
            console.error('Gagal menyalin citation: ', err);
            alert('Gagal menyalin citation. Silakan coba lagi.');
        });
    }

    // Handle PDF download with confirmation
    document.addEventListener('DOMContentLoaded', function() {
        const downloadBtn = document.querySelector('a[href*="download"]');
        if (downloadBtn) {
            downloadBtn.addEventListener('click', function(e) {
                if (!confirm('Anda akan mendownload file PDF publikasi ini. Lanjutkan?')) {
                    e.preventDefault();
                }
            });
        }
    });
</script>
@endpush

@push('styles')
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .break-all {
        word-break: break-all;
    }
    
    .whitespace-pre-line {
        white-space: pre-line;
    }
</style>
@endpush