<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Penelitian - Publikasi Terindeks') }} — Tambah Publikasi
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

      {{-- Tombol Kembali di atas form --}}
      <div class="mb-4 flex items-center justify-between">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.penelitian.publikasi-terindeks.index') }}'))">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          Kembali
        </button>
        <span class="text-xs text-zinc-500">Form tambah publikasi terindeks</span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <form action="{{ route('admin.penelitian.publikasi-terindeks.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-8">
          @csrf

          {{-- Judul Publikasi --}}
          <div class="grid md:grid-cols-1 gap-6">
            <div>
              <label for="judul" class="form-label">Judul Publikasi <span class="text-red-500">*</span></label>
              <input id="judul" name="judul" type="text" class="form-control"
                     value="{{ old('judul') }}" 
                     placeholder="Contoh: Machine Learning Approach for Sentiment Analysis in Social Media" required>
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Abstrak --}}
          <div>
            <label for="abstrak" class="form-label">Abstrak</label>
            <textarea id="abstrak" name="abstrak" rows="5" class="form-control"
                      placeholder="Tulis abstrak publikasi di sini...">{{ old('abstrak') }}</textarea>
            @error('abstrak') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Informasi Penulis & Jurnal --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="penulis" class="form-label">Penulis<span class="text-red-500">*</span></label>
              <input id="penulis" name="penulis" type="text" class="form-control"
                     value="{{ old('penulis') }}" 
                     placeholder="Contoh: John Doe, et al." required>
              @error('penulis') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="nama_jurnal" class="form-label">Nama Jurnal <span class="text-red-500">*</span></label>
              <input id="nama_jurnal" name="nama_jurnal" type="text" class="form-control"
                     value="{{ old('nama_jurnal') }}" 
                     placeholder="Contoh: Journal of Computer Science" required>
              @error('nama_jurnal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Informasi Detail Jurnal --}}
          <div class="grid md:grid-cols-4 gap-6">
            <div>
              <label for="issn" class="form-label">ISSN</label>
              <input id="issn" name="issn" type="text" class="form-control"
                     value="{{ old('issn') }}" 
                     placeholder="Contoh: 1234-5678">
              @error('issn') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="volume" class="form-label">Volume</label>
              <input id="volume" name="volume" type="text" class="form-control"
                     value="{{ old('volume') }}" 
                     placeholder="Contoh: 12">
              @error('volume') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="issue" class="form-label">Issue</label>
              <input id="issue" name="issue" type="text" class="form-control"
                     value="{{ old('issue') }}" 
                     placeholder="Contoh: 3">
              @error('issue') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="halaman" class="form-label">Halaman</label>
              <input id="halaman" name="halaman" type="text" class="form-control"
                     value="{{ old('halaman') }}" 
                     placeholder="Contoh: 123-135">
              @error('halaman') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Indeksasi dan Metrik --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="indeksasi" class="form-label">Indeksasi <span class="text-red-500">*</span></label>
              <select id="indeksasi" name="indeksasi" class="form-control" required>
                <option value="">Pilih Indeksasi</option>
                @foreach($indeksasiOptions as $key => $label)
                  <option value="{{ $key }}" {{ old('indeksasi') == $key ? 'selected' : '' }}>
                    {{ $label }}
                  </option>
                @endforeach
              </select>
              @error('indeksasi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="quartile" class="form-label">Quartile (Q)</label>
              <select id="quartile" name="quartile" class="form-control">
                <option value="">Pilih Quartile</option>
                <option value="1" {{ old('quartile') == '1' ? 'selected' : '' }}>Q1</option>
                <option value="2" {{ old('quartile') == '2' ? 'selected' : '' }}>Q2</option>
                <option value="3" {{ old('quartile') == '3' ? 'selected' : '' }}>Q3</option>
                <option value="4" {{ old('quartile') == '4' ? 'selected' : '' }}>Q4</option>
              </select>
              @error('quartile') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="impact_factor" class="form-label">Impact Factor</label>
              <input id="impact_factor" name="impact_factor" type="text" class="form-control"
                     value="{{ old('impact_factor') }}" 
                     placeholder="Contoh: 5.432">
              @error('impact_factor') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Informasi Tambahan --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="tahun_terbit" class="form-label">Tahun Terbit <span class="text-red-500">*</span></label>
              <input id="tahun_terbit" name="tahun_terbit" type="number" 
                     min="1900" max="{{ date('Y') }}" 
                     class="form-control"
                     value="{{ old('tahun_terbit', date('Y')) }}" required>
              @error('tahun_terbit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="doi" class="form-label">DOI</label>
              <input id="doi" name="doi" type="text" class="form-control"
                     value="{{ old('doi') }}" 
                     placeholder="Contoh: 10.1000/xyz123">
              @error('doi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="jumlah_dikutip" class="form-label">Jumlah Dikutip</label>
              <input id="jumlah_dikutip" name="jumlah_dikutip" type="number" 
                     min="0" class="form-control"
                     value="{{ old('jumlah_dikutip', 0) }}">
              @error('jumlah_dikutip') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- URL dan Kategori --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="url_jurnal" class="form-label">URL Jurnal</label>
              <input id="url_jurnal" name="url_jurnal" type="url" class="form-control"
                     value="{{ old('url_jurnal') }}" 
                     placeholder="Contoh: https://journal.example.com/article/123">
              @error('url_jurnal') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="bidang_ilmu" class="form-label">Bidang Ilmu</label>
              <input id="bidang_ilmu" name="bidang_ilmu" type="text" class="form-control"
                     value="{{ old('bidang_ilmu') }}" 
                     placeholder="Contoh: Computer Science, Engineering">
              @error('bidang_ilmu') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Upload File --}}
          <div class="grid md:grid-cols-2 gap-6">
            {{-- File PDF --}}
            <div x-data="{ pdfName: null }">
              <label for="file_pdf" class="form-label">File PDF</label>
              <div class="flex items-center gap-2">
                <input id="file_pdf" name="file_pdf" type="file" 
                       accept=".pdf" class="form-file flex-1"
                       @change="pdfName = $event.target.files[0]?.name">
              </div>
              <template x-if="pdfName">
                <p class="mt-1 text-sm text-green-600">
                  File dipilih: <span x-text="pdfName" class="font-medium"></span>
                </p>
              </template>
              <p class="text-xs text-gray-500 mt-1">Ukuran maksimal: 5MB</p>
              @error('file_pdf') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Cover Image --}}
            <div x-data="{ preview: null }">
              <label for="cover_image" class="form-label">Cover Image</label>
              <input id="cover_image" name="cover_image" type="file" 
                     accept="image/*" class="form-file"
                     @change="
                       const [f] = $event.target.files;
                       if (!f) { preview = null; return; }
                       const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f);
                     ">
              @error('cover_image') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

              <template x-if="preview">
                <div class="mt-3">
                  <p class="text-xs text-zinc-500 mb-1">Preview:</p>
                  <img :src="preview" alt="Preview Cover" class="max-h-40 rounded border border-zinc-200 bg-white p-1">
                </div>
              </template>
              <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF (maks 2MB)</p>
            </div>
          </div>

          {{-- Status dan Tanggal Publish --}}
          <div class="grid md:grid-cols-2 gap-6">
            <div>
              <label for="tanggal_publish" class="form-label">Tanggal Publish</label>
              <input id="tanggal_publish" name="tanggal_publish" type="date" class="form-control"
                     value="{{ old('tanggal_publish') }}">
              @error('tanggal_publish') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center">
              <div class="flex items-center h-5">
                <input id="is_active" name="is_active" type="checkbox" value="1" 
                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                       {{ old('is_active', true) ? 'checked' : '' }}>
              </div>
              <div class="ml-3 text-sm">
                <label for="is_active" class="font-medium text-gray-700">Aktif</label>
                <p class="text-gray-500">Publikasi akan ditampilkan di halaman depan</p>
              </div>
            </div>
          </div>

          <div class="flex items-center justify-end gap-4 pt-6 border-t">
            <a href="{{ route('admin.penelitian.publikasi-terindeks.index') }}"
               class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan Publikasi
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
      // Set tahun maksimal untuk input tahun
      document.addEventListener('DOMContentLoaded', function() {
        const tahunInput = document.getElementById('tahun_terbit');
        if (tahunInput) {
          tahunInput.max = new Date().getFullYear();
        }
        
        // Preview file name untuk PDF
        const pdfInput = document.getElementById('file_pdf');
        if (pdfInput) {
          pdfInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name;
            const previewElement = this.parentElement.querySelector('[x-text="pdfName"]');
            if (previewElement && fileName) {
              previewElement.textContent = fileName;
            }
          });
        }
      });
    </script>
  @endpush
</x-app-layout>