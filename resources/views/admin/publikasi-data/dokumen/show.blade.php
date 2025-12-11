{{-- resources/views/admin/publikasi-data/dokumen/show.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Detail Dokumen:') }} <span class="text-indigo-600">{{ $dokumen->judul }}</span>
    </h2>
  </x-slot>

  <div class="" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

      {{-- Breadcrumb --}}
      <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
          <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
              <a href="{{ route('admin.publikasi-data.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                Dashboard
              </a>
            </li>
            <li>
              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <a href="{{ route('admin.publikasi-data.dokumen.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600">
                  Dokumen
                </a>
              </div>
            </li>
            @if($dokumen->koleksi)
              <li>
                <div class="flex items-center">
                  <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                  </svg>
                  <a href="{{ route('admin.publikasi-data.dokumen.index', ['koleksi' => $dokumen->koleksi_dokumen_id]) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600">
                    {{ Str::limit($dokumen->koleksi->judul, 20) }}
                  </a>
                </div>
              </li>
            @endif
            <li aria-current="page">
              <div class="flex items-center">
                <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>
                <span class="ml-1 text-sm font-medium text-gray-500">Detail</span>
              </div>
            </li>
          </ol>
        </nav>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Sidebar - Informasi Utama --}}
        <div class="lg:col-span-1 space-y-6">
          {{-- Thumbnail & Quick Actions --}}
          <div class="bg-white -lg border border-gray-200 p-5">
            <div class="text-center mb-4">
              @if($dokumen->thumbnail_url)
                <img src="{{ $dokumen->thumbnail_url }}" 
                     alt="Thumbnail {{ $dokumen->judul }}"
                     class="w-48 h-48 object-cover -lg mx-auto shadow-md">
              @else
                <div class="w-48 h-48 bg-gray-100 -lg mx-auto flex items-center justify-center">
                  <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>
                </div>
              @endif
            </div>
            
            <div class="space-y-4">
              <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $dokumen->judul }}</h3>
                @if($dokumen->kode)
                  <p class="text-sm text-gray-500 font-mono mt-1">{{ $dokumen->kode }}</p>
                @endif
                @if($dokumen->slug)
                  <p class="text-xs text-gray-400 mt-1">Slug: {{ $dokumen->slug }}</p>
                @endif
              </div>
              
              @if($dokumen->deskripsi_singkat)
                <div class="border-t pt-4">
                  <p class="text-sm text-gray-700">{{ $dokumen->deskripsi_singkat }}</p>
                </div>
              @endif
              
              <div class="border-t pt-4">
                <h4 class="text-sm font-semibold text-gray-900 mb-2">Quick Actions</h4>
                <div class="grid grid-cols-2 gap-2">
                  @if($dokumen->menggunakan_google_drive || $dokumen->file_digital_path)
                    <a href="{{ $dokumen->menggunakan_google_drive ? $dokumen->link_google_drive : route('admin.publikasi-data.dokumen.view', $dokumen->id) }}"
                       target="{{ $dokumen->menggunakan_google_drive ? '_blank' : '' }}"
                       class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-medium -md
                              border border-blue-200 text-blue-700 bg-blue-50 hover:bg-blue-100">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                      View
                    </a>
                    
                    <a href="{{ $dokumen->menggunakan_google_drive ? $dokumen->download_google_drive : route('admin.publikasi-data.dokumen.download', $dokumen->id) }}"
                       class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-medium -md
                              border border-green-200 text-green-700 bg-green-50 hover:bg-green-100">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                      </svg>
                      Download
                    </a>
                  @endif
                  
                  <a href="{{ route('admin.publikasi-data.dokumen.edit', $dokumen->id) }}"
                     class="inline-flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-medium -md
                            border border-amber-200 text-amber-700 bg-amber-50 hover:bg-amber-100">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M12 20h9"/>
                      <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                    </svg>
                    Edit
                  </a>
                  
                  <form action="{{ route('admin.publikasi-data.dokumen.destroy', $dokumen->id) }}" 
                        method="POST" 
                        onsubmit="return confirm('Hapus dokumen ini dari repositori?');"
                        class="inline">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="w-full inline-flex items-center justify-center gap-1.5 px-3 py-2 text-sm font-medium -md
                                  border border-red-200 text-red-700 bg-red-50 hover:bg-red-100">
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
            </div>
          </div>

          {{-- Status & Stats --}}
          <div class="bg-white -lg border border-gray-200 p-5">
            <h4 class="text-sm font-semibold text-gray-900 mb-4">Status & Statistik</h4>
            
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Status Publikasi</span>
                <div>
                  @if($dokumen->is_published)
                    <span class="inline-flex items-center px-2.5 py-0.5 -full text-xs font-medium bg-green-100 text-green-800">
                      <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      Published
                    </span>
                    @if($dokumen->published_at)
                      <div class="text-xs text-gray-500 text-right mt-1">
                        {{ $dokumen->published_at->format('d/m/Y') }}
                      </div>
                    @endif
                  @else
                    <span class="inline-flex items-center px-2.5 py-0.5 -full text-xs font-medium bg-gray-100 text-gray-800">
                      <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      Draft
                    </span>
                  @endif
                </div>
              </div>
              
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Dokumen Utama</span>
                <span class="text-sm font-medium {{ $dokumen->is_utama ? 'text-amber-600' : 'text-gray-500' }}">
                  {{ $dokumen->is_utama ? 'Ya' : 'Tidak' }}
                </span>
              </div>
              
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Prioritas</span>
                <span class="text-sm font-medium text-gray-900">
                  @if($dokumen->prioritas <= 3)
                    <span class="text-red-600">{{ $dokumen->prioritas }} (Tinggi)</span>
                  @elseif($dokumen->prioritas <= 6)
                    <span class="text-amber-600">{{ $dokumen->prioritas }} (Sedang)</span>
                  @else
                    <span class="text-blue-600">{{ $dokumen->prioritas }} (Rendah)</span>
                  @endif
                </span>
              </div>
              
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Urutan</span>
                <span class="text-sm font-medium text-gray-900">{{ $dokumen->urutan }}</span>
              </div>
              
              <div class="pt-3 border-t">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-sm text-gray-500">Dilihat</span>
                  <span class="text-lg font-bold text-indigo-600">{{ $dokumen->view_count }}</span>
                </div>
                
                <div class="flex items-center justify-between">
                  <span class="text-sm text-gray-500">Diunduh</span>
                  <span class="text-lg font-bold text-green-600">{{ $dokumen->download_count }}</span>
                </div>
              </div>
              
              <div class="pt-3 border-t">
                <div class="text-xs text-gray-500 space-y-1">
                  <div class="flex justify-between">
                    <span>ID Dokumen:</span>
                    <span class="font-mono">{{ $dokumen->id }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span>Dibuat:</span>
                    <span>{{ $dokumen->created_at->format('d/m/Y H:i') }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span>Diupdate:</span>
                    <span>{{ $dokumen->updated_at->format('d/m/Y H:i') }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>

          {{-- File Information --}}
          <div class="bg-white -lg border border-gray-200 p-5">
            <h4 class="text-sm font-semibold text-gray-900 mb-4">Informasi File</h4>
            
            <div class="space-y-3">
              @if($dokumen->menggunakan_google_drive)
                <div>
                  <div class="flex items-center gap-2 mb-1">
                    <svg class="h-4 w-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                      <path d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Google Drive</span>
                  </div>
                  
                  @if($dokumen->google_drive_id)
                    <div class="text-xs text-gray-600 mb-1">
                      ID: <span class="font-mono">{{ $dokumen->google_drive_id }}</span>
                    </div>
                  @endif
                  
                  <div class="space-y-1">
                    <a href="{{ $dokumen->link_google_drive }}" target="_blank"
                       class="block text-xs text-blue-600 hover:text-blue-800 truncate">
                      {{ $dokumen->link_google_drive }}
                    </a>
                    <a href="{{ $dokumen->download_google_drive }}" 
                       class="block text-xs text-green-600 hover:text-green-800">
                      Link Download
                    </a>
                  </div>
                </div>
              @elseif($dokumen->file_digital_path)
                <div>
                  <div class="flex items-center gap-2 mb-1">
                    <svg class="h-4 w-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">File Lokal</span>
                  </div>
                  
                  <div class="text-xs text-gray-600">
                    <div class="truncate mb-1">{{ basename($dokumen->file_digital_path) }}</div>
                    <div>Ukuran: {{ $dokumen->ukuran_file_formatted }}</div>
                    <div>Format: {{ $dokumen->format_digital ?? $dokumen->format_asli ?? '-' }}</div>
                  </div>
                </div>
              @else
                <p class="text-sm text-gray-500 italic">Tidak ada file digital</p>
              @endif
              
              @if($dokumen->format_asli)
                <div class="pt-2 border-t">
                  <span class="text-xs text-gray-500">Format Asli:</span>
                  <span class="text-xs font-medium text-gray-700 ml-1">{{ $dokumen->format_asli }}</span>
                </div>
              @endif
              
              @if($dokumen->format_digital)
                <div>
                  <span class="text-xs text-gray-500">Format Digital:</span>
                  <span class="text-xs font-medium text-gray-700 ml-1">{{ $dokumen->format_digital }}</span>
                </div>
              @endif
            </div>
          </div>
        </div>

        {{-- Main Content - Detail Lengkap --}}
        <div class="lg:col-span-2 space-y-6">
          {{-- Koleksi Info --}}
          @if($dokumen->koleksi)
            <div class="bg-indigo-50 border border-indigo-200 -lg p-5">
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  @if($dokumen->koleksi->cover_path)
                    <div class="flex-shrink-0 mr-3">
                      <img src="{{ Storage::url($dokumen->koleksi->cover_path) }}" 
                           alt="Cover {{ $dokumen->koleksi->judul }}"
                           class="h-12 w-12 object-cover -md">
                    </div>
                  @endif
                  <div>
                    <h4 class="text-sm font-semibold text-indigo-900">Termasuk dalam Koleksi</h4>
                    <p class="text-sm text-indigo-700">{{ $dokumen->koleksi->judul }}</p>
                    @if($dokumen->koleksi->deskripsi_singkat)
                      <p class="text-xs text-indigo-600 mt-1">{{ $dokumen->koleksi->deskripsi_singkat }}</p>
                    @endif
                  </div>
                </div>
                <a href="{{ route('admin.publikasi-data.dokumen.index', ['koleksi' => $dokumen->koleksi_dokumen_id]) }}"
                   class="text-xs text-indigo-600 hover:text-indigo-800">
                  Lihat koleksi →
                </a>
              </div>
            </div>
          @endif

          {{-- Detail Informasi --}}
          <div class="bg-white -lg border border-gray-200 p-5">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Detail Informasi</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              {{-- Kolom kiri --}}
              <div class="space-y-4">
                <div>
                  <h4 class="text-sm font-semibold text-gray-900 mb-2">Klasifikasi</h4>
                  <dl class="space-y-2">
                    @if($dokumen->kategori)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Kategori</dt>
                        <dd class="text-sm font-medium text-gray-900">
                          <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 -full">
                            {{ $dokumen->kategori }}
                          </span>
                        </dd>
                      </div>
                    @endif
                    
                    @if($dokumen->sub_kategori)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Sub Kategori</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->sub_kategori }}</dd>
                      </div>
                    @endif
                    
                    @if($dokumen->bahasa)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Bahasa</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->bahasa }}</dd>
                      </div>
                    @endif
                    
                    <div class="flex justify-between">
                      <dt class="text-sm text-gray-500">Tahun</dt>
                      <dd class="text-sm font-medium text-gray-900">
                        {{ $dokumen->tahun_terbit ?? ($dokumen->tanggal_terbit ? $dokumen->tanggal_terbit->format('Y') : '—') }}
                        @if($dokumen->tanggal_terbit)
                          <div class="text-xs text-gray-500">
                            ({{ $dokumen->tanggal_terbit->format('d/m/Y') }})
                          </div>
                        @endif
                      </dd>
                    </div>
                    
                    @if($dokumen->halaman)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Halaman</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->halaman }} halaman</dd>
                      </div>
                    @endif
                  </dl>
                </div>
                
                <div>
                  <h4 class="text-sm font-semibold text-gray-900 mb-2">Kreator</h4>
                  <dl class="space-y-2">
                    @if($dokumen->penulis)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Penulis</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->penulis }}</dd>
                      </div>
                    @endif
                    
                    @if($dokumen->penerbit)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Penerbit</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->penerbit }}</dd>
                      </div>
                    @endif
                  </dl>
                </div>
              </div>
              
              {{-- Kolom kanan --}}
              <div class="space-y-4">
                <div>
                  <h4 class="text-sm font-semibold text-gray-900 mb-2">Sumber & Lokasi</h4>
                  <dl class="space-y-2">
                    @if($dokumen->sumber)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Sumber</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->sumber }}</dd>
                      </div>
                    @endif
                    
                    @if($dokumen->lembaga)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Lembaga</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->lembaga }}</dd>
                      </div>
                    @endif
                    
                    @if($dokumen->lokasi_fisik)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Lokasi Fisik</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->lokasi_fisik }}</dd>
                      </div>
                    @endif
                  </dl>
                </div>
                
                <div>
                  <h4 class="text-sm font-semibold text-gray-900 mb-2">Metadata Teknis</h4>
                  <dl class="space-y-2">
                    @if($dokumen->format_asli)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Format Asli</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->format_asli }}</dd>
                      </div>
                    @endif
                    
                    @if($dokumen->format_digital)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Format Digital</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->format_digital }}</dd>
                      </div>
                    @endif
                    
                    @if($dokumen->ukuran_file)
                      <div class="flex justify-between">
                        <dt class="text-sm text-gray-500">Ukuran File</dt>
                        <dd class="text-sm text-gray-900">{{ $dokumen->ukuran_file_formatted }}</dd>
                      </div>
                    @endif
                  </dl>
                </div>
              </div>
            </div>
          </div>

          {{-- Ringkasan Lengkap --}}
          @if($dokumen->ringkasan)
            <div class="bg-white -lg border border-gray-200 p-5">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Ringkasan Lengkap</h3>
              <div class="prose prose-sm max-w-none">
                {!! nl2br(e($dokumen->ringkasan)) !!}
              </div>
            </div>
          @endif

          {{-- Catatan --}}
          @if($dokumen->catatan)
            <div class="bg-yellow-50 border border-yellow-200 -lg p-5">
              <h3 class="text-lg font-bold text-yellow-900 mb-4">Catatan</h3>
              <div class="text-sm text-yellow-800">
                {!! nl2br(e($dokumen->catatan)) !!}
              </div>
            </div>
          @endif

          {{-- File Preview (jika PDF/Image) --}}
          @if($dokumen->menggunakan_google_drive && in_array(strtolower($dokumen->format_digital ?? ''), ['pdf', 'jpg', 'jpeg', 'png']))
            <div class="bg-white -lg border border-gray-200 p-5">
              <h3 class="text-lg font-bold text-gray-900 mb-4">Preview</h3>
              <div class="border -lg overflow-hidden">
                <iframe src="{{ $dokumen->google_drive_embed_url ?? $dokumen->google_drive_preview_url }}" 
                        width="100%" 
                        height="500px"
                        frameborder="0"
                        class="border-0">
                </iframe>
              </div>
            </div>
          @endif

          {{-- Navigation & Actions --}}
          <div class="bg-gray-50 border border-gray-200 -lg p-5">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
              <div class="text-sm text-gray-600">
                ID: {{ $dokumen->id }} • 
                <a href="{{ $dokumen->koleksi_dokumen_id ? route('admin.publikasi-data.dokumen.index', ['koleksi' => $dokumen->koleksi_dokumen_id]) : route('admin.publikasi-data.dokumen.index') }}"
                   class="text-indigo-600 hover:text-indigo-800">
                  Kembali ke daftar →
                </a>
              </div>
              
              <div class="flex items-center gap-3">
                @if($dokumen->menggunakan_google_drive || $dokumen->file_digital_path)
                  <a href="{{ $dokumen->menggunakan_google_drive ? $dokumen->download_google_drive : route('admin.publikasi-data.dokumen.download', $dokumen->id) }}"
                     class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium -md
                            border border-green-200 text-green-700 bg-green-50 hover:bg-green-100">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Download File
                  </a>
                @endif
                
                <a href="{{ route('admin.publikasi-data.dokumen.edit', $dokumen->id) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium -md
                          bg-indigo-600 text-white hover:bg-indigo-700">
                  <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 20h9"/>
                    <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                  </svg>
                  Edit Dokumen
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Copy Google Drive ID to clipboard
        const copyDriveIdBtn = document.getElementById('copy-drive-id');
        if (copyDriveIdBtn) {
          copyDriveIdBtn.addEventListener('click', function() {
            const driveId = "{{ $dokumen->google_drive_id }}";
            navigator.clipboard.writeText(driveId).then(() => {
              // Show success message
              const originalText = this.innerHTML;
              this.innerHTML = '<svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> Copied!';
              setTimeout(() => {
                this.innerHTML = originalText;
              }, 2000);
            });
          });
        }
        
        // View statistics
        console.log('Dokumen stats:', {
          views: {{ $dokumen->view_count }},
          downloads: {{ $dokumen->download_count }},
          published: {{ $dokumen->is_published ? 'true' : 'false' }},
          priority: {{ $dokumen->prioritas }}
        });
      });
    </script>
    
    <style>
      .prose {
        color: #374151;
      }
      .prose p {
        margin-top: 0.75em;
        margin-bottom: 0.75em;
      }
    </style>
  @endpush
</x-app-layout>