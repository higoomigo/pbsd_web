{{-- resources/views/admin/publikasi-data/koleksi-dokumen/show.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Koleksi Dokumen') }} — {{ $koleksi->judul }}
    </h2>
  </x-slot>

  <div class="py-6" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- Header dengan aksi --}}
      <div class="mb-6 flex items-center justify-between">
        <div>
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
                  <a href="{{ route('admin.publikasi-data.koleksi-dokumen.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-indigo-600">
                    Koleksi Dokumen
                  </a>
                </div>
              </li>
              <li aria-current="page">
                <div class="flex items-center">
                  <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                  </svg>
                  <span class="ml-1 text-sm font-medium text-gray-500">{{ Str::limit($koleksi->judul, 30) }}</span>
                </div>
              </li>
            </ol>
          </nav>
        </div>
        
        <div class="flex items-center gap-2">
          <a href="{{ route('admin.publikasi-data.koleksi-dokumen.edit', $koleksi->id) }}"
             class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-md
                    border border-amber-200 text-amber-800 bg-amber-50
                    hover:bg-amber-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 20h9"/>
              <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
            </svg>
            Edit Koleksi
          </a>
          
          <a href="{{ route('admin.publikasi-data.dokumen.create') }}?koleksi_dokumen_id={{ $koleksi->id }}"
             class="inline-flex items-center gap-1.5 px-3 py-2 text-sm font-medium rounded-md
                    border border-green-200 text-green-800 bg-green-50
                    hover:bg-green-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-400 focus-visible:ring-offset-2">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Dokumen
          </a>
        </div>
      </div>

      @if(session('success'))
        <div class="mb-6 p-3 bg-green-100 text-green-800 rounded text-sm">
          {{ session('success') }}
        </div>
      @endif

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Sidebar Info Koleksi --}}
        <div class="lg:col-span-1 space-y-6">
          {{-- Cover dan Basic Info --}}
          <div class="bg-white rounded-lg border border-gray-200 p-5">
            <div class="text-center mb-4">
              @if($koleksi->cover_path)
                <img src="{{ Storage::url($koleksi->cover_path) }}" 
                     alt="Cover {{ $koleksi->judul }}"
                     class="w-48 h-48 object-cover rounded-lg mx-auto shadow-md">
              @else
                <div class="w-48 h-48 bg-gray-100 rounded-lg mx-auto flex items-center justify-center">
                  <svg class="h-20 w-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                  </svg>
                </div>
              @endif
            </div>
            
            <div class="space-y-4">
              <div>
                <h3 class="text-lg font-bold text-gray-900">{{ $koleksi->judul }}</h3>
                <p class="text-sm text-gray-500 mt-1">{{ $koleksi->slug }}</p>
              </div>
              
              @if($koleksi->deskripsi_singkat)
                <div>
                  <p class="text-sm text-gray-700">{{ $koleksi->deskripsi_singkat }}</p>
                </div>
              @endif
              
              <div class="border-t pt-4">
                <h4 class="text-sm font-semibold text-gray-900 mb-2">Informasi Koleksi</h4>
                <dl class="space-y-2">
                  <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Kategori</dt>
                    <dd class="text-sm font-medium text-gray-900">
                      @if($koleksi->kategori)
                        <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                          {{ $koleksi->kategori }}
                        </span>
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </dd>
                  </div>
                  
                  <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Rentang Tahun</dt>
                    <dd class="text-sm font-medium text-gray-900">
                      @if($koleksi->tahun_mulai && $koleksi->tahun_selesai)
                        {{ $koleksi->tahun_mulai }} – {{ $koleksi->tahun_selesai }}
                      @elseif($koleksi->tahun_mulai)
                        {{ $koleksi->tahun_mulai }}
                      @else
                        <span class="text-gray-400">—</span>
                      @endif
                    </dd>
                  </div>
                  
                  <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Lembaga</dt>
                    <dd class="text-sm text-gray-900">{{ $koleksi->lembaga ?? '—' }}</dd>
                  </div>
                  
                  <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Sumber</dt>
                    <dd class="text-sm text-gray-900">{{ $koleksi->sumber ?? '—' }}</dd>
                  </div>
                  
                  <div class="flex justify-between">
                    <dt class="text-sm text-gray-500">Lokasi Fisik</dt>
                    <dd class="text-sm text-gray-900">{{ $koleksi->lokasi_fisik ?? '—' }}</dd>
                  </div>
                </dl>
              </div>
            </div>
          </div>

          {{-- Status dan Stats --}}
          <div class="bg-white rounded-lg border border-gray-200 p-5">
            <h4 class="text-sm font-semibold text-gray-900 mb-4">Status & Statistik</h4>
            
            <div class="space-y-4">
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Status Publikasi</span>
                <div>
                  @if($koleksi->is_published)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                      <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      Published
                    </span>
                    @if($koleksi->published_at)
                      <div class="text-xs text-gray-500 text-right mt-1">
                        {{ $koleksi->published_at->format('d/m/Y') }}
                      </div>
                    @endif
                  @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                      <svg class="mr-1 h-3 w-3" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      Draft
                    </span>
                  @endif
                </div>
              </div>
              
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Tampil di Beranda</span>
                <span class="text-sm font-medium {{ $koleksi->tampil_beranda ? 'text-green-600' : 'text-gray-500' }}">
                  {{ $koleksi->tampil_beranda ? 'Ya' : 'Tidak' }}
                </span>
              </div>
              
              <div class="flex items-center justify-between">
                <span class="text-sm text-gray-500">Urutan</span>
                <span class="text-sm font-medium text-gray-900">{{ $koleksi->urutan }}</span>
              </div>
              
              <div class="pt-3 border-t">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-sm text-gray-500">Total Dokumen</span>
                  <span class="text-xl font-bold text-indigo-600">{{ $koleksi->dokumen()->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between text-sm">
                  <span class="text-gray-500">Dokumen Utama</span>
                  <span class="font-medium">
                    {{ $koleksi->dokumen()->where('is_utama', true)->count() }}
                  </span>
                </div>
                
                <div class="flex items-center justify-between text-sm">
                  <span class="text-gray-500">Dokumen Dipublikasi</span>
                  <span class="font-medium">
                    {{ $koleksi->dokumen()->where('is_published', true)->count() }}
                  </span>
                </div>
              </div>
              
              <div class="pt-3 border-t">
                <div class="text-xs text-gray-500 space-y-1">
                  <div class="flex justify-between">
                    <span>ID Koleksi:</span>
                    <span class="font-mono">{{ $koleksi->id }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span>Dibuat:</span>
                    <span>{{ $koleksi->created_at->format('d/m/Y H:i') }}</span>
                  </div>
                  <div class="flex justify-between">
                    <span>Diupdate:</span>
                    <span>{{ $koleksi->updated_at->format('d/m/Y H:i') }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        {{-- Main Content: Daftar Dokumen --}}
        <div class="lg:col-span-2">
          {{-- Header Daftar Dokumen --}}
          <div class="bg-white rounded-lg border border-gray-200 p-5 mb-6">
            <div class="flex items-center justify-between mb-4">
              <div>
                <h3 class="text-lg font-bold text-gray-900">Dokumen dalam Koleksi</h3>
                <p class="text-sm text-gray-500">
                  {{ $koleksi->dokumen()->count() }} dokumen 
                  @if($koleksi->deskripsi_lengkap)
                    • {{ Str::limit($koleksi->deskripsi_lengkap, 100) }}
                  @endif
                </p>
              </div>
              
              <div class="flex items-center gap-2">
                <div class="relative">
                  <select id="sort-dokumen" class="appearance-none bg-white border border-gray-300 rounded-lg py-2 pl-3 pr-8 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="urutan_asc">Urut: Terurut</option>
                    <option value="created_desc">Terbaru</option>
                    <option value="judul_asc">A-Z Judul</option>
                    <option value="tahun_desc">Tahun (Terbaru)</option>
                  </select>
                  <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                  </div>
                </div>
                
                <a href="{{ route('admin.publikasi-data.dokumen.create') }}?koleksi_dokumen_id={{ $koleksi->id }}"
                   class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md
                          bg-indigo-600 text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  <svg class="h-4 w-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                  </svg>
                  Tambah
                </a>
              </div>
            </div>
            
            {{-- Filter Status --}}
            <div class="flex flex-wrap gap-2 mb-4">
              <button type="button" class="status-filter px-3 py-1 text-sm rounded-full bg-indigo-100 text-indigo-800 border border-indigo-200">
                Semua ({{ $koleksi->dokumen()->count() }})
              </button>
              <button type="button" class="status-filter px-3 py-1 text-sm rounded-full bg-gray-100 text-gray-800 border border-gray-200">
                Draft ({{ $koleksi->dokumen()->where('is_published', false)->count() }})
              </button>
              <button type="button" class="status-filter px-3 py-1 text-sm rounded-full bg-green-100 text-green-800 border border-green-200">
                Published ({{ $koleksi->dokumen()->where('is_published', true)->count() }})
              </button>
              <button type="button" class="status-filter px-3 py-1 text-sm rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                Utama ({{ $koleksi->dokumen()->where('is_utama', true)->count() }})
              </button>
            </div>
          </div>

          {{-- Daftar Dokumen --}}
          <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            @if($dokumen->count() > 0)
              <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                  <thead class="bg-gray-50">
                    <tr>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dokumen
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Tahun
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                      </th>
                      <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Aksi
                      </th>
                    </tr>
                  </thead>
                  <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($dokumen as $doc)
                      <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                          <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 mr-3">
                              @if($doc->thumbnail_url)
                                <img class="h-10 w-10 object-cover rounded" src="{{ $doc->thumbnail_url }}" alt="">
                              @else
                                <div class="h-10 w-10 bg-gray-100 rounded flex items-center justify-center">
                                  <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                  </svg>
                                </div>
                              @endif
                            </div>
                            <div>
                              <div class="text-sm font-medium text-gray-900">
                                <a href="{{ route('admin.publikasi-data.dokumen.show', $doc->id) }}" 
                                   class="hover:text-indigo-600">
                                  {{ $doc->judul }}
                                </a>
                              </div>
                              <div class="text-xs text-gray-500 mt-1">
                                @if($doc->kode)
                                  <span class="font-mono">{{ $doc->kode }}</span> •
                                @endif
                                {{ $doc->format_digital ?? $doc->format_asli ?? '—' }}
                                @if($doc->penulis)
                                  • {{ $doc->penulis }}
                                @endif
                              </div>
                              @if($doc->deskripsi_singkat)
                                <div class="text-xs text-gray-600 mt-1 line-clamp-1">
                                  {{ $doc->deskripsi_singkat }}
                                </div>
                              @endif
                            </div>
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{ $doc->tahun_terbit ?? '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="flex flex-col gap-1">
                            @if($doc->is_published)
                              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                Published
                              </span>
                            @else
                              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                Draft
                              </span>
                            @endif
                            
                            @if($doc->is_utama)
                              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-amber-100 text-amber-800">
                                Utama
                              </span>
                            @endif
                            
                            @if($doc->menggunakan_google_drive)
                              <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                Google Drive
                              </span>
                            @endif
                          </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                          <div class="flex items-center gap-2">
                            <a href="{{ route('admin.publikasi-data.dokumen.edit', $doc->id) }}"
                               class="text-indigo-600 hover:text-indigo-900"
                               title="Edit">
                              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                              </svg>
                            </a>
                            
                            <a href="{{ route('admin.publikasi-data.dokumen.show', $doc->id) }}"
                               class="text-gray-600 hover:text-gray-900"
                               title="Lihat">
                              <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                              </svg>
                            </a>
                            
                            <form action="{{ route('admin.publikasi-data.dokumen.destroy', $doc->id) }}" 
                                  method="POST" 
                                  class="inline"
                                  onsubmit="return confirm('Hapus dokumen ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" 
                                      class="text-red-600 hover:text-red-900"
                                      title="Hapus">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                              </button>
                            </form>
                          </div>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
              
              {{-- Pagination --}}
              @if($dokumen->hasPages())
                <div class="bg-gray-50 px-6 py-3 border-t">
                  {{ $dokumen->links() }}
                </div>
              @endif
            @else
              <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada dokumen</h3>
                <p class="mt-1 text-sm text-gray-500">
                  Mulai dengan menambahkan dokumen ke dalam koleksi ini.
                </p>
                <div class="mt-6">
                  <a href="{{ route('admin.publikasi-data.dokumen.create') }}?koleksi_dokumen_id={{ $koleksi->id }}"
                     class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Dokumen Pertama
                  </a>
                </div>
              </div>
            @endif
          </div>

          {{-- Info Tambahan --}}
          <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Tips mengelola dokumen dalam koleksi</h3>
                <div class="mt-2 text-sm text-blue-700">
                  <ul class="list-disc pl-5 space-y-1">
                    <li>Gunakan "Tambah Dokumen" untuk menambahkan item baru ke koleksi ini</li>
                    <li>Atur dokumen "Utama" untuk menampilkan dokumen penting di halaman publik</li>
                    <li>Publikasikan dokumen untuk membuatnya terlihat di halaman publik</li>
                    <li>Dokumen dalam koleksi ini dapat diakses di: 
                      <code class="text-xs bg-white px-1 py-0.5 rounded">/dokumen/koleksi/{{ $koleksi->slug }}</code>
                    </li>
                  </ul>
                </div>
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
        // Simple sorting (bisa di-expand dengan AJAX)
        const sortSelect = document.getElementById('sort-dokumen');
        if (sortSelect) {
          sortSelect.addEventListener('change', function() {
            // For now, just reload with query string
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
          });
        }
        
        // Status filter
        const statusFilters = document.querySelectorAll('.status-filter');
        statusFilters.forEach(button => {
          button.addEventListener('click', function() {
            // Remove active class from all
            statusFilters.forEach(b => {
              b.classList.remove('bg-indigo-100', 'text-indigo-800', 'border-indigo-200');
              b.classList.add('bg-gray-100', 'text-gray-800', 'border-gray-200');
            });
            
            // Add active class to clicked
            this.classList.remove('bg-gray-100', 'text-gray-800', 'border-gray-200');
            this.classList.add('bg-indigo-100', 'text-indigo-800', 'border-indigo-200');
            
            // Here you would filter the table rows
            const status = this.textContent.trim().split(' ')[0].toLowerCase();
            console.log('Filter by:', status); // Implement your filtering logic
          });
        });
      });
    </script>
    
    <style>
      .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
      }
      
      .status-filter.active {
        background-color: #e0e7ff;
        color: #3730a3;
        border-color: #c7d2fe;
      }
    </style>
  @endpush
</x-app-layout>