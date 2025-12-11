<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Galeri') }} — Kelola Media
    </h2>
  </x-slot>
{{-- @dd($album) --}}
  <div class="py-8" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        
         {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
          <div>
            <p class="font-semibold text-zinc-900 text-lg">
              @if($album)
                Daftar Media: {{ $album->judul }}
              @else
                Daftar Media Galeri
              @endif
              <span class="block text-xs font-normal text-zinc-500">
                @if($album)
                  Kelola foto, video, dan YouTube di album "{{ $album->judul }}"
                @else
                  Kelola semua foto, video, dan YouTube
                @endif
              </span>
            </p>
          </div>

          <div class="flex items-center gap-3">
            <a href="{{ route('admin.publikasi-data.galeri.albums.index') }}"
               class="px-3 py-2 rounded-md border border-zinc-300 text-zinc-700 hover:bg-zinc-50 text-sm">
              Kelola Album
            </a>
            {{-- @dd($album) --}}
            <a href="{{ route('admin.publikasi-data.galeri.media.create') }}?album_id={{ request('album_id') }}"
                class="px-3 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700 text-sm">
                + Tambah Media
            </a>
          </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
          <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
            <div class="text-2xl font-bold text-blue-700">{{ $media->total() }}</div>
            <div class="text-sm text-blue-600">Total Media</div>
          </div>
          <div class="bg-green-50 p-4 rounded-lg border border-green-200">
            <div class="text-2xl font-bold text-green-700">{{ $media->where('tipe', 'foto')->count() }}</div>
            <div class="text-sm text-green-600">Foto</div>
          </div>
          <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
            <div class="text-2xl font-bold text-purple-700">{{ $media->where('tipe', 'video')->count() }}</div>
            <div class="text-sm text-purple-600">Video</div>
          </div>
          <div class="bg-red-50 p-4 rounded-lg border border-red-200">
            <div class="text-2xl font-bold text-red-700">{{ $media->where('tipe', 'youtube')->count() }}</div>
            <div class="text-sm text-red-600">YouTube</div>
          </div>
        </div>

        {{-- Media Grid --}}
        @if($media->count() > 0)
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($media as $item)
              <div class="bg-white border border-zinc-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow">
                {{-- Media Thumbnail --}}
                <div class="relative aspect-square bg-zinc-100 overflow-hidden">
                  @if($item->tipe === 'foto' && $item->file_path)
                    <img src="{{ Storage::url($item->file_path) }}" 
                         alt="{{ $item->judul }}"
                         class="w-full h-full object-cover">
                  @elseif($item->tipe === 'video' && $item->thumbnail_path)
                    <img src="{{ Storage::url($item->thumbnail_path) }}" 
                         alt="{{ $item->judul }}"
                         class="w-full h-full object-cover">
                  @elseif($item->tipe === 'youtube')
                    <div class="w-full h-full bg-red-600 flex items-center justify-center">
                      <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                      </svg>
                    </div>
                  @else
                    <div class="w-full h-full flex items-center justify-center bg-zinc-200">
                      <span class="text-zinc-500 text-sm">No Preview</span>
                    </div>
                  @endif

                  {{-- Badge Tipe --}}
                  <div class="absolute top-2 left-2">
                    @if($item->tipe === 'foto')
                      <span class="px-2 py-1 text-xs bg-blue-500 text-white rounded-md">FOTO</span>
                    @elseif($item->tipe === 'video')
                      <span class="px-2 py-1 text-xs bg-purple-500 text-white rounded-md">VIDEO</span>
                    @else
                      <span class="px-2 py-1 text-xs bg-red-500 text-white rounded-md">YOUTUBE</span>
                    @endif
                  </div>

                  {{-- Badge Utama --}}
                  @if($item->is_utama)
                    <div class="absolute top-2 right-2">
                      <span class="px-2 py-1 text-xs bg-amber-500 text-white rounded-md">UTAMA</span>
                    </div>
                  @endif
                </div>

                {{-- Media Info --}}
                <div class="p-4">
                  <h3 class="font-medium text-zinc-800 text-sm line-clamp-2 mb-1">
                    {{ $item->judul }}
                  </h3>
                  
                  @if($item->album)
                    <p class="text-xs text-zinc-500 mb-2">
                      Album: {{ $item->album->judul }}
                    </p>
                  @endif
                  
                  @if($item->keterangan)
                    <p class="text-xs text-zinc-500 line-clamp-2 mb-2">
                      {{ $item->keterangan }}
                    </p>
                  @endif

                  <div class="flex items-center justify-between text-xs text-zinc-500">
                    <span>Urutan: {{ $item->urutan }}</span>
                    @if($item->taken_at)
                      <span>{{ $item->taken_at->format('d/m/Y') }}</span>
                    @endif
                  </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-4 pb-4">
                  <div class="flex items-center gap-2">
                    {{-- Set Utama --}}
                    @if(!$item->is_utama)
                      <form action="{{ route('admin.publikasi-data.galeri.media.set-utama', $item) }}" 
                            method="POST" class="flex-1">
                        @csrf
                        <button type="submit"
                                class="w-full px-2 py-1.5 text-xs font-medium rounded-md border border-amber-200 text-amber-700 bg-amber-50 hover:bg-amber-100">
                          Jadikan Utama
                        </button>
                      </form>
                    @else
                      <button disabled
                              class="w-full px-2 py-1.5 text-xs font-medium rounded-md border border-green-200 text-green-700 bg-green-50 cursor-default">
                        Media Utama
                      </button>
                    @endif

                    {{-- Edit --}}
                    <a href="{{ route('admin.publikasi-data.galeri.media.edit', $item) }}"
                       class="px-2 py-1.5 text-xs font-medium rounded-md border border-zinc-200 text-zinc-700 bg-white hover:bg-zinc-50">
                      <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20h9"/>
                        <path d="M16.5 3.5a2.121 2.121 0 113 3L7 19l-4 1 1-4 12.5-12.5z"/>
                      </svg>
                    </a>

                    {{-- Hapus --}}
                    <form action="{{ route('admin.publikasi-data.galeri.media.destroy', $item) }}" 
                          method="POST"
                          onsubmit="return confirm('Hapus media ini?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              class="px-2 py-1.5 text-xs font-medium rounded-md border border-red-200 text-red-700 bg-red-50 hover:bg-red-100">
                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                          <polyline points="3 6 5 6 21 6"/>
                          <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                        </svg>
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{-- Pagination --}}
          @if($media->hasPages())
            <div class="mt-6">
              {{ $media->links() }}
            </div>
          @endif
                @else
          {{-- Empty State --}}
          @if($album)
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-zinc-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-zinc-900 mb-2">Belum ada media di album ini</h3>
                <p class="text-zinc-500 mb-4">Mulai tambahkan foto, video, atau YouTube ke album "{{ $album->judul }}".</p>
                <a href="{{ route('admin.publikasi-data.galeri.media.create') }}?album_id={{ $album->id }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                    + Tambah Media Pertama
                </a>
            </div>
          @else
            {{-- <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-zinc-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-zinc-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-zinc-900 mb-2">Belum ada media</h3>
                <p class="text-zinc-500 mb-4">Mulai tambahkan foto, video, atau YouTube.</p>
                <a href="{{ route('admin.publikasi-data.galeri.media.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700">
                    + Tambah Media Pertama
                </a>
            </div> --}}
          @endif
        @endif
      </div>
    </div>
  </div>
</x-app-layout>