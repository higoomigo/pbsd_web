@extends('layout-web.app')

@section('title', 'Fasilitas — Pusat Studi Pelestarian Bahasa Dan Sastra Daerah')
@section('judul_halaman', 'Fasilitas Kami')

@section('content')
<div class="mb-20">
    <div class="mt-8">
        <div class="grid lg:grid-cols-1 gap-6 mb-6 pt-12 md:pb-12 bg-base-100">

            {{-- Deskripsi Halaman Fasilitas --}}
            <div class="px-4 sm:px-6">
                <div class="text-center max-w-3xl mx-auto mb-12">
                    <h2 class="text-2xl font-bold text-zinc-900 mb-4">Fasilitas Pendukung</h2>
                    <p class="text-zinc-600 leading-relaxed">
                        Pusat Studi Pelestarian Bahasa Dan Sastra Daerah dilengkapi dengan berbagai fasilitas 
                        modern untuk mendukung kegiatan penelitian, pembelajaran, dan pelestarian budaya.
                    </p>
                </div>
            </div>

            {{-- Daftar Fasilitas --}}
            <div class="px-4 sm:px-6">
                @if($fasilitas->count() > 0)
                    <div class="grid lg:grid-cols-2 xl:grid-cols-3 gap-8">
                        @foreach($fasilitas as $item)
                            @php
                                $gambar = $item->gambar_path ? Storage::url($item->gambar_path) : null;
                            @endphp
                            
                            <div class="bg-white rounded-lg shadow-sm border border-zinc-200 overflow-hidden hover:shadow-md transition-shadow duration-300">
                                {{-- Gambar Fasilitas --}}
                                <div class="aspect-w-16 aspect-h-9 bg-zinc-100">
                                    @if($gambar)
                                        <img 
                                            src="{{ $gambar }}" 
                                            alt="{{ $item->alt_text ?? $item->nama_fasilitas }}"
                                            class="w-full h-48 object-cover"
                                            loading="lazy"
                                        >
                                    @else
                                        <div class="w-full h-48 bg-zinc-200 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Konten Fasilitas --}}
                                <div class="p-6">
                                    <h3 class="text-xl font-semibold text-zinc-900 mb-3">
                                        {{ $item->nama_fasilitas }}
                                    </h3>
                                    
                                    <div class="prose prose-sm max-w-none text-zinc-600 mb-4">
                                        <p class="leading-relaxed">
                                            {{ Str::limit($item->deskripsi, 120) }}
                                        </p>
                                    </div>

                                    {{-- Badge jika tampil di beranda --}}
                                    @if($item->tampil_beranda)
                                        <div class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mb-4">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                            </svg>
                                            Ditampilkan di Beranda
                                        </div>
                                    @endif

                                    {{-- Tombol Detail --}}
                                    <button onclick="openModal('modal-{{ $item->id }}')"
                                            class="w-full mt-2 px-4 py-2 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-md hover:bg-indigo-100 transition-colors duration-200">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>

                            {{-- Modal Detail --}}
                            <div id="modal-{{ $item->id }}" 
                                 class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden">
                                <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-hidden">
                                    {{-- Header Modal --}}
                                    <div class="flex items-center justify-between p-6 border-b border-zinc-200">
                                        <h3 class="text-2xl font-bold text-zinc-900">{{ $item->nama_fasilitas }}</h3>
                                        <button onclick="closeModal('modal-{{ $item->id }}')"
                                                class="text-zinc-400 hover:text-zinc-600 transition-colors">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Content Modal --}}
                                    <div class="p-6 overflow-y-auto max-h-[calc(90vh-140px)]">
                                        <div class="grid lg:grid-cols-2 gap-6">
                                            {{-- Gambar --}}
                                            <div>
                                                @if($gambar)
                                                    <img 
                                                        src="{{ $gambar }}" 
                                                        alt="{{ $item->alt_text ?? $item->nama_fasilitas }}"
                                                        class="w-full h-64 object-cover rounded-lg shadow-sm"
                                                        loading="lazy"
                                                    >
                                                @else
                                                    <div class="w-full h-64 bg-zinc-200 rounded-lg flex items-center justify-center">
                                                        <svg class="w-16 h-16 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                                
                                                {{-- Alt Text --}}
                                                @if($item->alt_text)
                                                    <p class="text-xs text-zinc-500 mt-2 text-center">
                                                        {{ $item->alt_text }}
                                                    </p>
                                                @endif
                                            </div>

                                            {{-- Deskripsi Lengkap --}}
                                            <div class="prose prose-zinc max-w-none">
                                                <div class="whitespace-pre-line text-zinc-700 leading-relaxed">
                                                    {{ $item->deskripsi }}
                                                </div>

                                                {{-- Metadata --}}
                                                <div class="mt-6 pt-6 border-t border-zinc-200">
                                                    <div class="grid grid-cols-2 gap-4 text-sm">
                                                        <div>
                                                            <span class="font-medium text-zinc-900">Status:</span>
                                                            <span class="ml-2 text-zinc-600">
                                                                @if($item->tampil_beranda)
                                                                    <span class="text-green-600">Aktif di Beranda</span>
                                                                @else
                                                                    <span class="text-zinc-500">Tidak di Beranda</span>
                                                                @endif
                                                            </span>
                                                        </div>
                                                        <div>
                                                            <span class="font-medium text-zinc-900">Urutan:</span>
                                                            <span class="ml-2 text-zinc-600">{{ $item->urutan_tampil }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Footer Modal --}}
                                    <div class="px-6 py-4 border-t border-zinc-200 bg-zinc-50">
                                        <div class="flex justify-end">
                                            <button onclick="closeModal('modal-{{ $item->id }}')"
                                                    class="px-4 py-2 text-sm font-medium text-zinc-700 bg-white border border-zinc-300 rounded-md hover:bg-zinc-50 transition-colors">
                                                Tutup
                                            </button>
                                        </div>
                                    </div>
                                </div>
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

@push('scripts')
<script>
    // Fungsi untuk membuka modal
    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    // Fungsi untuk menutup modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Tutup modal ketika klik di luar konten
    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('fixed')) {
            event.target.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    });

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('.fixed.hidden');
            modals.forEach(modal => {
                modal.classList.add('hidden');
            });
            document.body.style.overflow = 'auto';
        }
    });
</script>
@endpush

<style>
    .aspect-w-16 {
        position: relative;
    }
    .aspect-w-16::before {
        content: "";
        display: block;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
    }
    .aspect-w-16 > * {
        position: absolute;
        height: 100%;
        width: 100%;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
    }
    
    /* Smooth scroll untuk modal */
    .overflow-y-auto {
        scrollbar-width: thin;
        scrollbar-color: #d4d4d8 transparent;
    }
    
    .overflow-y-auto::-webkit-scrollbar {
        width: 6px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: transparent;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background-color: #d4d4d8;
        border-radius: 3px;
    }
</style>