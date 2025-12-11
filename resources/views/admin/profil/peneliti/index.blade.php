<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Profil - Kelola Peneliti') }}
    </h2>
  </x-slot>

  <div class="min-h-screen py-6 bg-gray-100">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-8">
      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        
        <!-- Header dengan aksi -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
          <div>
            <h3 class="text-lg font-semibold text-gray-900">Daftar Peneliti</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola data peneliti dan penampilan di beranda</p>
          </div>
          <a href="{{ route('admin.profil.peneliti.create') }}"
             class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Peneliti
          </a>
        </div>

        <!-- DataTable -->
        <div class="overflow-x-auto">
          <x-datatable id="table-peneliti" order='[6,"asc"]' :page-length="10" :buttons="true">
            <thead>
              <tr class="bg-gray-50">
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posisi</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bidang Keahlian</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Urutan</th>
                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($peneliti as $p)
              @php
                $foto = $p->foto_url;
                $bidang_utama = $p->bidang_utama;
                $status_cls = match($p->status) {
                  'Aktif' => 'bg-green-100 text-green-800',
                  'Pensiun' => 'bg-gray-100 text-gray-800',
                  'Alumni' => 'bg-blue-100 text-blue-800',
                  'Mitra' => 'bg-purple-100 text-purple-800',
                  default => 'bg-gray-100 text-gray-800'
                };
                $tipe_cls = match($p->tipe) {
                  'Internal' => 'bg-indigo-100 text-indigo-800',
                  'Eksternal' => 'bg-orange-100 text-orange-800',
                  'Kolaborator' => 'bg-teal-100 text-teal-800',
                  default => 'bg-gray-100 text-gray-800'
                };
              @endphp

              <tr class="hover:bg-gray-50 transition-colors duration-150" data-id="{{ $p->id }}">
                <!-- Foto -->
                <td class="px-4 py-3 whitespace-nowrap">
                  <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden">
                    @if($foto)
                      <img src="{{ $foto }}" alt="{{ $p->nama }}" class="h-full w-full object-cover">
                    @else
                      <svg class="h-5 w-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12a5 5 0 1 0 0-10 5 5 0 0 0 0 10zm0 2c-4.42 0-8 3.58-8 8h16c0-4.42-3.58-8-8-8z"/>
                      </svg>
                    @endif
                  </div>
                </td>

                <!-- Nama & Info -->
                <td class="px-4 py-3">
                  <div class="flex flex-col">
                    <span class="font-medium text-gray-900">{{ $p->nama_lengkap }}</span>
                    @if($p->jabatan)
                      <span class="text-sm text-gray-500">{{ $p->jabatan }}</span>
                    @endif
                    @if($p->email)
                      <span class="text-xs text-gray-400 truncate max-w-xs">{{ $p->email }}</span>
                    @endif
                  </div>
                </td>

                <!-- Posisi -->
                <td class="px-4 py-3 text-sm text-gray-900">{{ $p->posisi }}</td>

                <!-- Bidang Keahlian -->
                <td class="px-4 py-3">
                  @if($bidang_utama)
                    <div class="flex flex-wrap gap-1">
                      <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        {{ $bidang_utama }}
                      </span>
                      @if(count($p->bidang_keahlian ?? []) > 1)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                          +{{ count($p->bidang_keahlian) - 1 }}
                        </span>
                      @endif
                    </div>
                  @else
                    <span class="text-gray-400 text-sm">-</span>
                  @endif
                </td>

                <!-- Status -->
                <td class="px-4 py-3">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status_cls }}">
                    {{ $p->status }}
                  </span>
                </td>

                <!-- Tipe -->
                <td class="px-4 py-3">
                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tipe_cls }}">
                    {{ $p->tipe }}
                  </span>
                </td>

                <!-- Urutan -->
                <td class="px-4 py-3 text-sm text-gray-900 font-mono">{{ $p->urutan }}</td>

                <!-- Aksi -->
                <td class="px-4 py-3 whitespace-nowrap text-center">
                  <div class="flex items-center justify-center space-x-2">
                    <!-- Edit -->
                    <a href="{{ route('admin.profil.peneliti.edit', $p) }}"
                      class="inline-flex items-center p-1.5 border border-transparent rounded text-indigo-600 hover:bg-indigo-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-150"
                      title="Edit">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                      </svg>
                    </a>

                    <!-- Lihat -->
                    <a href="{{ route('admin.profil.peneliti.show', $p) }}"
                      class="inline-flex items-center p-1.5 border border-transparent rounded text-blue-600 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-150"
                      title="Lihat">
                      <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                    </a>

                    <!-- Hapus -->
                    <form action="{{ route('admin.profil.peneliti.destroy', $p) }}"
                          method="POST" onsubmit="return confirm('Hapus peneliti {{ $p->nama }}?');" class="inline">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="inline-flex items-center p-1.5 border border-transparent rounded text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-150"
                              title="Hapus">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
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

      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Tambahkan efek hover untuk seluruh baris tabel
      const rows = document.querySelectorAll('#table-peneliti tbody tr');
      
      rows.forEach(row => {
        row.addEventListener('mouseenter', function() {
          this.style.backgroundColor = '#f9fafb';
        });
        
        row.addEventListener('mouseleave', function() {
          if (!this.classList.contains('selected')) {
            this.style.backgroundColor = '';
          }
        });
        
        // Klik untuk memilih baris (opsional untuk bulk actions)
        row.addEventListener('click', function(e) {
          // Hindari seleksi jika mengklik tautan atau tombol
          if (e.target.tagName === 'A' || e.target.tagName === 'BUTTON' || e.target.closest('a') || e.target.closest('button')) {
            return;
          }
          
          this.classList.toggle('selected');
          if (this.classList.contains('selected')) {
            this.style.backgroundColor = '#eff6ff';
          } else {
            this.style.backgroundColor = '';
          }
        });
      });
      
      // Animasi untuk tombol aksi
      const actionButtons = document.querySelectorAll('a, button');
      actionButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
          this.style.transform = 'translateY(-1px)';
        });
        
        button.addEventListener('mouseleave', function() {
          this.style.transform = '';
        });
      });
    });
  </script>

  <style>
    /* Transisi halus untuk semua elemen interaktif */
    a, button, tr {
      transition: all 0.2s ease-in-out;
    }
    
    /* Efek untuk baris yang dipilih */
    tr.selected {
      background-color: #eff6ff !important;
      border-left: 3px solid #3b82f6;
    }
    
    /* Efek hover untuk tombol aksi */
    .action-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    /* Styling untuk badge/status */
    .badge {
      display: inline-flex;
      align-items: center;
      padding: 0.25rem 0.5rem;
      border-radius: 9999px;
      font-size: 0.75rem;
      font-weight: 500;
      line-height: 1;
    }
  </style>
  @endpush
</x-app-layout> 