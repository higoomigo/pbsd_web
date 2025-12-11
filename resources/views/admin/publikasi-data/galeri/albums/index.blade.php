<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Galeri') }} — Kelola Album
    </h2>
  </x-slot>

  <div class="py-8" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg">
        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">
            Daftar Album Galeri
            <span class="block text-xs font-normal text-zinc-500">
              Kelola album untuk foto & video kegiatan Pusat Studi
            </span>
          </p>

          <a href="{{ route('admin.publikasi-data.galeri.albums.create') }}"
             class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
            + Tambah Album
          </a>
        </div>

        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-galeri-albums"
                       order='[6,"asc"]'
                       :page-length="10"
                       :buttons="true">
            <thead>
            <tr>
              <th>Cover</th>
              <th>Nama Album</th>
              <th>Koleksi</th>
              <th>Tahun</th>
              <th>Media</th>
              <th>Beranda</th>
              <th>Urutan</th>
              <th class="no-export" style="min-width:160px;">Aksi</th>
            </tr>
            </thead>

            <tbody>
            @foreach($albums as $a)
              @php
                $cover = $a->cover_path ? Storage::url($a->cover_path) : null;
                $tahun = $a->tahun ?: (optional($a->created_at)->format('Y') ?? '—');
                $koleksi = $a->kategori ?: '—';
                $mediaCount = $a->media_count ?? 0;
              @endphp

              <tr class="align-middle">
                {{-- Cover --}}
                <td class="py-2">
                  <div class="h-12 w-12 rounded bg-white border border-zinc-200 flex items-center justify-center overflow-hidden">
                    @if($cover)
                      <img src="{{ $cover }}" alt="{{ $a->judul }}" class="h-full w-full object-cover">
                    @else
                      <span class="text-[10px] text-zinc-500 px-1 text-center leading-tight">
                        No<br>Cover
                      </span>
                    @endif
                  </div>
                </td>

                {{-- Judul + deskripsi singkat --}}
                <td class="font-medium text-zinc-800">
                  <a href="{{ route('admin.publikasi-data.galeri.albums.show', $a->id) }}"
                     class="hover:underline">
                    {{ $a->judul }}
                  </a>
                  @if(!empty($a->deskripsi_singkat))
                    <div class="text-xs text-zinc-500 line-clamp-1 mt-0.5">
                      {{ $a->deskripsi_singkat }}
                    </div>
                  @endif
                </td>

                {{-- Koleksi / kategori --}}
                <td class="text-zinc-700 whitespace-nowrap">
                  {{ $koleksi }}
                </td>

                {{-- Tahun --}}
                <td class="text-center whitespace-nowrap text-zinc-700">
                  {{ $tahun }}
                </td>

                {{-- Jumlah media --}}
                <td class="text-center whitespace-nowrap text-zinc-800">
                  {{ $mediaCount }}
                </td>

                {{-- Tampil di beranda --}}
                <td class="text-center whitespace-nowrap">
                  {!! $a->tampil_beranda
                    ? '<span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700 font-semibold">Ya</span>'
                    : '<span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-600">Tidak</span>' !!}
                </td>

                {{-- Urutan --}}
                <td class="text-center whitespace-nowrap text-zinc-800">
                  {{ $a->urutan ?? 0 }}
                </td>

                {{-- Aksi --}}
                <td class="no-export">
  <div class="flex items-center justify-center gap-2">
    {{-- Kelola media --}}
    <a href="{{ route('admin.publikasi-data.galeri.media.index') }}?album_id={{ $a->id }}"
       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
              border border-blue-200 text-blue-700 bg-blue-50
              hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <rect x="3" y="4" width="18" height="14" rx="2" ry="2"></rect>
        <circle cx="8.5" cy="10.5" r="1.5"></circle>
        <polyline points="21 15 16 10 11 15 8 12 3 17"></polyline>
      </svg>
      Media
    </a>

    {{-- Edit --}}
    <a href="{{ route('admin.publikasi-data.galeri.albums.edit', $a->id) }}"
       class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
              border border-amber-200 text-amber-800 bg-amber-50
              hover:bg-amber-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">
      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
        <path d="M12 20h9"/>
        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
      </svg>
      Edit
    </a>

    {{-- Hapus --}}
    <form action="{{ route('admin.publikasi-data.galeri.albums.destroy', $a->id) }}"
          method="POST"
          onsubmit="return confirm('Hapus album ini beserta seluruh media di dalamnya?');"
          class="inline">
      @csrf
      @method('DELETE')
      <button type="submit"
              class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                      border border-red-200 text-red-700 bg-red-50
                      hover:bg-red-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2">
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
</td>
              </tr>
            @endforeach
            </tbody>
          </x-datatable>
        </div>
      </div>
    </div>
  </div>

  @push('head')
    <style>
      #table-galeri-albums th,
      #table-galeri-albums td {
        vertical-align: middle !important;
      }

      /* Cover kecil */
      #table-galeri-albums th:nth-child(1),
      #table-galeri-albums td:nth-child(1) {
        width: 64px;
        text-align: center;
      }

      /* Nama album agak lebar */
      #table-galeri-albums th:nth-child(2),
      #table-galeri-albums td:nth-child(2) {
        min-width: 260px;
      }

      /* Center beberapa kolom */
      #table-galeri-albums th:nth-child(4),
      #table-galeri-albums th:nth-child(5),
      #table-galeri-albums th:nth-child(6),
      #table-galeri-albums th:nth-child(7),
      #table-galeri-albums th:nth-child(8),
      #table-galeri-albums td:nth-child(4),
      #table-galeri-albums td:nth-child(5),
      #table-galeri-albums td:nth-child(6),
      #table-galeri-albums td:nth-child(7),
      #table-galeri-albums td:nth-child(8) {
        text-align: center;
      }
    </style>
  @endpush
</x-app-layout>
