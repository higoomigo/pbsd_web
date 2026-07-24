<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Moderasi Komentar') }}
    </h2>
  </x-slot>

  <div class="py-12" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">

        {{-- Filter Tabs --}}
        <div class="mb-6">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
              <a href="{{ route('admin.publikasi-data.komentar.index', ['status' => 'all']) }}" 
                 class="{{ request('status') == 'all' || !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Semua Komentar
              </a>
              <a href="{{ route('admin.publikasi-data.komentar.index', ['status' => 'pending']) }}" 
                 class="{{ request('status') == 'pending' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Menunggu Persetujuan
                @php
                  $pendingCount = App\Models\Komentar::where('is_approved', false)->count();
                @endphp
                @if($pendingCount > 0)
                  <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                    {{ $pendingCount }}
                  </span>
                @endif
              </a>
              <a href="{{ route('admin.publikasi-data.komentar.index', ['status' => 'approved']) }}" 
                 class="{{ request('status') == 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Telah Disetujui
              </a>
            </nav>
          </div>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
          <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="text-green-700">{{ session('success') }}</span>
            </div>
          </div>
        @endif

        @if(session('error'))
          <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
            <div class="flex items-center">
              <svg class="w-5 h-5 text-red-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <span class="text-red-700">{{ session('error') }}</span>
            </div>
          </div>
        @endif

        @if($komentars->count() > 0)
        {{-- FORM BULK ACTION (HANYA UNTUK CHECKBOX DAN SELECT) --}}
        <div class="mb-6">
          <form method="POST" action="{{ route('admin.publikasi-data.komentar.bulk-action') }}" 
                id="bulkForm">
              @csrf
              
              <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-2 sm:space-y-0 mb-4">
                  <div class="flex-1">
                      <label for="bulkAction" class="block text-sm font-medium text-gray-700 mb-1">
                          Aksi Massal
                      </label>
                      <select name="action" id="bulkAction" 
                              class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                              required>
                          <option value="">-- Pilih Aksi --</option>
                          <option value="approve">Setujui yang Dipilih</option>
                          <option value="reject">Tolak yang Dipilih</option>
                          <option value="delete">Hapus yang Dipilih</option>
                      </select>
                  </div>
                  
                  <div class="flex items-end">
                      <button type="submit" 
                              class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                          <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                          </svg>
                          Terapkan ke yang Dipilih
                      </button>
                  </div>
              </div>

              {{-- DataTable --}}
              <div class="overflow-x-auto" data-theme="light">
                  <table id="table-komentar" class="min-w-full divide-y divide-gray-200">
                      <thead>
                          <tr>
                              <th width="30" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                  <input type="checkbox" id="checkAll">
                              </th>
                              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komentar</th>
                              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Artikel</th>
                              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                              <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                              <th width="120" class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                          </tr>
                      </thead>
                      <tbody class="bg-white divide-y divide-gray-200">
                          @foreach($komentars as $komentar)
                          <tr>
                              <td class="px-6 py-4 whitespace-nowrap">
                                  <input type="checkbox" name="ids[]" value="{{ $komentar->id }}" 
                                         class="bulk-checkbox">
                              </td>
                              <td class="px-6 py-4">
                                  <div class="max-w-xs">
                                      <div class="text-sm font-medium text-gray-900 line-clamp-2">
                                          {{ Str::limit($komentar->konten, 80) }}
                                      </div>
                                      @if($komentar->parent_id)
                                      <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                          <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                          </svg>
                                          Balasan
                                      </span>
                                      @endif
                                  </div>
                              </td>
                              <td class="px-6 py-4">
                                  @if($komentar->artikel)
                                  <a href="{{ route('guest.artikel.show', $komentar->artikel->slug) }}" 
                                     target="_blank"
                                     class="text-sm text-indigo-600 hover:text-indigo-900 hover:underline">
                                      {{ Str::limit($komentar->artikel->judul, 40) }}
                                  </a>
                                  @else
                                  <span class="text-sm text-gray-500">Artikel tidak ditemukan</span>
                                  @endif
                              </td>
                              <td class="px-6 py-4">
                                  <div class="text-sm text-gray-900">
                                      {{ $komentar->nama_komentar }}
                                  </div>
                                  @if($komentar->email_komentar)
                                  <div class="text-xs text-gray-500">
                                      {{ $komentar->email_komentar }}
                                  </div>
                                  @endif
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap">
                                  <div class="text-sm text-gray-900">
                                      {{ $komentar->created_at->format('d/m/Y') }}
                                  </div>
                                  <div class="text-xs text-gray-500">
                                      {{ $komentar->created_at->format('H:i') }}
                                  </div>
                              </td>
                              <td class="px-6 py-4">
                                  @if($komentar->is_approved)
                                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                      Disetujui
                                  </span>
                                  @else
                                  <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                      Menunggu
                                  </span>
                                  @endif
                              </td>
                              <td class="px-6 py-4 whitespace-nowrap">
                                  <div class="flex items-center space-x-2">
                                      {{-- FORM APPROVE INDIVIDUAL (DI LUAR FORM BULK) --}}
                                      @if(!$komentar->is_approved)
                                      <form action="{{ route('admin.publikasi-data.komentar.approve', $komentar) }}" 
                                            method="POST" class="inline form-approve" id="form-approve-{{ $komentar->id }}">
                                          @csrf
                                          <button type="submit" 
                                                  class="text-green-600 hover:text-green-900 approve-btn"
                                                  title="Setujui">
                                              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                              </svg>
                                          </button>
                                      </form>
                                      @endif
                                      
                                      {{-- FORM REJECT INDIVIDUAL (DI LUAR FORM BULK) --}}
                                      @if($komentar->is_approved)
                                      <form action="{{ route('admin.publikasi-data.komentar.reject', $komentar) }}" 
                                            method="POST" class="inline form-reject" id="form-reject-{{ $komentar->id }}">
                                          @csrf
                                          @method('POST')
                                          <button type="submit" 
                                                  class="text-red-600 hover:text-red-900 reject-btn"
                                                  title="Tolak">
                                              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                              </svg>
                                          </button>
                                      </form>
                                      @endif

                                        <form action="{{ route('admin.publikasi-data.komentar.destroy', $komentar) }}" 
                                            method="POST" class="inline form-delete" id="form-delete-{{ $komentar->id }}">
                                            @csrf
                                            @method('POST')
                                            <button type="submit" 
                                                    class="text-gray-600 hover:text-gray-900 delete-btn"
                                                    title="Hapus">
                                                {{-- IKON TEMPAT SAMPAH --}}
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                      
                                      <a href="{{ route('admin.publikasi-data.komentar.show', $komentar) }}" 
                                         class="text-blue-600 hover:text-blue-900"
                                         title="Detail">
                                          <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                          </svg>
                                      </a>
                                  </div>
                              </td>
                          </tr>
                          @endforeach
                      </tbody>
                  </table>
              </div>
          </form>
        </div>
        
        {{-- PAGINATION --}}
        <div class="mt-4">
            {{ $komentars->links() }}
        </div>
        
        @else
        {{-- TAMPILAN JIKA TIDAK ADA KOMENTAR --}}
        <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada komentar</h3>
            <p class="text-gray-500">
                @if(request('status') == 'pending')
                    Tidak ada komentar yang menunggu persetujuan.
                @elseif(request('status') == 'approved')
                    Belum ada komentar yang disetujui.
                @else
                    Belum ada komentar di sistem.
                @endif
            </p>
        </div>
        @endif

      </div>
    </div>
  </div>
</x-app-layout>

@push('scripts')
<script>
// SCRIPT FIX UNTUK SEMUA FUNGSIONALITAS

// 1. TOGGLE CHECKBOX UNTUK BULK ACTION
function toggleAllCheckboxes(source) {
    const checkboxes = document.querySelectorAll('.bulk-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = source.checked;
    });
}

// Inisialisasi checkAll checkbox
document.getElementById('checkAll')?.addEventListener('click', function() {
    toggleAllCheckboxes(this);
});

// 2. VALIDASI DAN SUBMIT BULK FORM
document.getElementById('bulkForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const action = document.getElementById('bulkAction').value;
    const checkboxes = document.querySelectorAll('.bulk-checkbox:checked');
    
    if (!action) {
        alert('Pilih aksi terlebih dahulu!');
        return false;
    }
    
    if (checkboxes.length === 0) {
        alert('Pilih minimal satu komentar!');
        return false;
    }
    
    const actionText = {
        'approve': 'menyetujui',
        'reject': 'menolak',
        'delete': 'menghapus'
    }[action];
    
    if (confirm(`Anda yakin ingin ${actionText} ${checkboxes.length} komentar?`)) {
        this.submit();
    }
});

// 3. FUNGSI APPROVE INDIVIDUAL DENGAN AJAX
document.addEventListener('DOMContentLoaded', function() {
    // Tangani tombol approve
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Penting: hentikan event bubbling
            
            const form = this.closest('form');
            if (confirm('Setujui komentar ini?')) {
                submitForm(form);
            }
        });
    });
    
    // Tangani tombol reject
    document.querySelectorAll('.reject-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Penting: hentikan event bubbling
            
            const form = this.closest('form');
            if (confirm('Tolak komentar ini?')) {
                submitForm(form);
            }
        });
    });
    
    // Auto update checkall status
    const checkboxes = document.querySelectorAll('.bulk-checkbox');
    const checkAll = document.getElementById('checkAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            if (checkAll) {
                checkAll.checked = allChecked;
                checkAll.indeterminate = checkboxes.length > 0 && 
                                       !allChecked && 
                                       Array.from(checkboxes).some(cb => cb.checked);
            }
        });
    });
});

// 4. FUNGSI SUBMIT FORM DENGAN AJAX (LEBIH BAIK)
function submitForm(form) {
    // Ambil CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    
    // Buat FormData
    const formData = new FormData(form);
    
    // Kirim dengan fetch API
    fetch(form.action, {
        method: form.method,
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (response.redirected) {
            // Jika ada redirect, arahkan ke URL tersebut
            window.location.href = response.url;
        } else if (response.ok) {
            // Reload halaman jika sukses
            window.location.reload();
        } else {
            throw new Error('Network response was not ok');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan. Silakan coba lagi.');
    });
}

// 5. ALTERNATIF: SUBMIT FORM TRADISIONAL (jika AJAX tidak bekerja)
function submitFormTraditional(form) {
    if (confirm('Lanjutkan aksi ini?')) {
        form.submit();
    }
}

// 6. FUNGSI APPROVE/REJECT BY ID (jika masih bermasalah)
function approveComment(id) {
    if (confirm('Setujui komentar ini?')) {
        const form = document.getElementById('form-approve-' + id);
        if (form) form.submit();
    }
}

function rejectComment(id) {
    if (confirm('Tolak komentar ini?')) {
        const form = document.getElementById('form-reject-' + id);
        if (form) form.submit();
    }
}
</script>

{{-- Jika perlu DataTable, inisialisasi manual --}}
{{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function() {
    // Inisialisasi DataTable manual
    $('#table-komentar').DataTable({
        "pageLength": 20,
        "order": [[4, "desc"]],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
        },
        "dom": '<"flex justify-between items-center mb-4"<"flex"l><"flex"f>>rt<"flex justify-between items-center mt-4"<"flex"i><"flex"p>>'
    });
});
</script> --}}
@endpush