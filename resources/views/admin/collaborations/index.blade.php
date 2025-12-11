<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Kontak Kolaborasi - Daftar Proposal') }}
    </h2>
  </x-slot>

  <div class="py-12" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        <div class="flex items-center justify-between mb-6">
          <div>
            <p class="font-semibold text-zinc-900 text-lg">Daftar Proposal Kolaborasi</p>
            <p class="text-sm text-zinc-500 mt-1">
              Total: {{ $collaborations->total() }} proposal
              @if($collaborations->total() > 0)
                (Menampilkan {{ $collaborations->firstItem() }} - {{ $collaborations->lastItem() }})
              @endif
            </p>
          </div>
          
          <div class="flex gap-2">
            <a href="{{ route('admin.kontak.export') }}"
               class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 text-sm flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
              </svg>
              Export CSV
            </a>
          </div>
        </div>

        {{-- Filter Options --}}
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
          <div class="flex flex-wrap gap-4 items-center">
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kolaborasi</label>
              <select id="filter-type" class="rounded-md border-gray-300 text-sm">
                <option value="">Semua Jenis</option>
                <option value="Penelitian Bersama">Penelitian Bersama</option>
                <option value="Konsultasi Akademik">Konsultasi Akademik</option>
                <option value="Kemitraan Industri">Kemitraan Industri</option>
                <option value="Program Magang">Program Magang</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>
            
            <div>
              <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
              <input type="date" id="filter-date" class="rounded-md border-gray-300 text-sm">
            </div>
            
            <div class="flex items-end">
              <button onclick="applyFilters()" 
                      class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 text-sm">
                Terapkan Filter
              </button>
            </div>
          </div>
        </div>

        {{-- DataTable --}}
        <div class="overflow-x-auto" data-theme="light">
          <x-datatable id="table-kolaborasi" order='[0, "desc"]' :page-length="10" :buttons="true">
            <thead>
              <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Institusi</th>
                <th>Email</th>
                <th>Jenis Kolaborasi</th>
                <th>Tanggal Dikirim</th>
                <th style="min-width:160px; text-align:center;">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($collaborations as $collaboration)
                @php
                  $created_at = $collaboration->created_at->format('d M Y, H:i');
                  $collab_type_color = [
                    'Penelitian Bersama' => 'bg-blue-100 text-blue-800',
                    'Konsultasi Akademik' => 'bg-purple-100 text-purple-800',
                    'Kemitraan Industri' => 'bg-green-100 text-green-800',
                    'Program Magang' => 'bg-amber-100 text-amber-800',
                    'Lainnya' => 'bg-gray-100 text-gray-800',
                  ][$collaboration->collaboration_type] ?? 'bg-gray-100 text-gray-800';
                @endphp

                <tr class="align-middle hover:bg-gray-50">
                  <td class="font-mono text-sm text-gray-600">#{{ $collaboration->id }}</td>
                  
                  <td class="font-medium text-zinc-800">
                    <div class="flex items-center gap-2">
                      <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-semibold text-sm">
                        {{ strtoupper(substr($collaboration->name, 0, 1)) }}
                      </div>
                      <div>
                        <div>{{ $collaboration->name }}</div>
                        @if(strlen($collaboration->message) > 50)
                          <div class="text-xs text-zinc-500 line-clamp-1 mt-0.5">
                            {{ substr($collaboration->message, 0, 50) }}...
                          </div>
                        @endif
                      </div>
                    </div>
                  </td>
                  
                  <td class="text-zinc-700">{{ $collaboration->institution }}</td>
                  
                  <td class="text-zinc-700">
                    <a href="mailto:{{ $collaboration->email }}" 
                       class="text-blue-600 hover:text-blue-800 hover:underline">
                      {{ $collaboration->email }}
                    </a>
                  </td>
                  
                  <td>
                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $collab_type_color }}">
                      {{ $collaboration->collaboration_type }}
                    </span>
                  </td>
                  
                  <td class="whitespace-nowrap text-zinc-700">
                    <div>{{ $created_at }}</div>
                    <div class="text-xs text-zinc-500">
                      {{ $collaboration->created_at->diffForHumans() }}
                    </div>
                  </td>
                  
                  <td>
                    <div class="flex items-center justify-center gap-2">
                      {{-- Lihat Detail (biru) --}}
                      <a href="{{ route('admin.kontak.show', $collaboration->id) }}"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md
                                border border-blue-200 text-blue-700 bg-blue-50
                                hover:bg-blue-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-400 focus-visible:ring-offset-2">
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/>
                          <circle cx="12" cy="12" r="3"/>
                        </svg>
                        Detail
                      </a>
                      
                      {{-- WhatsApp (hijau) --}}
                      {{-- <a href="https://wa.me/62{{ substr($collaboration->phone ?? '81234567890', 1) }}?text=Halo%20{{ urlencode($collaboration->name) }},%20kami%20menerima%20proposal%20kolaborasi%20Anda."
                         target="_blank"
                         class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-md
                                border border-green-200 text-green-700 bg-green-50
                                hover:bg-green-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-green-400 focus-visible:ring-offset-2">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                          <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.76.982.998-3.675-.236-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.9 6.994c-.004 5.45-4.437 9.88-9.885 9.88m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
                        </svg>
                        WhatsApp
                      </a> --}}
                      
                      {{-- Hapus (merah) --}}
                      <form action="{{ route('admin.kontak.destroy', $collaboration->id) }}"
                            method="POST" onsubmit="return confirm('Hapus data kolaborasi ini?');" class="inline">
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
          
          {{-- Pagination --}}
          @if($collaborations->hasPages())
            <div class="mt-4" data-theme="light">
              {{ $collaborations->links() }}
            </div>
          @endif
        </div>

      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    function applyFilters() {
      const type = document.getElementById('filter-type').value;
      const date = document.getElementById('filter-date').value;
      
      let url = new URL(window.location.href);
      
      if (type) {
        url.searchParams.set('type', type);
      } else {
        url.searchParams.delete('type');
      }
      
      if (date) {
        url.searchParams.set('date', date);
      } else {
        url.searchParams.delete('date');
      }
      
      window.location.href = url.toString();
    }
    
    // Initialize filter values from URL
    document.addEventListener('DOMContentLoaded', function() {
      const urlParams = new URLSearchParams(window.location.search);
      document.getElementById('filter-type').value = urlParams.get('type') || '';
      document.getElementById('filter-date').value = urlParams.get('date') || '';
    });
  </script>
  @endpush
  
  <style>
    #table-kolaborasi th, #table-kolaborasi td { 
      vertical-align: middle !important; 
      padding: 12px 8px;
    }
    #table-kolaborasi th:nth-child(1), 
    #table-kolaborasi td:nth-child(1) { 
      width: 80px; 
      text-align: center; 
    }
    #table-kolaborasi th:nth-child(6),
    #table-kolaborasi td:nth-child(6) { 
      width: 160px; 
    }
    #table-kolaborasi th:nth-child(7),
    #table-kolaborasi td:nth-child(7) { 
      width: 200px; 
      text-align: center; 
    }
  </style>
</x-app-layout>