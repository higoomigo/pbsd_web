<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Fasilitas - Detail Fasilitas') }}
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
        
        {{-- Header dengan Gambar --}}
        <div class="relative h-64 sm:h-80 bg-gray-200">
          @if($fasilitas->gambar_path)
            <img src="{{ Storage::url($fasilitas->gambar_path) }}" 
                 alt="{{ $fasilitas->alt_text ?? $fasilitas->nama_fasilitas }}"
                 class="w-full h-full object-cover">
          @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100">
              <div class="text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <p class="mt-2 text-gray-500">Tidak ada gambar</p>
              </div>
            </div>
          @endif
          
          {{-- Badge Status Beranda --}}
          @if($fasilitas->tampil_beranda)
            <div class="absolute top-4 right-4">
              <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">
                ✓ Tampil di Beranda
              </span>
            </div>
          @endif
        </div>

        {{-- Content --}}
        <div class="p-6">
          {{-- Navigation --}}
          <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.fasilitas.index') }}" 
               class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
              <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
              </svg>
              Kembali ke Daftar
            </a>
            
            <div class="flex items-center space-x-3">
              {{-- Edit Button --}}
              <a href="{{ route('admin.fasilitas.edit', $fasilitas->id) }}"
                 class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md
                        border border-amber-200 text-amber-800 bg-amber-50
                        hover:bg-amber-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-amber-400 focus-visible:ring-offset-2 transition-colors">
                <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M12 20h9"/>
                  <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                </svg>
                Edit
              </a>

              {{-- Delete Button --}}
              <form action="{{ route('admin.fasilitas.destroy', $fasilitas->id) }}" 
                    method="POST" 
                    onsubmit="return confirm('Hapus fasilitas \"{{ $fasilitas->nama_fasilitas }}\"?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-md
                              border border-red-200 text-red-700 bg-red-50
                              hover:bg-red-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-400 focus-visible:ring-offset-2 transition-colors">
                  <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
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
          </div>

          {{-- Main Content --}}
          <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Informasi Utama --}}
            <div class="lg:col-span-2">
              <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $fasilitas->nama_fasilitas }}</h1>
              
              {{-- Deskripsi --}}
              <div class="prose max-w-none mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Deskripsi</h3>
                <div class="text-gray-600 leading-relaxed whitespace-pre-line">
                  {{ $fasilitas->deskripsi }}
                </div>
              </div>

              {{-- Informasi Gambar --}}
              @if($fasilitas->alt_text)
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                  <h4 class="text-sm font-medium text-blue-800 mb-2">Alt Text (Aksesibilitas)</h4>
                  <p class="text-blue-700">{{ $fasilitas->alt_text }}</p>
                </div>
              @endif
            </div>

            {{-- Sidebar Informasi --}}
            <div class="lg:col-span-1">
              <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Fasilitas</h3>
                
                <div class="space-y-4">
                  {{-- Status Beranda --}}
                  <div>
                    <dt class="text-sm font-medium text-gray-500">Status Beranda</dt>
                    <dd class="mt-1">
                      <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $fasilitas->tampil_beranda ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $fasilitas->tampil_beranda ? 'Ditampilkan di Beranda' : 'Tidak Ditampilkan' }}
                      </span>
                    </dd>
                  </div>

                  {{-- Urutan Tampil --}}
                  <div>
                    <dt class="text-sm font-medium text-gray-500">Urutan Tampil</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      <span class="font-mono bg-white border border-gray-300 rounded px-2 py-1">
                        {{ $fasilitas->urutan_tampil }}
                      </span>
                    </dd>
                  </div>

                  {{-- Metadata --}}
                  <div class="pt-4 border-t border-gray-200">
                    <dt class="text-sm font-medium text-gray-500">Dibuat</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ $fasilitas->created_at->translatedFormat('d F Y') }}
                      <span class="text-gray-500">• {{ $fasilitas->created_at->format('H:i') }}</span>
                    </dd>
                  </div>

                  <div>
                    <dt class="text-sm font-medium text-gray-500">Diupdate Terakhir</dt>
                    <dd class="mt-1 text-sm text-gray-900">
                      {{ $fasilitas->updated_at->translatedFormat('d F Y') }}
                      <span class="text-gray-500">• {{ $fasilitas->updated_at->format('H:i') }}</span>
                    </dd>
                  </div>

                  {{-- Quick Actions --}}
                  <div class="pt-4 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Aksi Cepat</h4>
                    <div class="space-y-2">
                      {{-- Toggle Beranda --}}
                      <form action="{{ route('admin.fasilitas.updateTampilBeranda', $fasilitas->id) }}" method="POST" class="inline-block w-full">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="tampil_beranda" value="{{ $fasilitas->tampil_beranda ? 0 : 1 }}">
                        <button type="submit" 
                                class="w-full text-left px-3 py-2 text-sm rounded-md {{ $fasilitas->tampil_beranda ? 'bg-orange-50 text-orange-700 border border-orange-200' : 'bg-green-50 text-green-700 border border-green-200' }} hover:opacity-80 transition-opacity">
                          {{ $fasilitas->tampil_beranda ? '✕ Sembunyikan dari Beranda' : '✓ Tampilkan di Beranda' }}
                        </button>
                      </form>

                      {{-- Copy Image URL --}}
                      @if($fasilitas->gambar_path)
                        <button type="button" 
                                onclick="copyImageUrl('{{ Storage::url($fasilitas->gambar_path) }}')"
                                class="w-full text-left px-3 py-2 text-sm bg-blue-50 text-blue-700 border border-blue-200 rounded-md hover:bg-blue-100 transition-colors">
                          📋 Copy URL Gambar
                        </button>
                      @endif
                    </div>
                  </div>
                </div>
              </div>

              {{-- Preview di Beranda --}}
              @if($fasilitas->tampil_beranda)
                <div class="mt-6 bg-green-50 rounded-lg p-4 border border-green-200">
                  <h4 class="text-sm font-medium text-green-800 mb-2">✓ Tampil di Beranda</h4>
                  <p class="text-sm text-green-700">
                    Fasilitas ini akan ditampilkan di halaman beranda dengan urutan ke-{{ $fasilitas->urutan_tampil }}.
                  </p>
                </div>
              @else
                <div class="mt-6 bg-gray-100 rounded-lg p-4 border border-gray-300">
                  <h4 class="text-sm font-medium text-gray-700 mb-2">✕ Tidak Tampil di Beranda</h4>
                  <p class="text-sm text-gray-600">
                    Fasilitas ini tidak ditampilkan di halaman beranda.
                  </p>
                </div>
              @endif
            </div>
          </div>

          {{-- Image Details --}}
          @if($fasilitas->gambar_path)
            <div class="mt-8 pt-6 border-t border-gray-200">
              <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Gambar</h3>
              <div class="bg-gray-50 rounded-lg p-4">
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between">
                  <div class="flex items-center space-x-4 mb-4 sm:mb-0">
                    <div class="w-20 h-20 bg-white border border-gray-300 rounded-lg overflow-hidden">
                      <img src="{{ Storage::url($fasilitas->gambar_path) }}" 
                           alt="Thumbnail"
                           class="w-full h-full object-cover">
                    </div>
                    <div>
                      <p class="text-sm font-medium text-gray-900">Nama File</p>
                      <p class="text-sm text-gray-500 break-all">
                        {{ basename($fasilitas->gambar_path) }}
                      </p>
                    </div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <a href="{{ Storage::url($fasilitas->gambar_path) }}" 
                       target="_blank"
                       class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md
                              border border-gray-300 text-gray-700 bg-white
                              hover:bg-gray-50 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-400 focus-visible:ring-offset-2 transition-colors">
                      <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                      </svg>
                      Lihat Full Size
                    </a>
                  </div>
                </div>
              </div>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
  <script>
    function copyImageUrl(url) {
      navigator.clipboard.writeText(url).then(function() {
        // Show success message
        const button = event.target;
        const originalText = button.textContent;
        button.textContent = '✓ URL Disalin!';
        button.classList.remove('bg-blue-50', 'text-blue-700', 'border-blue-200');
        button.classList.add('bg-green-50', 'text-green-700', 'border-green-200');
        
        setTimeout(() => {
          button.textContent = originalText;
          button.classList.remove('bg-green-50', 'text-green-700', 'border-green-200');
          button.classList.add('bg-blue-50', 'text-blue-700', 'border-blue-200');
        }, 2000);
      }).catch(function(err) {
        alert('Gagal menyalin URL: ' + err);
      });
    }

    // Add some interactivity
    document.addEventListener('DOMContentLoaded', function() {
      // Add smooth scrolling for anchor links
      const anchorLinks = document.querySelectorAll('a[href^="#"]');
      anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
          e.preventDefault();
          const target = document.querySelector(this.getAttribute('href'));
          if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
          }
        });
      });
    });
  </script>
  @endpush

  <style>
    .prose h3 {
      margin-top: 0;
      margin-bottom: 0.5rem;
    }
    .whitespace-pre-line {
      white-space: pre-line;
    }
  </style>
</x-app-layout>