<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Galeri') }} — Edit Media: {{ $media->judul }}
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- Back + hint --}}
      <div class="mb-4 flex items-center justify-between">
        {{-- Back button --}}
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.publikasi-data.galeri.media.index', $album->id) }}'))">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
        Kembali
        </button>
        <span class="text-xs text-zinc-500">Form edit media</span>
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
              action="{{ route('admin.publikasi-data.galeri.media.update', $media) }}"
              method="POST" enctype="multipart/form-data" class="space-y-8" data-theme="light">
          @csrf
          @method('PUT')

          {{-- Tipe Media + Judul --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="tipe" class="form-label">Tipe Media *</label>
              <select id="tipe" name="tipe" required class="form-control">
                <option value="">— Pilih Tipe —</option>
                <option value="foto" {{ old('tipe', $media->tipe) == 'foto' ? 'selected' : '' }}>Foto</option>
                <option value="video" {{ old('tipe', $media->tipe) == 'video' ? 'selected' : '' }}>Video</option>
                <option value="youtube" {{ old('tipe', $media->tipe) == 'youtube' ? 'selected' : '' }}>YouTube</option>
              </select>
              @error('tipe') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
              <label for="judul" class="form-label">Judul Media *</label>
              <input id="judul" name="judul" type="text" required class="form-control"
                     value="{{ old('judul', $media->judul) }}" placeholder="Contoh: Pembukaan Acara Tahunan">
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- File Upload Section --}}
          <div id="file-section" class="{{ in_array($media->tipe, ['foto', 'video']) ? '' : 'hidden' }}">
            <label class="form-label">
              Upload File 
              <span class="text-xs text-zinc-500">(Max 20MB, JPG/PNG/WebP/MP4)</span>
            </label>
            
            {{-- Current File Info --}}
            @if($media->file_path)
              <div class="mb-3 p-3 bg-green-50 rounded border border-green-200">
                <p class="text-sm text-green-700 font-medium mb-1">File saat ini:</p>
                <div class="flex items-center gap-2">
                  @if($media->tipe === 'foto')
                    <img src="{{ Storage::url($media->file_path) }}" alt="Current file" class="h-12 w-12 object-cover rounded border">
                  @else
                    <div class="h-12 w-12 bg-purple-100 rounded border flex items-center justify-center">
                      <svg class="w-6 h-6 text-purple-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 3v2h-2V3H8v2H6V3H4v18h2v-2h2v2h8v-2h2v2h2V3h-2zM8 17H6v-2h2v2zm0-4H6v-2h2v2zm0-4H6V7h2v2zm10 8h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V7h2v2z"/>
                      </svg>
                    </div>
                  @endif
                  <span class="text-sm text-zinc-600">{{ basename($media->file_path) }}</span>
                </div>
                <p class="text-xs text-zinc-500 mt-1">Kosongkan jika tidak ingin mengganti file</p>
              </div>
            @endif
            
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

              {{-- Preview untuk gambar baru --}}
              <template x-if="preview">
                <div class="mt-2">
                  <p class="text-xs text-zinc-500 mb-1">Preview file baru:</p>
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
          <div id="youtube-section" class="{{ $media->tipe === 'youtube' ? '' : 'hidden' }}">
            <label for="youtube_url" class="form-label">
              URL YouTube
            </label>
            <input id="youtube_url" name="youtube_url" type="url" class="form-control"
                   value="{{ old('youtube_url', $media->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
            @error('youtube_url') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            <p class="mt-1 text-[11px] text-zinc-500">
              Paste link YouTube lengkap. Contoh: https://www.youtube.com/watch?v=abc123
            </p>
          </div>

          {{-- Thumbnail Section (khusus video) --}}
          <div id="thumbnail-section" class="{{ $media->tipe === 'video' ? '' : 'hidden' }}">
            <label for="thumbnail_path" class="form-label">
              Thumbnail Custom
              <span class="text-xs text-zinc-500">(opsional, JPG/PNG/WebP, maks 4MB)</span>
            </label>
            
            {{-- Current Thumbnail --}}
            @if($media->thumbnail_path)
              <div class="mb-3 p-3 bg-blue-50 rounded border border-blue-200">
                <p class="text-sm text-blue-700 font-medium mb-1">Thumbnail saat ini:</p>
                <div class="flex items-center gap-2">
                  <img src="{{ Storage::url($media->thumbnail_path) }}" alt="Current thumbnail" class="h-12 w-12 object-cover rounded border">
                  <span class="text-sm text-zinc-600">{{ basename($media->thumbnail_path) }}</span>
                </div>
                <p class="text-xs text-zinc-500 mt-1">Kosongkan jika tidak ingin mengganti thumbnail</p>
              </div>
            @endif
            
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
                  <p class="text-xs text-zinc-500 mb-1">Preview thumbnail baru:</p>
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
                      placeholder="Deskripsi atau caption untuk media ini...">{{ old('keterangan', $media->keterangan) }}</textarea>
            @error('keterangan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Metadata --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="taken_at" class="form-label">Tanggal Pengambilan</label>
              <input id="taken_at" name="taken_at" type="date" class="form-control"
                     value="{{ old('taken_at', $media->taken_at ? $media->taken_at->format('Y-m-d') : '') }}">
              @error('taken_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="urutan" class="form-label">Urutan Tampil</label>
              <input id="urutan" name="urutan" type="number" min="0" class="form-control"
                     value="{{ old('urutan', $media->urutan) }}" placeholder="0">
              @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-center">
              <div class="flex items-center gap-2">
                <input id="is_utama" name="is_utama" type="checkbox" value="1" class="checkbox"
                       {{ old('is_utama', $media->is_utama) ? 'checked' : '' }}>
                <label for="is_utama" class="text-sm text-zinc-700">
                  Jadikan media utama
                </label>
              </div>
            </div>
          </div>

          {{-- Info Album & Media --}}
          <div class="p-4 bg-zinc-50 rounded-lg border border-zinc-200">
            <h4 class="text-sm font-medium text-zinc-700 mb-2">Info</h4>
            <div class="grid grid-cols-2 gap-4 text-sm">
              <div>
                <span class="text-zinc-500">Album:</span>
                <span class="font-medium ml-2">{{ $album->judul }}</span>
              </div>
              <div>
                <span class="text-zinc-500">Tipe:</span>
                <span class="font-medium ml-2 capitalize">{{ $media->tipe }}</span>
              </div>
              <div>
                <span class="text-zinc-500">Dibuat:</span>
                <span class="font-medium ml-2">{{ $media->created_at->format('d/m/Y H:i') }}</span>
              </div>
              <div>
                <span class="text-zinc-500">Diupdate:</span>
                <span class="font-medium ml-2">{{ $media->updated_at->format('d/m/Y H:i') }}</span>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between pt-6 border-t border-zinc-200">
            <div>
            <div class="flex items-center gap-2">
                {{-- @dd($album) --}}
              <a href="{{ route('admin.publikasi-data.galeri.media.index', $album->id) }}"
                    class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50">Batal</a>

              <button type="submit"
                      class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Update Media
              </button>
            </div>
            </div>
          </div>
        </form>
        <form action="{{ route('admin.publikasi-data.galeri.media.destroy', $media->id) }}" 
            method="POST" class="inline"
            onsubmit="return confirm('Hapus media ini? Tindakan tidak dapat dibatalkan.')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center px-3 py-2 border border-red-300 text-sm leading-4 font-medium rounded-md text-red-700 bg-white hover:bg-red-50">
                <svg class="w-4 h-4 mr-1" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <polyline points="3 6 5 6 21 6"/>
                <path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/>
                </svg>
                Hapus Media
            </button>
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
      });
    </script>
  @endpush
</x-app-layout>