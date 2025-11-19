<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{ __('Menu Berita') }} — Tambah Berita
    </h2>
  </x-slot>

  <div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 ">

      {{-- Tombol Kembali di atas form --}}
      <div class="mb-4 flex items-center justify-between">
        <button type="button"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md border text-zinc-700 bg-zinc-50 hover:bg-white"
                onclick="(document.referrer ? history.back() : (window.location='{{ route('admin.publikasi-data.berita.index') }}'))">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 18l-6-6 6-6"/></svg>
          Kembali
        </button>
        <span class="text-xs text-zinc-500">Form tambah berita</span>
      </div>

      <div class="bg-white shadow-sm sm:rounded-lg p-6">
        <form action="{{ route('admin.publikasi-data.berita.store') }}"
              method="POST" enctype="multipart/form-data" class="space-y-8">
          @csrf

          {{-- Judul (slug otomatis, field slug disembunyikan) --}}
        <div class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-3">
              <label for="judul" class="form-label">Judul</label>
              <input id="judul" name="judul" type="text" class="form-control"
                     value="{{ old('judul') }}" placeholder="Contoh: Pusat Studi Luncurkan Arsip Digital Bahasa Gorontalo"/>
              @error('judul') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

              {{-- Hidden slug (diisi otomatis oleh JS) --}}
              <input id="slug" name="slug" type="hidden" value="{{ old('slug') }}">
              <p id="slugPreview" class="mt-1 text-xs text-zinc-500">
                Slug: <span class="font-mono opacity-80">—</span>
              </p>
            </div>
          </div>

          {{-- Kategori & Tag --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="kategori" class="form-label">Kategori</label>
              @php $kategoriOld = old('kategori', 'Kegiatan'); @endphp
              <select id="kategori" name="kategori" class="form-control">
                @foreach (['Kegiatan','Pengumuman','Rilis','Opini','Publikasi'] as $opt)
                  <option value="{{ $opt }}" @selected($kategoriOld===$opt)>{{ $opt }}</option>
                @endforeach
              </select>
              @error('kategori') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="md:col-span-2">
              <label for="tag" class="form-label">Tag (pisahkan dengan koma)</label>
              <input id="tag" name="tag" type="text" class="form-control"
                     value="{{ old('tag') }}" placeholder="bahasa gorontalo, arsip, penelitian"/>
              @error('tag') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          {{-- Ringkasan --}}
          <div>
            <label for="ringkasan" class="form-label">Ringkasan (excerpt)</label>
            <textarea id="ringkasan" name="ringkasan" rows="3" class="form-control"
                      placeholder="Ringkas isi berita dalam 1–2 kalimat.">{{ old('ringkasan') }}</textarea>
            @error('ringkasan') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Konten --}}
          <div>
            <label for="konten" class="form-label">Konten</label>
            <textarea id="konten" name="konten" rows="10" class="form-control"
                      placeholder="Tulis isi berita di sini...">{{ old('konten') }}</textarea>
            @error('konten') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
          </div>

          {{-- Thumbnail / Gambar Utama --}}
          <div x-data="{ preview: null }">
            <label for="thumbnail" class="form-label">Gambar Utama (thumbnail)</label>
            <input id="thumbnail" name="thumbnail" type="file" accept="image/*" class="form-file"
                   @change="
                     const [f] = $event.target.files;
                     if (!f) { preview = null; return; }
                     const r = new FileReader(); r.onload = e => preview = e.target.result; r.readAsDataURL(f);
                   ">
            @error('thumbnail') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

            <template x-if="preview">
              <div class="mt-3">
                <p class="text-xs text-zinc-500 mb-1">Preview:</p>
                <img :src="preview" alt="Preview Thumbnail" class="max-h-56 rounded border border-zinc-200 bg-white p-1">
              </div>
            </template>
          </div>

          {{-- Tanggal Terbit --}}
          <div class="grid md:grid-cols-3 gap-6">
            <div>
              <label for="published_at" class="form-label">Tanggal Terbit (opsional)</label>
              <input id="published_at" name="published_at" type="datetime-local" class="form-control"
                     value="{{ old('published_at') }}">
              @error('published_at') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="flex items-center justify-end gap-2 pt-2">
            <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  @push('scripts')
    <script src="//unpkg.com/alpinejs" defer></script>
    <script>
      // Debounce helper biar gak nge-run terlalu sering saat user ngetik
      function debounce(fn, wait=250){
        let t; return (...args)=>{ clearTimeout(t); t=setTimeout(()=>fn.apply(null,args), wait); };
      }

      // Slugify: lowercase, hapus aksen/diakritik, ganti non-alfanumerik jadi '-', trim '-'
      function slugify(text) {
        return text
          .normalize('NFKD')                      // pisah huruf + diakritik
          .replace(/[\u0300-\u036f]/g, '')       // hapus diakritik
          .replace(/[^a-zA-Z0-9\s-]/g, '')       // hilangkan simbol aneh
          .trim()
          .toLowerCase()
          .replace(/[\s_-]+/g, '-')              // spasi/underscore ke '-'
          .replace(/^-+|-+$/g, '');              // trim '-'
      }

      (function(){
        const judul = document.getElementById('judul');
        const slug  = document.getElementById('slug');
        const prev  = document.querySelector('#slugPreview span');

        if(!judul || !slug) return;

        const update = debounce(() => {
          const s = slugify(judul.value || '');
          slug.value = s;
          if (prev) prev.textContent = s || '—';
        }, 150);

        // init dari old value
        update();

        // listen ke input, paste, change
        ['input','change','paste'].forEach(evt => {
          judul.addEventListener(evt, update);
        });
      })();
    </script>
  @endpush
</x-app-layout>
