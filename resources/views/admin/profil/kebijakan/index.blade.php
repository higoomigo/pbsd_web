<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Profil') }} — Kebijakan & Tata Kelola
    </h2>
  </x-slot>

  <div class="py-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">Daftar Kebijakan & Tata Kelola <br> Pusat Studi</p>
          <a href="{{ route('admin.profil.kebijakan.create') }}"
             class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
            + Tambah Kebijakan
          </a>
        </div>

        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">
            {{ session('success') }}
          </div>
        @endif

        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-kebijakan"
                       order='[4,"desc"]'
                       :page-length="10"
                       :buttons="true">
            <thead>
            <tr>
              <th>Judul</th>
              <th>Kategori</th>
              <th>Nomor Dokumen</th>
              <th>Versi</th>
              <th>Berlaku</th>
              <th>Status</th>
              <th>Siklus Tinjau</th>
              <th class="no-export" style="min-width:160px;">Aksi</th>
            </tr>
            </thead>
            <tbody>
            @foreach($kebijakan as $k)
              @php
                $tglBerlaku = optional($k->tanggal_berlaku)->format('d M Y');
                $statusVal  = $k->status ?? 'Draft';
                $statusCls  = $statusVal === 'Publik'
                  ? 'bg-green-100 text-green-700'
                  : 'bg-gray-100 text-gray-700';
              @endphp
              <tr class="align-middle">
                <td class="font-medium text-zinc-800">
                  {{ $k->judul }}
                  @if(!empty($k->ringkasan))
                    <div class="text-xs text-zinc-500 line-clamp-1 mt-0.5">
                      {{ $k->ringkasan }}
                    </div>
                  @endif
                </td>

                <td class="text-zinc-700 whitespace-nowrap">
                  {{ $k->kategori ?? '—' }}
                </td>

                <td class="text-zinc-700 whitespace-nowrap">
                  {{ $k->nomor_dokumen ?? '—' }}
                </td>

                <td class="text-zinc-700 whitespace-nowrap">
                  {{ $k->versi ?? '—' }}
                </td>

                <td class="text-zinc-700 whitespace-nowrap">
                  {{ $tglBerlaku ?: '—' }}
                </td>

                <td class="whitespace-nowrap text-center">
                  <span class="px-2 py-1 rounded text-xs {{ $statusCls }}">
                    {{ $statusVal }}
                  </span>
                </td>

                <td class="text-zinc-700 whitespace-nowrap">
                  {{ $k->siklus_tinjau ?? '—' }}
                </td>

                <td class="no-export">
                  <div class="flex items-center justify-center gap-2">
                    @if(!empty($k->dokumen_path))
                      <a href="{{ Storage::url($k->dokumen_path) }}"
                         target="_blank" rel="noopener"
                         class="px-2 py-1 rounded border text-indigo-700 hover:bg-indigo-50 text-xs">
                        Dokumen
                      </a>
                    @endif

                    <a href="{{ route('admin.profil.kebijakan.edit', $k->id) }}"
                       class="px-2 py-1 rounded border text-zinc-700 hover:bg-gray-50 text-xs">
                      Edit
                    </a>

                    <a href="{{ route('admin.profil.kebijakan.show', $k->id) }}"
                       class="px-2 py-1 rounded border text-zinc-700 hover:bg-gray-50 text-xs">
                      Lihat
                    </a>

                    <form action="{{ route('admin.profil.kebijakan.destroy', $k->id) }}"
                          method="POST"
                          onsubmit="return confirm('Hapus kebijakan ini?');"
                          class="inline">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="px-2 py-1 rounded border text-red-700 hover:bg-red-50 text-xs">
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
      #table-kebijakan th,
      #table-kebijakan td {
        vertical-align: middle !important;
      }

      /* Kolom aksi & status lebih center */
      #table-kebijakan th:nth-child(6),
      #table-kebijakan th:nth-child(8),
      #table-kebijakan td:nth-child(6),
      #table-kebijakan td:nth-child(8) {
        text-align: center;
      }
    </style>
  @endpush
</x-app-layout>
