<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Penelitian - Publikasi Terindeks') }} — Detail Publikasi
    </h2>
  </x-slot>

  <div class="py-6" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      
      {{-- Tombol Kembali dan Aksi --}}
      <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('admin.penelitian.publikasi-terindeks.index') }}"
           class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M15 18l-6-6 6-6"/>
          </svg>
          Kembali ke Daftar
        </a>
        
        <div class="flex items-center gap-2">
          <a href="{{ route('admin.penelitian.publikasi-terindeks.edit', $publikasiTerindeks->id) }}"
             class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-md
                    border border-amber-200 text-amber-800 bg-amber-50
                    hover:bg-amber-100">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 20h9"/>
              <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
            </svg>
            Edit
          </a>
          
          <form action="{{ route('admin.penelitian.publikasi-terindeks.destroy', $publikasiTerindeks->id) }}"
                method="POST" onsubmit="return confirm('Hapus publikasi ini?');" class="inline">
            @csrf @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-md
                          border border-red-200 text-red-700 bg-red-50
                          hover:bg-red-100">
              <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                <path d="M10 11v6"/>
                <path d="M14 11v6"/>
                <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
              </svg>
              Hapus
            </button>
          </form>
        </div>
      </div>

      {{-- Badge Status --}}
      <div class="mb-6">
        @php
          $statusClass = $publikasiTerindeks->is_active 
            ? 'bg-green-100 text-green-800 border-green-200' 
            : 'bg-red-100 text-red-800 border-red-200';
          $statusText = $publikasiTerindeks->is_active ? 'Aktif' : 'Nonaktif';
        @endphp
        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusClass }} border">
          {{ $statusText }}
        </span>
        
        <form action="{{ route('admin.penelitian.publikasi-terindeks.toggle-status', $publikasiTerindeks->id) }}" 
              method="POST" class="inline ml-2">
          @csrf
          <button type="submit" 
                  class="text-sm text-indigo-600 hover:text-indigo-800 underline">
            Ubah Status
          </button>
        </form>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        {{-- Header dengan Cover Image --}}
        <div class="relative">
          @if($publikasiTerindeks->cover_image)
            <div class="h-64 bg-gradient-to-r from-blue-50 to-indigo-50 flex items-center justify-center">
              <img src="{{ Storage::url($publikasiTerindeks->cover_image) }}" 
                   alt="Cover {{ $publikasiTerindeks->judul }}"
                   class="max-h-56 rounded-lg shadow-lg">
            </div>
          @else
            <div class="h-48 bg-gradient-to-r from-gray-50 to-blue-50 flex items-center justify-center">
              <div class="text-center">
                <svg class="h-16 w-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <p class="mt-2 text-gray-500">Tidak ada cover image</p>
              </div>
            </div>
          @endif
          
          {{-- Indeksasi Badge --}}
          <div class="absolute top-4 right-4">
            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-600 text-white shadow">
              {{ $publikasiTerindeks->indeksasi }}
            </span>
          </div>
        </div>

        {{-- Konten Detail --}}
        <div class="p-6 space-y-8">
          {{-- Judul dan Metadata Utama --}}
          <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-4">{{ $publikasiTerindeks->judul }}</h1>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
              <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Penulis</p>
                <p class="font-medium text-gray-900">{{ $publikasiTerindeks->penulis }}</p>
              </div>
              
              <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Jurnal</p>
                <p class="font-medium text-gray-900">{{ $publikasiTerindeks->nama_jurnal }}</p>
              </div>
              
              <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-sm text-gray-500 mb-1">Tahun Terbit</p>
                <p class="font-medium text-gray-900">{{ $publikasiTerindeks->tahun_terbit }}</p>
              </div>
            </div>
          </div>

          {{-- Abstrak --}}
          @if($publikasiTerindeks->abstrak)
            <div>
              <h3 class="text-lg font-semibold text-gray-900 mb-3">Abstrak</h3>
              <div class="bg-gray-50 p-4 rounded-lg">
                <p class="text-gray-700 whitespace-pre-line">{{ $publikasiTerindeks->abstrak }}</p>
              </div>
            </div>
          @endif

          {{-- Detail Publikasi --}}
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Kolom Kiri: Informasi Jurnal --}}
            <div class="space-y-6">
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Informasi Jurnal</h3>
                <div class="bg-white border border-gray-200 rounded-lg divide-y">
                  <div class="px-4 py-3 flex justify-between">
                    <span class="text-gray-600">ISSN</span>
                    <span class="font-medium">{{ $publikasiTerindeks->issn ?: '-' }}</span>
                  </div>
                  <div class="px-4 py-3 flex justify-between">
                    <span class="text-gray-600">Volume/Issue</span>
                    <span class="font-medium">
                      @if($publikasiTerindeks->volume && $publikasiTerindeks->issue)
                        {{ $publikasiTerindeks->volume }}({{ $publikasiTerindeks->issue }})
                      @elseif($publikasiTerindeks->volume)
                        Vol. {{ $publikasiTerindeks->volume }}
                      @elseif($publikasiTerindeks->issue)
                        Issue {{ $publikasiTerindeks->issue }}
                      @else
                        -
                      @endif
                    </span>
                  </div>
                  <div class="px-4 py-3 flex justify-between">
                    <span class="text-gray-600">Halaman</span>
                    <span class="font-medium">{{ $publikasiTerindeks->halaman ?: '-' }}</span>
                  </div>
                </div>
              </div>

              {{-- Indeksasi dan Metrik --}}
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Indeksasi & Metrik</h3>
                <div class="bg-white border border-gray-200 rounded-lg divide-y">
                  <div class="px-4 py-3 flex justify-between">
                    <span class="text-gray-600">Quartile</span>
                    <span class="font-medium">
                      @if($publikasiTerindeks->quartile)
                        <span class="px-2 py-1 rounded text-xs bg-purple-100 text-purple-800">
                          Q{{ $publikasiTerindeks->quartile }}
                        </span>
                      @else
                        -
                      @endif
                    </span>
                  </div>
                  <div class="px-4 py-3 flex justify-between">
                    <span class="text-gray-600">Impact Factor</span>
                    <span class="font-medium">{{ $publikasiTerindeks->impact_factor ?: '-' }}</span>
                  </div>
                  <div class="px-4 py-3 flex justify-between">
                    <span class="text-gray-600">Jumlah Dikutip</span>
                    <span class="font-medium">{{ $publikasiTerindeks->jumlah_dikutip }} kali</span>
                  </div>
                </div>
              </div>
            </div>

            {{-- Kolom Kanan: Informasi Tambahan --}}
            <div class="space-y-6">
              {{-- DOI dan Link --}}
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Identifikasi & Link</h3>
                <div class="bg-white border border-gray-200 rounded-lg divide-y">
                  @if($publikasiTerindeks->doi)
                    <div class="px-4 py-3">
                      <p class="text-gray-600 text-sm mb-1">DOI</p>
                      <p class="font-mono text-sm text-blue-600 break-all">{{ $publikasiTerindeks->doi }}</p>
                    </div>
                  @endif
                  
                  @if($publikasiTerindeks->url_jurnal)
                    <div class="px-4 py-3">
                      <p class="text-gray-600 text-sm mb-1">URL Jurnal</p>
                      <a href="{{ $publikasiTerindeks->url_jurnal }}" 
                         target="_blank"
                         class="text-sm text-blue-600 hover:text-blue-800 break-all underline">
                        {{ Str::limit($publikasiTerindeks->url_jurnal, 50) }}
                      </a>
                    </div>
                  @endif
                  
                  @if($publikasiTerindeks->bidang_ilmu)
                    <div class="px-4 py-3">
                      <p class="text-gray-600 text-sm mb-1">Bidang Ilmu</p>
                      <p class="font-medium">{{ $publikasiTerindeks->bidang_ilmu }}</p>
                    </div>
                  @endif
                  
                  @if($publikasiTerindeks->kategori_publikasi)
                    <div class="px-4 py-3">
                      <p class="text-gray-600 text-sm mb-1">Kategori Publikasi</p>
                      <p class="font-medium">{{ $publikasiTerindeks->kategori_publikasi }}</p>
                    </div>
                  @endif
                  
                  @if($publikasiTerindeks->tanggal_publish)
                    <div class="px-4 py-3">
                      <p class="text-gray-600 text-sm mb-1">Tanggal Publish</p>
                      <p class="font-medium">{{ $publikasiTerindeks->tanggal_publish->format('d F Y') }}</p>
                    </div>
                  @endif
                </div>
              </div>

              {{-- File dan Download --}}
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">File & Dokumen</h3>
                <div class="bg-white border border-gray-200 rounded-lg p-4">
                  @if($publikasiTerindeks->file_pdf)
                    <div class="flex items-center justify-between mb-3">
                      <div class="flex items-center gap-3">
                        <svg class="h-8 w-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                          <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                          <p class="font-medium text-gray-900">File PDF</p>
                          <p class="text-sm text-gray-500">File publikasi lengkap</p>
                        </div>
                      </div>
                      <a href="{{ route('admin.penelitian.publikasi-terindeks.download', $publikasiTerindeks->id) }}"
                         class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-md
                                border border-green-200 text-green-700 bg-green-50
                                hover:bg-green-100">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                          <polyline points="7 10 12 15 17 10"/>
                          <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        Download
                      </a>
                    </div>
                  @else
                    <div class="text-center py-4">
                      <svg class="h-12 w-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                      </svg>
                      <p class="text-gray-500">Tidak ada file PDF tersedia</p>
                    </div>
                  @endif
                </div>
              </div>

              {{-- Metadata Sistem --}}
              <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-3">Metadata Sistem</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                  <div class="grid grid-cols-2 gap-3 text-sm">
                    <div>
                      <p class="text-gray-500">Dibuat</p>
                      <p class="font-medium">{{ $publikasiTerindeks->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div>
                      <p class="text-gray-500">Diperbarui</p>
                      <p class="font-medium">{{ $publikasiTerindeks->updated_at->format('d M Y H:i') }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('styles')
    <style>
      .break-all {
        word-break: break-all;
      }
      .whitespace-pre-line {
        white-space: pre-line;
      }
    </style>
  @endpush
</x-app-layout>