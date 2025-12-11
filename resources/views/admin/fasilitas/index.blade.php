<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Fasilitas - Kelola Fasilitas') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        <div class="flex items-center justify-between mb-4">
          <p class="font-semibold text-zinc-900 text-lg">Daftar Fasilitas</p>
          <a href="{{ route('admin.fasilitas.create') }}"
             class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
            + Tambah Fasilitas
          </a>
        </div>

        {{-- DataTable --}}
        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-fasilitas" order='[5,"desc"]' :page-length="10" :buttons="true">
            <thead>
              <tr>
                <th>Gambar</th>
                <th>Nama Fasilitas</th>
                <th>Deskripsi</th>
                <th>Tampil di Beranda</th>
                <th>Urutan</th>
                <th>Dibuat</th>
                <th style="min-width:140px; text-align:center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($fasilitas as $item)
              @php
                $gambar = $item->gambar_path ? Storage::url($item->gambar_path) : null;
                $tglDibuat = $item->created_at->format('d M Y');
                $deskripsiSingkat = Str::limit($item->deskripsi, 80);
              @endphp

              <tr class="align-middle">
                <td class="py-2">
                  <div class="h-12 w-12 rounded bg-white border border-zinc-200 flex items-center justify-center overflow-hidden">
                    @if($gambar)
                      <img src="{{ $gambar }}" alt="{{ $item->alt_text ?? $item->nama_fasilitas }}" class="h-full w-full object-cover">
                    @else
                      <span class="text-[10px] text-zinc-500 px-1 text-center leading-tight">No<br>Image</span>
                    @endif
                  </div>
                </td>

                <td class="font-medium text-zinc-800">
                  {{ $item->nama_fasilitas }}
                </td>

                <td class="text-zinc-700">
                  <div class="max-w-xs">
                    {{ $deskripsiSingkat }}
                  </div>
                </td>

                <td class="text-center">
                  <form action="{{ route('admin.fasilitas.updateTampilBeranda', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="tampil_beranda" value="{{ $item->tampil_beranda ? 0 : 1 }}">
                    <button type="submit" 
                            class="px-2 py-1 rounded text-xs {{ $item->tampil_beranda ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition-opacity">
                      {{ $item->tampil_beranda ? 'Ya' : 'Tidak' }}
                    </button>
                  </form>
                </td>

                <td class="text-center">
                  <form action="{{ route('admin.fasilitas.updateUrutan', $item->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="number" 
                           name="urutan_tampil" 
                           value="{{ $item->urutan_tampil }}" 
                           min="0" 
                           class="w-16 px-1 py-1 text-xs border border-zinc-300 rounded text-center"
                           onchange="this.form.submit()">
                  </form>
                </td>

                <td class="whitespace-nowrap text-zinc-700">{{ $tglDibuat }}</td>

                <td>
                  <div class="flex items-center justify-center gap-2">
                    {{-- Edit (kuning/amber) --}}
                    <a href="{{ route('admin.fasilitas.edit', $item->id) }}"
                      class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-amber-200 text-amber-800 bg-amber-50
                              hover:bg-amber-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2 transition-colors">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                      </svg>
                      Edit
                    </a>

                    {{-- Lihat (biru) --}}
                    <a href="{{ route('admin.fasilitas.show', $item->id) }}"
                      class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-blue-200 text-blue-700 bg-blue-50
                              hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2 transition-colors">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                      Lihat
                    </a>

                    {{-- Hapus (merah) --}}
                    <form action="{{ route('admin.fasilitas.destroy', $item->id) }}"
                          method="POST" onsubmit="return confirm('Hapus fasilitas \"{{ $item->nama_fasilitas }}\"?');" class="inline">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center gap-1.5 px-2.5 py-1.5 text-xs font-medium rounded-md
                                    border border-red-200 text-red-700 bg-red-50
                                    hover:bg-red-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 transition-colors">
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

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Auto-submit form urutan ketika nilai berubah
      const urutanInputs = document.querySelectorAll('input[name="urutan_tampil"]');
      
      urutanInputs.forEach(input => {
        input.addEventListener('change', function() {
          this.disabled = true;
          this.form.submit();
        });
      });

      // Sweet alert untuk konfirmasi
      const deleteForms = document.querySelectorAll('form[onsubmit]');
      deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
          if (!confirm(this.getAttribute('onsubmit').replace('return confirm(', '').replace(');', '').replace(/'/g, ''))) {
            e.preventDefault();
          }
        });
      });
    });
  </script>
  @endpush

  <style>
    #table-fasilitas th, #table-fasilitas td { vertical-align: middle !important; }
    #table-fasilitas th:nth-child(1), #table-fasilitas td:nth-child(1) { width: 64px; text-align:center; }
    #table-fasilitas th:nth-child(4),
    #table-fasilitas th:nth-child(5),
    #table-fasilitas th:nth-child(7),
    #table-fasilitas td:nth-child(4),
    #table-fasilitas td:nth-child(5),
    #table-fasilitas td:nth-child(7) { text-align:center; }
    #table-fasilitas td:nth-child(3) { max-width: 200px; }
  </style>
</x-app-layout>