<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Penelitian - Seminar') }}
    </h2>
  </x-slot>

  <div class="pb-12" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        {{-- Filter Section --}}
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
          <form method="GET" action="{{ route('admin.penelitian.seminar.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
              {{-- Search --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Judul, pembicara, atau tempat..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
              </div>

              {{-- Filter Tipe --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipe</label>
                <select name="tipe" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="">Semua Tipe</option>
                  @foreach($tipeOptions as $key => $label)
                    <option value="{{ $key }}" {{ request('tipe') == $key ? 'selected' : '' }}>
                      {{ $label }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- Filter Format --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Format</label>
                <select name="format" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="">Semua Format</option>
                  @foreach($formatOptions as $key => $label)
                    <option value="{{ $key }}" {{ request('format') == $key ? 'selected' : '' }}>
                      {{ $label }}
                    </option>
                  @endforeach
                </select>
              </div>

              {{-- Filter Status --}}
              <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="">Semua Status</option>
                  <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                  <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                  <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                  <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                </select>
              </div>
            </div>

            <div class="flex gap-3">
              <button type="submit" 
                      class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Terapkan Filter
              </button>
              <a href="{{ route('admin.penelitian.seminar.index') }}" 
                 class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Reset
              </a>
            </div>
          </form>
        </div>

        <div class="flex items-center justify-between mb-6">
          <p class="font-semibold text-zinc-900 text-lg">Daftar Seminar</p>
          <a href="{{ route('admin.penelitian.seminar.create') }}"
             class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm font-medium">
            + Tambah Seminar
          </a>
        </div>

        {{-- DataTable --}}
        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-seminar" order='[5,"asc"]' :page-length="10" :buttons="true">
            <thead>
              <tr>
                <th style="width: 80px;">Poster</th>
                <th>Judul Seminar</th>
                <th>Pembicara</th>
                <th>Tipe & Format</th>
                <th>Status</th>
                <th>Tanggal & Waktu</th>
                <th style="min-width:200px; text-align:center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
            @foreach($seminars as $seminar)
              @php
                // Poster image
                $poster = $seminar->poster ? Storage::url($seminar->poster) : null;
                
                // Status badge
                $statusColor = $seminar->is_cancelled ? 'bg-red-100 text-red-800 border-red-200' : 
                              ($seminar->is_published ? 'bg-green-100 text-green-800 border-green-200' : 
                              'bg-gray-100 text-gray-800 border-gray-200');
                $statusText = $seminar->is_cancelled ? 'Dibatalkan' : 
                             ($seminar->is_published ? 'Published' : 'Draft');
                
                // Format tanggal
                $tanggal = $seminar->tanggal->format('d M Y');
                $waktu = $seminar->waktu_mulai->format('H:i');
              @endphp

              <tr class="align-middle hover:bg-gray-50">
                {{-- Poster --}}
                <td class="py-3">
                  <div class="h-16 w-16 rounded bg-white border border-zinc-200 flex items-center justify-center overflow-hidden">
                    @if($poster)
                      <img src="{{ $poster }}" alt="{{ $seminar->judul }}" 
                           class="h-full w-full object-cover">
                    @else
                      <span class="text-[10px] text-zinc-500 px-1 text-center leading-tight">
                        No<br>Poster
                      </span>
                    @endif
                  </div>
                </td>

                {{-- Judul --}}
                <td class="font-medium text-zinc-800">
                  <div class="line-clamp-2">{{ $seminar->judul }}</div>
                  @if($seminar->ringkasan)
                    <div class="text-xs text-zinc-500 mt-1 line-clamp-1">
                      {{ Str::limit($seminar->ringkasan, 50) }}
                    </div>
                  @endif
                </td>

                {{-- Pembicara --}}
                <td class="text-zinc-700">
                  <div class="font-medium">{{ $seminar->pembicara }}</div>
                  @if($seminar->institusi_pembicara)
                    <div class="text-xs text-zinc-500">{{ $seminar->institusi_pembicara }}</div>
                  @endif
                </td>

                {{-- Tipe & Format --}}
                <td class="text-zinc-700">
                  <div class="flex flex-col gap-1">
                    <span class="px-2 py-1 rounded text-xs bg-blue-50 text-blue-700 border border-blue-100">
                      {{ $tipeOptions[$seminar->tipe] ?? $seminar->tipe }}
                    </span>
                    <span class="px-2 py-1 rounded text-xs bg-purple-50 text-purple-700 border border-purple-100">
                      {{ $formatOptions[$seminar->format] ?? $seminar->format }}
                    </span>
                  </div>
                </td>

                {{-- Status --}}
                <td class="text-center">
                  <div class="flex flex-col gap-1 items-center">
                    <span class="px-3 py-1 rounded text-xs {{ $statusColor }} border">
                      {{ $statusText }}
                    </span>
                    
                    @if($seminar->is_featured)
                      <span class="px-2 py-1 rounded text-xs bg-yellow-50 text-yellow-700 border border-yellow-100">
                        Featured
                      </span>
                    @endif
                  </div>
                </td>

                {{-- Tanggal & Waktu --}}
                <td class="text-zinc-700">
                  <div class="font-medium">{{ $tanggal }}</div>
                  <div class="text-sm text-zinc-500">{{ $waktu }}</div>
                  <div class="text-xs text-zinc-500">{{ $seminar->tempat }}</div>
                </td>

                {{-- Aksi --}}
                <td>
                  <div class="flex items-center justify-center gap-2 flex-wrap">
                    {{-- Toggle Published --}}
                    <form action="{{ route('admin.penelitian.seminar.toggle-published', $seminar->id) }}" 
                          method="POST" class="inline">
                      @csrf
                      <button type="submit" 
                              class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md
                                     border {{ $seminar->is_published ? 'border-green-200 text-green-700 bg-green-50 hover:bg-green-100' : 'border-gray-200 text-gray-700 bg-gray-50 hover:bg-gray-100' }}">
                        @if($seminar->is_published)
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                          </svg>
                        @else
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L6.59 6.59m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                          </svg>
                        @endif
                        {{ $seminar->is_published ? 'Hide' : 'Publish' }}
                      </button>
                    </form>

                    {{-- Toggle Featured --}}
                    <form action="{{ route('admin.penelitian.seminar.toggle-featured', $seminar->id) }}" 
                          method="POST" class="inline">
                      @csrf
                      <button type="submit" 
                              class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md
                                     border {{ $seminar->is_featured ? 'border-yellow-200 text-yellow-700 bg-yellow-50 hover:bg-yellow-100' : 'border-gray-200 text-gray-700 bg-gray-50 hover:bg-gray-100' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        {{ $seminar->is_featured ? 'Unfeature' : 'Feature' }}
                      </button>
                    </form>

                    {{-- Toggle Cancelled --}}
                    <form action="{{ route('admin.penelitian.seminar.toggle-cancelled', $seminar->id) }}" 
                          method="POST" class="inline">
                      @csrf
                      <button type="submit" 
                              class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md
                                     border {{ $seminar->is_cancelled ? 'border-red-200 text-red-700 bg-red-50 hover:bg-red-100' : 'border-gray-200 text-gray-700 bg-gray-50 hover:bg-gray-100' }}">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        {{ $seminar->is_cancelled ? 'Aktifkan' : 'Batalkan' }}
                      </button>
                    </form>

                    {{-- Edit --}}
                    <a href="{{ route('admin.penelitian.seminar.edit', $seminar->id) }}"
                      class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-amber-200 text-amber-800 bg-amber-50
                              hover:bg-amber-100">
                      <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                      </svg>
                      Edit
                    </a>

                    {{-- Lihat --}}
                    <a href="{{ route('guest.seminar.show', $seminar->slug) }}" target="_blank"
                      class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md
                              border border-blue-200 text-blue-700 bg-blue-50
                              hover:bg-blue-100">
                      <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                        <circle cx="12" cy="12" r="3"/>
                      </svg>
                      Lihat
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('admin.penelitian.seminar.destroy', $seminar->id) }}"
                          method="POST" onsubmit="return confirm('Hapus seminar ini?');" class="inline">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md
                                    border border-red-200 text-red-700 bg-red-50
                                    hover:bg-red-100">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
        @if($seminars->hasPages())
          <div class="mt-6">
            {{ $seminars->links() }}
          </div>
        @endif

      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        // Konfirmasi sebelum toggle status
        document.querySelectorAll('form[action*="toggle-"]').forEach(form => {
          form.addEventListener('submit', function(e) {
            const action = this.getAttribute('action');
            let message = '';
            
            if (action.includes('toggle-published')) {
              message = 'Ubah status publikasi seminar?';
            } else if (action.includes('toggle-featured')) {
              message = 'Ubah status featured seminar?';
            } else if (action.includes('toggle-cancelled')) {
              message = 'Ubah status batal seminar?';
            } else {
              message = 'Lanjutkan aksi ini?';
            }
            
            if (!confirm(message)) {
              e.preventDefault();
            }
          });
        });
      });
    </script>
  @endpush

  @push('styles')
    <style>
      .line-clamp-1 {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }
      
      .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }
      
      #table-seminar th, #table-seminar td { 
        vertical-align: middle !important; 
      }
      
      #table-seminar th:nth-child(1), 
      #table-seminar td:nth-child(1) { 
        width: 80px; 
        text-align: center; 
      }
      
      #table-seminar th:nth-child(5),
      #table-seminar th:nth-child(7),
      #table-seminar td:nth-child(5),
      #table-seminar td:nth-child(7) { 
        text-align: center; 
      }
    </style>
  @endpush
</x-app-layout>