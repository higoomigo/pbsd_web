<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Koleksi Dokumen - Kelola Kategori/Kelompok') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">
            Koleksi Dokumen
            <span class="block text-xs font-normal text-zinc-500">
              Kelompokan dokumen dalam koleksi seperti album galeri (contoh: "Arsip Sejarah 1900-1950", "Naskah Kuno Bali", dll.)
            </span>
          </p>
          <a href="{{ route('admin.publikasi-data.koleksi-dokumen.create') }}"
             class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
            + Tambah Koleksi
          </a>
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

        {{-- DataTable koleksi dokumen --}}
        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-koleksi-dokumen"
                       order='[7,"asc"]'
                       :page-length="10"
                       :buttons="true">
            <thead>
              <tr>
                <th width="60">Cover</th>
                <th>Judul Koleksi</th>
                {{-- <th>Deskripsi</th> --}}
                <th>Kategori</th>
                <th>Tahun</th>
                <th>Status</th>
                <th>Jumlah Dokumen</th>
                <th>Urutan</th>
                <th class="no-export" style="min-width:150px;">Aksi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($koleksi as $item)
              @php
                // Rentang tahun
                $tahun = '-';
                if ($item->tahun_mulai && $item->tahun_selesai) {
                  $tahun = $item->tahun_mulai . ' - ' . $item->tahun_selesai;
                } elseif ($item->tahun_mulai) {
                  $tahun = $item->tahun_mulai;
                }
                
                // Jumlah dokumen
                $jumlahDokumen = $item->dokumen()->count();
                
                // Status badges
                $statusBadges = [];
                if ($item->is_published) {
                  $statusBadges[] = '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">Published</span>';
                } else {
                  $statusBadges[] = '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">Draft</span>';
                }
                
                if ($item->tampil_beranda) {
                  $statusBadges[] = '<span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-blue-100 text-blue-800">Beranda</span>';
                }
              @endphp

              <tr class="align-middle hover:bg-gray-50">
                {{-- Cover --}}
                <td class="text-center">
                  @if($item->cover_path)
                    <div class="inline-block">
                      <img src="{{ Storage::url($item->cover_path) }}" 
                           alt="Cover" 
                           class="w-12 h-12 object-cover rounded-md shadow-sm">
                    </div>
                  @else
                    <div class="w-12 h-12 bg-gray-100 rounded-md flex items-center justify-center mx-auto">
                      <svg class="h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                      </svg>
                    </div>
                  @endif
                </td>

                {{-- Judul Koleksi --}}
                <td class="font-medium text-zinc-800">
                  <a href="{{ route('admin.publikasi-data.koleksi-dokumen.show', $item->id) }}"
                     class="hover:underline hover:text-indigo-600 font-semibold">
                    {{ $item->judul ?? '—' }}
                  </a>
                  
                  @if($item->slug)
                    <div class="text-xs text-zinc-500 font-mono mt-0.5">
                      /{{ $item->slug }}
                    </div>
                  @endif
                </td>

                {{-- Deskripsi Singkat --}}
                {{-- <td class="text-zinc-700 text-sm">
                  @if($item->deskripsi_singkat)
                    {{ Str::limit($item->deskripsi_singkat, 80) }}
                  @else
                    <span class="text-zinc-400 italic">Tidak ada deskripsi</span>
                  @endif
                </td> --}}

                {{-- Kategori --}}
                <td class="text-zinc-700 whitespace-nowrap">
                  @if($item->kategori)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                      {{ $item->kategori }}
                    </span>
                  @else
                    <span class="text-zinc-400">—</span>
                  @endif
                </td>

                {{-- Tahun --}}
                <td class="text-center whitespace-nowrap text-zinc-700">
                  {{ $tahun }}
                </td>

                {{-- Status --}}
                <td class="text-center">
                  <div class="flex flex-col gap-1 items-center">
                    {!! implode('', $statusBadges) !!}
                  </div>
                </td>

                {{-- Jumlah Dokumen --}}
                <td class="text-center whitespace-nowrap">
                  <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                    {{ $jumlahDokumen > 0 ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ $jumlahDokumen }} dokumen
                  </span>
                </td>

                {{-- Urutan --}}
                <td class="text-center whitespace-nowrap text-zinc-800 font-mono">
                  {{ $item->urutan }}
                </td>

                {{-- Aksi --}}
                <td class="no-export">
                  <div class="flex items-center justify-center gap-2">
                    {{-- Lihat Dokumen dalam Koleksi --}}
                    <a href="{{ route('admin.publikasi-data.dokumen.index', ['koleksi' => $item->id]) }}"
                      class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-blue-200 text-blue-700 bg-blue-50
                              hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2"
                      title="Lihat dokumen dalam koleksi">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                      Dokumen
                    </a>

                    {{-- Edit --}}
                    <a href="{{ route('admin.publikasi-data.koleksi-dokumen.edit', $item->id) }}"
                      class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-amber-200 text-amber-800 bg-amber-50
                              hover:bg-amber-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2"
                      title="Edit koleksi">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                      </svg>
                      Edit
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('admin.publikasi-data.koleksi-dokumen.destroy', $item->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus koleksi ini?\\n\\nCatatan: Dokumen di dalam koleksi TIDAK akan dihapus, hanya hubungan koleksi yang akan diputus.');"
                          class="inline">
                      @csrf 
                      @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                                    border border-red-200 text-red-700 bg-red-50
                                    hover:bg-red-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2"
                              title="Hapus koleksi">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
            @endforeach
            </tbody>
          </x-datatable>
        </div>

        {{-- Info Panel --}}
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-md">
          <div class="flex items-start">
            <svg class="h-5 w-5 text-blue-500 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-700">
              <strong class="font-semibold">Cara kerja sistem koleksi dokumen:</strong>
              <ul class="list-disc ml-4 mt-1 space-y-1">
                <li>Koleksi berfungsi seperti "album galeri" untuk mengelompokkan dokumen terkait</li>
                <li>Setiap dokumen dapat dimasukkan ke dalam satu koleksi (opsional)</li>
                <li>Gunakan fitur ini untuk membuat kategori seperti: "Arsip Sejarah", "Naskah Kuno", "Transkrip Wawancara", dll.</li>
                <li>Koleksi yang dipublikasi akan muncul di halaman publik</li>
              </ul>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  @push('head')
    <style>
      #table-koleksi-dokumen th,
      #table-koleksi-dokumen td {
        vertical-align: middle !important;
      }

      /* Cover kolom kecil */
      #table-koleksi-dokumen th:nth-child(1),
      #table-koleksi-dokumen td:nth-child(1) {
        width: 70px;
        text-align: center;
      }

      /* Judul koleksi lebar */
      #table-koleksi-dokumen th:nth-child(2),
      #table-koleksi-dokumen td:nth-child(2) {
        min-width: 200px;
      }

      /* Deskripsi medium */
      #table-koleksi-dokumen th:nth-child(3),
      #table-koleksi-dokumen td:nth-child(3) {
        min-width: 180px;
      }

      /* Kategori, Tahun, Status, Jumlah, Urutan - medium */
      #table-koleksi-dokumen th:nth-child(4),
      #table-koleksi-dokumen td:nth-child(4),
      #table-koleksi-dokumen th:nth-child(5),
      #table-koleksi-dokumen td:nth-child(5),
      #table-koleksi-dokumen th:nth-child(6),
      #table-koleksi-dokumen td:nth-child(6),
      #table-koleksi-dokumen th:nth-child(7),
      #table-koleksi-dokumen td:nth-child(7),
      #table-koleksi-dokumen th:nth-child(8),
      #table-koleksi-dokumen td:nth-child(8) {
        min-width: 120px;
        text-align: center;
      }

      /* Aksi kolom - fixed width */
      #table-koleksi-dokumen th:nth-child(9),
      #table-koleksi-dokumen td:nth-child(9) {
        width: 150px;
        text-align: center;
      }

      /* Status badges styling */
      .bg-green-100 {
        background-color: #d1fae5;
      }
      .text-green-800 {
        color: #065f46;
      }
      .bg-gray-100 {
        background-color: #f3f4f6;
      }
      .text-gray-800 {
        color: #374151;
      }
      .bg-blue-100 {
        background-color: #dbeafe;
      }
      .text-blue-800 {
        color: #1e40af;
      }
      .bg-indigo-100 {
        background-color: #e0e7ff;
      }
      .text-indigo-800 {
        color: #3730a3;
      }
    </style>
  @endpush
</x-app-layout>