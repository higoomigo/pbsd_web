{{-- resources/views/admin/publikasi-data/koleksi-dokumen/edit.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Koleksi Dokumen') }} — Edit Koleksi: {{ $koleksi->judul }}
    </h2>
  </x-slot>

  <div class="py-6" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

      {{-- Tombol kembali + hint --}}
      <div class="mb-4 flex items-center justify-between">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.publikasi-data.koleksi-dokumen.index') }}'))">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          Kembali
        </button>
        <span class="text-xs text-zinc-500">Edit koleksi dokumen: {{ $koleksi->judul }}</span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded text-sm">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 p-3 bg-red-100 text-red-800 rounded text-sm">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="form-edit-koleksi-dokumen"
              action="{{ route('admin.publikasi-data.koleksi-dokumen.update', $koleksi->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-8">
          @csrf
          @method('PUT')

          {{-- Judul dan Slug --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="judul" class="form-label">Judul Koleksi</label>
              <input id="judul" name="judul" type="text" class="form-control"
                     value="{{ old('judul', $koleksi->judul) }}" 
                     placeholder="Contoh: Arsip Sejarah Kota Gorontalo 1900-1950"
                     required>
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="slug" class="form-label">Slug (URL-friendly)</label>
              <input id="slug" name="slug" type="text" class="form-control"
                     value="{{ old('slug', $koleksi->slug) }}" 
                     placeholder="Contoh: arsip-sejarah-gorontalo-1900-1950"
                     required>
              <p class="mt-1 text-xs text-zinc-500">
                Gunakan huruf kecil, angka, dan strip (-). Contoh: naskah-kuno-bali
              </p>
              @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Deskripsi --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="deskripsi_singkat" class="form-label">Deskripsi Singkat</label>
              <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="3" class="form-control"
                placeholder="Deskripsi singkat untuk tampilan list (1-2 kalimat)">{{ old('deskripsi_singkat', $koleksi->deskripsi_singkat) }}</textarea>
              <p class="mt-1 text-xs text-zinc-500">Maks. 200 karakter</p>
              @error('deskripsi_singkat') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="deskripsi_lengkap" class="form-label">Deskripsi Lengkap (opsional)</label>
              <textarea id="deskripsi_lengkap" name="deskripsi_lengkap" rows="3" class="form-control"
                placeholder="Detail lengkap koleksi, latar belakang, konteks, dll.">{{ old('deskripsi_lengkap', $koleksi->deskripsi_lengkap) }}</textarea>
              @error('deskripsi_lengkap') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Kategori dan Tahun --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="kategori" class="form-label">Kategori</label>
              @php
                $kategoriOld = old('kategori', $koleksi->kategori);
              @endphp
              <select id="kategori" name="kategori" class="form-control">
                <option value="">Pilih Kategori</option>
                @foreach (['Arsip Sejarah', 'Naskah Kuno', 'Transkrip Wawancara', 'Dokumen Pemerintah', 'Karya Sastra', 'Penelitian', 'Lainnya'] as $opt)
                  <option value="{{ $opt }}" @selected($kategoriOld === $opt)>{{ $opt }}</option>
                @endforeach
              </select>
              @error('kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tahun_mulai" class="form-label">Tahun Mulai (opsional)</label>
              <input id="tahun_mulai" name="tahun_mulai" type="number" min="1800" max="{{ date('Y') }}"
                     class="form-control"
                     value="{{ old('tahun_mulai', $koleksi->tahun_mulai) }}" placeholder="Contoh: 1900">
              @error('tahun_mulai') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tahun_selesai" class="form-label">Tahun Selesai (opsional)</label>
              <input id="tahun_selesai" name="tahun_selesai" type="number" min="1800" max="{{ date('Y') }}"
                     class="form-control"
                     value="{{ old('tahun_selesai', $koleksi->tahun_selesai) }}" placeholder="Contoh: 1950">
              @error('tahun_selesai') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Informasi Lembaga dan Lokasi --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="lembaga" class="form-label">Lembaga (opsional)</label>
              <input id="lembaga" name="lembaga" type="text" class="form-control"
                     value="{{ old('lembaga', $koleksi->lembaga) }}" placeholder="Contoh: Pusat Studi BG, Arsip Nasional">
              @error('lembaga') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="sumber" class="form-label">Sumber (opsional)</label>
              <input id="sumber" name="sumber" type="text" class="form-control"
                     value="{{ old('sumber', $koleksi->sumber) }}" placeholder="Contoh: Donasi Keluarga, Hibah Museum">
              @error('sumber') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="lokasi_fisik" class="form-label">Lokasi Fisik (opsional)</label>
              <input id="lokasi_fisik" name="lokasi_fisik" type="text" class="form-control"
                     value="{{ old('lokasi_fisik', $koleksi->lokasi_fisik) }}" placeholder="Contoh: Ruang Arsip, Lemari A">
              @error('lokasi_fisik') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Upload Cover --}}
          <div x-data="{ 
            filename: null, 
            previewUrl: '{{ $koleksi->cover_path ? Storage::url($koleksi->cover_path) : '' }}',
            showDelete: false
          }">
            <label class="form-label">
              Cover/Gambar Koleksi (opsional)
              <span class="text-xs text-zinc-500">(JPG/PNG/WebP, maks 2MB)</span>
            </label>
            
            <div class="mt-2 flex items-center gap-4">
              <div class="shrink-0">
                <template x-if="previewUrl">
                  <img :src="previewUrl" 
                       class="h-32 w-32 object-cover rounded-md border shadow-sm">
                </template>
                <template x-if="!previewUrl">
                  <div class="h-32 w-32 bg-gray-100 border-2 border-dashed border-gray-300 rounded-md flex items-center justify-center">
                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                </template>
              </div>
              
              <div class="flex-1 space-y-2">
                <div>
                  <input id="cover" name="cover" type="file"
                         class="block w-full text-sm text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                         accept="image/*"
                         @change="
                           filename = $event.target.files[0]?.name || null;
                           if ($event.target.files[0]) {
                             previewUrl = URL.createObjectURL($event.target.files[0]);
                           }
                         ">
                  <template x-if="filename">
                    <p class="mt-1 text-xs text-gray-500">
                      File baru: <span x-text="filename"></span>
                    </p>
                  </template>
                </div>
                
                @if($koleksi->cover_path)
                  <div class="flex items-center">
                    <input id="hapus_cover" name="hapus_cover" type="checkbox" 
                           class="h-4 w-4 text-red-600 border-gray-300 rounded"
                           value="1"
                           @click="showDelete = !showDelete">
                    <label for="hapus_cover" class="ml-2 text-sm text-gray-700">
                      <span :class="showDelete ? 'text-red-600 font-medium' : 'text-gray-700'">
                        Hapus cover saat ini
                      </span>
                    </label>
                  </div>
                @endif
                
                <p class="text-xs text-zinc-500">
                  Ukuran disarankan: 400×400 px. Gambar akan tampil sebagai thumbnail koleksi.
                </p>
              </div>
            </div>
            @error('cover') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Pengaturan Publikasi --}}
          <div class="border-t pt-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pengaturan Publikasi</h3>
            
            <div class="grid md:grid-cols-3 gap-6">
              <div>
                <label for="published_at" class="form-label">Tanggal Publikasi</label>
                <input id="published_at" name="published_at" type="date" class="form-control"
                       value="{{ old('published_at', $koleksi->published_at ? $koleksi->published_at->format('Y-m-d') : '') }}">
                <p class="mt-1 text-xs text-zinc-500">
                  @if($koleksi->published_at)
                    Saat ini: {{ $koleksi->published_at->format('d/m/Y') }}
                  @else
                    Kosongkan untuk publikasi langsung
                  @endif
                </p>
                @error('published_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div>
                <label for="urutan" class="form-label">Urutan Tampil</label>
                <input id="urutan" name="urutan" type="number" min="0"
                       class="form-control"
                       value="{{ old('urutan', $koleksi->urutan) }}" placeholder="0">
                <p class="mt-1 text-xs text-zinc-500">Angka lebih kecil = tampil lebih awal</p>
                @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              </div>

              <div class="space-y-3">
                <div class="flex items-center">
                  <input id="is_published" name="is_published" type="checkbox" 
                         class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                         value="1" {{ old('is_published', $koleksi->is_published) ? 'checked' : '' }}>
                  <label for="is_published" class="ml-2 block text-sm text-gray-900">
                    Publikasikan koleksi
                  </label>
                </div>
                
                <div class="flex items-center">
                  <input id="tampil_beranda" name="tampil_beranda" type="checkbox" 
                         class="h-4 w-4 text-indigo-600 border-gray-300 rounded"
                         value="1" {{ old('tampil_beranda', $koleksi->tampil_beranda) ? 'checked' : '' }}>
                  <label for="tampil_beranda" class="ml-2 block text-sm text-gray-900">
                    Tampilkan di halaman beranda
                  </label>
                </div>
              </div>
            </div>
          </div>

          {{-- Stats Info --}}
          <div class="border-t pt-6 mt-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Koleksi</h3>
            
            <div class="grid md:grid-cols-3 gap-4">
              <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm text-gray-500">Jumlah Dokumen</div>
                <div class="text-2xl font-bold text-gray-900">{{ $koleksi->dokumen()->count() }}</div>
              </div>
              
              <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm text-gray-500">Dibuat Pada</div>
                <div class="text-lg font-medium text-gray-900">{{ $koleksi->created_at->format('d/m/Y H:i') }}</div>
              </div>
              
              <div class="bg-gray-50 p-4 rounded-lg">
                <div class="text-sm text-gray-500">Terakhir Diupdate</div>
                <div class="text-lg font-medium text-gray-900">{{ $koleksi->updated_at->format('d/m/Y H:i') }}</div>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-between pt-6 border-t">
            <div class="text-sm text-gray-500">
              ID: {{ $koleksi->id }} • 
              <a href="{{ route('admin.publikasi-data.koleksi-dokumen.show', $koleksi->id) }}"
                 class="text-indigo-600 hover:text-indigo-800">
                Lihat dokumen dalam koleksi →
              </a>
            </div>
            
            <div class="flex items-center gap-2">
              <a href="{{ route('admin.publikasi-data.koleksi-dokumen.index') }}"
                 class="px-4 py-2 border rounded-md text-zinc-700 hover:bg-zinc-50">
                Batal
              </a>

              <button type="submit"
                      class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Update Koleksi
              </button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>

  @push('scripts')
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        const judulInput = document.getElementById('judul');
        const slugInput = document.getElementById('slug');
        
        // Set manual flag if slug is not empty
        if (slugInput && slugInput.value !== '') {
          slugInput.dataset.manual = 'true';
        }
        
        if (judulInput && slugInput) {
          judulInput.addEventListener('input', function() {
            // Only auto-generate if slug is empty or hasn't been manually changed
            if (!slugInput.dataset.manual && slugInput.value === '') {
              const slug = judulInput.value
                .toLowerCase()
                .replace(/[^\w\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim();
              slugInput.value = slug;
            }
          });
          
          // Mark slug as manually changed
          slugInput.addEventListener('input', function() {
            this.dataset.manual = 'true';
          });
        }
      });
    </script>
  @endpush
</x-app-layout>