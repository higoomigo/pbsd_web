<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Kegiatan - Kelola Kegiatan') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">Daftar Kegiatan</p>
          <a href="{{ route('admin.publikasi-data.berita.create') }}"
             class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
            + Tambah Berita
          </a>
        </div>

        {{-- DataTable (pakai komponen reusable yang sudah dibuat) --}}
        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-berita" order='[4,"desc"]' :page-length="10" :buttons="true">
            <thead>
              <tr>
                <th>Thumb</th>
                <th>Judul</th>
                <th>Kategori</th>
                {{-- <th>Status</th> --}}
                <th>Terbit</th>
                <th>Penulis</th>
                <th style="min-width:140px; text-align:center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($berita as $b)
              @php
                $thumb = $b->thumbnail_path ? Storage::url($b->thumbnail_path) : null;
                $tgl   = optional($b->published_at)->format('d M Y');

                // Fallback status: pakai kolom 'status' jika ada; kalau tidak, derive dari published_at
                // $statusVal = $b->status ?? ($b->published_at ? 'Terbit' : 'Draft');
                // $statusCls = $statusVal === 'Terbit' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700';

                // Penulis: pakai relasi author (users.name) jika ada; kalau tidak, coba kolom 'penulis'; kalau tidak ada juga, '-'
                $authorName = optional($b->author)->name ?? ($b->penulis ?? '-');
              @endphp

              <tr class="align-middle">
                <td class="py-2">
                  <div class="h-12 w-12 rounded bg-white border border-zinc-200 flex items-center justify-center overflow-hidden">
                    @if($thumb)
                      <img src="{{ $thumb }}" alt="{{ $b->judul }}" class="h-full w-full object-cover">
                    @else
                      <span class="text-[10px] text-zinc-500 px-1 text-center leading-tight">No<br>Image</span>
                    @endif
                  </div>
                </td>

                <td class="font-medium text-zinc-800">
                  <a href="{{ route('admin.publikasi-data.berita.show', $b->id) }}"
                    class="hover:underline">{{ $b->judul }}</a>
                  @if(!empty($b->ringkasan))
                    <div class="text-xs text-zinc-500 line-clamp-1 mt-0.5">{{ $b->ringkasan }}</div>
                  @endif
                </td>

                <td class="text-zinc-700 whitespace-nowrap">{{ $b->kategori ?? '-' }}</td>

                {{-- <td class="text-center">
                  {{-- <span class="px-2 py-1 rounded text-xs {{ $statusCls }}">{{ $statusVal }}</span> --}}
                {{-- </td> --}}

                <td class="whitespace-nowrap text-zinc-700">{{ $tgl ?: '—' }}</td>

                <td class="whitespace-nowrap text-zinc-700">{{ $authorName }}</td>

                <td>
                  <div class="flex items-center justify-center gap-2">
                    {{-- Edit (kuning/amber) --}}
                    <a href="{{ route('admin.publikasi-data.berita.edit', $b->id) }}"
                      class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-amber-200 text-amber-800 bg-amber-50
                              hover:bg-amber-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">
                      {{-- icon pensil --}}
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
                      Edit
                    </a>

                    {{-- Lihat (biru) --}}
                    <a href="{{ route('admin.publikasi-data.berita.show', $b->id) }}"
                      class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-blue-200 text-blue-700 bg-blue-50
                              hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                      {{-- icon eye --}}
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                      Lihat
                    </a>

                    {{-- Hapus (merah) --}}
                    <form action="{{ route('admin.publikasi-data.berita.destroy', $b->id) }}"
                          method="POST" onsubmit="return confirm('Hapus berita ini?');" class="inline">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                                    border border-red-200 text-red-700 bg-red-50
                                    hover:bg-red-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2">
                        {{-- icon trash --}}
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
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

  {{-- @push('head') --}}
    {{-- perapian kolom (opsional) --}}
    {{-- <style>
      #table-berita th, #table-berita td { vertical-align: middle !important; }
      #table-berita th:nth-child(1), #table-berita td:nth-child(1) { width: 64px; text-align:center; }
      #table-berita th:nth-child(4),
      #table-berita th:nth-child(7),
      #table-berita td:nth-child(4),
      #table-berita td:nth-child(7) { text-align:center; }
    </style>
  @endpush --}}
</x-app-layout>
