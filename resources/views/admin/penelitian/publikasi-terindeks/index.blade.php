<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Penelitian - Publikasi Terindeks') }}
    </h2>
  </x-slot>

  <div class="py-12" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        {{-- Filter Section --}}
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
          <form method="GET" action="{{ route('admin.penelitian.publikasi-terindeks.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              {{-- Search --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Judul, penulis, atau jurnal..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>

              {{-- Filter Indeksasi --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Indeksasi</label>
                <select name="indeksasi" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="">Semua</option>
                  @foreach($indeksasiOptions as $key => $label)
                    <option value="{{ $key }}" {{ request('indeksasi') == $key ? 'selected' : '' }}>
                      {{ $label }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- Filter Tahun --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                <select name="tahun" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="">Semua Tahun</option>
                  @foreach($years as $year)
                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                      {{ $year }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- Filter Status --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="">Semua</option>
                  <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                  <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
              </div>
            </div>

            <div class="flex gap-3">
              <button type="submit" 
                      class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Terapkan Filter
              </button>
              <a href="{{ route('admin.penelitian.publikasi-terindeks.index') }}" 
                 class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Reset
              </a>
            </div>
          </form>
        </div>

        <div class="flex items-center justify-between mb-6">
          <p class="font-semibold text-zinc-900 text-lg">Daftar Publikasi Terindeks</p>
          <a href="{{ route('admin.penelitian.publikasi-terindeks.create') }}"
             class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm font-medium">
            + Tambah Publikasi
          </a>
        </div>

        {{-- DataTable --}}
        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-publikasi" order='[6,"desc"]' :page-length="10" :buttons="true">
            <thead>
              <tr>
                <th style="width: 60px;">Cover</th>
                <th>Judul Publikasi</th>
                <th>Penulis</th>
                <th>Jurnal</th>
                <th>Indeksasi</th>
                <th>Tahun</th>
                <th>Status</th>
                <th style="min-width:180px; text-align:center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($publikasis as $publikasi)
              @php
                // Cover image
                $cover = $publikasi->cover_image ? Storage::url($publikasi->cover_image) : null;
                
                // Status
                $statusClass = $publikasi->is_active 
                  ? 'bg-green-100 text-green-800 border-green-200' 
                  : 'bg-red-100 text-red-800 border-red-200';
                $statusText = $publikasi->is_active ? 'Aktif' : 'Nonaktif';
                
                // Quartile display
                $quartileDisplay = $publikasi->quartile 
                  ? 'Q' . $publikasi->quartile 
                  : '-';
              @endphp

              <tr class="align-middle hover:bg-gray-50">
                {{-- Cover Image --}}
                <td class="py-3">
                  <div class="h-12 w-12 rounded bg-white border border-zinc-200 flex items-center justify-center overflow-hidden">
                    @if($cover)
                      <img src="{{ $cover }}" alt="{{ $publikasi->judul }}" 
                           class="h-full w-full object-cover">
                    @else
                      <span class="text-[10px] text-zinc-500 px-1 text-center leading-tight">
                        No<br>Image
                      </span>
                    @endif
                  </div>
                </td>

                {{-- Judul --}}
                <td class="font-medium text-zinc-800">
                  <div class="line-clamp-2">{{ $publikasi->judul }}</div>
                  @if($publikasi->doi)
                    <div class="text-xs text-zinc-500 mt-1">
                      DOI: {{ Str::limit($publikasi->doi, 30) }}
                    </div>
                  @endif
                </td>

                {{-- Penulis --}}
                <td class="text-zinc-700">
                  <div class="line-clamp-2">{{ Str::limit($publikasi->penulis, 30) }}</div>
                </td>

                {{-- Jurnal --}}
                <td class="text-zinc-700">
                  <div class="font-medium">{{ Str::limit($publikasi->nama_jurnal, 25) }}</div>
                  <div class="text-xs text-zinc-500">
                    {{ $quartileDisplay }}
                    @if($publikasi->impact_factor)
                      | IF: {{ $publikasi->impact_factor }}
                    @endif
                  </div>
                </td>

                {{-- Indeksasi --}}
                <td class="text-zinc-700">
                  <span class="px-2 py-1 rounded text-xs bg-blue-50 text-blue-700 border border-blue-100">
                    {{ $publikasi->indeksasi }}
                  </span>
                </td>

                {{-- Tahun --}}
                <td class="text-zinc-700 text-center font-medium">
                  {{ $publikasi->tahun_terbit }}
                </td>

                {{-- Status --}}
                <td class="text-center">
                  <form action="{{ route('admin.penelitian.publikasi-terindeks.toggle-status', $publikasi->id) }}" 
                        method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="px-3 py-1 rounded text-xs {{ $statusClass }} border hover:opacity-80">
                      {{ $statusText }}
                    </button>
                  </form>
                </td>

                {{-- Aksi --}}
                <td>
                  <div class="flex items-center justify-center gap-2">
                    {{-- Edit --}}
                    <a href="{{ route('admin.penelitian.publikasi-terindeks.edit', $publikasi->id) }}"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md
                              border border-amber-200 text-amber-800 bg-amber-50
                              hover:bg-amber-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                      </svg>
                      Edit
                    </a>

                    {{-- Lihat --}}
                    <a href="{{ route('admin.penelitian.publikasi-terindeks.show', $publikasi->id) }}"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md
                              border border-blue-200 text-blue-700 bg-blue-50
                              hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                      <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                      Lihat
                    </a>

                    {{-- Download PDF --}}
                    @if($publikasi->file_pdf)
                      <a href="{{ route('admin.penelitian.publikasi-terindeks.download', $publikasi->id) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md
                                border border-green-200 text-green-700 bg-green-50
                                hover:bg-green-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-400 focus-visible:ring-offset-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                          <polyline points="7 10 12 15 17 10"/>
                          <line x1="12" y1="15" x2="12" y2="3"/>
                        </svg>
                        PDF
                      </a>
                    @endif

                    {{-- Hapus --}}
                    <form action="{{ route('admin.penelitian.publikasi-terindeks.destroy', $publikasi->id) }}"
                          method="POST" onsubmit="return confirm('Hapus publikasi ini?');" class="inline">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md
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

        {{-- Pagination --}}
        @if($publikasis->hasPages())
          <div class="mt-6">
            {{ $publikasis->links() }}
          </div>
        @endif

      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      // Inisialisasi DataTable dengan konfigurasi tambahan
      document.addEventListener('DOMContentLoaded', function() {
        const table = document.getElementById('table-publikasi');
        if (table) {
          // DataTable sudah diinisialisasi oleh komponen x-datatable
          // Tambahkan custom script jika diperlukan
        }
        
        // Konfirmasi sebelum toggle status
        document.querySelectorAll('form[action*="toggle-status"]').forEach(form => {
          form.addEventListener('submit', function(e) {
            if (!confirm('Ubah status publikasi?')) {
              e.preventDefault();
            }
          });
        });
      });
    </script>
  @endpush
</x-app-layout>