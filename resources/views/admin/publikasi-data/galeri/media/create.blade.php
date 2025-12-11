<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Galeri') }} — Tambah Media: {{ $album->judul }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
       
      {{-- Back + hint --}}
      <div class="mb-4 flex items-center justify-between">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.publikasi-data.galeri.media.index', $album->id) }}'))">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          Kembali
        </button>
        <span class="text-xs text-zinc-500">Form tambah media ke album</span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
          </div>
        @endif
        @if ($errors->any())
          <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="form-galeri-media"
              action="{{ route('admin.publikasi-data.galeri.media.store', $album->id) }}"
              method="POST" enctype="multipart/form-data" class="space-y-8" data-theme="light">
          @csrf

           {{-- Hidden input untuk galeri_album_id --}}
            <input type="hidden" name="galeri_album_id" value="{{ request('album_id') }}">

            {{-- Tampilkan info album yang dipilih --}}
            @php
                $selectedAlbum = $albums->firstWhere('id', request('album_id'));
            @endphp

            @if($selectedAlbum)
                <div class="p-4 bg-blue-50 rounded-lg border border-blue-200 mb-6">
                    <h4 class="text-sm font-medium text-blue-700 mb-2">Album Tujuan</h4>
                    <div class="flex items-center gap-3">
                        @if($selectedAlbum->cover_path)
                            <img src="{{ Storage::url($selectedAlbum->cover_path) }}" 
                                alt="{{ $selectedAlbum->judul }}"
                                class="h-12 w-12 object-cover rounded border">
                        @endif
                        <div>
                            <p class="font-medium text-blue-800">{{ $selectedAlbum->judul }}</p>
                            <p class="text-xs text-blue-600">
                                {{ $selectedAlbum->media_count ?? 0 }} media • 
                                {{ $selectedAlbum->tahun ?: $selectedAlbum->created_at->format('Y') }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                {{-- Fallback jika album tidak ditemukan --}}
                <div class="p-3 bg-red-50 rounded border border-red-200 mb-4">
                    <p class="text-sm text-red-700">
                        <strong>Error:</strong> Album tidak ditemukan. 
                        <a href="{{ route('admin.publikasi-data.galeri.albums.index') }}" class="underline">
                            Pilih album dulu
                        </a>
                    </p>
                </div>
            @endif

          {{-- Tipe Media + Judul --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="tipe" class="form-label">Tipe Media *</label>
              <select id="tipe" name="tipe" required class="form-control">
                <option value="">— Pilih Tipe —</option>
                <option value="foto" {{ old('tipe') == 'foto' ? 'selected' : '' }}>Foto</option>
                <option value="video" {{ old('tipe') == 'video' ? 'selected' : '' }}>Video</option>
                <option value="youtube" {{ old('tipe') == 'youtube' ? 'selected' : '' }}>YouTube</option>
              </select>
              @error('tipe') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
              <label for="judul" class="form-label">Judul Media *</label>
              <input id="judul" name="judul" type="text" required class="form-control"
                     value="{{ old('judul') }}" placeholder="Contoh: Pembukaan Acara Tahunan">
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- File Upload Section --}}
          <div id="file-section" class="hidden">
            <label class="form-label">
              Upload File <span class="text-red-500">*</span>
              <span class="text-xs text-zinc-500">(Max 20MB, JPG/PNG/WebP/MP4)</span>
            </label>
            
            <div x-data="{ preview: null, isVideo: false }" class="space-y-4">
              <input id="file_path" name="file_path" type="file" class="form-file"
                     @change="
                       const file = $event.target.files[0];
                       if (!file) { preview = null; return; }
                       
                       isVideo = file.type.startsWith('video/');
                       
                       if (file.type.startsWith('image/')) {
                         const reader = new FileReader();
                         reader.onload = e => preview = e.target.result;
                         reader.readAsDataURL(file);
                       } else {
                         preview = null;
                       }
                     ">

              {{-- Preview untuk gambar --}}
              <template x-if="preview">
                <div class="mt-2">
                  <p class="text-xs text-zinc-500 mb-1">Preview:</p>
                  <img :src="preview" alt="Preview" class="max-h-64 rounded border border-zinc-200 bg-white p-1">
                </div>
              </template>

              {{-- Info untuk video --}}
              <template x-if="isVideo && !preview">
                <div class="p-3 bg-blue-50 rounded border border-blue-200">
                  <p class="text-sm text-blue-700">
                    <strong>File video terdeteksi.</strong> Disarankan upload thumbnail untuk preview yang lebih baik.
                  </p>
                </div>
              </template>
            </div>
            @error('file_path') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- YouTube URL Section --}}
          <div id="youtube-section" class="hidden">
            <label for="youtube_url" class="form-label">
              URL YouTube <span class="text-red-500">*</span>
            </label>
            <input id="youtube_url" name="youtube_url" type="url" class="form-control"
                   value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=...">
            @error('youtube_url') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            <p class="mt-1 text-[11px] text-zinc-500">
              Paste link YouTube lengkap. Contoh: https://www.youtube.com/watch?v=abc123
            </p>
          </div>

          {{-- Thumbnail Section (khusus video) --}}
          <div id="thumbnail-section" class="hidden">
            <label for="thumbnail_path" class="form-label">
              Thumbnail Custom
              <span class="text-xs text-zinc-500">(opsional, JPG/PNG/WebP, maks 4MB)</span>
            </label>
            
            <div x-data="{ thumbPreview: null }">
              <input id="thumbnail_path" name="thumbnail_path" type="file" accept="image/*" class="form-file"
                     @change="
                       const [f] = $event.target.files;
                       if (!f) { thumbPreview = null; return; }
                       const r = new FileReader();
                       r.onload = e => thumbPreview = e.target.result;
                       r.readAsDataURL(f);
                     ">

              <template x-if="thumbPreview">
                <div class="mt-3">
                  <p class="text-xs text-zinc-500 mb-1">Preview thumbnail:</p>
                  <img :src="thumbPreview" alt="Preview Thumbnail" class="max-h-40 rounded border border-zinc-200 bg-white p-1">
                </div>
              </template>
            </div>
            @error('thumbnail_path') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Keterangan --}}
          <div>
            <label for="keterangan" class="form-label">Keterangan (opsional)</label>
            <textarea id="keterangan" name="keterangan" rows="3" class="form-control"
                      placeholder="Deskripsi atau caption untuk media ini...">{{ old('keterangan') }}</textarea>
            @error('keterangan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Metadata --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="taken_at" class="form-label">Tanggal Pengambilan</label>
              <input id="taken_at" name="taken_at" type="date" class="form-control"
                     value="{{ old('taken_at') }}">
              @error('taken_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="urutan" class="form-label">Urutan Tampil</label>
              <input id="urutan" name="urutan" type="number" min="0" class="form-control"
                     value="{{ old('urutan', 0) }}" placeholder="0">
              @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-center">
              <div class="flex items-center gap-2">
                <input id="is_utama" name="is_utama" type="checkbox" value="1" class="checkbox"
                       {{ old('is_utama') ? 'checked' : '' }}>
                <label for="is_utama" class="text-sm text-zinc-700">
                  Jadikan media utama
                </label>
              </div>
            </div>
          </div>

          {{-- Info Album --}}
          <div class="p-4 bg-zinc-50 rounded-lg border border-zinc-200">
            <h4 class="text-sm font-medium text-zinc-700 mb-2">Info Album</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
              <div>
                <span class="text-zinc-500">Album:</span>
                <span class="font-medium ml-2">{{ $album->judul }}</span>
              </div>
              <div>
                <span class="text-zinc-500">Total Media:</span>
                <span class="font-medium ml-2">{{ $album->media_count ?? 0 }}</span>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-end gap-2 pt-2">
            <a href="{{ route('admin.publikasi-data.galeri.media.index', $album->id) }}"
               class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50">Batal</a>

            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan Media
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const tipeSelect = document.getElementById('tipe');
        const fileSection = document.getElementById('file-section');
        const youtubeSection = document.getElementById('youtube-section');
        const thumbnailSection = document.getElementById('thumbnail-section');
        
        function toggleSections() {
          const selectedTipe = tipeSelect.value;
          
          // Reset semua section
          fileSection.classList.add('hidden');
          youtubeSection.classList.add('hidden');
          thumbnailSection.classList.add('hidden');
          
          // Tampilkan section sesuai tipe
          if (selectedTipe === 'foto' || selectedTipe === 'video') {
            fileSection.classList.remove('hidden');
            
            // Tampilkan thumbnail section khusus untuk video
            if (selectedTipe === 'video') {
              thumbnailSection.classList.remove('hidden');
            }
          } else if (selectedTipe === 'youtube') {
            youtubeSection.classList.remove('hidden');
          }
        }
        
        // Event listener untuk perubahan tipe
        tipeSelect.addEventListener('change', toggleSections);
        
        // Jalankan sekali saat load untuk set initial state
        toggleSections();
        
        // Validasi form sebelum submit
        document.getElementById('form-galeri-media').addEventListener('submit', function(e) {
          const tipe = tipeSelect.value;
          const fileInput = document.getElementById('file_path');
          const youtubeUrl = document.getElementById('youtube_url');
          
          if (tipe === 'foto' || tipe === 'video') {
            if (!fileInput.files.length) {
              e.preventDefault();
              alert('File wajib diupload untuk tipe ' + tipe);
              fileInput.focus();
            }
          } else if (tipe === 'youtube') {
            if (!youtubeUrl.value.trim()) {
              e.preventDefault();
              alert('URL YouTube wajib diisi');
              youtubeUrl.focus();
            }
          }
        });
      });
    </script>
  @endpush
</x-app-layout>