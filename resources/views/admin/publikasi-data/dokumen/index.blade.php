{{-- resources/views/admin/publikasi-data/dokumen/index.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      @if($currentKoleksi)
        {{ __('Dokumen dalam Koleksi:') }} <span class="text-indigo-600">{{ $currentKoleksi->judul }}</span>
      @else
        {{ __('Menu Repositori Dokumen - Kelola Dokumen') }}
      @endif
    </h2>
  </x-slot>

  <div class="py-2" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        {{-- Header dengan Breadcrumb --}}
        <div class="flex items-center justify-between mb-6">
          <div>
            @if($currentKoleksi)
              {{-- Breadcrumb untuk koleksi --}}
              <nav class="flex mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                  <li class="inline-flex items-center">
                    <a href="{{ route('admin.publikasi-data.dokumen.index') }}" 
                       class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-indigo-600">
                      Semua Dokumen
                    </a>
                  </li>
                  <li aria-current="page">
                    <div class="flex items-center">
                      <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                      </svg>
                      <span class="ml-1 text-sm font-medium text-gray-500">{{ $currentKoleksi->judul }}</span>
                    </div>
                  </li>
                </ol>
              </nav>
              
              <p class="font-semibold text-zinc-900 text-lg">
                Dokumen dalam Koleksi
                <span class="block text-xs font-normal text-zinc-500">
                  {{ $currentKoleksi->deskripsi_singkat ?? 'Kelola dokumen dalam koleksi ini' }}
                </span>
              </p>
            @else
              <p class="font-semibold text-zinc-900 text-lg">
                Repositori Dokumen
                <span class="block text-xs font-normal text-zinc-500">
                  Kelola dokumen digital dan fisik untuk pelestarian bahasa daerah
                </span>
              </p>
            @endif
          </div>
          
          <div class="flex items-center gap-3">
            <a href="{{ route('admin.publikasi-data.koleksi-dokumen.index') }}"
               class="px-3 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">
              <span class="flex items-center gap-2">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Semua Koleksi
              </span>
            </a>
            
            @if($currentKoleksi)
              <a href="{{ route('admin.publikasi-data.dokumen.create', ['koleksi_dokumen_id' => $currentKoleksi->id]) }}"
                 class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
                + Tambah ke Koleksi Ini
              </a>
            @else
              <a href="{{ route('admin.publikasi-data.dokumen.create') }}"
                 class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
                + Tambah Dokumen
              </a>
            @endif
          </div>
        </div>

        {{-- Info Koleksi (jika sedang filter koleksi) --}}
        @if($currentKoleksi)
          <div class="mb-6 bg-indigo-50 border border-indigo-200 rounded-lg p-4">
            <div class="flex items-start">
              @if($currentKoleksi->cover_path)
                <div class="flex-shrink-0 mr-4">
                  <img src="{{ Storage::url($currentKoleksi->cover_path) }}" 
                       alt="Cover {{ $currentKoleksi->judul }}"
                       class="h-16 w-16 object-cover rounded-md">
                </div>
              @endif
              <div class="flex-1">
                <div class="flex items-center justify-between">
                  <div>
                    <h3 class="text-sm font-semibold text-indigo-900">{{ $currentKoleksi->judul }}</h3>
                    @if($currentKoleksi->deskripsi_lengkap)
                      <p class="text-sm text-indigo-700 mt-1">{{ $currentKoleksi->deskripsi_lengkap }}</p>
                    @endif
                  </div>
                  <div class="text-right">
                    <div class="text-xs text-indigo-600">
                      ID: {{ $currentKoleksi->id }} • 
                      <a href="{{ route('admin.publikasi-data.koleksi-dokumen.edit', $currentKoleksi->id) }}"
                         class="hover:text-indigo-800">
                        Edit Koleksi
                      </a>
                    </div>
                    <div class="text-xs text-indigo-500 mt-1">
                      {{ $currentKoleksi->tahun_mulai ? $currentKoleksi->tahun_mulai . ($currentKoleksi->tahun_selesai ? ' - ' . $currentKoleksi->tahun_selesai : '') : '' }}
                    </div>
                  </div>
                </div>
                
                <div class="flex items-center gap-4 mt-3 text-xs">
                  <span class="inline-flex items-center px-2 py-1 rounded bg-white text-indigo-700 border border-indigo-200">
                    {{ $dokumen->total() }} dokumen
                  </span>
                  
                  @if($currentKoleksi->is_published)
                    <span class="inline-flex items-center px-2 py-1 rounded bg-green-100 text-green-800">
                      <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      Published
                    </span>
                  @else
                    <span class="inline-flex items-center px-2 py-1 rounded bg-gray-100 text-gray-800">
                      <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                        <circle cx="4" cy="4" r="3"/>
                      </svg>
                      Draft
                    </span>
                  @endif
                  
                  @if($currentKoleksi->tampil_beranda)
                    <span class="inline-flex items-center px-2 py-1 rounded bg-blue-100 text-blue-800">
                      Tampil di Beranda
                    </span>
                  @endif
                  
                  @if($currentKoleksi->kategori)
                    <span class="inline-flex items-center px-2 py-1 rounded bg-purple-100 text-purple-800">
                      {{ $currentKoleksi->kategori }}
                    </span>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endif

        {{-- Quick Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
          <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-blue-900">Total Dokumen</p>
                <p class="text-lg font-bold text-blue-700">{{ $dokumen->total() }}</p>
              </div>
            </div>
          </div>
          
          <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-green-900">Dipublikasi</p>
                <p class="text-lg font-bold text-green-700">{{ $dokumen->where('is_published', true)->count() }}</p>
              </div>
            </div>
          </div>
          
          {{-- <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-amber-900">Dokumen Utama</p>
                <p class="text-lg font-bold text-amber-700">{{ $dokumen->where('is_utama', true)->count() }}</p>
              </div>
            </div>
          </div> --}}
          
          {{-- <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
            <div class="flex items-center">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/>
                </svg>
              </div>
              <div class="ml-3">
                <p class="text-sm font-medium text-purple-900">Google Drive</p>
                <p class="text-lg font-bold text-purple-700">{{ $dokumen->where(function($q) {
                    return $q->whereNotNull('google_drive_id')->orWhereNotNull('google_drive_link');
                })->count() }}</p>
              </div>
            </div>
          </div> --}}
        </div>

        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">
            {{ session('success') }}
          </div>
        @endif
        
        @if(session('error'))
          <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
            {{ session('error') }}
          </div>
        @endif

        {{-- Filter dan Search (jika tidak sedang filter koleksi) --}}
        @if(!$currentKoleksi)
          <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
              <div class="flex-1">
                <form method="GET" action="{{ route('admin.publikasi-data.dokumen.index') }}">
                  <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                      </svg>
                    </div>
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari dokumen (judul, kode, penulis...)" 
                           class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  </div>
                </form>
              </div>
              
              <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.publikasi-data.dokumen.index') }}" class="flex items-center gap-3">
                  <select name="koleksi" class="block w-full md:w-auto px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          onchange="this.form.submit()">
                    <option value="">Semua Koleksi</option>
                    @foreach($koleksiList as $koleksi)
                      <option value="{{ $koleksi->id }}" 
                        {{ request('koleksi') == $koleksi->id ? 'selected' : '' }}>
                        {{ $koleksi->judul }}
                      </option>
                    @endforeach
                  </select>
                  
                  <select name="kategori" class="block w-full md:w-auto px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kategori)
                      <option value="{{ $kategori }}" 
                        {{ request('kategori') == $kategori ? 'selected' : '' }}>
                        {{ $kategori }}
                      </option>
                    @endforeach
                  </select>
                  
                  <select name="status" class="block w-full md:w-auto px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="utama" {{ request('status') == 'utama' ? 'selected' : '' }}>Dokumen Utama</option>
                  </select>
                  
                  @if(request()->hasAny(['koleksi', 'status', 'kategori', 'search']))
                    <a href="{{ route('admin.publikasi-data.dokumen.index') }}"
                       class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 text-sm">
                      Reset
                    </a>
                  @endif
                </form>
              </div>
            </div>
          </div>
        @else
          {{-- Filter tambahan untuk dalam koleksi --}}
          <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
              <div class="text-sm text-gray-600">
                Menampilkan dokumen dalam koleksi: <strong>{{ $currentKoleksi->judul }}</strong>
                <a href="{{ route('admin.publikasi-data.dokumen.index') }}"
                   class="ml-2 text-indigo-600 hover:text-indigo-800 text-sm">
                  Tampilkan semua dokumen →
                </a>
              </div>
              
              <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('admin.publikasi-data.dokumen.index', ['koleksi' => $currentKoleksi->id]) }}" class="flex items-center gap-3">
                  <select name="status" class="block w-full md:w-auto px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                          onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="utama" {{ request('status') == 'utama' ? 'selected' : '' }}>Dokumen Utama</option>
                  </select>
                  
                  @if(request()->has('status'))
                    <a href="{{ route('admin.publikasi-data.dokumen.index', ['koleksi' => $currentKoleksi->id]) }}"
                       class="px-3 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 text-sm">
                      Reset Filter
                    </a>
                  @endif
                </form>
              </div>
            </div>
          </div>
        @endif

        {{-- DataTable repositori dokumen --}}
        <div class="overflow-x-auto" data-theme="light">
          <table class="min-w-full divide-y divide-gray-200" id="table-dokumen">
            <thead>
              <tr>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul Dokumen</th>
                @if(!$currentKoleksi)
                  <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Koleksi</th>
                @endif
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis / Penerbit</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tahun</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prioritas</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @forelse($dokumen as $d)
              @php
                // Kode / ID katalog
                $kode = $d->kode ?? ('DOC-' . str_pad($d->id, 4, '0', STR_PAD_LEFT));

                // Tahun (dari tahun_terbit atau tanggal_terbit)
                $tahun = $d->tahun_terbit
                  ?? optional($d->tanggal_terbit)->format('Y')
                  ?? '—';

                // Koleksi
                $koleksi = $d->koleksi ? $d->koleksi->judul : '—';

                // Kategori: mis. "Keagamaan", "Sastra", dsb.
                $kategori = $d->kategori ?? '—';

                // Penulis/Penerbit
                $penulisPenerbit = [];
                if ($d->penulis) $penulisPenerbit[] = $d->penulis;
                if ($d->penerbit) $penulisPenerbit[] = $d->penerbit;
                $penulisPenerbitStr = $penulisPenerbit ? implode(' • ', $penulisPenerbit) : '—';

                // Prioritas: 0 default
                $prioritas = $d->prioritas ?? 0;
                
                // Format file
                $format = $d->format_digital ?? $d->format_asli ?? '';
                
                // Status badges
                $statusBadges = [];
                if ($d->is_published) {
                  $statusBadges[] = '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Published</span>';
                } else {
                  $statusBadges[] = '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">Draft</span>';
                }
                
                if ($d->is_utama) {
                  $statusBadges[] = '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-amber-100 text-amber-800">Utama</span>';
                }
                
                if ($d->menggunakan_google_drive) {
                  $statusBadges[] = '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">Google Drive</span>';
                }
              @endphp

              <tr class="hover:bg-gray-50">
                {{-- Kode --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm font-mono text-gray-700">
                  {{ $kode }}
                </td>

                {{-- Judul + ringkasan + format --}}
                <td class="px-6 py-4">
                  <div class="font-medium text-gray-900">
                    <a href="{{ route('admin.publikasi-data.dokumen.show', $d->id) }}"
                       class="hover:text-indigo-600 hover:underline">
                      {{ $d->judul ?? '—' }}
                    </a>
                  </div>

                  @if(!empty($d->deskripsi_singkat))
                    <div class="text-xs text-gray-500 mt-1 line-clamp-1">
                      {{ $d->deskripsi_singkat }}
                    </div>
                  @endif

                  @if(!empty($format))
                    <div class="mt-1 text-xs text-gray-500 flex items-center gap-1">
                      <svg class="h-3 w-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                      </svg>
                      {{ $format }}
                      @if($d->menggunakan_google_drive)
                        <span class="text-blue-500">• Google Drive</span>
                      @endif
                    </div>
                  @endif
                </td>

                {{-- Koleksi (hanya jika tidak sedang filter koleksi) --}}
                @if(!$currentKoleksi)
                  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    @if($d->koleksi)
                      <a href="{{ route('admin.publikasi-data.dokumen.index', ['koleksi' => $d->koleksi_dokumen_id]) }}"
                         class="text-indigo-600 hover:text-indigo-800 hover:underline">
                        {{ $koleksi }}
                      </a>
                    @else
                      {{ $koleksi }}
                    @endif
                  </td>
                @endif

                {{-- Kategori --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  @if($kategori)
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                      {{ $kategori }}
                    </span>
                  @else
                    <span class="text-gray-400">—</span>
                  @endif
                </td>

                {{-- Penulis / Penerbit --}}
                <td class="px-6 py-4 text-sm text-gray-700">
                  {{ $penulisPenerbitStr }}
                </td>

                {{-- Tahun --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-medium text-center">
                  {{ $tahun }}
                </td>

                {{-- Prioritas --}}
                <td class="px-6 py-4 whitespace-nowrap text-center">
                  @if($prioritas == 0)
                    <span class="text-gray-400">—</span>
                  @elseif($prioritas <= 3)
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-100 text-red-800">
                      {{ $prioritas }} (Tinggi)
                    </span>
                  @elseif($prioritas <= 6)
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-amber-100 text-amber-800">
                      {{ $prioritas }} (Sedang)
                    </span>
                  @else
                    <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">
                      {{ $prioritas }} (Rendah)
                    </span>
                  @endif
                </td>

                {{-- Status --}}
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex flex-col gap-1">
                    {!! implode('', $statusBadges) !!}
                  </div>
                </td>

                {{-- Aksi --}}
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex items-center gap-2">
                    {{-- Preview/View --}}
                    @if($d->menggunakan_google_drive || $d->file_digital_path)
                      <a href="{{ $d->menggunakan_google_drive ? $d->link_google_drive : route('admin.publikasi-data.dokumen.view', $d->id) }}"
                         target="{{ $d->menggunakan_google_drive ? '_blank' : '' }}"
                         class="text-blue-600 hover:text-blue-900"
                         title="{{ $d->menggunakan_google_drive ? 'Buka di Google Drive' : 'Preview' }}">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                          <circle cx="12" cy="12" r="3"/>
                        </svg>
                      </a>
                    @endif

                    {{-- Edit metadata --}}
                    <a href="{{ route('admin.publikasi-data.dokumen.edit', $d->id) }}"
                      class="text-amber-600 hover:text-amber-900"
                      title="Edit dokumen">
                      <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                      </svg>
                    </a>

                    {{-- Detail --}}
                    <a href="{{ route('admin.publikasi-data.dokumen.show', $d->id) }}"
                      class="text-gray-600 hover:text-gray-900"
                      title="Detail lengkap">
                      <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                      </svg>
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('admin.publikasi-data.dokumen.destroy', $d->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus dokumen ini dari repositori?');"
                          class="inline">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="text-red-600 hover:text-red-900"
                              title="Hapus dokumen">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <polyline points="3 6 5 6 21 6"/>
                          <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                          <path d="M10 11v6"/>
                          <path d="M14 11v6"/>
                          <path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/>
                        </svg>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="{{ $currentKoleksi ? 8 : 9 }}" class="px-6 py-8 text-center">
                  <div class="text-gray-500">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada dokumen</h3>
                    <p class="mt-1 text-sm text-gray-500">
                      @if($currentKoleksi)
                        Mulai dengan menambahkan dokumen ke koleksi ini.
                      @else
                        Mulai dengan menambahkan dokumen baru.
                      @endif
                    </p>
                    <div class="mt-6">
                      @if($currentKoleksi)
                        <a href="{{ route('admin.publikasi-data.dokumen.create', ['koleksi_dokumen_id' => $currentKoleksi->id]) }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                          </svg>
                          Tambah Dokumen Pertama
                        </a>
                      @else
                        <a href="{{ route('admin.publikasi-data.dokumen.create') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                          <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                          </svg>
                          Tambah Dokumen Pertama
                        </a>
                      @endif
                    </div>
                  </div>
                </td>
              </tr>
            @endforelse
            </tbody>
          </table>
        </div>

        {{-- Pagination --}}
        @if($dokumen->hasPages())
          <div class="mt-6">
            {{ $dokumen->withQueryString()->links() }}
          </div>
        @endif

      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      // Initialize simple DataTable
      document.addEventListener('DOMContentLoaded', function() {
        // Simple table without advanced DataTable features since we use pagination
        // You can add DataTable back if needed, but with server-side processing
        
        // Highlight current collection in sidebar if available
        const currentCollectionId = "{{ $currentKoleksi ? $currentKoleksi->id : '' }}";
        if (currentCollectionId) {
          // You can add specific highlighting logic here
          console.log('Viewing collection:', currentCollectionId);
        }
      });
    </script>
  @endpush
  
  @push('styles')
    <style>
      .line-clamp-1 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
      }
      
      /* Badge colors */
      .bg-green-100 { background-color: #d1fae5; }
      .text-green-800 { color: #065f46; }
      .bg-gray-100 { background-color: #f3f4f6; }
      .text-gray-800 { color: #374151; }
      .bg-amber-100 { background-color: #fef3c7; }
      .text-amber-800 { color: #92400e; }
      .bg-blue-100 { background-color: #dbeafe; }
      .text-blue-800 { color: #1e40af; }
      .bg-red-100 { background-color: #fee2e2; }
      .text-red-800 { color: #991b1b; }
      .bg-purple-100 { background-color: #f3e8ff; }
      .text-purple-800 { color: #5b21b6; }
    </style>
  @endpush
</x-app-layout>