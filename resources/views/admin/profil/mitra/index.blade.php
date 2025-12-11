<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Profil') }} — Daftar Mitra
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">Daftar Mitra</p>
          <a href="{{ route('admin.profil.mitra.create') }}"
             class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
            + Tambah Mitra
          </a>
        </div>

        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-mitra"
                       order='[5,"asc"]'
                       :page-length="10"
                       :buttons="true">
            <thead>
            <tr>
              <th>Logo</th>
              <th>Nama</th>
              <th>Jenis</th>
              <th>Periode</th>
              <th>Status</th>
              <th>Urutan</th>
              {{-- <th>Beranda</th> --}}
              {{-- <th>Website</th> --}}
              <th class="no-export" style="min-width:160px;">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($mitra as $m)
              @php
                $mulai = optional($m->mulai)->format('d M Y');
                $akhir = optional($m->berakhir)->format('d M Y');
                // Inisial fallback: ambil 2 huruf pertama dari 2 kata awal
                $parts = preg_split('/\s+/', trim($m->nama ?? ''), -1, PREG_SPLIT_NO_EMPTY);
                $initials = '';
                foreach (array_slice($parts,0,2) as $p) { $initials .= mb_substr($p,0,1); }
                $initials = mb_strtoupper($initials ?: '—');
              @endphp
              <tr class="align-middle text-center">
                <td class="py-2">
                  <div class="h-10 w-10 rounded bg-white border border-zinc-200 flex items-center justify-center overflow-hidden">
                    @if($m->logo_path)
                      <img src="{{ Storage::url($m->logo_path) }}" alt="{{ $m->nama }}"
                           class="h-full w-fit object-contain p-1">
                    @else
                      <span class="text-xs font-semibold text-zinc-500 select-none">{{ $initials }}</span>
                    @endif
                  </div>
                </td>

                <td class="font-medium text-zinc-800 text-center">{{ $m->nama }}</td>
                <td class="text-zinc-700">{{ $m->jenis }}</td>

                <td class="whitespace-nowrap text-zinc-700">
                  {{ $mulai ?: '—' }}{{ $akhir ? ' — '.$akhir : '' }}
                </td>

                <td>
                  <span class="px-2 py-1 rounded text-xs
                    {{ $m->status === 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                    {{ $m->status }}
                  </span>
                </td>

                <td class="whitespace-nowrap">{{ $m->urutan ?? 0 }}</td>

                {{-- <td class="whitespace-nowrap">
                  {!! $m->tampil_beranda
                    ? '<span class="text-green-600 font-semibold">Ya</span>'
                    : '<span class="text-zinc-600">Tidak</span>' !!}
                </td> --}}

                {{-- <td class="whitespace-nowrap">
                  @if($m->website)
                    <a href="{{ $m->website }}" target="_blank" rel="noopener"
                       class="text-indigo-700 hover:underline">Kunjungi</a>
                  @else
                    <span class="text-zinc-500">—</span>
                  @endif
                </td> --}}

                <td class="no-export">
                  <div class="flex items-center justify-center gap-2">
                    <a href="{{ route('admin.profil.mitra.edit', $m->id) }}"
                       class="px-2 py-1 rounded border text-zinc-700 hover:bg-gray-50">Edit</a>

                    <a href="{{ route('admin.profil.mitra.show', $m->id) }}"
                       class="px-2 py-1 rounded border text-zinc-700 hover:bg-gray-50">Lihat</a>

                    <form action="{{ route('admin.profil.mitra.destroy', $m->id) }}" method="POST"
                          onsubmit="return confirm('Hapus mitra ini?');">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="px-2 py-1 rounded border text-red-700 hover:bg-red-50">Hapus</button>
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
      /* Middle align semua sel */
      #table-mitra th,
      #table-mitra td {
        vertical-align: middle !important;
      }
      /* Kolom logo fix width */
      #table-mitra th:nth-child(1),
      #table-mitra td:nth-child(1) {
        width: 56px;
        text-align: start;
      }
      /* Center kolom Status, Urutan, Beranda, Aksi */
      #table-mitra th:nth-child(5),
      #table-mitra th:nth-child(6),
      #table-mitra th:nth-child(7),
      #table-mitra th:nth-child(8),
      #table-mitra td:nth-child(5),
      #table-mitra td:nth-child(6),
      #table-mitra td:nth-child(7),
      #table-mitra td:nth-child(8) {
        text-align: center;
      }
    </style>
  @endpush

</x-app-layout>
