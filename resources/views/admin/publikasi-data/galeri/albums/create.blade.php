<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Galeri') }} — Tambah Album
    </h2>
  </x-slot>

  <div class="py-8" data-theme="light">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

      {{-- Back + hint --}}
      <div class="mb-4 flex items-center justify-between">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.publikasi-data.galeri.albums.index') }}'))">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M15 18l-6-6 6-6"/>
          </svg>
          Kembali
        </button>
        <span class="text-xs text-zinc-500">Form tambah album galeri</span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        @if(session('success'))
          <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
          </div>
        @endif

        @if ($errors->any())
          <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">
            <ul class="list-disc pl-5 text-sm">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form id="form-galeri-album"
              action="{{ route('admin.publikasi-data.galeri.albums.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-8">
          @csrf

          {{-- Judul + slug --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2">
              <label for="judul" class="block text-sm font-medium text-zinc-700">Nama Album</label>
              <input id="judul" name="judul" type="text"
                     class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('judul') }}" placeholder="Contoh: Dokumentasi Quran Terjemahan Bahasa Gorontalo">
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-1">
              <label for="slug" class="block text-sm font-medium text-zinc-700">Slug (URL)</label>
              <input id="slug" name="slug" type="text"
                     class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('slug') }}" placeholder="otomatis dari judul, bisa diubah">
              @error('slug') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
              <p class="mt-1 text-[11px] text-zinc-500">
                Digunakan di URL, misal: <span class="font-mono">/galeri/album/<span id="slugPreview">{{ old('slug') ?: 'nama-album' }}</span></span>
              </p>
            </div>
          </div>

          {{-- Kategori & tahun & urutan --}}
          <div class="grid md:grid-cols-4 gap-6">
            <div class="md:col-span-2">
              <label for="kategori" class="block text-sm font-medium text-zinc-700">Koleksi / Kategori</label>
              @php $kategoriOld = old('kategori'); @endphp
              <select id="kategori" name="kategori"
                      class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">— Pilih / ketik manual di bawah —</option>
                @foreach (['Dokumentasi Bahasa','Quran Terjemahan BG','Dikili & Sastra','Kegiatan Pusat Studi','Pelatihan & Workshop','Kunjungan & Kolaborasi'] as $opt)
                  <option value="{{ $opt }}" @selected($kategoriOld === $opt)>{{ $opt }}</option>
                @endforeach
              </select>
              <p class="mt-1 text-[11px] text-zinc-500">
                Boleh dikosongkan atau diisi manual (contoh: "Quran Terjemahan BG").
              </p>
              <input id="kategori_manual" name="kategori_manual" type="text"
                     class="mt-1 block w-full border border-dashed border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('kategori_manual') }}" placeholder="Atau ketik kategori manual di sini">
              @error('kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tahun" class="block text-sm font-medium text-zinc-700">Tahun</label>
              <input id="tahun" name="tahun" type="number" min="1900" max="2100"
                     class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('tahun') }}" placeholder="{{ now()->year }}">
              @error('tahun') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="urutan" class="block text-sm font-medium text-zinc-700">Urutan Tampil</label>
              <input id="urutan" name="urutan" type="number" min="0"
                     class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('urutan', 0) }}" placeholder="0">
              @error('urutan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Periode & lokasi --}}
          <div class="grid md:grid-cols-4 gap-6">
            <div>
              <label for="tanggal_mulai" class="block text-sm font-medium text-zinc-700">Tanggal Mulai</label>
              <input id="tanggal_mulai" name="tanggal_mulai" type="date"
                     class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('tanggal_mulai') }}">
              @error('tanggal_mulai') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
              <label for="tanggal_selesai" class="block text-sm font-medium text-zinc-700">Tanggal Selesai</label>
              <input id="tanggal_selesai" name="tanggal_selesai" type="date"
                     class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('tanggal_selesai') }}">
              @error('tanggal_selesai') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="md:col-span-2">
              <label for="lokasi" class="block text-sm font-medium text-zinc-700">Lokasi Kegiatan / Dokumentasi</label>
              <input id="lokasi" name="lokasi" type="text"
                     class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                     value="{{ old('lokasi') }}" placeholder="Contoh: Kampus UNG, Gorontalo / Masjid Agung Baiturrahim">
              @error('lokasi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Deskripsi singkat + deskripsi --}}
          <div>
            <label for="deskripsi_singkat" class="block text-sm font-medium text-zinc-700">
              Deskripsi Singkat
            </label>
            <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="2"
                      class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Ringkasan album dalam 1–2 kalimat untuk ditampilkan di kartu galeri.">{{ old('deskripsi_singkat') }}</textarea>
            @error('deskripsi_singkat') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          <div>
            <label for="deskripsi" class="block text-sm font-medium text-zinc-700">
              Deskripsi Lengkap (opsional)
            </label>
            <textarea id="deskripsi" name="deskripsi" rows="5"
                      class="mt-1 block w-full border border-zinc-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                      placeholder="Boleh diisi narasi lebih panjang tentang konteks album, kegiatan, atau koleksi.">{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Cover album --}}
          <div x-data="{ preview: null }">
            <label for="cover" class="block text-sm font-medium text-zinc-700">
              Cover Album
              <span class="text-xs text-zinc-500">(opsional, gambar JPG/PNG/WebP, maks 3MB)</span>
            </label>
            <input id="cover" name="cover" type="file" accept="image/*"
                   class="mt-1 block w-full text-sm text-zinc-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                   @change="
                     const [f] = $event.target.files;
                     if (!f) { preview = null; return; }
                     const r = new FileReader();
                     r.onload = e => preview = e.target.result;
                     r.readAsDataURL(f);
                   ">
            @error('cover') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

            <template x-if="preview">
              <div class="mt-3">
                <p class="text-xs text-zinc-500 mb-1">Preview cover:</p>
                <img :src="preview" alt="Preview Cover" class="max-h-56 rounded border border-zinc-200 bg-white p-1">
              </div>
            </template>
          </div>

          {{-- Tampil di beranda --}}
          <div class="flex items-center gap-2">
            <input id="tampil_beranda" name="tampil_beranda" type="checkbox" value="1"
                   class="h-4 w-4 rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500"
                   @checked(old('tampil_beranda', false))>
            <label for="tampil_beranda" class="text-sm text-zinc-700">
              Tampilkan album ini di beranda (section galeri / kegiatan pilihan)
            </label>
          </div>

          <div class="flex items-center justify-end gap-2 pt-2">
            <a href="{{ route('admin.publikasi-data.galeri.albums.index') }}"
               class="px-4 py-2 border border-zinc-300 rounded-md text-sm text-zinc-700 hover:bg-zinc-50">
              Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md text-sm font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan Album
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      // Simple slugify dari judul
      function slugify(text){
        return (text || '')
          .normalize('NFKD').replace(/[\u0300-\u036f]/g, '')
          .replace(/[^a-zA-Z0-9\s-]/g, '')
          .trim()
          .toLowerCase()
          .replace(/[\s_-]+/g, '-')
          .replace(/^-+|-+$/g, '');
      }

      (function(){
        const $judul = document.getElementById('judul');
        const $slug = document.getElementById('slug');
        const $slugPrev = document.getElementById('slugPreview');

        if(!$judul || !$slug || !$slugPrev) return;

        const updateSlug = () => {
          // hanya auto kalau slug masih kosong atau sama dengan slug lama dari judul
          if (!$slug.dataset.manual || $slug.dataset.manual === '0') {
            const s = slugify($judul.value);
            $slug.value = s;
            $slugPrev.textContent = s || 'nama-album';
          }
        };

        $judul.addEventListener('input', updateSlug);

        // kalau user ubah slug manual, tandai supaya tidak di-overwrite
        $slug.addEventListener('input', () => {
          $slug.dataset.manual = '1';
          $slugPrev.textContent = $slug.value || 'nama-album';
        });
      })();
    </script>
  @endpush
</x-app-layout>
