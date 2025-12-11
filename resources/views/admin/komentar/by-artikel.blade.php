<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Komentar di Artikel: ') . $artikel->judul }}
    </h2>
  </x-slot>

  <div class="py-12" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        
        {{-- Artikel Info --}}
        <div class="mb-8 p-4 bg-gray-50 rounded-lg border border-gray-200">
          <div class="flex items-start">
            @if($artikel->thumbnail_path)
            <div class="flex-shrink-0 h-16 w-16 mr-4">
              <img src="{{ Storage::url($artikel->thumbnail_path) }}" 
                   alt="{{ $artikel->judul }}"
                   class="h-full w-full object-cover rounded">
            </div>
            @endif
            <div class="flex-grow">
              <h3 class="text-lg font-medium text-gray-900">
                <a href="{{ route('guest.artikel.show', $artikel->slug) }}" 
                   target="_blank"
                   class="hover:text-indigo-600 hover:underline">
                  {{ $artikel->judul }}
                </a>
              </h3>
              <div class="mt-2 flex flex-wrap items-center gap-2 text-sm text-gray-500">
                <span>Diterbitkan: {{ $artikel->published_at ? $artikel->published_at->translatedFormat('d F Y') : 'Draft' }}</span>
                <span>•</span>
                <span>Kategori: {{ $artikel->kategori ?? 'Tidak ada' }}</span>
                <span>•</span>
                <span>Total Komentar: {{ $artikel->komentars->count() }}</span>
                <span>•</span>
                <span>Disetujui: {{ $artikel->komentarApproved()->count() }}</span>
                <span>•</span>
                <span>Pending: {{ $artikel->komentars()->pending()->count() }}</span>
              </div>
            </div>
            <div class="flex-shrink-0">
              <a href="{{ route('admin.publikasi-data.komentar.index') }}" 
                 class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Semua Komentar
              </a>
            </div>
          </div>
        </div>

        {{-- Filter Tabs --}}
        <div class="mb-6">
          <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8">
              <a href="{{ route('admin.publikasi-data.komentar.by-artikel', ['artikel' => $artikel->id, 'status' => 'all']) }}" 
                 class="{{ request('status') == 'all' || !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Semua Komentar
              </a>
              <a href="{{ route('admin.publikasi-data.komentar.by-artikel', ['artikel' => $artikel->id, 'status' => 'pending']) }}" 
                 class="{{ request('status') == 'pending' ? 'border-orange-500 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Menunggu
              </a>
              <a href="{{ route('admin.publikasi-data.komentar.by-artikel', ['artikel' => $artikel->id, 'status' => 'approved']) }}" 
                 class="{{ request('status') == 'approved' ? 'border-green-500 text-green-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Disetujui
              </a>
            </nav>
          </div>
        </div>

        @if($komentars->count() > 0)
          <div class="overflow-x-auto" data-theme="light">
            <x-datatable id="table-komentar-artikel" order='[3,"desc"]' :page-length="20" :buttons="true">
              <thead>
                <tr>
                  <th>Komentar</th>
                  <th>Penulis</th>
                  <th>Tanggal</th>
                  <th>Status</th>
                  <th width="100">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach($komentars as $komentar)
                  <tr class="hover:bg-gray-50">
                    <td>
                      <div class="max-w-md">
                        <div class="text-sm font-medium text-gray-900 line-clamp-2">
                          {{ Str::limit($komentar->konten, 100) }}
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
                    
                    <td>
                      <div class="text-sm text-gray-900">{{ $komentar->nama_komentar }}</div>
                      @if($komentar->email_komentar)
                        <div class="text-xs text-gray-500">{{ $komentar->email_komentar }}</div>
                      @endif
                    </td>
                    
                    <td class="whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ $komentar->created_at->format('d/m/Y') }}</div>
                      <div class="text-xs text-gray-500">{{ $komentar->created_at->format('H:i') }}</div>
                    </td>
                    
                    <td>
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
                    
                    <td>
                      <div class="flex items-center space-x-2">
                        @if(!$komentar->is_approved)
                        <form action="{{ route('admin.publikasi-data.komentar.approve', $komentar) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Setujui komentar ini?')">
                          @csrf
                          <button type="submit" 
                                  class="text-green-600 hover:text-green-900"
                                  title="Setujui">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                          </button>
                        </form>
                        @endif
                        
                        <form action="{{ route('admin.publikasi-data.komentar.reject', $komentar) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Tolak komentar ini?')">
                          @csrf
                          <button type="submit" 
                                  class="text-red-600 hover:text-red-900"
                                  title="Tolak">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
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
            </x-datatable>
          </div>
          
          <div class="mt-4">
            {{ $komentars->links() }}
          </div>
          
        @else
          <div class="text-center py-12">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada komentar</h3>
            <p class="text-gray-500">
              @if(request('status') == 'pending')
                Tidak ada komentar yang menunggu persetujuan di artikel ini.
              @elseif(request('status') == 'approved')
                Belum ada komentar yang disetujui di artikel ini.
              @else
                Belum ada komentar di artikel ini.
              @endif
            </p>
          </div>
        @endif
        
      </div>
    </div>
  </div>
</x-app-layout>